@extends('layouts.app')

@section('title', 'Order History')

@section('content')
<div class="container py-5" style="max-width:860px">
    <h2 class="mb-4"><i class="fa-solid fa-clock-rotate-left"></i> My Orders</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <div class="display-6 mb-3">📦</div>
            <h4 class="text-muted">No orders yet.</h4>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">Browse Menu</a>
        </div>
    @else
        <div class="list-group">
            @foreach($orders as $order)
            <div class="list-group-item list-group-item-action mb-3 rounded border shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <strong>Order #{{ $order->id }}</strong>
                        <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }} ms-2">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <small class="text-muted">{{ $order->created_at->format('d M Y, h:i A') }}</small>
                </div>

                <ul class="list-unstyled mb-2 small">
                    @foreach($order->items as $item)
                    <li class="d-flex justify-content-between">
                        <span>{{ $item->name }} ×{{ $item->quantity }}</span>
                        <span>${{ number_format($item->subtotal, 2) }}</span>
                    </li>
                    @endforeach
                </ul>

                <div class="d-flex justify-content-between border-top pt-2">
                    <span class="text-muted">📍 {{ $order->address }}</span>
                    <strong>Total: ${{ number_format($order->total_price, 2) }}</strong>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
