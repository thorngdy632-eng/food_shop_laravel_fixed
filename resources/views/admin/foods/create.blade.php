@extends('layouts.layout')

@section('title', 'បង្កើតម្ហូប')
@section('breadcrumb', 'ការគ្រប់គ្រងមុខម្ហូប / បង្កើត')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">បង្កើតមុខម្ហូបថ្មី</h1>
        <p class="page-subtitle">បន្ថែមមុខម្ហូបថ្មីទៅក្នុងម៉ឺនុយរបស់អ្នក</p>
    </div>
    <a href="{{ route('admin.foods') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> ត្រឡប់ទៅមុខម្ហូប
    </a>
</div>

<div class="card" style="max-width:700px;">
    <div class="card-body">
        <form action="{{ route('admin.foods.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">ឈ្មោះម្ហូប <span style="color:var(--danger);">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name') <div class="text-sm text-muted" style="color:var(--danger);margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">ប្រភេទ <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="category" class="form-control" value="{{ old('category') }}" required placeholder="ឧ. ខ្មែរ, បស្ចិម, ភេសជ្ជៈ">
                    @error('category') <div class="text-sm text-muted" style="color:var(--danger);margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">តម្លៃ ($) <span style="color:var(--danger);">*</span></label>
                    <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price') }}" required>
                    @error('price') <div class="text-sm text-muted" style="color:var(--danger);margin-top:4px;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">ការពិពណ៌នា</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                @error('description') <div class="text-sm text-muted" style="color:var(--danger);margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">ស្លាក</label>
                    <input type="text" name="badge" class="form-control" value="{{ old('badge') }}" placeholder="ឧ. មុខម្ហូបពិសេស, ថ្មី">
                    @error('badge') <div class="text-sm text-muted" style="color:var(--danger);margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">ការវាយតម្លៃ (0-5)</label>
                    <input type="number" step="0.1" min="0" max="5" name="rating" class="form-control" value="{{ old('rating') }}">
                    @error('rating') <div class="text-sm text-muted" style="color:var(--danger);margin-top:4px;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">រូបភាព</label>
                <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                <div class="text-xs text-muted mt-1">ទទួលយក: JPEG, PNG, JPG, GIF, WebP (អតិបរមា 3MB)</div>
                @error('image') <div class="text-sm text-muted" style="color:var(--danger);margin-top:4px;">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:12px;margin-top:24px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-floppy-disk"></i> បង្កើតម្ហូប
                </button>
                <a href="{{ route('admin.foods') }}" class="btn btn-secondary">បោះបង់</a>
            </div>
        </form>
    </div>
</div>
@endsection
