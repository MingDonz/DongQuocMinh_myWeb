@extends('client.layouts.app')

@section('title', 'Tìm kiếm sản phẩm')

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tìm kiếm</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Kết quả tìm kiếm</h2>
        </div>

        <form action="{{ route('products.search') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-5">
                <label class="form-label">Từ khóa</label>
                <input type="text" name="q" value="{{ $keyword }}" class="form-control" placeholder="Tên sản phẩm">
            </div>
            <div class="col-md-3">
                <label class="form-label">Giá từ</label>
                <input type="number" min="0" name="price_min" value="{{ $priceMin }}" class="form-control" placeholder="0">
            </div>
            <div class="col-md-3">
                <label class="form-label">Đến</label>
                <input type="number" min="0" name="price_max" value="{{ $priceMax }}" class="form-control">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Lọc</button>
            </div>
        </form>

        @if ($keyword !== '')
            <div class="alert alert-light border mb-4">
                Từ khóa tìm kiếm: <strong>{{ $keyword }}</strong>
            </div>
        @endif

        @if ($products->isEmpty())
            <div class="alert alert-info">
                Không tìm thấy sản phẩm phù hợp với điều kiện hiện tại.
            </div>
        @else
            <div class="row g-4">
                @foreach ($products as $product)
                    <div class="col-12 col-sm-6 col-lg-3">
                        <x-client.product-card :product="$product" />
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection