@extends('admin.layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-9">
                <h1>QR Codes</h1>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        @include('admin.message')

        <ul class="tabs">
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
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="flexWrapper">
                                                            <h5>{{ $value->name }}</h5>
                                                           
                                                            <p class="seatCount">{{ $value->seating_capacity }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">                                                        
                                                        <div class="qr_code">                                                            
                                                            {!! DNS2D::getBarcodeHTML('http://127.0.0.1:8000/'.$value->area->slug.'/'.$value->slug, 'QRCODE',6.7,6.7) !!}
                                                        </div>                                                        
                                                    </div>
                                                    <div class="card-footer">
                                                        <ul class="cardDownload">
                                                            <li><a href="#">Download</a></li>
                                                            <li><a href="#">View</a></li>
                                                        </ul>                                                        
                                                    </div>
                                                </div>
                                            </div>
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
