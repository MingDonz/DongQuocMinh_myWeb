<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //có thể bỏ qua khai báo $table nếu đặt theo nguyên tắc số nhiều)
protected $table = 'products';
// có thể bỏ qua khai báo $primaryKey nếu primary key là id
// protected $primaryKey = 'id';

protected $fillable = [
    'proname',
    'cateid',
    'brandid',
    'slug',
    'price',
    'image',
    'status',
    'description'
];

// Cấu hình Quan hệ với Category
public function category()
{
    // // products.cateid = categories.cateid
    return $this->belongsTo(Category::class, 'cateid', 'cateid');
}

// Cấu hình Quan hệ với Brand
public function brand()
{
    // products.brandid = brands.id
    return $this->belongsTo(Brand::class, 'brandid', 'id');
}
}
