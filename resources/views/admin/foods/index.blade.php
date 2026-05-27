@extends('layouts.layout')

@section('title', 'ការគ្រប់គ្រងមុខម្ហូប')
@section('breadcrumb', 'ការគ្រប់គ្រងមុខម្ហូប')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">ការគ្រប់គ្រងមុខម្ហូប</h1>
        <p class="page-subtitle">គ្រប់គ្រងមុខម្ហូបរបស់អ្នក</p>
    </div>
    <a href="{{ route('admin.foods.create') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> បន្ថែមម្ហូបថ្មី
    </a>
</div>

<form method="GET" action="{{ route('admin.foods') }}" class="filter-row">
    <div class="search-bar">
        <i class="fa fa-search"></i>
        <input type="text" name="search" placeholder="ស្វែងរកម្ហូប..." value="{{ request('search') }}">
    </div>
    <select name="category" class="status-select" onchange="this.form.submit()">
        <option value="">ប្រភេទទាំងអស់</option>
        @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
    </select>
    @if(request('search') || request('category'))
        <a href="{{ route('admin.foods') }}" class="btn btn-sm btn-secondary">
            <i class="fa fa-times"></i> សម្អាត
        </a>
    @endif
</form>

@if($foods->count())
    <div class="food-admin-grid">
        @foreach($foods as $food)
            <div class="food-card">
                <img src="{{ asset($food->image) }}"
                     alt="{{ $food->name }}" class="food-card-img"
                     onerror="this.src='https://placehold.co/300x200?text=No+Image'">
                <div class="food-card-body">
                    <div class="food-card-name">{{ $food->name }}</div>
                    <div class="food-card-cat">
                        <i class="fa fa-tag" style="font-size:10px;"></i> {{ $food->category }}
                        @if($food->badge)
                            <span class="badge badge-delivered" style="margin-left:6px;">{{ $food->badge }}</span>
                        @endif
                    </div>
                    <div class="food-card-price">${{ number_format($food->price, 2) }}</div>
                    @if($food->rating)
                        <div class="text-xs text-muted mt-1">
                            <i class="fa fa-star" style="color:var(--warning);"></i> {{ $food->rating }}/5
                        </div>
                    @endif
                </div>
                <div class="food-card-actions">
                    <a href="{{ route('admin.foods.edit', $food) }}" class="btn btn-sm btn-secondary">
                        <i class="fa fa-pen"></i> កែសម្រួល
                    </a>
                    <form action="{{ route('admin.foods.delete', $food) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('តើអ្នកពិតជាចង់លុបម្ហូបនេះមែនទេ?')">
                            <i class="fa fa-trash"></i> លុប
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>


@else
    <div class="card">
        <div class="card-body">
            <div class="empty-state">
                <i class="fa fa-bowl-food"></i>
                <h3>មិនមានម្ហូបទេ</h3>
                <p>{{ request('search') ? 'សូមសាកល្បងពាក្យស្វែងរកផ្សេងទៀត។' : 'ចាប់ផ្ដើមដោយបន្ថែមមុខម្ហូបដំបូងរបស់អ្នក។' }}</p>
                @if(!request('search'))
                    <a href="{{ route('admin.foods.create') }}" class="btn btn-primary mt-4">
                        <i class="fa fa-plus"></i> បន្ថែមម្ហូបដំបូងរបស់អ្នក
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
@endsection
