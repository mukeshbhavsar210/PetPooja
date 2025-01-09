@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-9">
                <h1>Menu Item</h1>
            </div>
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModalRight">Add Menu</button>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        @include('admin.message')

        <!-- Modal -->
        <div class="modal fade drawer right-align" id="exampleModalRight" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Right Align Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="" method="post" name="productForm" id="productForm">
                    <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Item Name</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                        <p class="error"></p>
                    </div>
                
                    <div class="form-group">
                        <label for="description">Item Description</label>
                        <textarea name="description" id="description" cols="10" rows="3" class="form-control" placeholder="Description"></textarea>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="from-group">
                                <label for="category">Choose Menu</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select a category</option>
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="from-group">
                                <label for="menu">Item category</label>
                                <select name="menu" id="sub_category" class="form-control">
                                    <option value="">Select a category</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="vegContainer">
                            <div class="btn-group" name="veg_nonveg" id="options" data-toggle="buttons">
                                <label class="btn btn-default active">
                                  <input type="radio" name="veg_nonveg" id="option1" class="btn-check" value="Veg">
                                  <div class="innerView">
                                    <img src="{{ asset('admin-assets/img/veg.svg') }}" alt="" > Veg
                                  </div>                                          
                                </label>

                                <label class="btn btn-default" >
                                  <input type="radio" name="veg_nonveg" id="option2" class="btn-check" value="Non-veg" >
                                  <div class="innerView">
                                    <img src="{{ asset('admin-assets/img/non-veg.svg') }}" alt="" > Non-Veg
                                  </div>
                                </label>
                                
                                <label class="btn btn-default" >
                                  <input type="radio" name="veg_nonveg" id="option3" class="btn-check" value="Egg" >
                                  <div class="innerView">
                                    <img src="{{ asset('admin-assets/img/egg.svg') }}" alt="" > Egg
                                  </div>
                                </label>
                              </div>
                        </div>

                        {{-- <select name="veg_nonveg" id="veg_nonveg" class="form-control">
                            <option value="">Select a category</option>
                            <option value="veg">Veg</option>
                            <option value="non-veg">Non-veg</option>
                            <option value="egg">Egg</option>
                        </select> --}}
                    </div>
                    
                    <div class="form-group">                                                                
                        <div id="image" class="dropzone dz-clickable" style="height: 100px;">
                            <div class="dz-message needsclick">
                                Drop files here or click to upload.
                            </div>
                        </div>
                    </div>                                
                    <div class="row" id="product-gallery"></div>
                    
                    <div class="mb-2">
                        <label for="price">Price</label>
                        <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                        <p class="error"></p>
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

        <div class="card">
            <form action="" method="get" >
                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{ route('products.index') }}'" class="btn btn-default btn-sm">Reset</button>
                    </div>

                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input value="{{ Request::get('keyword') }}" type="text" name="keyword" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="360">Item Name</th>
                            <th>Price</th>
                            <th>Item Category</th>
                            <th>Menu Name</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($products->isNotEmpty())
                            @foreach($products as $value)
                            @php
                                $productImage = $value->product_images->first();
                            @endphp
                            <tr>                                
                                <td>
                                    <div class="row">
                                        <div class="col-md-3">
                                            @if (!empty($productImage->image))
                                                <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" class="img-thumbnail" width="50" >
                                                @else
                                                <img src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" class="img-thumbnail" width="50"  />
                                            @endif
                                        </div>
                                        <div class="col-md-9">
                                            <p>{{ $value->title }}</p>
                                            <p>{{ $value->description }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>₹{{ $value->price }}</td>                                                                
                                <td>{{ $value->category->name }}</td>
                                <td>{{ $value->menu->name }}</td>                               
                                <td>
                                    <a href="{{ route('products.edit', $value->id) }}">
                                        <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </a>
                                    <a href="#" onclick="deleteProduct( {{ $value->id }} )" class="text-danger w-4 h-4 mr-1">
                                        <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                          </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>Records not found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $products->links() }}
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
@endsection

@section('customJs')


@section('customJs')
<script>

    // $('.related-product').select2({
    //     ajax: {
    //         url: '{{ route('products.getProducts') }}',
    //         dataType: 'json',
    //         tags: true,
    //         multiple: true,
    //         minimumInputLength: 3,
    //         processResults: function (data) {
    //             return {
    //                 results: data.tags
    //             };
    //         }
    //     }
    // });

  



    //Product form add details in database
    $("#productForm").submit(function(event){
        event.preventDefault();

        var formArray = $(this).serializeArray();
        $("button[type='submit']").prop('disabled',true);

        $.ajax({
            url: '{{ route("products.store") }}',
            type: 'post',
            data: formArray,
            dataType: 'json',
            success: function(response){

                $("button[type='submit']").prop('disabled',false);

                if (response['status'] == true) {

                    $(".error").removeClass('invalid-feedback').html('');
                    $("input[type='text'], select, input[type='number']").removeClass('is-invalid');

                    window.location.href="{{ route('products.index') }}";

                } else {
                    var errors = response['errors'];

                    $(".error").removeClass('invalid-feedback').html('');
                    $("input[type='text'], select, input[type='number']").removeClass('is-invalid');

                    $.each(errors, function(key,value){
                        $(`#${key}`).addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(value);
                    });
                }
            },

            error: function(){
                console.log("Something went wrong")
            }
        });
    });



    $("#category").change(function(){
        var category_id = $(this).val();
        $.ajax({
            url: '{{ route("product-subcategories.index") }}',
            type: 'get',
            data: {category_id:category_id},
            dataType: 'json',
            success: function(response) {
                $("#sub_category").find("option").not(":first").remove();
                $.each(response["subCategories"],function(key,item){
                    $("#sub_category").append(`<option value='${item.id}' >${item.name}</option>`)
                })
            },
            error: function(){
                console.log("Something went wrong")
            }
        });
    })

    //File image uplaod
    Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            url:  "{{ route('temp-images.create') }}",
            maxFiles: 10,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(file, response){
                $("#image_id").val(response.image_id);
                console.log(response)

               var html = `<div class="col-md-2" id="image-row-${response.image_id}">
                    <div class="card">
                        <input type="hidden" name="image_array[]" value="${response.image_id}" >
                        <img src="${response.ImagePath}" />
                        <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="deleteCardImg">X</a>
                    </div>
                </div>`;

                $("#product-gallery").append(html);
            },
            complete: function(file){
                this.removeFile(file);
            }
        });

        function deleteImage(id){
            $("#image-row-"+id).remove();
        }

        function deleteProduct(id){
        var url = '{{ route("products.delete","ID") }}'
        var newUrl = url.replace("ID",id)

        if(confirm("Are you sure you want to delete?")){
            $.ajax({
                url: newUrl,
                type: 'delete',
                data: {},
                dataType: 'json',
                success: function(response){
                    if(response["status"]){
                        window.location.href="{{ route('products.index') }}"
                    } else {
                        window.location.href="{{ route('products.index') }}"
                    }
                }
            });
        }
    }


</script>

@endsection

