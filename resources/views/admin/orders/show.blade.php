@extends('layouts.layout')

@section('title', 'ការបញ្ជាទិញ #' . $order->id)
@section('breadcrumb', 'ការបញ្ជាទិញ / #' . $order->id)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">ការបញ្ជាទិញ #{{ $order->id }}</h1>
        <p class="page-subtitle">បានដាក់នៅថ្ងៃទី {{ $order->created_at->format('F d, Y \a\t H:i') }}</p>
    </div>
    <a href="{{ route('admin.orders') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> ត្រឡប់ទៅការបញ្ជាទិញ
    </a>
</div>

<div class="grid-3" style="margin-bottom:24px;">
    <div class="card">
        <div class="card-header"><span class="card-title"><i class="fa fa-user" style="margin-right:8px;color:var(--primary);"></i>អតិថិជន</span></div>
        <div class="card-body">
            <p style="font-weight:600;margin-bottom:4px;">{{ $order->user->name ?? 'N/A' }}</p>
            <p class="text-sm text-muted">{{ $order->user->email ?? '' }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><span class="card-title"><i class="fa fa-credit-card" style="margin-right:8px;color:var(--primary);"></i>ការទូទាត់</span></div>
        <div class="card-body">
            <p style="font-weight:600;margin-bottom:4px;">សរុប៖ <span style="color:var(--primary);">${{ number_format($order->total_price, 2) }}</span></p>
            <p class="text-sm text-muted">ស្ថានភាព៖ <span class="badge badge-{{ $order->status }}">
                @switch($order->status)
                    @case('pending') រង់ចាំ @break
                    @case('confirmed') បានបញ្ជាក់ @break
                    @case('preparing') កំពុងរៀបចំ @break
                    @case('delivered') បានដឹកជញ្ជូន @break
                    @case('cancelled') បានបោះបង់ @break
                    @default {{ ucfirst($order->status) }}
                @endswitch
            </span></p>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><span class="card-title"><i class="fa fa-pen" style="margin-right:8px;color:var(--primary);"></i>ធ្វើបច្ចុប្បន្នភាពស្ថានភាព</span></div>
        <div class="card-body">
            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                @csrf
                <div style="display:flex;gap:8px;">
                    <select name="status" class="status-select" style="flex:1;">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>រង់ចាំ</option>
                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>បានបញ្ជាក់</option>
                        <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>កំពុងរៀបចំ</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>បានដឹកជញ្ជូន</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>បានបោះបង់</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fa fa-check"></i> ធ្វើបច្ចុប្បន្នភាព
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title"><i class="fa fa-bowl-food" style="margin-right:8px;color:var(--primary);"></i>មុខម្ហូបដែលបានបញ្ជាទិញ</span>
        <span class="text-sm text-muted">{{ $order->items->count() }} មុខម្ហូប</span>
    </div>
    <div class="card-body" style="padding:0;">
        @if($order->items->count())
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>មុខម្ហូប</th>
                            <th>តម្លៃ</th>
                            <th>បរិមាណ</th>
                            <th>បរិយាប័ន្តរង</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td><strong>{{ $item->name }}</strong></td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td><strong>${{ number_format($item->price * $item->quantity, 2) }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background:var(--bg);">
                            <td colspan="3" style="text-align:right;font-weight:600;padding:14px 16px;">សរុប</td>
                            <td style="font-weight:800;font-size:1.1rem;color:var(--primary);padding:14px 16px;">
                                ${{ number_format($order->total_price, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fa fa-bowl-food"></i>
                <h3>មិនមានមុខម្ហូបទេ</h3>
                <p>ការបញ្ជាទិញនេះគ្មានមុខម្ហូបទេ។</p>
            </div>
        @endif
    </div>
</div>
@endsection
