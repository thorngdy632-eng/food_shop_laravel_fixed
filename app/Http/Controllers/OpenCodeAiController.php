<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Services\OpenCodeAiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OpenCodeAiController extends Controller
{
    public function __construct(
        protected OpenCodeAiService $ai
    ) {}

    /**
     * Show the AI dashboard view.
     */
    public function index(): View
    {
        return view('admin.ai.index');
    }

    /**
     * Generate a food description via AI (admin only).
     */
    public function generateDescription(Request $request): JsonResponse
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price'    => 'required|numeric|min:0',
            'keywords' => 'nullable|string|max:500',
        ]);

        $result = $this->ai->generateFoodDescription(
            $request->name,
            $request->category,
            $request->price,
            $request->keywords,
        );

        return response()->json($result);
    }

    /**
     * Analyse order trends (admin only).
     */
    public function orderTrends(): JsonResponse
    {
        $orders = Order::with('items')
            ->latest()
            ->take(50)
            ->get()
            ->toArray();

        if (empty($orders)) {
            return response()->json([
                'success' => true,
                'data'    => 'មិនទាន់មានការបញ្ជាទិញនៅឡើយទេ។',
            ]);
        }

        $result = $this->ai->analyseOrderTrends($orders);

        return response()->json($result);
    }

    /**
     * Generate a smart customer-service reply (admin only).
     */
    public function customerReply(Request $request): JsonResponse
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'message'       => 'required|string|max:2000',
            'context'       => 'nullable|string|in:review,complaint,inquiry',
        ]);

        $result = $this->ai->smartCustomerReply(
            $request->customer_name,
            $request->message,
            $request->context ?? 'review',
        );

        return response()->json($result);
    }

    /**
     * Generic AI chat endpoint (admin only). Accepts any prompt.
     */
    public function customPrompt(Request $request): JsonResponse
    {
        $request->validate([
            'prompt'       => 'required|string|max:4000',
            'system_hint'  => 'nullable|string|max:1000',
        ]);

        $system = $request->system_hint ?? 'You are a helpful AI assistant for "THORNG DY\'S SHOP", a Khmer food e-commerce store. Respond in Khmer where appropriate.';

        $result = $this->ai->chat($system, $request->prompt);

        return response()->json($result);
    }
}
