@extends('client.layouts.app')
@section('title', 'Chi tiết sản phẩm')
@section('content')
    <div class="row g-4">
        <div class="col-md-5">
            <!-- Ảnh chính -->
            <div class="border rounded p-2 mb-3">
                <img src="{{ asset('storage/products/' . ($product->image ?? 'default.png')) }}"
                    class="img-fluid rounded w-100" style="height:400px;object-fit:cover;">
            </div>
            <!-- Ảnh phụ -->
            <div class="row g-2">
                @foreach ($product->images as $image)
                    <div class="col-3">
                        <img src="{{ asset('storage/products/' . $image->image) }}" class="img-fluid rounded border shadow-sm">
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-7">
            <h2 class="fw-bold">{{ $product->productname }}</h2>
            <p><strong>Danh mục:</strong> {{ $product->category?->catename }}</p>
            <p><strong>Thương hiệu:</strong> {{ $product->brand?->brandname }}</p>
            @if ($product->pricediscount > 0)
                <h5>
                    <span class="text-decoration-line-through text-secondary me-2">
                        {{ number_format($product->price) }} VNĐ
                    </span>
                    <span class="text-danger fw-bold">
                        {{ number_format($product->pricediscount) }} VNĐ
                    </span>
                </h5>
            @else
                <h4 class="text-danger fw-bold">
                    {{ number_format($product->price) }} VNĐ
                </h4>
            @endif
            <hr>
            <h5>Mô tả sản phẩm</h5>
            {!! $product->description !!}
            <hr>
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="form-add-cart">
                @csrf
                <div class="mb-3">
                    <label for="quantity" class="form-label">Số lượng</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control w-25">
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ hàng
                </button>
            </form>
        </div>
    </div>
    <hr>
    <h3 class="mb-3">Sản phẩm cùng loại</h3>
    <div class="row">
        @foreach ($relatedProducts as $item)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('storage/products/' . ($item->image ?? 'default.png')) }}" class="card-img-top"
                        style="height:150px;object-fit:cover;">
                    <div class="card-body">
                        <h6>{{ $item->productname }}</h6>
                        <p class="text-danger fw-bold">
                            {{ number_format($item->price) }} VNĐ
                        </p>
                        <a href="{{ route('product.show', $item->slug) }}" class="btn btn-primary btn-sm">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection