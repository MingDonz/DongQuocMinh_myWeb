<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model   
{
    protected $table = 'brands';
    // có thể bỏ qua khai báo $primaryKey nếu primary key là id
    // protected $primaryKey = 'id';
    
    protected $fillable = [
        'brandname',
        'slug',
        'image',
        'status',
        'sort_order',
        'description'
    ];
}