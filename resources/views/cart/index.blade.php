@extends('layouts.app')

@section('title', 'Your Cart')

@push('styles')
<style>
.cart-page-wrapper {
    background: #0d0c0a;
    min-height: 80vh;
    padding-top: 140px;
    padding-bottom: 80px;
}
.cart-main-card {
    background: #121212;
    border: 1px solid #222;
    border-radius: 16px;
    overflow: hidden;
    padding: 24px;
    max-width: 900px;
    margin: 0 auto;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
}
.cart-item-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 0;
    border-bottom: 1px solid #1e1e1e;
}
.cart-item-row:last-child { border-bottom: none; }
.cart-item-thumb { width: 70px; height: 70px; border-radius: 12px; object-fit: cover; }
.cart-item-name { font-family: 'Kantumruy Pro'; font-weight: 700; color: #fff; font-size: 1.1rem; }
.cart-price { color: #32e622; font-weight: 700; font-size: 1.1rem; }

/* Qty Buttons */
.cart-qty-wrap { display: flex; align-items: center; gap: 8px; }
.cart-qty-btn { width: 30px; height: 30px; background: #32e622; border: none; font-weight: bold; cursor: pointer; border-radius: 6px; }
.cart-qty-val { color: #fff; font-weight: bold; min-width: 20px; text-align: center; }
.btn-remove { background: transparent; border: none; color: #ff4d4f; cursor: pointer; font-size: 1.2rem; }

/* Footer summary */
.cart-summary-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #222;
}
.total-amount { color: #32e622; font-size: 1.8rem; font-weight: 900; }
</style>
@endpush

@section('content')
<div class="cart-page-wrapper">
    <div class="container">
        <h2 class="text-white mb-4" style="font-family: 'Kantumruy Pro'; text-align: center;">កន្ត្រកទំនិញរបស់អ្នក</h2>
        
        <div class="cart-main-card">
            @if(empty($cart) || (is_object($cart) && $cart->isEmpty()))
                <div class="text-center text-muted py-5">
                    <p style="font-family: 'Kantumruy Pro';">មិនមានទំនិញក្នុងកន្ត្រកឡើយ</p>
                    <a href="{{ url('/') }}" class="btn style="background: #32e622; color: #000;">ទៅទិញទំនិញ</a>
                </div>
            @else
                @foreach($cart as $key => $item)
                <div class="cart-item-row" data-food-id="{{ $item['food_id'] ?? $key }}">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <img src="{{ asset($item['image']) }}" class="cart-item-thumb" onerror="this.src='{{ asset('assets/Overal/logo.png') }}'">
                        <span class="cart-item-name">{{ $item['name'] }}</span>
                    </div>
                    
                    <div class="cart-price">${{ number_format($item['price'], 2) }}</div>
                    
                    <div class="cart-qty-wrap">
                        <button class="cart-qty-btn btn-qty-minus">−</button>
                        <span class="cart-qty-val qty-input">{{ $item['quantity'] }}</span>
                        <button class="cart-qty-btn btn-qty-plus">+</button>
                    </div>
                    
                    <button class="btn-remove">🗑️</button>
                </div>
                @endforeach

                <div class="cart-summary-footer">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" style="background: transparent; border: 1px solid #ff4d4f; color: #ff4d4f; padding: 10px 20px; border-radius: 50px; cursor: pointer; font-family: 'Kantumruy Pro';">🗑️ សម្អាតកន្ត្រក</button>
                    </form>
                    
                    <div class="text-right">
                        <span class="text-muted" style="font-family: 'Kantumruy Pro';">សរុប៖ </span>
                        <span class="total-amount">$<span id="cart-total">{{ number_format($total ?? 0, 2) }}</span></span>
                        <br>
                        <a href="{{ route('checkout.index') }}" class="btn" style="background: #32e622; color:#000; font-weight: bold; padding: 12px 30px; border-radius: 50px; text-decoration: none; display: inline-block; margin-top: 10px; font-family: 'Kantumruy Pro';">បន្តទៅកាន់ការទូទាត់ប្រាក់ ➔</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection