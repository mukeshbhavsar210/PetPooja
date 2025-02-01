@extends('admin.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-11">
                <h1>Permissions</h1>
            </div>
            <div class="col-sm-1">
                <a href="{{ route('permissions.create') }}" class="btn btn-primary">Create</a>
                {{-- @can('create permissions')
                    <a href="{{ route('permissions.create') }}" class="bg-slate-700 text-sm rounded-md px-3 py-2 text-white">Create</a>
                @endcan    --}}
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
                        <th>Title</th>                        
                        <th>Author</th>    
                        <th width="250">Created</th>
                        <th class="px-6 py-2 text-center" width="200">Action</th>                                
                    </tr>
                </thead>
                <tbody>
                    @if($articles->isNotEmpty())
                        @foreach ($articles as $value)
                            <tr class="border-b">
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->title }}</td>
                                <td>{{ $value->author }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($value->created_at)->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-2 text-center">
                                    <a href="{{ route("articles.edit", $value->id) }}" class="btn btn-primary">Edit</a>
                                    <a href="javascript:void(0)" onclick="deleteArticle({{ $value->id }})" class="btn btn-danger">Delete</a>                                        

                                    {{-- @can('edit articles')
                                        <a href="{{ route("articles.edit", $value->id) }}" class="bg-slate-600 text-xs rounded-md px-3 py-2 text-white hover:bg-state-500">Edit</a>    
                                    @endcan
                                    @can('delete articles')
                                        <a href="javascript:void(0)" onclick="deleteArticle({{ $value->id }})" class="bg-red-600 text-xs rounded-md px-3 py-2 text-white hover:bg-red-500">Delete</a>    
                                    @endcan --}}
                                </td>
                            </tr>
                        @endforeach
                    @endif                            
                </tbody>
            </table>

            <div class="my-3">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script type="text/javascript">
        function deleteArticle(id) {
            if (confirm("Are you sure you want to delete?")) {
                $.ajax({
                    url: '{{ route("articles.destroy") }}',
                    type: 'delete',
                    data: {id:id},
                    dataType: 'json',                    
                    headers: {
                        'x-csrf-token' : '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        window.location.href="{{ route('articles.index') }}"
                    }
                });
            }
        }
    </script>
@endsection