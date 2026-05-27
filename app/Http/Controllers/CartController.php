<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * កន្ត្រកទំនិញផ្អែកលើ Session — មិនតម្រូវឱ្យមានការចូលប្រើប្រាស់ទេ
     * (Checkout / Order ត្រូវបានការពារដោយ Route Middleware រួចហើយ)
     */

    /**
     * Display the cart page or return sidebar content via AJAX.
     */
    public function index(Request $request)
    {
        $cart = Session::get('cart', []);
        $total = $this->calculateTotal($cart);

        // ── បើការហៅមកជាប្រភេទ AJAX (ពី Side Cart Drawer) ──
        if ($request->ajax()) {
            return response()
                ->view('cart.side-items', compact('cart', 'total'))
                ->header('Content-Type', 'text/html; charset=UTF-8');
        }

        // បើចូលតាម URL ធម្មតា /cart
        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Add a food item to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'food_id' => 'required|exists:foods,id',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $food = Food::findOrFail($request->food_id);
        $cart = Session::get('cart', []);

        $key = 'food_'.$food->id;

        if (isset($cart[$key])) {
            // Cap quantity at 99
            $cart[$key]['quantity'] = min(99, $cart[$key]['quantity'] + (int) $request->quantity);
        } else {
            $cart[$key] = [
                'food_id' => $food->id,
                'name' => $food->name,
                'price' => (float) $food->price,
                'image' => $food->image ?? 'default.jpg',
                'quantity' => (int) $request->quantity,
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => $food->name.' added to cart!',
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    /**
     * Update item quantity in the cart.
     */
    public function update(Request $request)
    {
        $request->validate([
            'food_id' => 'required|exists:foods,id',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $cart = Session::get('cart', []);
        $key = 'food_'.$request->food_id;

        // FIX: check key exists before accessing it
        if (! isset($cart[$key])) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart.',
            ], 404);
        }

        $cart[$key]['quantity'] = (int) $request->quantity;
        Session::put('cart', $cart);

        $total = $this->calculateTotal($cart);

        return response()->json([
            'success' => true,
            'subtotal' => number_format($cart[$key]['price'] * $cart[$key]['quantity'], 2),
            'total' => number_format($total, 2),
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(Request $request)
    {
        $request->validate(['food_id' => 'required|exists:foods,id']);

        $cart = Session::get('cart', []);
        $key = 'food_'.$request->food_id;

        unset($cart[$key]);
        Session::put('cart', $cart);

        $total = $this->calculateTotal($cart);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
            'total' => number_format($total, 2),
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    /**
     * Return cart data as JSON for the sidebar UI.
     */
    public function cartData()
    {
        $cart = Session::get('cart', []);
        $items = array_values($cart);
        $total = $this->calculateTotal($cart);

        return response()->json([
            'items' => $items,
            'total' => $total,
            'cart_count' => array_sum(array_column($cart, 'quantity')),
        ]);
    }

    /**
     * Clear entire cart.
     */
    public function clear()
    {
        Session::forget('cart');

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    // ────────────────────────────────────────────────
    private function userId(): int
    {
        return auth()->id();
    }

    private function calculateTotal(array $cart): float
    {
        return (float) array_sum(
            array_map(fn ($item) => $item['price'] * $item['quantity'], $cart)
        );
    }
}
