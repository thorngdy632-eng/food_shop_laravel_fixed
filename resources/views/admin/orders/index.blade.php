@extends('layouts.layout')

@section('title', 'ការបញ្ជាទិញ')
@section('breadcrumb', 'ការបញ្ជាទិញ')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">ការបញ្ជាទិញ</h1>
        <p class="page-subtitle">គ្រប់គ្រងការបញ្ជាទិញរបស់អតិថិជន</p>
    </div>
</div>

<form method="GET" action="{{ route('admin.orders') }}" class="filter-row">
    <select name="status" class="status-select" onchange="this.form.submit()">
        <option value="">ស្ថានភាពទាំងអស់</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>រង់ចាំ</option>
        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>បានបញ្ជាក់</option>
        <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>កំពុងរៀបចំ</option>
        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>បានដឹកជញ្ជូន</option>
        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>បានបោះបង់</option>
    </select>
    @if(request('status'))
        <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-secondary">
            <i class="fa fa-times"></i> សម្អាត
        </a>
    @endif
</form>

<div class="card">
    <div class="card-body" style="padding:0;">
        @if($orders->count())
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>លេខការបញ្ជាទិញ</th>
                            <th>អតិថិជន</th>
                            <th>មុខម្ហូប</th>
                            <th>សរុប</th>
                            <th>ស្ថានភាព</th>
                            <th>កាលបរិច្ឆេទ</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td class="text-sm text-muted">{{ $order->items_count ?? $order->items->count() ?? '—' }} មុខម្ហូប</td>
                            <td><strong>${{ number_format($order->total_price, 2) }}</strong></td>
                            <td>
                                <span class="badge badge-{{ $order->status }}">
                                    @switch($order->status)
                                        @case('pending') រង់ចាំ @break
                                        @case('confirmed') បានបញ្ជាក់ @break
                                        @case('preparing') កំពុងរៀបចំ @break
                                        @case('delivered') បានដឹកជញ្ជូន @break
                                        @case('cancelled') បានបោះបង់ @break
                                        @default {{ ucfirst($order->status) }}
                                    @endswitch
                                </span>
                            </td>
                            <td class="text-sm text-muted">{{ $order->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-eye"></i> មើល
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding:16px 22px;">
                {{ $orders->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fa fa-receipt"></i>
                <h3>មិនទាន់មានការបញ្ជាទិញឡើយ</h3>
                <p>{{ request('status') ? 'មិនមានការបញ្ជាទិញដែលមានស្ថានភាពនេះទេ។' : 'មិនទាន់មានការបញ្ជាទិញនៅឡើយទេ។' }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
