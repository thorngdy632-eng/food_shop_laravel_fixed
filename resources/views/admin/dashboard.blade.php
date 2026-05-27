@extends('layouts.layout')

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script>
  tailwind.config = {
    darkMode: 'class',
    theme: {
      extend: {
        colors: {
          emerald: {
            DEFAULT: '#32e622',
            50:  'rgba(50,230,34,0.05)',
            100: 'rgba(50,230,34,0.1)',
            200: 'rgba(50,230,34,0.2)',
            300: 'rgba(50,230,34,0.3)',
            400: 'rgba(50,230,34,0.4)',
            500: '#32e622',
            600: '#29c71b',
            700: '#20a814',
            800: '#178a0d',
            900: '#0e6b06',
          },
          surface: {
            DEFAULT: '#121212',
            50:  '#1a1a1a',
            100: '#1f1f1f',
            200: '#252525',
            300: '#2a2a2a',
            400: '#333333',
          }
        },
        fontFamily: {
          khmer: ["'Noto Sans Khmer'", "'Kantumruy Pro'", "sans-serif"],
        }
      }
    }
  }
</script>
<style>
  body { font-family: 'Noto Sans Khmer', 'Kantumruy Pro', sans-serif; }
  .scroll-thin::-webkit-scrollbar { width: 4px; }
  .scroll-thin::-webkit-scrollbar-track { background: transparent; }
  .scroll-thin::-webkit-scrollbar-thumb { background: #333; border-radius: 999px; }
</style>
@endpush

@section('title', 'ផ្ទាំងគ្រប់គ្រង')
@section('breadcrumb', 'ផ្ទាំងគ្រប់គ្រង')

@section('content')
<div class="space-y-8">

  {{-- Page Header --}}
  <div class="flex items-center justify-between flex-wrap gap-4">
    <div>
      <h1 class="text-2xl font-bold text-white tracking-tight flex items-center gap-3 font-khmer">
        <span class="w-9 h-9 rounded-xl flex items-center justify-center text-lg shrink-0 bg-emerald-100 text-emerald-500">
          <i class="fa fa-gauge"></i>
        </span>
        ផ្ទាំងគ្រប់គ្រង
      </h1>
      <p class="mt-1.5 text-sm text-gray-500">ទិដ្ឋភាពទូទៅនៃដំណើរការហាងរបស់អ្នក</p>
    </div>
    <div class="flex items-center gap-2 text-xs text-gray-600">
      <span class="inline-flex items-center gap-1.5">
        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
        {{ now()->format('D, M d, Y') }}
      </span>
    </div>
  </div>

  {{-- Stats Grid --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-surface-50 border border-surface-200 rounded-2xl p-5 flex items-center gap-4 transition-all duration-300 hover:border-emerald-300 hover:shadow-lg hover:shadow-emerald-500/5 hover:-translate-y-0.5">
      <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shrink-0 bg-emerald-100 text-emerald-500">
        <i class="fa fa-dollar-sign"></i>
      </div>
      <div class="min-w-0">
        <div class="text-2xl font-extrabold text-white tracking-tight truncate">${{ number_format($stats['total_revenue'], 2) }}</div>
        <div class="text-xs font-medium mt-1 text-gray-500">ចំណូលសរុប</div>
      </div>
    </div>
    <div class="bg-surface-50 border border-surface-200 rounded-2xl p-5 flex items-center gap-4 transition-all duration-300 hover:border-emerald-300 hover:shadow-lg hover:shadow-emerald-500/5 hover:-translate-y-0.5">
      <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shrink-0 bg-emerald-100 text-emerald-500">
        <i class="fa fa-receipt"></i>
      </div>
      <div class="min-w-0">
        <div class="text-2xl font-extrabold text-white tracking-tight">{{ $stats['total_orders'] }}</div>
        <div class="text-xs font-medium mt-1 text-gray-500">ការបញ្ជាទិញសរុប</div>
      </div>
    </div>
    <div class="bg-surface-50 border border-surface-200 rounded-2xl p-5 flex items-center gap-4 transition-all duration-300 hover:border-emerald-300 hover:shadow-lg hover:shadow-emerald-500/5 hover:-translate-y-0.5">
      <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shrink-0 bg-yellow-500/10 text-yellow-400">
        <i class="fa fa-clock"></i>
      </div>
      <div class="min-w-0">
        <div class="text-2xl font-extrabold text-white tracking-tight">{{ $stats['pending_orders'] }}</div>
        <div class="text-xs font-medium mt-1 text-gray-500">រង់ចាំការអនុម័ត</div>
      </div>
    </div>
    <div class="bg-surface-50 border border-surface-200 rounded-2xl p-5 flex items-center gap-4 transition-all duration-300 hover:border-emerald-300 hover:shadow-lg hover:shadow-emerald-500/5 hover:-translate-y-0.5">
      <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl shrink-0 bg-purple-500/10 text-purple-400">
        <i class="fa fa-users"></i>
      </div>
      <div class="min-w-0">
        <div class="text-2xl font-extrabold text-white tracking-tight">{{ $stats['total_users'] }}</div>
        <div class="text-xs font-medium mt-1 text-gray-500">អតិថិជន</div>
      </div>
    </div>
  </div>

  {{-- Two-Column Layout --}}
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    {{-- Recent Orders --}}
    <div class="lg:col-span-7 bg-surface-50 border border-surface-200 rounded-2xl overflow-hidden">
      <div class="flex items-center justify-between flex-wrap gap-3 px-6 py-4 border-b border-surface-200">
        <h3 class="text-sm font-bold text-white flex items-center gap-2.5 font-khmer">
          <i class="fa fa-clock-rotate-left text-emerald-500"></i>
          ការបញ្ជាទិញថ្មីៗ
        </h3>
        <a href="{{ route('admin.orders') }}" class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-all duration-200 flex items-center gap-1.5 text-gray-400 border border-surface-200 bg-surface-100 hover:bg-surface-200 hover:text-white">
          មើលទាំងអស់
          <i class="fa fa-arrow-right text-[10px]"></i>
        </a>
      </div>

      @if($recent_orders->count())
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr>
              <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wider text-emerald-500 bg-surface-100 border-b border-surface-200 whitespace-nowrap">លេខកូដ</th>
              <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wider text-emerald-500 bg-surface-100 border-b border-surface-200 whitespace-nowrap">អតិថិជន</th>
              <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wider text-emerald-500 bg-surface-100 border-b border-surface-200 whitespace-nowrap">តម្លៃសរុប</th>
              <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wider text-emerald-500 bg-surface-100 border-b border-surface-200 whitespace-nowrap">ស្ថានភាព</th>
              <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wider text-emerald-500 bg-surface-100 border-b border-surface-200 whitespace-nowrap">កាលបរិច្ឆេទ</th>
            </tr>
          </thead>
          <tbody>
            @foreach($recent_orders as $order)
            <tr class="transition-colors duration-150 hover:bg-white/[0.015]">
              <td class="px-4 py-3.5 border-b border-surface-200 font-semibold text-white text-sm">#{{ $order->id }}</td>
              <td class="px-4 py-3.5 border-b border-surface-200">
                <div class="flex items-center gap-2.5">
                  <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold shrink-0 bg-emerald-500/10 text-emerald-500">
                    {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                  </span>
                  <span class="truncate max-w-[120px] text-gray-300 text-sm">{{ $order->user->name ?? 'ភ្ញៀវ' }}</span>
                </div>
              </td>
              <td class="px-4 py-3.5 border-b border-surface-200 font-bold text-emerald-500 text-sm">${{ number_format($order->total_price, 2) }}</td>
              <td class="px-4 py-3.5 border-b border-surface-200">
                @php
                  $statusColors = [
                    'pending'   => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                    'confirmed' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                    'preparing' => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                    'delivered' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                    'cancelled' => 'bg-red-500/10 text-red-400 border-red-500/20',
                  ];
                  $statusLabel = [
                    'pending'   => 'រង់ចាំ',
                    'confirmed' => 'បញ្ជាក់',
                    'preparing' => 'កំពុងរៀបចំ',
                    'delivered' => 'ដឹកជញ្ជូន',
                    'cancelled' => 'បោះបង់',
                  ];
                @endphp
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $statusColors[$order->status] ?? 'bg-gray-500/10 text-gray-400 border-gray-500/20' }}">
                  <span class="w-1.5 h-1.5 rounded-full" style="background:currentColor;"></span>
                  {{ $statusLabel[$order->status] ?? ucfirst($order->status) }}
                </span>
              </td>
              <td class="px-4 py-3.5 border-b border-surface-200 text-gray-500 text-sm whitespace-nowrap">{{ $order->created_at->format('M d, H:i') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @else
      <div class="flex flex-col items-center justify-center py-16 text-center">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-4 bg-surface-100 text-gray-600">
          <i class="fa fa-receipt"></i>
        </div>
        <h3 class="text-sm font-semibold text-white mb-1.5">មិនទាន់មានការបញ្ជាទិញ</h3>
        <p class="text-xs text-gray-500">ការបញ្ជាទិញនឹងបង្ហាញនៅទីនេះ នៅពេលអតិថិជនចាប់ផ្ដើមបញ្ជាទិញ។</p>
      </div>
      @endif
    </div>

    {{-- Top Selling Foods --}}
    <div class="lg:col-span-5 bg-surface-50 border border-surface-200 rounded-2xl overflow-hidden">
      <div class="flex items-center justify-between flex-wrap gap-3 px-6 py-4 border-b border-surface-200">
        <h3 class="text-sm font-bold text-white flex items-center gap-2.5 font-khmer">
          <i class="fa fa-fire text-emerald-500"></i>
          មុខម្ហូបដែលលក់ដាច់បំផុត
        </h3>
        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">
          <i class="fa fa-crown text-[10px]"></i> កំពូល
        </span>
      </div>

      @if($top_foods->count())
      @php
        $foodEmojis = ['🍲', '🥘', '🍜', '🥗', '🍛', '🌮', '🍔', '🍕', '🫓', '🥟'];
        $categories = ['បាយ', 'ស៊ុប', 'ឆា', 'បំពង', 'គុយទាវ', 'ចំណី'];
      @endphp
      <div class="divide-y divide-surface-200 scroll-thin" style="max-height:396px;overflow-y:auto;">
        @foreach($top_foods as $i => $food)
        <div class="flex items-center gap-4 px-6 py-4 transition-all duration-150 hover:bg-white/[0.015]">
          @php
            $rankColors = match($i) {
              0 => 'bg-yellow-500/15 text-yellow-400 border-yellow-500/25',
              1 => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
              2 => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
              default => 'bg-surface-100 text-gray-500 border-surface-200',
            };
            $perfColors = match($i) {
              0 => 'bg-yellow-500/15 text-yellow-400 border-yellow-500/25',
              1 => 'bg-emerald-500/15 text-emerald-500 border-emerald-500/25',
              default => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
            };
            $perfLabel = match($i) {
              0 => 'លក់ដាច់',
              1 => 'ពេញនិយម',
              default => 'ធម្មតា',
            };
            $emoji = $foodEmojis[$i % count($foodEmojis)];
            $cat   = $categories[$i % count($categories)];
          @endphp
          <div class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-extrabold shrink-0 border {{ $rankColors }}">
            {{ $i + 1 }}
          </div>
          <div class="w-11 h-11 rounded-2xl overflow-hidden shrink-0 flex items-center justify-center text-2xl bg-surface-100 border border-surface-200">
            {{ $emoji }}
          </div>
          <div class="min-w-0 flex-1">
            <div class="text-sm font-semibold text-white truncate leading-tight">{{ $food->name }}</div>
            <div class="flex items-center gap-1.5 mt-1.5 flex-wrap">
              <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-white/5 text-gray-500 border border-white/10">
                <i class="fa fa-tag" style="font-size:8px;"></i>{{ $cat }}
              </span>
              <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide border {{ $perfColors }}">
                <i class="fa fa-bolt"></i> {{ $perfLabel }}
              </span>
            </div>
          </div>
          <div class="text-right shrink-0 ml-2">
            <div class="text-base font-black text-emerald-500">{{ $food->total_sold }}</div>
            <div class="text-[10px] font-medium mt-0.5 text-gray-500">បានលក់</div>
          </div>
        </div>
        @endforeach
      </div>
      @else
      <div class="flex flex-col items-center justify-center py-16 text-center">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-4 bg-surface-100 text-gray-600">
          <i class="fa fa-bowl-food"></i>
        </div>
        <h3 class="text-sm font-semibold text-white mb-1.5">មិនទាន់មានទិន្នន័យលក់</h3>
        <p class="text-xs text-gray-500">ចាប់ផ្ដើមលក់ដើម្បីមើលមុខម្ហូបដែលលក់ដាច់បំផុតនៅទីនេះ។</p>
      </div>
      @endif
    </div>

  </div>
</div>
@endsection
