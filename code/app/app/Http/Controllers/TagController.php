<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Http\Resources\TagResource;
use App\Http\Resources\TagCollection;

class TagController extends Controller
{
    public function index()
    {
        return new TagCollection(Tag::paginate(5));
    }

    public function show($id)
    {
        $tag = Tag::findOrfail($id);
        return new TagResource($tag);
    }

    public function destroy($id)
    {
        $tag = Tag::findOrfail($id);
        if($tag->delete()) {
            return new TagResource($tag);
        }
    }

    public function store(Request $request)
    {
        $tag = $request->isMethod('put') ?
            Tag::findOrfail($request->id) : new Tag;

        $tag->name = $request->input('name');

        if($tag->save()) {
            return new TagResource($tag);
        }
    }
}
