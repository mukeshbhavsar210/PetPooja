@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Edit Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->

    <section >
        <form action="" method="post" name="productForm" id="productForm">
            <div class="container-fluid">                
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">Item Name</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{ $product->title }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Item Description</label>
                                    <textarea name="description" id="description" cols="10" rows="3" class="form-control" placeholder="Description">{{ $product->description }}</textarea>
                                </div>
                            </div>
                           
                            <div class="col-md-6">
                                <div class="from-group">
                                    <label for="category">Choose Menu</label>
                                    <select name="category" id="category" class="form-control">
                                    <option value="">Select a category</option>
                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $value)
                                                <option {{ ($product->category_id == $value->id) ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="from-group">
                                    <label for="category">Item category</label>
                                    <select name="menu" id="sub_category" class="form-control">
                                        <option value="">Select a Sub category</option>
                                        @if ($subCategories->isNotEmpty())
                                            @foreach ($subCategories as $subCategory)
                                                <option {{ ($product->menu_id == $subCategory->id) ? 'selected' : '' }} value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="vegContainer">
                                    <div class="btn-group" id="options" data-toggle="buttons">
                                        <label class="btn btn-default active">
                                          <input type="radio" name ="option" id="option1" class="btn-check" value="Veg" {{ ($product->veg_nonveg == 'Veg' ? 'checked' : '' )}}>
                                          <div class="innerView">
                                            <img src="{{ asset('admin-assets/img/veg.svg') }}" alt="" > Veg
                                          </div>                                          
                                        </label>

                                        <label class="btn btn-default" >
                                          <input type="radio" name ="option" id="option2" class="btn-check" value="Non-veg" {{ ($product->veg_nonveg == 'Non-veg' ? 'checked' : '' )}} >
                                          <div class="innerView">
                                            <img src="{{ asset('admin-assets/img/non-veg.svg') }}" alt="" > Non-Veg
                                          </div>
                                        </label>
                                        
                                        <label class="btn btn-default" >
                                          <input type="radio" name ="option" id="option3" class="btn-check" value="Egg" {{ ($product->veg_nonveg == 'Egg' ? 'checked' : '' )}}>
                                          <div class="innerView">
                                            <img src="{{ asset('admin-assets/img/egg.svg') }}" alt="" > Egg
                                          </div>
                                        </label>
                                      </div>
                                </div>
                            </div>
                       
                            <div class="col-md-12">
                                <div class="from-group">
                                    <h2 class="h4 mb-2">Media</h2>
                                    <div id="image" class="dropzone dz-clickable mb-4">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                    <div id="product-gallery">
                                        @if ($productImages->isNotEmpty())
                                        <h6>Uploaded images</h6>
                                        <div class="row">
                                            @foreach ( $productImages as $image)
                                                <div class="col-md-2" id="image-row-{{ $image->id }}">
                                                    <div class="card">
                                                        <input type="hidden" name="image_array[]" value="{{ $image->id }}" >
                                                        <img src="{{ asset('uploads/product/small/'.$image->image ) }}" />
                                                        <a href="javascript:void(0)" onclick="deleteImage({{ $image->id }})" class="deleteCardImg">X</a>
                                                    </div>
                                                </div>
                                            @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="from-group">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" id="price" class="form-control" placeholder="Price" value="{{ $product->price }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
    </section>
@endsection

@section('customJs')
<script>
    $('.related-product').select2({
        ajax: {
            url: '{{ route('products.getProducts') }}',
            dataType: 'json',
            tags: true,
            multiple: true,
            minimumInputLength: 3,
            processResults: function (data) {
                return {
                    results: data.tags
                };
            }
        }
    });

    $('#title').change(function(){
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



    //Product form add details in database
    $("#productForm").submit(function(event){
        event.preventDefault();

        var formArray = $(this).serializeArray();
        $("button[type='submit']").prop('disabled',true);

        $.ajax({
            url: '{{ route("products.update",$product->id) }}',
            type: 'put',
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
            url:  "{{ route('product-images.update') }}",
            maxFiles: 10,
            paramName: 'image',
            params: {'product_id' : '{{ $product->id }}'},
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

            if (confirm("Are you sure you want to delete image?")) {
                $.ajax({
                    url: '{{ route("product-images.destroy") }}',
                    type: 'delete',
                    data: {id:id},
                        success: function(response) {
                            if(response.status == true){
                                alert(response.message);
                            } else {
                                alert(response.message);
                            }
                        }
                })
            }
        }

</script>

@endsection
