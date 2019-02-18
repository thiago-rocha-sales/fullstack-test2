<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\AuthorCollection;

class AuthorController extends Controller
{
    public function index()
    {
        return new AuthorCollection(Author::paginate(5));
    }

    public function show($id)
    {
        $author = Author::findOrfail($id);
        return new AuthorResource($author);
    }

    public function destroy($id)
    {
        $author = Author::findOrfail($id);
        if($author->delete()) {
            return new AuthorResource($author);
        }
    }

    public function store(Request $request) 
    {
        $author = $request->isMethod('put') ?
            Author::findOrfail($request->id) : new Author;

        $author->name = $request->input('name');
        if($author->save()) {
            return new AuthorResource($author);
        }
    }
}
