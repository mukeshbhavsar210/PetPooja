@extends('admin.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-11">
                <h1>Edit Permission</h1>
            </div>
            <div class="col-sm-1">
                <a href="{{ route('permissions.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</section>

<form action="{{ route('permissions.update',$permission->id) }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="">Name</label>
                <input value="{{ old('name', $permission->name) }}" name="name" placeholder="Permission name" type="text" class="form-control"/>
                @error('name')
                    <p class="text-red-400 font-small">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary mt-4">Update</button>
        </div>    
    </div>
</form>        

@endsection