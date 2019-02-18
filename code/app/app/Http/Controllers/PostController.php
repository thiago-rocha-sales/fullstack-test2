<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;

class PostController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('client.credentials')->only([
    //         'store', 'destroy']);
    // }

    public function index()
    {
        return new PostCollection(Post::paginate(5));
    }

    public function show($id)
    {
        $post = Post::findOrfail($id);
        return new PostResource($post);
    }

    public function destroy($id)
    {
        $post = Post::findOrfail($id);
        if($post->delete()) {
            return new PostResource($post);
        }
    }

    public function store(Request $request)
    {
        $post = $request->isMethod('put') ?
            Post::findOrfail($request->id) : new Post;

        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->image = $request->input('image');
        $post->published = $request->input('published');
        $post->author_id = $request->input('author_id');

        if($post->save()) {
            return new PostResource($post);
        }
    }
}
