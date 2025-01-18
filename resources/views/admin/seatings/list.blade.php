@extends('admin.layouts.app')

@section('content')

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
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModalRight">Add Table</button>
            </div>           
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        @include('admin.message')

        <div class="modal fade drawer right-align" id="exampleModalRight" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Table</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="" method="post" name="addingTableForm" id="addingTableForm">
                        <div class="modal-body">                  
                            <div class="form-group">
                                <label for="name">Select Area</label>
                                <select name="area" id="area" class="form-control">
                                    <option value="">Select a Area</option>
                                    @if($areas->isNotEmpty())
                                        @foreach ($areas as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Table Code</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Table_01">
                                        <p></p>
                                    </div>  
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_code">QR code</label>
                                        <input type="text" name="product_code" id="product_code" class="form-control" placeholder="e.g. Table_01">
                                        <p></p>
                                    </div>  
                                </div>
                                <div class="col-md-6">
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
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>
                                <p></p>
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

        <ul class="tabs" style="position: relative">
            @if (getAreas()->isNotEmpty())
                @php
                    $count=1;
                @endphp
                @foreach (getAreas() as $value )
                    <li>
                        <a data-toggle="tab" href="#tabs-{{ $count }}" role="tab">{{ $value->name }}</a>

                        <div class="showingTabs">  
                            <div class="tab-pane my-4" id="tabs-{{ $count }}" role="tabpanel"> 
                                <div class="row">
                                    @if ($value->seating->isNotEmpty())
                                        @foreach ($value->seating as $value)

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

$(document).ready(function(){
    $('.tabs li').click(function(event){
        $('.active-tab').removeClass('active-tab');
        $(this).addClass('active-tab');
        event.preventDefault();
    });
});
    
    $(".tabs li:first").addClass("active-tab");    

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
</script>
@endsection
