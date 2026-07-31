<div class="card h-100 shadow-sm">
    <a href="{{ route('product.show', ['slug' => $product->slug]) }}" class="text-decoration-none text-dark">
        <img src="{{ $product->image ? asset('storage/products/' . $product->image) : asset('images/default.png') }}"
            class="card-img-top" alt="{{ $product->productname }}" style="height: 220px; object-fit: cover;">
    </a>
    <div class="card-body d-flex flex-column">
        <h5 class="card-title">
            <a href="{{ route('product.show', ['slug' => $product->slug]) }}" class="text-decoration-none text-dark">
                {{ $product->productname }}
            </a>
        </h5>
        <div class="mt-auto">
            <div class="fw-bold text-danger">
                {{ number_format($product->pricediscount > 0 ? $product->pricediscount : $product->price, 0, ',', '.') }}
                đ
            </div>
            @if ($product->pricediscount > 0)
                <small class="text-muted text-decoration-line-through">
                    {{ number_format($product->price, 0, ',', '.') }} đ
                </small>
            @endif
            <button type="button" class="btn btn-success btn-sm w-100 mt-3 add-to-cart-btn">
                <i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ
            </button>
        </div>
    </div>
</div>