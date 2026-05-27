@extends('layouts.checkout')

@section('title', 'ការបញ្ជាទិញ — THORNG DY\'S SHOP')

@section('content')

<style>
    .payment-card input[type="radio"] {
        display: none !important;
    }
    .payment-card:has(input:checked) {
        border-color: #10b981 !important;
        background-color: #ecfdf5 !important;
    }
    .payment-card:has(input:checked) .payment-check {
        opacity: 1 !important;
        transform: scale(1) !important;
    }
    .scrollbar-thin::-webkit-scrollbar {
        width: 4px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background: transparent;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 99px;
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ── Back Link ── --}}
        <div class="mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors duration-200 group">
                <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                ត្រឡប់ទៅទំព័រដើម
            </a>
        </div>

        {{-- ── Page Header ── --}}
        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight flex items-center gap-3">
                <span class="text-emerald-500">📝</span>
                ការបញ្ជាទិញទំនិញ
            </h1>
            <p class="mt-2 text-gray-500 text-sm sm:text-base">សូមបំពេញព័ត៌មានដឹកជញ្ជូន និងជ្រើសរើសវិធីបង់ប្រាក់</p>
        </div>

        {{-- ── Validation Errors ── --}}
        @if($errors->any())
            <div class="mb-8 p-5 rounded-2xl text-sm font-medium bg-red-50 border border-red-200 text-red-700 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-semibold">សូមកែតម្រូវកំហុសខាងក្រោម</span>
                </div>
                <ul class="list-disc list-inside space-y-1 pl-7">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ── Two-Column Layout ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">

            {{-- ═══════════════════ COLUMN LEFT: SHIPPING FORM ═══════════════════ --}}
            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl shadow-[0_2px_20px_-4px_rgba(0,0,0,0.08)] border border-gray-100 p-6 sm:p-8 lg:p-10">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-8 flex items-center gap-3 border-b border-gray-100 pb-5">
                        <span class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 text-lg">📦</span>
                        ព័ត៌មានដឹកជញ្ជូន
                    </h2>

                    <form action="{{ route('order.place') }}" method="POST" id="checkout-form" class="space-y-6">
                        @csrf

                        {{-- Name --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">ឈ្មោះពេញ <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                                class="w-full px-4 py-3.5 bg-gray-50/80 border border-gray-200 rounded-2xl focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 transition duration-200 text-gray-800 font-medium placeholder:text-gray-400">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">លេខទូរស័ព្ទ <span class="text-red-500">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+855 xx xxx xxx" required
                                class="w-full px-4 py-3.5 bg-gray-50/80 border border-gray-200 rounded-2xl focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 transition duration-200 text-gray-800 font-medium placeholder:text-gray-400">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">អាសយដ្ឋានដឹកជញ្ជូន <span class="text-red-500">*</span></label>
                            <textarea name="address" rows="3" placeholder="សូមបញ្ចូលខេត្ត ក្រុង ផ្លូវ និងលេខផ្ទះ..." required
                                class="w-full px-4 py-3.5 bg-gray-50/80 border border-gray-200 rounded-2xl focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 transition duration-200 text-gray-800 font-medium resize-none placeholder:text-gray-400">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Payment Method --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">វិធីបង់ប្រាក់ <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                                <label class="payment-card relative flex flex-col items-center text-center p-5 border-2 border-gray-200 rounded-2xl cursor-pointer hover:border-emerald-400 transition-all duration-200 bg-white hover:bg-emerald-50/30 hover:shadow-sm">
                                    <input type="radio" name="payment_method" value="cash" {{ old('payment_method', 'cash') === 'cash' ? 'checked' : '' }}>
                                    <span class="payment-check absolute top-3 right-3 w-5 h-5 bg-emerald-500 rounded-full flex items-center justify-center opacity-0 scale-0 transition-all duration-200">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </span>
                                    <span class="text-3xl mb-2 block">💵</span>
                                    <span class="font-bold text-sm text-gray-900">សាច់ប្រាក់</span>
                                    <span class="text-xs text-gray-400 mt-1">បង់ពេលទំនិញទៅដល់</span>
                                </label>

                                <label class="payment-card relative flex flex-col items-center text-center p-5 border-2 border-gray-200 rounded-2xl cursor-pointer hover:border-emerald-400 transition-all duration-200 bg-white hover:bg-emerald-50/30 hover:shadow-sm">
                                    <input type="radio" name="payment_method" value="card" {{ old('payment_method') === 'card' ? 'checked' : '' }}>
                                    <span class="payment-check absolute top-3 right-3 w-5 h-5 bg-emerald-500 rounded-full flex items-center justify-center opacity-0 scale-0 transition-all duration-200">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </span>
                                    <span class="text-3xl mb-2 block">💳</span>
                                    <span class="font-bold text-sm text-gray-900">កាតធនាគារ</span>
                                    <span class="text-xs text-gray-400 mt-1">Visa / Mastercard</span>
                                </label>

                                <label class="payment-card relative flex flex-col items-center text-center p-5 border-2 border-gray-200 rounded-2xl cursor-pointer hover:border-emerald-400 transition-all duration-200 bg-white hover:bg-emerald-50/30 hover:shadow-sm">
                                    <input type="radio" name="payment_method" value="qr" {{ old('payment_method') === 'qr' ? 'checked' : '' }}>
                                    <span class="payment-check absolute top-3 right-3 w-5 h-5 bg-emerald-500 rounded-full flex items-center justify-center opacity-0 scale-0 transition-all duration-200">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </span>
                                    <span class="text-3xl mb-2 block">📱</span>
                                    <span class="font-bold text-sm text-gray-900">QR / ស្កែន</span>
                                    <span class="text-xs text-gray-400 mt-1">ទូទាត់តាមទូរស័ព្ទ</span>
                                </label>

                            </div>
                            @error('payment_method')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">កំណត់សម្គាល់ (បើមាន)</label>
                            <textarea name="notes" rows="2" placeholder="បញ្ជាក់បន្ថែមអំពីអាហារ ឬទីតាំង..."
                                class="w-full px-4 py-3.5 bg-gray-50/80 border border-gray-200 rounded-2xl focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 transition duration-200 text-gray-800 font-medium resize-none placeholder:text-gray-400">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fa fa-circle-exclamation"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <button type="submit" id="submit-btn"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold py-4 px-6 rounded-2xl shadow-lg shadow-emerald-600/25 hover:shadow-xl hover:shadow-emerald-600/30 transform active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-3 cursor-pointer text-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>បញ្ជាក់ការបញ្ជាទិញ</span>
                        </button>

                    </form>
                </div>
            </div>

            {{-- ═══════════════════ COLUMN RIGHT: ORDER SUMMARY ═══════════════════ --}}
            <div class="lg:col-span-5">
                <div class="bg-white rounded-3xl shadow-[0_2px_20px_-4px_rgba(0,0,0,0.08)] border border-gray-100 p-6 sm:p-8 lg:p-10 sticky top-8">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3 border-b border-gray-100 pb-5">
                        <span class="w-9 h-9 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 text-lg">📋</span>
                        សេចក្តីសង្ខេបការបញ្ជាទិញ
                    </h2>

                    {{-- Cart Items --}}
                    <div class="space-y-4 max-h-[320px] overflow-y-auto pr-1 scrollbar-thin">
                        @forelse($cart as $item)
                            <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-xl shrink-0 shadow-sm">🍲</div>
                                    <div class="min-w-0">
                                        <h3 class="font-bold text-sm text-gray-800 truncate">{{ $item['name'] }}</h3>
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            <span class="font-medium text-gray-500">{{ $item['quantity'] }}</span> x
                                            <span class="font-semibold text-gray-600">${{ number_format($item['price'], 2) }}</span>
                                        </p>
                                    </div>
                                </div>
                                <span class="font-extrabold text-sm text-gray-800 shrink-0 ml-3">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-400 text-sm">
                                <div class="text-4xl mb-3">🛒</div>
                                <p>មិនមានទំនិញក្នុងកន្ត្រកឡើយ</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Totals --}}
                    <div class="mt-6 pt-5 space-y-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 font-medium">តម្លៃទំនិញសរុប</span>
                            <span class="font-bold text-gray-800">${{ number_format($total ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 font-medium">សេវាដឹកជញ្ជូន</span>
                            <span class="text-emerald-600 font-bold bg-emerald-50 px-3 py-0.5 rounded-full text-xs inline-flex items-center gap-1">
                                <i class="fa fa-truck text-[10px]"></i> ឥតគិតថ្លៃ
                            </span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t-2 border-dashed border-gray-200">
                            <span class="text-base font-bold text-gray-900">ទឹកប្រាក់សរុប</span>
                            <span class="text-2xl font-black text-emerald-600">${{ number_format($total ?? 0, 2) }}</span>
                        </div>
                    </div>

                    {{-- Bottom Link --}}
                    <div class="mt-6 pt-5 text-center border-t border-gray-100">
                        <a href="{{ route('home') }}" class="text-sm text-gray-400 hover:text-emerald-600 font-semibold transition-colors duration-200 inline-flex items-center gap-2 group">
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            ត្រឡប់ទៅកាន់មុខម្ហូប
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const cards = document.querySelectorAll('.payment-card');

        function updateCards() {
            cards.forEach(card => {
                const radio = card.querySelector('input[type="radio"]');
                if (radio && radio.checked) {
                    card.classList.remove('border-gray-200', 'bg-white', 'hover:bg-emerald-50/30');
                    card.classList.add('border-emerald-500', 'bg-emerald-50/40');
                } else if (card) {
                    card.classList.remove('border-emerald-500', 'bg-emerald-50/40');
                    card.classList.add('border-gray-200', 'bg-white', 'hover:bg-emerald-50/30');
                }
            });
        }

        cards.forEach(card => {
            card.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                    updateCards();
                }
            });
        });

        updateCards();
    });
</script>
@endpush

@endsection
