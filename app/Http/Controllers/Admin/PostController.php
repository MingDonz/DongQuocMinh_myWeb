<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit=10)
    {
        // $list = DB::table('posts')
        // ->join('users', 'users.id', '=', 'posts.user_id')
        // ->select(
        // 'posts.id',
        // 'posts.title',
        // 'posts.slug',
        // 'posts.content',
        // 'posts.image',
        // 'posts.status',
        // 'users.username'
        // )
        // ->get();

        //ORM query
        $list = Post::with(['user:userid,username'])
        ->select(
             'posts.id',
             'posts.title',
             'posts.slug',
             'posts.content',
             'posts.image',
             'posts.status',
             'users.username'
             )
             ->paginate($limit);
        return view('admin.posts.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
