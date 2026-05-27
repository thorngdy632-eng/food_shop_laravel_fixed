@extends('layouts.layout')

@section('title', 'កែសម្រួលម្ហូប')
@section('breadcrumb', 'ការគ្រប់គ្រងមុខម្ហូប / កែសម្រួល')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">កែសម្រួលម្ហូប</h1>
        <p class="page-subtitle">ធ្វើបច្ចុប្បន្នភាព "{{ $food->name }}"</p>
    </div>
    <a href="{{ route('admin.foods') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> ត្រឡប់ទៅមុខម្ហូប
    </a>
</div>

<div class="card" style="max-width:700px;">
    <div class="card-body">
        <form action="{{ route('admin.foods.update', $food) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">ឈ្មោះម្ហូប <span style="color:var(--danger);">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $food->name) }}" required>
                @error('name') <div class="text-sm text-muted" style="color:var(--danger);margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">ប្រភេទ <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="category" class="form-control" value="{{ old('category', $food->category) }}" required>
                    @error('category') <div class="text-sm text-muted" style="color:var(--danger);margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">តម្លៃ ($) <span style="color:var(--danger);">*</span></label>
                    <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price', $food->price) }}" required>
                    @error('price') <div class="text-sm text-muted" style="color:var(--danger);margin-top:4px;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">ការពិពណ៌នា</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $food->description) }}</textarea>
                @error('description') <div class="text-sm text-muted" style="color:var(--danger);margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">ស្លាក</label>
                    <input type="text" name="badge" class="form-control" value="{{ old('badge', $food->badge) }}">
                    @error('badge') <div class="text-sm text-muted" style="color:var(--danger);margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">ការវាយតម្លៃ (0-5)</label>
                    <input type="number" step="0.1" min="0" max="5" name="rating" class="form-control" value="{{ old('rating', $food->rating) }}">
                    @error('rating') <div class="text-sm text-muted" style="color:var(--danger);margin-top:4px;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">រូបភាពបច្ចុប្បន្ន</label>
                @if($food->image)
                    @php
                        $segments = explode('/', $food->image);
                        $file = rawurlencode(array_pop($segments));
                        $encPath = implode('/', $segments) . '/' . $file;
                    @endphp
                    <div style="margin-bottom:10px;">
                        <img src="{{ asset($encPath) }}"
                             alt="{{ $food->name }}"
                             style="width:120px;height:80px;object-fit:cover;border-radius:8px;border:1px solid var(--border);"
                             onerror="this.style.display='none'">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                <div class="text-xs text-muted mt-1">ទុកឲ្យទទេដើម្បីរក្សារូបភាពបច្ចុប្បន្ន។ ទទួលយក: JPEG, PNG, JPG, GIF, WebP (អតិបរមា 3MB)</div>
                @error('image') <div class="text-sm text-muted" style="color:var(--danger);margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:12px;margin-top:24px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-floppy-disk"></i> ធ្វើបច្ចុប្បន្នភាពម្ហូប
                </button>
                <a href="{{ route('admin.foods') }}" class="btn btn-secondary">បោះបង់</a>
            </div>
        </form>
    </div>
</div>
@endsection
