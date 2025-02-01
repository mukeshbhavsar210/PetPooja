@extends('admin.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-11">
                <h1>Create Permission</h1>
            </div>
            <div class="col-sm-1">
                <a href="{{ route('permissions.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</section>

<form action="{{ route('permissions.store') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="" class="text-lg font-medium">Name</label>
        <input value="{{ old('name') }}"  name="name" placeholder="Permission name" type="text" class="form-control"/>
        @error('name')
            <p class="text-red-400 font-small">{{ $message }}</p>
        @enderror
    </div>
    <button class="btn btn-primary">Submit</button>
    </div>
</form>
               
@endsection

@section('customJs')
@endsection