@extends('layouts.layout')

@section('title', 'ផ្ទាំងគ្រប់គ្រង')
@section('breadcrumb', 'ផ្ទាំងគ្រប់គ្រង')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">ផ្ទាំងគ្រប់គ្រង</h1>
        <p class="page-subtitle">ទិដ្ឋភាពទូទៅនៃដំណើរការហាងរបស់អ្នក</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon icon-orange"><i class="fa fa-bowl-food"></i></div>
        <div>
            <div class="stat-value">{{ $stats['total_foods'] }}</div>
            <div class="stat-label">មុខម្ហូបសរុប</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon icon-blue"><i class="fa fa-receipt"></i></div>
        <div>
            <div class="stat-value">{{ $stats['total_orders'] }}</div>
            <div class="stat-label">ការបញ្ជាទិញសរុប</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon icon-green"><i class="fa fa-users"></i></div>
        <div>
            <div class="stat-value">{{ $stats['total_users'] }}</div>
            <div class="stat-label">អតិថិជន</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon icon-purple"><i class="fa fa-dollar-sign"></i></div>
        <div>
            <div class="stat-value">${{ number_format($stats['total_revenue'], 2) }}</div>
            <div class="stat-label">ចំណូលសរុប</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon icon-yellow"><i class="fa fa-clock"></i></div>
        <div>
            <div class="stat-value">{{ $stats['pending_orders'] }}</div>
            <div class="stat-label">ការបញ្ជាទិញដែលរង់ចាំ</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon icon-red"><i class="fa fa-calendar-day"></i></div>
        <div>
            <div class="stat-value">{{ $stats['today_orders'] }}</div>
            <div class="stat-label">ការបញ្ជាទិញថ្ងៃនេះ</div>
        </div>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fa fa-clock-rotate-left" style="margin-right:8px;color:var(--primary);"></i>ការបញ្ជាទិញថ្មីៗ</span>
            <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-secondary">មើលទាំងអស់</a>
        </div>
        <div class="card-body" style="padding:0;">
            @if($recent_orders->count())
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ការបញ្ជាទិញ</th>
                                <th>អតិថិជន</th>
                                <th>សរុប</th>
                                <th>ស្ថានភាព</th>
                                <th>កាលបរិច្ឆេទ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_orders as $order)
                            <tr>
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td>${{ number_format($order->total_price, 2) }}</td>
                                <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                <td class="text-sm text-muted">{{ $order->created_at->format('M d, H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fa fa-receipt"></i>
                    <h3>មិនទាន់មានការបញ្ជាទិញ</h3>
                    <p>ការបញ្ជាទិញនឹងបង្ហាញនៅទីនេះ នៅពេលអតិថិជនចាប់ផ្ដើមបញ្ជាទិញ។</p>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fa fa-fire" style="margin-right:8px;color:var(--primary);"></i>មុខម្ហូបដែលលក់ដាច់បំផុត</span>
        </div>
        <div class="card-body" style="padding:0;">
            @if($top_foods->count())
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ឈ្មោះម្ហូប</th>
                                <th>បានលក់</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($top_foods as $i => $food)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><strong>{{ $food->name }}</strong></td>
                                <td><span class="badge badge-delivered">{{ $food->total_sold }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fa fa-bowl-food"></i>
                    <h3>មិនទាន់មានទិន្នន័យលក់</h3>
                    <p>ចាប់ផ្ដើមលក់ដើម្បីមើលមុខម្ហូបដែលលក់ដាច់បំផុតនៅទីនេះ។</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
