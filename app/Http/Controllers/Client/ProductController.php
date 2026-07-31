<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function category($slug, $limit = 12)
    {
        $products = Product::select(
            'products.id',
            'products.productname',
            'products.slug',
            'products.price',
            'products.pricediscount',
            'products.image',
            'categories.catename'
        )
            ->join('categories', 'products.cateid', 'categories.cateid')
            ->where('categories.slug', $slug)
            ->where('products.status', 1)
            ->paginate($limit);
        return view('client.products.category', compact('products'));
    }
    public function brand($slug, $limit = 12)
    {
        $products = Product::select(
            'products.id',
            'products.productname',
            'products.slug',
            'products.price',
            'products.pricediscount',
            'products.image',
            'brands.brandname'
        )
            ->join('brands', 'products.brandid', 'brands.id')
            ->where('brands.slug', $slug)
            ->where('products.status', 1)
            ->paginate($limit);
        return view('client.products.brand', compact('products'));
    }


    public function show($slug)
    {
        $product = Product::select(
            'id',
            'cateid',
            'brandid',
            'productname',
            'slug',
            'price',
            'pricediscount',
            'image',
            'description'
        )
            ->with([
                'category:cateid,catename',
                'brand:id,brandname',
                'images:id,product_id,image'
            ])
            ->where('slug', $slug)
            ->firstOrFail();
        // sản phẩm liên quan cùng danh muc
        $relatedProducts = Product::select(
            'id',
            'productname',
            'slug',
            'price',
            'pricediscount',
            'image'
        )
            ->where('cateid', $product->cateid)
            ->where('id', '<>', $product->id)
            ->take(4)
            ->get();
        return view('client.products.show', compact(
            'product',
            'relatedProducts'
        ));
    }
    public function search(Request $request)
    {
        $keyword = trim((string) $request->input('q', ''));
        $priceMin = trim((string) $request->input('price_min', ''));
        $priceMax = trim((string) $request->input('price_max', ''));

        $query = Product::where('status', 1)
            ->select(
                'id',
                'productname',
                'price',
                'pricediscount',
                'image',
                'status',
                'slug'
            );

        if ($keyword !== '') {
            $query->where('productname', 'like', "%{$keyword}%");
        }

        if ($priceMin !== '' && $priceMax !== '') {
            $query->whereBetween('price', [(int) $priceMin, (int) $priceMax]);
        } elseif ($priceMin !== '') {
            $query->where('price', '>=', (int) $priceMin);
        } elseif ($priceMax !== '') {
            $query->where('price', '<=', (int) $priceMax);
        }

        $products = $query->orderByDesc('created_at')
            ->paginate(8)
            ->withQueryString();

        return view('client.products.search', compact('keyword', 'priceMin', 'priceMax', 'products'));
    }
}
