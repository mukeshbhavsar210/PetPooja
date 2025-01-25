@extends('admin.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Area & tables <span class="count">{{ $areaCount }}</span></h1>
            </div>
            <div class="col-sm-6 text-right">
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
    <!-- /.container-fluid -->
</section>

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-9">
                <ul class="progressStep">
                    <li><a href="#" class="active"><span>1</span> Choose a table</a></li>
                    <li><a href="#"><span>2</span> Choose a customer</a></li>
                    <li><a href="#"><span>3</span> Select a menu</a></li>
                </ul>                
            </div>
            <div class="col-sm-3">
                
            </div>           
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        @include('admin.message')
        <ul class="tabs" style="position: relative">
            @if ($areas->isNotEmpty())
                @php
                    $count=1;
                @endphp
                @foreach ($areas as $value )
                    <li>
                        <a data-toggle="tab" href="#tabs-{{ $count }}" role="tab">{{ $value->area_name }}</a>
                        <div class="showingTabs">  
                            <div class="tab-pane my-4" id="tabs-{{ $count }}" role="tabpanel"> 
                                <div class="row">
                                    @if ($value->seating->isNotEmpty())
                                        @foreach ($value->seating as $value)
                                            <a href="#" data-toggle="modal" data-target="#qr_{{ $value->id }}">{{ $value->table_name }}</a>

                                            <div class="modal fade" id="qr_{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h4 class="modal-title" id="myModalLabel">QR Code - {{ $value->table_name }}</h4>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ $value->area_name }}
                                                      {!! DNS2D::getBarcodeHTML('http://127.0.0.1:8000/'.$value->area_name.'/'.$value->table_slug, 'QRCODE',6.5,6.5) !!}
                                                    </div>
                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>

                                            @if($value->status == 'Available')
                                                <div class="status available ">Available</div>
                                            @endif

                                            @if($value->status == 'Reserved')
                                                <div class="status reserved">Reserved</div>
                                            @endif

                                            @if($value->status == 'Booked')
                                                <div class="status booked">Booked</div>
                                            @endif

                                            @if($value->status == 'Filled')
                                                <div class="status filled">Filled</div>
                                            @endif

                                        @if($value->seating_capacity == 2)                                      
                                            <div class="col">
                                                <div class="tableWrapper">
                                                   
                                                    {{ $value->name }}
                                                   <img src="{{ asset('admin-assets/img/2_chair.jpg') }}" alt="" >
                                                    {{-- <a href="{{ route('seatings.edit', $value->id ) }}">
                                                        <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                        </svg>
                                                    </a> --}}
                                                </div>
                                            </div>

                                            @elseif($value->seating_capacity == 4)
                                            <div class="col">
                                                <div class="tableWrapper">
                                                    <img src="{{ asset('admin-assets/img/4_chair.jpg') }}" alt="" >
                                                </div>
                                            </div>
                                                
                                            @elseif($value->seating_capacity == 6)
                                            <div class="col">
                                                <div class="tableWrapper">
                                                    <img src="{{ asset('admin-assets/img/6_chair.jpg') }}" alt="" >
                                                </div>
                                            </div>
                                                
                                            @elseif($value->seating_capacity == 8)
                                            <div class="col">
                                                <div class="tableWrapper">
                                                    <img src="{{ asset('admin-assets/img/8_chair.jpg') }}" alt="" >
                                                </div>
                                            </div>
                                                
                                            @elseif($value->seating_capacity == 10)
                                            <div class="col">
                                                <div class="tableWrapper">
                                                    <img src="{{ asset('admin-assets/img/10_chair.jpg') }}" alt="" >
                                                </div>                                            
                                            </div> 
                                        @endif 
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @php
                    $count++;
                @endphp
                @endforeach
            @endif
        </ul>
    </div>
</section>
@endsection

@section('customJs')
<script>
  
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



$(document).ready(function(){
    $('.tabs li').click(function(event){
        $('.active-tab').removeClass('active-tab');
        $(this).addClass('active-tab');
        event.preventDefault();
    });
});
    
    $(".tabs li:first").addClass("active-tab");   
    
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
</script>
@endsection