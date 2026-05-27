@extends('layouts.layout')

@section('title', 'អតិថិជន')
@section('breadcrumb', 'អតិថិជន')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">អតិថិជន</h1>
        <p class="page-subtitle">គ្រប់គ្រងអ្នកប្រើប្រាស់ដែលបានចុះឈ្មោះ</p>
    </div>
</div>

<form method="GET" action="{{ route('admin.users') }}" class="filter-row">
    <div class="search-bar">
        <i class="fa fa-search"></i>
        <input type="text" name="search" placeholder="ស្វែងរកតាមឈ្មោះ ឬអ៊ីមែល..." value="{{ request('search') }}">
    </div>
    <select name="role" class="status-select" onchange="this.form.submit()">
        <option value="">តួនាទីទាំងអស់</option>
        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>អ្នកគ្រប់គ្រង</option>
        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>អ្នកប្រើប្រាស់</option>
    </select>
    @if(request('search') || request('role'))
        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-secondary">
            <i class="fa fa-times"></i> សម្អាត
        </a>
    @endif
</form>

<div class="card">
    <div class="card-body" style="padding:0;">
        @if($users->count())
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>អ្នកប្រើប្រាស់</th>
                            <th>អ៊ីមែល</th>
                            <th>តួនាទី</th>
                            <th>បានចុះឈ្មោះ</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <img src="{{ asset('assets/profiles/' . ($user->profile_image ?? 'default.jfif')) }}"
                                         alt="" class="user-avatar-sm"
                                         onerror="this.src='https://placehold.co/34x34?text={{ substr($user->name,0,1) }}'">
                                    <strong>{{ $user->name }}</strong>
                                </div>
                            </td>
                            <td class="text-sm text-muted">{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td class="text-sm text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div style="display:flex;gap:6px;">
                                    <form action="{{ route('admin.users.role', $user) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @if($user->role === 'admin')
                                            <input type="hidden" name="role" value="user">
                                            <button type="submit" class="btn btn-xs btn-warning" onclick="return confirm('តើអ្នកចង់ទម្លាក់ {{ $user->name }} ទៅជាអ្នកប្រើប្រាស់ធម្មតាមែនទេ?')">
                                                <i class="fa fa-user"></i> ទម្លាក់តួនាទី
                                            </button>
                                        @else
                                            <input type="hidden" name="role" value="admin">
                                            <button type="submit" class="btn btn-xs btn-primary" onclick="return confirm('តើអ្នកចង់ដំឡើង {{ $user->name }} ជាអ្នកគ្រប់គ្រងមែនទេ?')">
                                                <i class="fa fa-shield"></i> ដំឡើងតួនាទី
                                            </button>
                                        @endif
                                    </form>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.delete', $user) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('លុបអ្នកប្រើប្រាស់ {{ $user->name }}? សកម្មភាពនេះមិនអាចត្រឡប់វិញបានទេ។')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="padding:16px 22px;">
                {{ $users->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fa fa-users"></i>
                <h3>មិនមានអ្នកប្រើប្រាស់ទេ</h3>
                <p>{{ request('search') ? 'សូមសាកល្បងពាក្យស្វែងរកផ្សេងទៀត។' : 'មិនទាន់មានអ្នកប្រើប្រាស់ចុះឈ្មោះនៅឡើយទេ។' }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
