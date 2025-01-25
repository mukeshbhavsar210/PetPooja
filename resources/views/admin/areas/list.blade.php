@extends('admin.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-9">
                <div class="flex-wrapper">
                    <button type="button" class="btn addBtn" >+</button>
                    <button type="button" class="btn removeBtn" >x</button>
                    <h1>Area <span class="count">{{ $totalTable }}</span></h1>
                    {{-- <form action="" method="post" id="addAreaForm" name="addAreaForm"> --}}
                    <form action="areas" method="post" class="form">
                        @csrf
                        
                        <div class="form-adding">
                            <input type="text" name="area_name" id="area_name" class="form-control" placeholder="Name">
                            <input type="hidden" name="area_slug" id="area_slug" class="form-control" placeholder="Name">
                            <p></p>
                            <button type="submit" id="hideSmallForm" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        @include('admin.message')

        <div class="row">
            <div class="col-md-8">
                <div id="accordion" class="accordion">
                <div class="card mb-0">
                    @if ($areas->isNotEmpty())
                        @foreach ($areas as $value)
                            <div class="card-header collapsed" data-toggle="collapse" href="#collapse_{{ $value->id }}" aria-expanded="true">
                                <a class="card-title">{{ $value->area_name }} <span class="count">1</span></a> 
                            </div>
                            <div id="collapse_{{ $value->id }}" class="collapse" data-parent="#accordion" >
                                <div class="card-body">
                                    <div class="row">
                                        @if ($value->seating->isNotEmpty())
                                            @foreach ($value->seating as $value)
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <button data-toggle="modal" data-target="#qr_{{ $value->id }}" class="btn btn-primary">{{ $value->table_name }}</button>
                                                        </div>
                                                        <div class="card-body">
                                                        
                                                        {!! DNS2D::getBarcodeHTML('http://127.0.0.1:8000/'.$value->area_name.'/'.$value->table_slug, 'QRCODE',6.5,6.5) !!}
                                                        @if($value->status == 'Available')
                                                            <div class="status available ">Available</div>
                                                        @endif
                                                        @if($value->status == 'Reserved')
                                                            <div class="status reserved mt-2">Reserved</div>
                                                        @endif
                                                        @if($value->status == 'Booked')
                                                            <div class="status booked mt-2">Booked</div>
                                                        @endif
                                                        @if($value->status == 'Filled')
                                                            <div class="status filled mt-2">Filled</div>
                                                        @endif
                                                    </div>
                                                </div>

                                                    <div class="modal fade" id="qr_{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel">Add table for - {{ $value->area->area_name }}</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{ $value->area_name }}
                                                                {{-- {!! DNS2D::getBarcodeHTML('http://127.0.0.1:8000/'.$value->area_name.'/'.$value->table_slug, 'QRCODE',6.5,6.5) !!} --}}

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
                                                            <div class="modal-footer">
                                                                @if ($value->seating->isNotEmpty())
                                                                    @foreach ($value->seating as $value)
                                                                        <button data-toggle="modal" data-target="#qr_{{ $value->id }}" class="btn btn-primary">111{{ $value->table_name }}</button>
                                                                    @endforeach
                                                                @endif
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>                           
                                <div class="card-footer">
                                    <a href="{{ route('categories.index') }}" class="btn btn-primary">Add table</a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            
              
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Assgin table</div>
                    <div class="card-body">1</div>
                    <div class="card-footer">1</div>
                </div>
            </div>
        </div>
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
                    window.location.href="{{ route('tables.index') }}"

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