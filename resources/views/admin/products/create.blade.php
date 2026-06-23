{{-- thừa kế layout/view admin.blade.php --}}
{{-- resources/views/admin/layouts/admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title' --}}
{{-- (tương ứng với @yield('title') trong layout --}}
@section('title', 'Thêm Sản phẩm')

{{-- Gán nội dung cho vùng section 'content' --}}
{{-- (tương ứng với @yield('content') trong layout --}}
@section('content')
    <div class="border rounded bg-white p-4 shadow-sm">
        <h3 class="mb-4">Thêm sản phẩm</h3>
        <x-admin.alert />
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf

            <div class="row">
                {{-- CỘT BÊN TRÁI: Thông tin cơ bản --}}
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="productname" class="form-control" value="{{ old('productname') }}"
                            required>
                        @error('productname')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
                    </div>
                    @error('slug')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror

                    <<div class="mb-3">
                        <label class="form-label">Loại sản phẩm</label>
                        <select name="cateid" class="form-select">
                            <option value="">-- Chọn loại sản phẩm --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->cateid }}"
                                    {{ old('cateid') == $category->cateid ? 'selected' : '' }}>
                                    {{ $category->catename }}
                                </option>
                            @endforeach
                        </select>
                        @error('catename')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Thương hiệu</label>
                    <select name="brandid" class="form-select">
                        <option value="">-- Chọn thương hiệu --</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->brandname }}</option>
                        @endforeach
                    </select>
                    @error('brandname')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            {{-- CỘT BÊN PHẢI: Giá, Trạng thái & Mô tả --}}
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Giá</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
                    @error('price')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá khuyến mãi</label>
                    <input type="number" name="pricediscount" class="form-control" value="{{ old('pricediscount', 0) }}">
                    @error('pricediscount')
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
                    @error('status')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả sản phẩm</label>
                    <textarea name="description" rows="4" class="form-control"></textarea>
                    @error('description')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
    </div>

    {{-- CÁC NÚT THAO TÁC --}}
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">
            Lưu sản phẩm
        </button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            Quay lại
        </a>
    </div>

    </form>
    </div>
@endsection
