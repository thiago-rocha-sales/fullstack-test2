<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;

class PostController extends Controller
{

    public function index(Request $request)
    {
        $posts = null;
        if ($request->has('title')) {
            $q = $request->input('title');
            $posts = Post::where('title', 'like', '%' . $q . '%')
                ->paginate(5);
        } else {
            $posts = Post::orderBy('id', 'desc')->paginate(5);
        }
        return new PostCollection($posts);
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
       
        $fileName = '';
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // $imagePath = storage_path('app/public/images');
            $imagePath = storage_path('images');

            // if(!File::exists($imagePath)) {
            //     File::makeDirectory($imagePath);
            // }

            // $name = uniqid(date('HisYmd'));
            // $ext = $request->image->extension();

            // $fileName = "{$name}.{$ext}";

            $fileName = $request->file('image')->getClientOriginalName();

            $request->image->storeAs('public/images', $fileName);
        }    
 
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->image = $fileName;
        $post->published = $request->input('published');
        $post->author_id = $request->input('author_id');

        if($post->save()) {
            return new PostResource($post);
        }
    }
}
