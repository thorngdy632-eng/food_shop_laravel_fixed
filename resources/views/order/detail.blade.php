@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="container py-5" style="max-width:800px;margin:0 auto;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fa fa-receipt" style="color:var(--accent);"></i> Order #{{ $order->id }}</h2>
            <small class="text-muted">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</small>
        </div>
        <a href="{{ route('order.history') }}" class="btn btn-sm" style="background:var(--accent);color:#000;font-weight:600;border-radius:8px;">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,.08);border:1px solid #e2e8f0;overflow:hidden;">

        <div style="padding:20px 24px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;background:#fafafa;">
            <div>
                <span class="text-muted small">Status</span>
                <div>
                    <span class="badge" style="background:
                        {{ $order->status === 'delivered' ? 'rgba(72,187,120,.15)' : ($order->status === 'cancelled' ? 'rgba(252,129,129,.15)' : 'rgba(236,201,75,.15)') }};
                        color:
                        {{ $order->status === 'delivered' ? '#276749' : ($order->status === 'cancelled' ? '#c53030' : '#b7791f') }};
                        padding:6px 14px;font-size:.85rem;">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
            <div class="text-end">
                <span class="text-muted small">Payment</span>
                <div class="fw-semibold">{{ ucfirst($order->payment_method) }}</div>
            </div>
        </div>

        <div style="padding:20px 24px;border-bottom:1px solid #e2e8f0;">
            <h6 class="fw-bold mb-3"><i class="fa fa-location-dot" style="color:var(--accent);"></i> Delivery Details</h6>
            <div class="row g-2">
                <div class="col-sm-6"><small class="text-muted d-block">Name</small><span>{{ $order->name }}</span></div>
                <div class="col-sm-6"><small class="text-muted d-block">Phone</small><span>{{ $order->phone }}</span></div>
                <div class="col-12"><small class="text-muted d-block">Address</small><span>{{ $order->address }}</span></div>
                @if($order->notes)
                <div class="col-12"><small class="text-muted d-block">Notes</small><span>{{ $order->notes }}</span></div>
                @endif
            </div>
        </div>

        <div style="padding:0;">
            <div style="padding:16px 24px;border-bottom:1px solid #e2e8f0;">
                <h6 class="fw-bold mb-0"><i class="fa fa-bowl-food" style="color:var(--accent);"></i> Items</h6>
            </div>
            @foreach($order->items as $item)
            <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom:1px solid #e2e8f0;">
                <div>
                    <strong>{{ $item->name }}</strong>
                    <span class="text-muted small ms-2">×{{ $item->quantity }}</span>
                </div>
                <span class="fw-semibold">${{ number_format($item->subtotal, 2) }}</span>
            </div>
            @endforeach
            <div class="d-flex align-items-center justify-content-between px-4 py-3" style="background:#fafafa;">
                <strong>Total</strong>
                <strong style="color:var(--accent);font-size:1.2rem;">${{ number_format($order->total_price, 2) }}</strong>
            </div>
        </div>
    </div>
</div>
@endsection
