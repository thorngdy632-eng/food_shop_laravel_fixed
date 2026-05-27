<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected TelegramService $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Show the checkout form.
     */
    public function checkout()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $this->calcTotal($cart);

        return view('checkout.index', compact('cart', 'total'));
    }

    /**
     * Place the order (called on "Confirm Order" submit).
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:255',
            'payment_method' => 'required|in:cash,card,qr',
            'notes'          => 'nullable|string|max:500',
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $this->calcTotal($cart);

        DB::beginTransaction();
        try {
            // 1. Create order
            $order = Order::create([
                'user_id'        => Auth::id(),
                'name'           => $request->name,
                'phone'          => $request->phone,
                'address'        => $request->address,
                'payment_method' => $request->payment_method,
                'notes'          => $request->notes ?? '',
                'total_price'    => $total,
                'status'         => 'pending',
            ]);

            // 2. Create order items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'food_id'  => $item['food_id'],
                    'name'     => $item['name'],
                    'price'    => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            // 3. Clear the cart
            Session::forget('cart');

            DB::commit();

            // 4. Send Telegram notification (non-blocking: failure must not break the order)
            try {
                $this->telegram->sendOrderNotification($order, collect($cart));
            } catch (\Exception $te) {
                Log::warning('Telegram notification failed (order saved): ' . $te->getMessage());
            }

            return redirect()->route('order.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order placement failed: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Order success page.
     */
    public function success($id)
    {
        $order = Order::with('items')->findOrFail($id);

        // Security: only allow the owner to see their order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }

    /**
     * Order history for logged-in user.
     */
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->with('items')
                       ->latest()
                       ->paginate(10);

        return view('order.history', compact('orders'));
    }

    // ─────────────────────────────────────────────────────────────
    private function calcTotal(array $cart): float
    {
        return (float) array_sum(
            array_map(fn($item) => $item['price'] * $item['quantity'], $cart)
        );
    }
}
