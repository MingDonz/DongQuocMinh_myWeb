{{-- thừa kế layout/view admin.blade.php --}}
{{-- resources/views/admin/layouts/admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
{{-- (tương ứng với @yield('title') trong layout --}}
@section('title', 'Thêm bài viết')

{{-- Gán nội dung cho vùng section 'content' --}}
{{-- (tương ứng với @yield('content') trong layout --}}
@section('content')
    <div class="border rounded bg-white p-4 shadow-sm">
        <h3 class="mb-4">Thêm bài viết</h3>
        <x-admin.alert />
        <form action="{{ route('admin.posts.store') }}" method="POST">
            @csrf

            <div class="row">
                {{-- CỘT BÊN TRÁI: Thông tin cơ bản --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nội dung</label>
                        <input type="text" name="content" class="form-control" value="{{ old('content') }}" required>
                    </div>
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
                </div>
            </div>

            {{-- CÁC NÚT THAO TÁC --}}
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    Lưu bài viết
                </button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                    Quay lại
                </a>
            </div>

        </form>
    </div>
@endsection
