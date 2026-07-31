<div class="card h-100 shadow-sm">
    {{-- Hình ảnh --}}
    <img src="{{ asset('storage/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->productname }}"
        style="height:150px;object-fit:cover;">
    <div class="card-body d-flex flex-column">
        {{-- Tên sản phẩm --}}
        <h6 class="card-title">
            {{ $product->productname }}
        </h6>
        {{-- Giá --}}
        @if ($product->pricediscount > 0)
            <div>
                <span class="text-decoration-line-through text-muted">
                    {{ number_format($product->price) }} đ
                </span>
            </div>
            <h5 class="text-danger fw-bold">
                {{ number_format($product->pricediscount) }} đ
            </h5>
        @else
            <h5 class="text-danger fw-bold">
                {{ number_format($product->price) }} đ
            </h5>
        @endif
        {{-- Nút chức năng --}}
        <div class="mt-auto">
            <div class="row g-2">
                <div class="col-6">
                    <a href="{{ route('product.show', ['slug' => $product->slug]) }}" class="btn btn-primary w-100">
                        <i class="bi bi-eye"></i>
                    </a>
                </div>
                <div class="col-6">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="form-add-cart">
                        @csrf
                        <button type="submit" class="btn btn-success w-100"><i class="bi bi-cart-plus"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>