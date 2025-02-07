@extends('admin.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-9">
                <h1>Roles <span class="count"></span></h1>
                    {{-- @can('create permissions')
                        <a href="{{ route('permissions.create') }}" class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">Create</a>
                    @endcan    --}}
            </div>
            <div class="col-sm-3">
                @can('create roles')
                    <a href="{{ route('roles.create') }}" class="btn btn-primary">Create</a>    
                @endcan
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#createRole">Create Role</button>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        @include('admin.message')

         <div class="modal fade drawer right-align" id="createRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ route('roles.store') }}" method="post">
                        <div class="modal-body">             
                            @csrf
                            <div class="form-group">
                                <label for="" class="text-lg font-medium">Name</label>
                                <input value="{{ old('name') }}" name="name" placeholder="Role name" type="text" class="form-control"/>
                                @error('name')
                                    <p class="text-red-400 font-small">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="row">
                                @if($permissions->isNotEmpty())
                                    @foreach ($permissions as $value)
                                        <div class="col-md-4">
                                            <input type="checkbox" id="permission_{{ $value->id }}" class="rounded" name="permission[]" value="{{ $value->name }}" />
                                            <label for="permission_{{ $value->id }}">{{ $value->name }}</label>
                                        </div>        
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>

            <table class="table border">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Name</th>
                        <th>Permissions</th>
                        <th width="250">Created</th>
                        <th width="200">Action</th>                                
                    </tr>
                </thead>
                <tbody class="bg-white">                    
                    @if($roles->isNotEmpty())
                        @foreach ($roles as $value)
                            <tr class="border-b">
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->permissions->pluck('name')->implode(', ') }}</td>
                                <td>{{ \Carbon\Carbon::parse($value->created_at)->format('d M, Y') }}</td>
                                <td class="px-6 py-2 text-center">
                                    <a href="{{ route("roles.edit", $value->id) }}" class="btn btn-primary">Edit</a>
                                    <a href="javascript:void(0)" onclick="deleteRole({{ $value->id }})" class="btn btn-danger">Delete</a>

                                    {{-- @can('edit roles')
                                        <a href="{{ route("roles.edit", $value->id) }}" class="bg-slate-600 text-xs rounded-md px-3 py-2 text-white hover:bg-state-500">Edit</a>
                                    @endcan
                                    @can('delete roles')
                                        <a href="javascript:void(0)" onclick="deleteRole({{ $value->id }})" class="bg-red-600 text-xs rounded-md px-3 py-2 text-white hover:bg-red-500">Delete</a>
                                    @endcan --}}
                                </td>
                            </tr>
                        @endforeach
                    @endif                            
                </tbody>
            </table>

            <div class="my-3">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
@endsection

@section('customJs')
<script type="text/javascript">
    function deleteRole(id) {
        if (confirm("Are you sure you want to delete?")) {
            $.ajax({
                url: '{{ route("roles.destroy") }}',
                type: 'delete',
                data: {id:id},
                dataType: 'json',                    
                headers: {
                    'x-csrf-token' : '{{ csrf_token() }}'
                },
                success: function(response) {
                    window.location.href="{{ route('roles.index') }}"
                }
            });
        }
    }
</script>
@endsection