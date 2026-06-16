<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    // có thể bỏ qua khai báo $primaryKey nếu primary key là id
    // protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status'
    ];

    public function user()
    {
        // // products.cateid = categories.cateid
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
