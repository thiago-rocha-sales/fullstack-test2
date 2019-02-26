@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Post's</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts['data'] as $post)
                                <tr>
                                    <th scope="row">{{ $post['id'] }}</th>
                                    <td>{{ $post['title'] }}</td>
                                    <td>{{ $post['slug'] }}</td>
                                    <td>
                                        <i class="fa fa-camera-retro fa-lg">
                                            <!-- <a href="#{{ $post['id'] }}" class="delete">Delete</a> -->
                                        </i>
                                        <i>
                                            <a href="/admin/show/{{ $post['id'] }}" class="edit">Edit</a>
                                        </i>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="{{ $paginator->getPrev() }}">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="{{ $paginator->getNext() }}">Next</a></li>
                    </ul> 

                    <form id="delete-post-form" action="/admin/delete" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <div class="card">
                        <div class="card-header">Form Post's</div>
                        <div class="card-body">
                            <form method="POST" action="/admin" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="body">Content</label>
                                    <textarea class="form-control" id="body" name="body" rows="3"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="author_id">Author</label>
                                    <select class="form-control" id="author_id" name="author_id">
                                        @foreach($authors['data'] as $author)
                                            <option value="{{ $author['id'] }}">{{ $author['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control-file" id="image" name="image" accept=".jpg, .jpeg, .png">
                                </div>

                                <input type="hidden" id="published" name="published" value="true">
                                <!-- <input type="hidden" id="author_id" name="author_id" value="6"> -->
                                <input type="hidden" id="id" name="id">

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>

                </div>
                <div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
