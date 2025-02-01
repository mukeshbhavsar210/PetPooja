@extends('admin.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-11">
                <h1>Create Article</h1>
            </div>
            <div class="col-sm-1">
                <a href="{{ route('articles.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</section>

<form action="{{ route('articles.store') }}" method="post">
    @csrf   
    <div class="form-group">
        <label for="" >Title</label><br />
        <input value="{{ old('title') }}" name="title" placeholder="Title" type="text" class="form-control"/>
        @error('title')
            <p class="text-red-400 font-small">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="" >Content</label><br />
        <textarea cols="10" rows="4" id="text" name="text" placeholder="Content" type="text" class="form-control">{{ old('text') }}</textarea>
    </div>

    <div class="form-group">
        <label for="" >Author</label><br />
        <input value="{{ old('author') }}" name="author" placeholder="Author" type="text" class="form-control"/>
        @error('author')
            <p class="text-red-400 font-small">{{ $message }}</p>
        @enderror
    </div>
    <button class="btn btn-primary">Submit</button>
</form>

@endsection