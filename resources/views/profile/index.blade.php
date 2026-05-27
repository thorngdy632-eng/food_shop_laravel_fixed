@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container py-5" style="max-width:860px;margin:0 auto;">
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2" style="background:rgba(72,187,120,.12);color:#276749;border:1px solid rgba(72,187,120,.3);padding:13px 18px;border-radius:10px;margin-bottom:20px;">
            <i class="fa fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error d-flex align-items-center gap-2" style="background:rgba(252,129,129,.12);color:#c53030;border:1px solid rgba(252,129,129,.3);padding:13px 18px;border-radius:10px;margin-bottom:20px;">
            <i class="fa fa-triangle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm rounded-4 border-0 overflow-hidden" style="background:#fff;">
        <div class="card-header d-flex align-items-center gap-3 px-4 py-3" style="background:linear-gradient(135deg,#1a1a1a,#2d2d2d);border-bottom:1px solid #333;">
            <div style="width:60px;height:60px;border-radius:50%;overflow:hidden;border:3px solid var(--accent);flex-shrink:0;">
                <img src="{{ $user->profile_image && $user->profile_image !== 'default.jfif' ? asset('storage/profile_images/' . $user->profile_image) : asset('assets/profiles/default.jfif') }}"
                     alt="" style="width:100%;height:100%;object-fit:cover;">
            </div>
            <div>
                <h4 class="mb-0 text-white fw-bold">{{ $user->name }}</h4>
                <small class="text-muted">
                    <span class="badge" style="background:var(--accent);color:#000;">{{ ucfirst($user->role) }}</span>
                    <span class="ms-2"><i class="fa fa-envelope"></i> {{ $user->email }}</span>
                </small>
            </div>
            <a href="{{ route('order.history') }}" class="btn btn-sm ms-auto" style="background:var(--accent);color:#000;font-weight:600;">
                <i class="fa fa-clock-rotate-left"></i> My Orders
            </a>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Full Name</label>
                        <input type="text" name="fullname" class="form-control" value="{{ old('fullname', $user->name) }}" required>
                        @error('fullname') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="+855 12 345 678">
                        @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Profile Image</label>
                        <input type="file" name="profile_image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                        <div class="small text-muted mt-1">JPEG, PNG, JPG, GIF, WebP (max 3MB)</div>
                        @error('profile_image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Bio / About Me</label>
                    <textarea name="bio" class="form-control" rows="3" placeholder="Tell us a little about yourself...">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <hr class="my-4">
                <h5 class="mb-3"><i class="fa fa-lock" style="color:var(--accent);"></i> Change Password</h5>
                <p class="small text-muted mb-3">Leave blank if you don't want to change your password.</p>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Current Password</label>
                        <input type="password" name="old_password" class="form-control" placeholder="Enter current password">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">New Password</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Min 6 characters">
                        @error('new_password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control" placeholder="Re-enter new password">
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn px-4 py-2" style="background:var(--accent);color:#000;font-weight:700;border-radius:10px;">
                        <i class="fa fa-floppy-disk"></i> Save Changes
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary px-4 py-2" style="border-radius:10px;">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    @if($orders->count())
    <div class="mt-4">
        <h5 class="fw-bold mb-3"><i class="fa fa-clock-rotate-left" style="color:var(--accent);"></i> Recent Orders</h5>
        <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,.08);border:1px solid #e2e8f0;overflow:hidden;">
            @foreach($orders as $order)
            <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom:1px solid #e2e8f0;">
                <div>
                    <strong>Order #{{ $order->id }}</strong>
                    <span class="badge ms-2" style="background:
                        {{ $order->status === 'delivered' ? 'rgba(72,187,120,.15)' : ($order->status === 'cancelled' ? 'rgba(252,129,129,.15)' : 'rgba(236,201,75,.15)') }};
                        color:
                        {{ $order->status === 'delivered' ? '#276749' : ($order->status === 'cancelled' ? '#c53030' : '#b7791f') }};">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="text-end">
                    <div class="fw-bold">${{ number_format($order->total_price, 2) }}</div>
                    <small class="text-muted">{{ $order->created_at->format('d M Y, h:i A') }}</small>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('order.history') }}" class="btn btn-sm" style="background:var(--accent);color:#000;font-weight:600;border-radius:8px;">
                <i class="fa fa-eye"></i> View All Orders
            </a>
        </div>
    </div>
    @endif
</div>

<style>
    .form-control {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: .9rem;
        transition: border-color .2s, box-shadow .2s;
    }
    .form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(50,230,34,.15);
        outline: none;
    }
    .form-label { font-size: .85rem; margin-bottom: 5px; }
    .card { box-shadow: 0 1px 3px rgba(0,0,0,.08); }
</style>
@endsection
