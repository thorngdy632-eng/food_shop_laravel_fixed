<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&family=Noto+Sans+Khmer:wght@100..900&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Noto Sans Khmer', 'Kantumruy Pro', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-b from-gray-50 to-gray-100 min-h-screen py-10 px-4 sm:px-6 lg:px-8">

    <div class="max-w-3xl mx-auto">
        
        {{-- Clean Standalone Header --}}
        <div class="flex items-center justify-between border-b border-gray-200 pb-5 mb-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center shadow-md shadow-emerald-100">
                    <i class="fa-solid fa-clock-rotate-left text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight">ប្រវត្តិនៃការកម្ម៉ង់របស់អ្នក</h1>
                    <p class="text-xs text-gray-400 mt-0.5 uppercase tracking-wider font-semibold">Your Order History</p>
                </div>
            </div>
            
            {{-- Total Orders Badge Counts --}}
            <span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-3 py-1.5 rounded-full border border-emerald-200">
                សរុប: {{ $orders->count() }} កម្ម៉ង់
            </span>
        </div>

        {{-- Flash Success Alert --}}
        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-5 py-4 mb-6 flex items-center gap-3 shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
        @endif

        @if($orders->isEmpty())
        {{-- Empty State (No Header/Footer Context) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                <i class="fa-solid fa-box-open text-gray-300 text-2xl"></i>
            </div>
            <h3 class="text-base font-bold text-gray-700 mb-1">មិនទាន់មានការកម្ម៉ង់នៅឡើយទេ</h3>
            <p class="text-xs text-gray-400 mb-6">អ្នកមិនទាន់បានធ្វើការកម្ម៉ង់ម្ហូបអាហារនៅឡើយទេ</p>
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all duration-200 shadow-sm">
                <i class="fa-solid fa-utensils text-xs"></i>
                ទៅកាន់ទំព័រដើម
            </a>
        </div>
        @else
        
        {{-- Container Stack --}}
        <div class="space-y-5">
            @foreach($orders as $order)
            @php
                $statusMap = [
                    'pending'    => ['bg-amber-50 text-amber-700 border-amber-200', 'fa-solid fa-clock', 'កំពុងរង់ចាំ'],
                    'processing' => ['bg-blue-50 text-blue-700 border-blue-200', 'fa-solid fa-gear', 'កំពុងដំណើរការ'],
                    'completed'  => ['bg-emerald-50 text-emerald-700 border-emerald-200', 'fa-solid fa-circle-check', 'បានបញ្ចប់'],
                    'delivered'  => ['bg-emerald-50 text-emerald-700 border-emerald-200', 'fa-solid fa-circle-check', 'បានដឹកជញ្ជូន'],
                    'cancelled'  => ['bg-red-50 text-red-700 border-red-200', 'fa-solid fa-circle-xmark', 'បានបោះបង់'],
                ];
                $status = $statusMap[$order->status] ?? $statusMap['pending'];
            @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-200 hover:shadow-md">
                
                {{-- Header Row inside Card --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center border border-emerald-100">
                            <i class="fa-solid fa-receipt text-emerald-600 text-xs"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">ID កម្ម៉ង់</span>
                            <h3 class="text-sm font-bold text-gray-800 leading-none">#{{ sprintf('%04d', $order->id) }}</h3>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-xs text-gray-400 flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar text-gray-300"></i>
                            {{ $order->created_at->format('d M Y, h:i A') }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md border text-xs font-bold {{ $status[0] }}">
                            <i class="{{ $status[1] }} text-[10px]"></i>
                            {{ $status[2] }}
                        </span>
                    </div>
                </div>

                {{-- Food Items Row Lists --}}
                <div class="px-6 py-4 space-y-3.5">
                    @foreach($order->items as $item)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0 border border-gray-100">
                                <i class="fa-solid fa-bowl-food text-gray-400 text-xs"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-gray-800 truncate">{{ $item->name }}</p>
                                <p class="text-[11px] text-gray-400 font-medium mt-0.5">បរិមាណ: ×{{ $item->quantity }}</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-gray-700 whitespace-nowrap ml-4">
                            ${{ number_format($item->subtotal ?? ($item->price * $item->quantity), 2) }}
                        </span>
                    </div>
                    @if(!$loop->last)
                    <hr class="border-gray-100">
                    @endif
                    @endforeach
                </div>

                {{-- Standalone Card Delivery Area --}}
                <div class="px-6 py-3 bg-gray-50/30 border-t border-gray-50 flex items-start gap-2">
                    <i class="fa-solid fa-map-location-dot text-emerald-500 text-xs mt-0.5"></i>
                    <div class="min-w-0">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">អាសយដ្ឋានដឹកជញ្ជូន</p>
                        <p class="text-xs text-gray-600 leading-relaxed mt-0.5">{{ $order->address }}</p>
                    </div>
                </div>

                {{-- Card Footer Total Amount --}}
                <div class="px-6 py-3.5 border-t border-gray-100 flex items-center justify-between bg-white">
                    <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">ទឹកប្រាក់សរុបរួម</span>
                    <span class="text-base font-black text-emerald-600">${{ number_format($order->total_price, 2) }}</span>
                </div>
                
            </div>
            @endforeach
        </div>

        {{-- Simple Pagination Navigation Links --}}
        @if(method_exists($orders, 'links'))
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
        @endif

        @endif
        
    </div>

</body>
</html>