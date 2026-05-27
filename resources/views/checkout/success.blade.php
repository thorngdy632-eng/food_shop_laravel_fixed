{{-- resources/views/checkout/success.blade.php --}}
@extends('layouts.checkout')

@section('title', 'ការបញ្ជាទិញជោគជ័យ')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-16 text-center animate-fade-in">
    
    {{-- Icon ជោគជ័យបែបទំនើប --}}
    <div class="inline-flex items-center justify-center w-20 h-20 bg-green-50 rounded-full mb-6 border border-green-100">
        <span class="text-4xl">🎉</span>
    </div>
    
    {{-- ចំណងជើងធំ --}}
    <h2 class="text-3xl font-extrabold text-gray-900 mb-3 tracking-tight">ការបញ្ជាទិញបានជោគជ័យ!</h2>
    <p class="text-base text-gray-500 max-w-md mx-auto mb-10">
        សូមអរគុណ <strong>{{ $order->name }}</strong>! ការបញ្ជាទិញលេខ 
        <span class="inline-block px-2.5 py-0.5 text-xs font-bold bg-green-100 text-green-800 rounded-full">#{{ $order->id }}</span> 
        ត្រូវបានទទួលយក និងកំពុងរៀបចំហើយ។
    </p>

    {{-- កាតបង្ហាញព័ត៌មានលម្អិតនៃវិក្កយបត្រ (Order Details Card) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-left mb-8">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                📋 លម្អិតនៃការបញ្ជាទិញ
            </h3>
        </div>
        
        {{-- បញ្ជីមុខម្ហូប --}}
        <div class="px-6 py-2 divide-y divide-gray-100">
            @foreach($order->items as $item)
            <div class="flex justify-between items-center py-4">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $item->name }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">បរិមាណ: {{ $item->quantity }}</p>
                </div>
                <span class="text-sm font-semibold text-gray-900 ml-4">${{ number_format($item->subtotal, 2) }}</span>
            </div>
            @endforeach
        </div>

        {{-- ផ្នែកទឹកប្រាក់សរុប --}}
        <div class="px-6 py-4 bg-green-50/50 border-t border-gray-100 flex justify-between items-center">
            <span class="text-sm font-bold text-gray-700">ទឹកប្រាក់បានទូទាត់សរុប</span>
            <span class="text-xl font-black text-green-600">${{ number_format($order->total_price, 2) }}</span>
        </div>
    </div>

    {{-- ទីតាំងដឹកជញ្ជូន --}}
    <div class="inline-flex items-center gap-2 text-sm text-gray-500 bg-gray-100 px-4 py-2.5 rounded-full mb-10 max-w-full truncate">
        <span>📍</span> <span class="font-medium text-gray-700">អាសយដ្ឋានដឹកជញ្ជូន:</span> {{ $order->address }}
    </div>

    {{-- ប៊ូតុងសកម្មភាព (Action Buttons) --}}
    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
        <a href="{{ route('order.history') }}" 
           class="w-full sm:w-auto px-6 py-3 border border-gray-200 text-gray-700 font-bold text-sm rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-all duration-150 text-center">
            មើលប្រវត្តិកុម្ម៉ង់អាហារ
        </a>
        <a href="{{ route('home') }}" 
           class="w-full sm:w-auto px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-green-600/10 transform active:scale-[0.98] transition-all duration-150 flex items-center justify-center gap-1.5 text-center cursor-pointer">
            កុម្ម៉ង់អាហារបន្ថែមទៀត 🍽️
        </a>
    </div>

</div>
@endsection