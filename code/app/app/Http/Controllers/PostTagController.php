<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostTag;
use App\Http\Resources\PostTagResource;
use App\Http\Resources\PostTagCollection;

class PostTagController extends Controller
{
    public function index()
    {
        return new PostTagCollection(PostTag::paginate(5));
    }

    public function show($id)
    {
        $postTag = PostTag::findOrfail($id);
        return new PostTagResource($postTag);
    }

    public function destroy($id)
    {
        $postTag = PostTag::findOrfail($id);
        if($postTag->delete()) {
            return new PostTagResource($postTag);
        }
    }

    public function store(Request $request)
    {
        $postTag = $request->isMethod('put') ?
            PostTag::findOrfail($request->id) : new PostTag;

        $postTag->post_id = $request->input('post_id');
        $postTag->tag_id = $request->input('tag_id');

        if($postTag->save()) {
            return new PostTagResource($postTag);
        }
    }
}
