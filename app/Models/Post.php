<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $table = 'posts';
    // có thể bỏ qua khai báo $primaryKey nếu primary key là id
    // protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status',
        'user_id'
    ];

    public function user()
    {
        // // products.cateid = categories.cateid
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
