@extends('admin.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-9">
                <div class="flex-wrapper">
                    <button type="button" class="btn addBtn" >+</button>
                    <button type="button" class="btn removeBtn" >x</button>
                    <h1>Categories <span class="count">{{ $totalMenu }}</span></h1>
                    <form action="" method="post" id="categoryForm" name="categoryForm" class="form">
                        <div class="form-adding">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                            <input type="hidden" name="slug" id="slug" class="form-control" placeholder="Slug">
                            <button type="submit" class="btn btn-primary">Add</button>
                            <p></p>
                        </div>
                        {{-- <div class="form-group">
                            <input type="hidden" id="image_id" name="image_id" value=" ">
                            <label for="image">Image</label>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    <br>Drop files here or click to upload.<br><br>
                                </div>
                            </div>
                        </div> --}}
                    </form> 
                </div>
            </div>

            <div class="col-sm-3">
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addMenuItem">Add Menu</button>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        @include('admin.message')

         <div class="modal fade drawer right-align" id="addMenuItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="" method="post" name="addingMenuForm" id="addingMenuForm">
                        <div class="modal-body">                  
                            <div class="form-group">
                                <label for="name">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select a category</option>
                                    @if($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>
                                                            
                            <div class="form-group">
                                <label for="name">Menu Name</label>
                                <input type="text" name="name" id="menu_name" class="form-control" placeholder="Name">
                                <p></p>
                            </div> 

                            <input type="hidden" name="slug" id="menu_slug" class="form-control" placeholder="Slug">

                            <div class="form-group">
                                <input type="hidden" id="image_id" name="image_id" value=" ">
                                <label for="image">Menu Photo</label>
                                <div id="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        <br>Drop files here or click to upload.<br><br>
                                    </div>
                                </div>
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

        <div class="card-body table-responsive mt-3 p-0">
            <ul class="nav nav-tabs" role="tablist">
                @if ($categories->isNotEmpty())
                    @foreach ($categories as $value)
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs_{{ $value->id }}" role="tab">{{ $value->name }} <span class="count-sub">{{ $value->total_products }}</span></a>
                        </li>
                    @endforeach
                @endif
            </ul>

            <div class="tab-content">
                @if ($categories->isNotEmpty())
                    @foreach ($categories as $value)
                        <div class="tab-pane" id="tabs_{{ $value->id }}" role="tabpanel">
                            <div class="row ml-1 my-4">
                                @if ($value->menus->isNotEmpty())
                                    @foreach ($value->menus as $value)
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-md-8">{{ $value->name }}</div>
                                                    <div class="col-md-4">
                                                        <a href="{{ route('menu.edit', $value->id ) }}">
                                                            <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                            </svg>
                                                        </a>
                                                        <a href="#" onclick="deleteMenuItem({{ $value->id }})" class="text-danger w-4 h-4 mr-1">
                                                            <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                                </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body p-0">
                                                <img style="border-radius: 100px; width:150px;" src="{{ asset('uploads/menu/thumb/'.$value->image) }}" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
</section>
@endsection

@section('customJs')
<script>    
$("#addingMenuForm").submit(function(event){
        event.preventDefault();

        var element = $('#addingMenuForm');
        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url: '{{ route("menu.store") }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);

                if(response["status"] == true){
                    window.location.href="{{ route('menu.index') }}"

                    $('#name').removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");
                    
                    $('#category').removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");

                } else {
                    var errors = response['errors']
                    if(errors['name']){
                        $('#name').addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['name']);
                    } else {
                        $('#name').removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                    }
                    
                    if(errors['category']){
                        $('#category').addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['category']);
                    } else {
                        $('#category').removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                    }
                }

            }, error: function(jqXHR, exception) {
                console.log("Something event wrong");
            }
        })
    });


    //DELETE
    function deleteMenuItem(id){
        var url = '{{ route("menu.delete","ID") }}'
        var newUrl = url.replace("ID",id)

        if(confirm("Are you sure you want to delete?")){
            $.ajax({
                url: newUrl,
                type: 'delete',
                data: {},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    window.location.href="{{ route('categories.index') }}"
                }
            });
        }
    }

    Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url:  "{{ route('temp-images.create') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(file, response){
                $("#image_id").val(response.image_id);
                console.log(response)
            }
        });


    // $('#menu_name').change(function(){
    //     element = $(this);
    //     $("button[type=submit]").prop('disabled', true);
    //     $.ajax({
    //         url: '{{ route("getSlug") }}',
    //         type: 'get',
    //         data: {title: element.val()},
    //         dataType: 'json',
    //         success: function(response){
    //             $("button[type=submit]").prop('disabled', false);
    //             if(response["status"] == true){
    //                 $("#menu_slug").val(response["slug"]);
    //             }
    //         }
    //     });
    // })

    $("#categoryForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("categories.store") }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);

                if(response["status"] == true){

                    window.location.href="{{ route('categories.index') }}"

                    $('#name').removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");

                } else {
                    var errors = response['errors']
                    if(errors['name']){
                        $('#name').addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['name']);
                    } else {
                        $('#name').removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                    }
                 
                }
            }, error: function(jqXHR, exception) {
                console.log("Something event wrong");
            }
        })
    });      

    $('#name').change(function(){
        element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("getSlug") }}',
            type: 'get',
            data: {title: element.val()},
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);
                if(response["status"] == true){
                    $("#slug").val(response["slug"]);
                }
            }
        });
    })

    //DELETE
    function deleteCategory(id){
        var url = '{{ route("categories.delete","ID") }}'
        var newUrl = url.replace("ID",id)

        if(confirm("Are you sure you want to delete?")){
            $.ajax({
                url: newUrl,
                type: 'delete',
                data: {},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    window.location.href="{{ route('categories.index') }}"
                }
            });
        }
    }

    // Dropzone.autoDiscover = false;
    //     const dropzone = $("#image").dropzone({
    //         init: function() {
    //             this.on('addedfile', function(file) {
    //                 if (this.files.length > 1) {
    //                     this.removeFile(this.files[0]);
    //                 }
    //             });
    //         },
    //         url:  "{{ route('temp-images.create') }}",
    //         maxFiles: 1,
    //         paramName: 'image',
    //         addRemoveLinks: true,
    //         acceptedFiles: "image/jpeg,image/png,image/gif",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }, success: function(file, response){
    //             $("#image_id").val(response.image_id);
    //             console.log(response)
    //         }
    //     });
    </script>
@endsection
