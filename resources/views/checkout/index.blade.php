{{-- resources/views/checkout/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5" style="max-width:760px">
    <h2 class="mb-4">📋 Checkout</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-4">

        {{-- ── Delivery Form ── --}}
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">📦 Delivery Details</div>
                <div class="card-body">
                    <form action="{{ route('order.place') }}" method="POST" id="checkout-form">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number *</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}" placeholder="+855 xx xxx xxx" required>
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Delivery Address *</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                      rows="3" required>{{ old('address') }}</textarea>
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Payment Method *</label>
                            <div class="d-flex gap-3 flex-wrap">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                           name="payment_method" value="cash" id="pay_cash"
                                           {{ old('payment_method', 'cash') === 'cash' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pay_cash">💵 Cash on Delivery</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                           name="payment_method" value="card" id="pay_card"
                                           {{ old('payment_method') === 'card' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pay_card">💳 Card</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                           name="payment_method" value="qr" id="pay_qr"
                                           {{ old('payment_method') === 'qr' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pay_qr">📱 QR / E-Wallet</label>
                                </div>
                            </div>
                            @error('payment_method')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notes (optional)</label>
                            <textarea name="notes" class="form-control" rows="2"
                                      placeholder="Special requests, allergies…">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100 btn-lg" id="place-order-btn">
                            ✅ Confirm Order
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ── Order Summary ── --}}
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">🧾 Order Summary</div>
                <ul class="list-group list-group-flush">
                    @foreach($cart as $item)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $item['name'] }} <span class="text-muted">×{{ $item['quantity'] }}</span></span>
                        <span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </li>
                    @endforeach
                </ul>
                <div class="card-footer d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </div>

            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-3">← Edit Cart</a>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
// FIX: prevent double-submit but re-enable the button if validation fails
// (validation failure causes a redirect back, so button state resets on page load)
// We also add a safety timeout in case the server is slow.
const form = document.getElementById('checkout-form');
const btn  = document.getElementById('place-order-btn');
let submitted = false;

form.addEventListener('submit', function (e) {
    // Run HTML5 validation first; if invalid, don't disable
    if (!form.checkValidity()) return;

    if (submitted) {
        // Already submitted, prevent second click
        e.preventDefault();
        return;
    }

    submitted = true;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Placing order…';

    // Safety: re-enable after 15 s in case something goes wrong
    setTimeout(() => {
        submitted  = false;
        btn.disabled   = false;
        btn.textContent = '✅ Confirm Order';
    }, 15000);
});
</script>
@endpush
