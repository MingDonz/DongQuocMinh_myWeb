<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;
use App\Http\Requests\Admin\PostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
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
        $list = Post::with(['user:id,username'])
            ->select(
                'posts.id',
                'posts.title',
                'posts.slug',
                'posts.content',
                'posts.image',
                'posts.status',
                'posts.user_id'
            )
            ->paginate($limit);
        return view('admin.posts.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select('id', 'username')->get();
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        //
        try {
            Post::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'image' => $request->image ? $request->image : "",
                'status' => $request->status,
                'user_id' =>  $request->user_id ? $request->user_id : 1
            ]);

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Thêm bài viết thành công');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
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
        $post = Post::find($id);

        return view('admin.posts.edit', compact('post'));
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
