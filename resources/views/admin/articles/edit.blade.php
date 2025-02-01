@extends('admin.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-11">
                <h1>Edit Article</h1>
            </div>
            <div class="col-sm-1">
                <a href="{{ route('articles.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</section>

<form action="{{ route('articles.update',$article->id) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="" class="text-lg font-medium">Name</label><br />
        <input value="{{ old('title', $article->title) }}" name="title" placeholder="Title" type="text" class="form-control"/>
        @error('title')
            <p class="text-red-400 font-small">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="" >Content</label><br />
        <textarea cols="10" rows="4" id="text" name="text" placeholder="Content" type="text" class="form-control">{{ old('text', $article->text) }}</textarea>
    </div>

    <div class="form-group">
        <label for="" >Author</label><br />
        <input value="{{ old('author', $article->author) }}" name="author" placeholder="Author" type="text" class="form-control"/>
        @error('author')
            <p class="text-red-400 font-small">{{ $message }}</p>
        @enderror
    </div>
    <button class="btn btn-primary">Update</button>
</form>

@endsection