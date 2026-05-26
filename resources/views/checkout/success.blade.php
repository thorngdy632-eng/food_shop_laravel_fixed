{{-- resources/views/checkout/success.blade.php --}}
@extends('layouts.app')

@section('title', 'Order Placed!')

@section('content')
<div class="container py-5 text-center" style="max-width:600px">
    <div class="display-1 mb-3">🎉</div>
    <h2 class="mb-2">Order Placed Successfully!</h2>
    <p class="text-muted">Thank you, <strong>{{ $order->name }}</strong>!
       Your order <strong>#{{ $order->id }}</strong> has been received.</p>

    <div class="card my-4 text-start shadow-sm">
        <div class="card-header fw-semibold">Order Details</div>
        <ul class="list-group list-group-flush">
            @foreach($order->items as $item)
            <li class="list-group-item d-flex justify-content-between">
                <span>{{ $item->name }} ×{{ $item->quantity }}</span>
                <span>${{ number_format($item->subtotal, 2) }}</span>
            </li>
            @endforeach
        </ul>
        <div class="card-footer d-flex justify-content-between fw-bold">
            <span>Total Paid</span>
            <span>${{ number_format($order->total_price, 2) }}</span>
        </div>
    </div>

    <p class="text-muted small">📍 Delivering to: {{ $order->address }}</p>

    <div class="d-flex gap-3 justify-content-center mt-4">
        <a href="{{ route('order.history') }}" class="btn btn-outline-primary">View My Orders</a>
        <a href="{{ route('home') }}" class="btn btn-success">Order More 🍽</a>
    </div>
</div>
@endsection
