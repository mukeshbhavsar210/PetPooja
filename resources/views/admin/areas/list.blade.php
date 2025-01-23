@extends('admin.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-9">
                <h1>Area <span style="background: #000; margin-left:5px; position:relative; top:-4px; padding:4px 9px; font-size:14px; border-radius:100px; color:#fff;">{{ $totalTable }}</span></h1>
            </div>
            <div class="col-sm-3">
                <div class="menu">
                    <button type="button" id="showmenu" class="btn btn-primary float-right" >Add Branch</button>
                    {{-- <form action="" method="post" id="addAreaForm" name="addAreaForm"> --}}
                    <form action="areas" method="post">
                        @csrf
                        
                        <div class="form-group">
                            <input type="text" name="area_name" id="area_name" class="form-control" placeholder="Name">
                            <input type="hidden" name="area_slug" id="area_slug" class="form-control" placeholder="Name">
                            <p></p>
                        </div>
                        <button type="submit" id="hideSmallForm" class="btn btn-primary">Tick</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        @include('admin.message')
        <div id="accordion" class="accordion">
            <div class="card mb-0">
                @if ($areas->isNotEmpty())
                    @foreach ($areas as $value)
                        <div class="card-header collapsed" data-toggle="collapse" href="#collapse{{ $value->id }}" aria-expanded="true">
                            <a class="card-title">{{ $value->area_name }}</a> 
                            <span style="background: #666; margin-left:5px; position:relative; top:1px; padding:3px 8px; font-size:12px; border-radius:100px; color:#fff;">{{ $tableIndividual }}</span>
                        </div>
                        <div id="collapse{{ $value->id }}" class="card-body collapse" data-parent="#accordion" >

                            <div class="row">
                                <div class="col-md-9 col-12">
                                    <div class="row">
                                        @if ($seatings->isNotEmpty())
                                            @foreach ($seatings as $value)
                                                <div class="col-md-4">
                                                    <div class="card p-0">
                                                        <div class="card-body p-4">
                                                            <div class="qr_code">                                                            
                                                                <b>{{ $value->table_name }} {{ $value->id }}</b>
                                                                <a href="#" onclick="deleteArea({{ $value->id }})" class="text-danger w-4 h-4 mr-1">
                                                                    <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                        <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                                    </svg>
                                                                </a>
                                                                {!! DNS2D::getBarcodeHTML('http://127.0.0.1:8000/'.$value->area_name.'/'.$value->table_slug, 'QRCODE',6.5,6.5) !!}
                                                            </div>                                                        
                                                            
                                                            {{-- <a href="{{ route('areas.edit', $value->id ) }}">
                                                                <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                                </svg>
                                                            </a> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                            @endforeach
                                        @else
                                            Records not found
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <form action="" method="post" name="addingTableForm" id="addingTableForm">
                                    {{-- <form action="seatings" method="post">
                                        @csrf --}}
                                        <div class="row">
                                            {{-- <div class="mb-3 ">
                                                <select name="area" id="area" class="form-control">
                                                    <option selected value="{{ $value->id }}">{{ $value->area_name }}</option>
                                                </select>
                                            </div> --}}
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Select Area</label>
                                                    <select name="area" id="area" class="form-control">
                                                        <option value="">Select a Area</option>
                                                        @if($areas->isNotEmpty())
                                                            @foreach ($areas as $value)
                                                                <option value="{{ $value->id }}">{{ $value->area_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <p></p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="table_name">Table Code</label>
                                                    <input type="text" name="table_name" id="name" class="form-control" placeholder="e.g. Table_01">
                                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug">
                                                    {{-- <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                                    {{-- <input type="hidden" name="product_code" id="product_code" class="form-control">
                                                    <input type="hidden" name="qr_generate" id="qr_generate"> --}}
                                                    <p></p>
                                                </div>  
                                            </div>    
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="seating_capacity">Seating Capacity</label>
                                                    <select name="seating_capacity" id="seating_capacity" class="form-control">
                                                        <option value="">Select table</option>
                                                        <option value="2">2 tables</option>
                                                        <option value="4">4 tables</option>
                                                        <option value="6">6 tables</option>
                                                        <option value="8">8 tables</option>
                                                        <option value="10">10 tables</option>
                                                    </select>
                                                    <p></p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary mt-4">Create</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>        
        {{-- {{ $areas->links() }} --}}
    </div>
</section>
@endsection

@section('customJs')
<script>  
$('#area_name').change(function(){
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
                    $("#area_slug").val(response["slug"]);
                }
            }
        });
    })

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
                    $("#product_code").val(response["slug"]);
                }
            }
        });
    })

    $("#addingTableForm").submit(function(event){
        event.preventDefault();

        var element = $('#addingTableForm');
        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url: '{{ route("seatings.store") }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);

                if(response["status"] == true){
                    window.location.href="{{ route('seatings.index') }}"

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
                    window.location.href="{{ route('menu.index') }}"
                    /*if(response["status"]){
                        window.location.href="{{ route('menu.index') }}"
                    }*/
                }
            });
        }
    }

    $("#addAreaForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("areas.store") }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);

                if(response["status"] == true){
                    window.location.href="{{ route('areas.index') }}"
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

    function deleteArea(id){
        var url = '{{ route("areas.delete","ID") }}'
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
                    if(response["status"]){
                        window.location.href="{{ route('areas.index') }}"
                    }
                }
            });
        }
    }
</script>
@endsection