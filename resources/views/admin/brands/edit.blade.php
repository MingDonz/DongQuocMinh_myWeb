{{-- thừa kế layout/view admin.blade.php --}}
{{-- resources/views/admin/layouts/admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
{{-- (tương ứng với @yield('title') trong layout --}}
@section('title', 'Sửa thương hiệu')

{{-- Gán nội dung cho vùng section 'content' --}}
{{-- (tương ứng với @yield('content') trong layout --}}
@section('content')
    <div class="border rounded bg-white p-4 shadow-sm">
        <h3 class="mb-4">Sửa thương hiệu {{ $brand->brandname }}</h3>
        <x-admin.alert />
        <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Tên thương hiệu</label>
                <input type="text" name="brandname" class="form-control" value="{{ old('brandname', $brand->brandname) }}"
                    required>
                {{-- hiển thị lỗi cho trường catename --}}
                @error('catename')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label>Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $brand->slug) }}">
                {{-- hiển thị lỗi cho trường slug --}}
                @error('slug')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label d-block">Trạng thái</label>

                <input type="radio" class="btn-check" name="status" id="active" value="1"
                    {{ old('status', 1) == 1 ? 'checked' : '' }}>
                <label class="btn btn-outline-success" for="active">
                    Hiển thị
                </label>

                <input type="radio" class="btn-check" name="status" id="inactive" value="0"
                    {{ old('status', 1) == 0 ? 'checked' : '' }}>
                <label class="btn btn-outline-danger" for="inactive">
                    Ẩn
                </label>
                {{-- hiển thị lỗi cho trường status --}}
                @error('status')
                    <span class="text-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả thương hiệu</label>
                <textarea name="description" rows="4" class="form-control" value="{{ old('description', $brand->description) }}"></textarea>
            </div>

            <div class="mb-3 img-group">
                <label class="form-label">Hình ảnh</label>
                <input type="file" name="img" class="form-control img-input">
                <div class="img-preview mt-2">
                    @if ($brand->image)
                        <img src="{{ asset('storage/brands/' . $brand->image) }}" alt="{{ $brand->brandname }}" width="150"
                            class="img-thumbnail">
                    @endif
                </div>
            </div>
            {{-- hiển thị lỗi cho trường img --}}
            @error('img')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
            <button type="submit" class="btn btn-primary">
                Lưu
            </button>
        </form>
    </div>
@endsection
