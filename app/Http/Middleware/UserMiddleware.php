<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // ពិនិត្យមើលថាតើអ្នកប្រើប្រាស់បច្ចុប្បន្នជា Admin ឬអត់
        if (auth()->check() && auth()->user()->role === 'admin') {
            
            // ប្រសិនបើ Admin ព្យាយាមចូលទៅកាន់ទំព័រ Checkout ឬទំព័រគ្រប់គ្រងការបញ្ជាទិញរបស់ Customer
            if ($request->is('checkout*') || $request->is('order*') || $request->is('cart*')) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'គណនី Admin មិនត្រូវបានអនុញ្ញាតឱ្យប្រើប្រាស់ប្រព័ន្ធកន្ត្រកទំនិញ ឬបញ្ជាទិញឡើយ។');
            }
        }

        return $next($request);
    }
}