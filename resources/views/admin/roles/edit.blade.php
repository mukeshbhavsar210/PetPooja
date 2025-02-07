@extends('admin.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-11">
                <h1>Edit Role</h1>
            </div>
            <div class="col-sm-1">
                <a href="{{ route('roles.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        <form action="{{ route('roles.update',$role->id) }}" method="post">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input value="{{ old('name', $role->name) }}" name="name" placeholder="Permission name" type="text" class="form-control"/>
                        @error('name')
                            <p class="text-red-400 font-small">{{ $message }}</p>
                        @enderror
                    </div>                        
                    <div class="row">
                        @if($permissions->isNotEmpty())
                            @foreach ($permissions as $value)
                                <div class="col-md-3">
                                    <input {{ ($hasPermissions->contains($value->name)) ? 'checked' : '' }} type="checkbox" id="permission_{{ $value->id }}" class="rounded" name="permission[]" value="{{ $value->name }}" />
                                    <label for="permission_{{ $value->id }}">{{ $value->name }}</label>
                                </div>        
                            @endforeach
                        @endif
                    </div>

            <button class="btn btn-primary mt-2">Update</button>
        </form>
    </div>
    </div>
</section>   
@endsection