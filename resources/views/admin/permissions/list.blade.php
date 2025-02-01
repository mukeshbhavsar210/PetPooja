@extends('admin.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-11">
                <div class="flex-wrapper">
                    {{-- @can('create permissions')
                        <a href="{{ route('permissions.create') }}" class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">Create</a>
                    @endcan    --}}
                    <button type="button" class="btn addBtn" >+</button>
                    <button type="button" class="btn removeBtn" >x</button>

                    <h1>Permissions</h1>
                    
                    <form action="{{ route('permissions.store') }}" method="post" class="form">
                        @csrf
                        <div class="form-group">
                            <label for="" class="text-lg font-medium">Name</label>
                            <input value="{{ old('name') }}"  name="name" placeholder="Permission name" type="text" class="form-control"/>
                            @error('name')
                                <p class="text-red-400 font-small">{{ $message }}</p>
                            @enderror
                        </div>
                            <button class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        @include('admin.message')

        <table class="table border">
            <thead>
                <tr>
                    <th width="60">#</th>
                    <th>Name</th>
                    <th width="250">Created</th>
                    <th width="200">Action</th>                                
                </tr>
            </thead>
            <tbody>
                @if($permissions->isNotEmpty())
                    @foreach ($permissions as $value)
                        <tr class="border-b">
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->name }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($value->created_at)->format('d M, Y') }}
                            </td>
                            <td>
                                <a href="{{ route("permissions.edit", $value->id) }}" class="btn btn-primary">Edit</a>
                                <a href="javascript:void(0)" onclick="deletePermission({{ $value->id }})" class="btn btn-danger">Delete</a>
                                {{-- @can('edit permissions')
                                    <a href="{{ route("permissions.edit", $value->id) }}" class="bg-slate-600 text-xs rounded-md px-3 py-2 text-white hover:bg-state-500">Edit</a>
                                @endcan
                                @can('delete permissions')
                                    <a href="javascript:void(0)" onclick="deletePermission({{ $value->id }})" class="bg-red-600 text-xs rounded-md px-3 py-2 text-white hover:bg-red-500">Delete</a>
                                @endcan --}}
                            </td>
                        </tr>
                    @endforeach
                @endif                            
            </tbody>
        </table>

        <div class="my-3">
            {{ $permissions->links() }}
        </div>
    </div>
</section>
       
@endsection

@section('customJs')
<script type="text/javascript">
    function deletePermission(id) {
        if (confirm("Are you sure you want to delete?")) {
            $.ajax({
                url: '{{ route('permissions.destroy') }}',
                type: 'delete',
                data: {id:id},
                dataType: 'json',                    
                headers: {
                    'x-csrf-token' : '{{ csrf_token() }}'
                },
                success: function(response) {
                    window.location.href="{{ route('permissions.index') }}"
                }
            });
        }
    }
</script>
@endsection