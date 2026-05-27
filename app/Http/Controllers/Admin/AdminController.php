<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_foods'    => Food::count(),
            'total_orders'   => Order::count(),
            'total_users'    => User::where('role', 'user')->count(),
            'total_revenue'  => Order::where('status', 'delivered')->sum('total_price'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'today_orders'   => Order::whereDate('created_at', today())->count(),
            'today_revenue'  => Order::whereDate('created_at', today())->where('status', 'delivered')->sum('total_price'),
        ];

        $recent_orders = Order::with('user')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        $top_foods = DB::table('order_items')
            ->select('name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'top_foods'));
    }

    // ── Foods ──────────────────────────────────────────────────────────
    public function foods(Request $request)
    {
        $query = Food::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        $foods = $query->orderByDesc('created_at')->get();
        $categories = Food::distinct()->pluck('category');
        return view('admin.foods.index', compact('foods', 'categories'));
    }

    public function createFood()
    {
        return view('admin.foods.create');
    }

    public function storeFood(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'badge'       => 'nullable|string|max:50',
            'rating'      => 'nullable|numeric|min:0|max:5',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->extension();
            $dir = public_path('assets/foods');
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            $file->move($dir, $filename);
            $data['image'] = 'assets/foods/' . $filename;
        }

        Food::create($data);
        return redirect()->route('admin.foods')->with('success', 'Food item created successfully!');
    }

    public function editFood(Food $food)
    {
        return view('admin.foods.edit', compact('food'));
    }

    public function updateFood(Request $request, Food $food)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'badge'       => 'nullable|string|max:50',
            'rating'      => 'nullable|numeric|min:0|max:5',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->extension();
            $dir = public_path('assets/foods');
            if (!is_dir($dir)) mkdir($dir, 0755, true);
            $file->move($dir, $filename);
            $data['image'] = 'assets/foods/' . $filename;
        }

        $food->update($data);
        return redirect()->route('admin.foods')->with('success', 'Food item updated!');
    }

    public function deleteFood(Food $food)
    {
        $food->delete();
        return redirect()->route('admin.foods')->with('success', 'Food item deleted.');
    }

    // ── Orders ─────────────────────────────────────────────────────────
    public function orders(Request $request)
    {
        $query = Order::with('user')->orderByDesc('created_at');
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $orders = $query->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $order->load('items', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,preparing,delivered,cancelled']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Order status updated!');
    }

    // ── Users ──────────────────────────────────────────────────────────
    public function users(Request $request)
    {
        $query = User::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        $users = $query->orderByDesc('created_at')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:admin,user']);
        $user->update(['role' => $request->role]);
        return back()->with('success', 'User role updated!');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself!');
        }
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted.');
    }
}