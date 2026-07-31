@extends('client.layouts.app')
@section('title', $products->first()?->catename)
@section('content')
    <div class="container py-4">
        <h3 class="mb-4">
            Danh mục: {{ $products->first()?->catename }}
        </h3>
        <div class="row g-4">
            @foreach ($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <x-client.product :product="$product" />
                </div>
            @endforeach
        </div>
        {{-- phân trang--}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
@endsection