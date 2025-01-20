@extends('front.layouts.app')

@section('content')

<div class="menu-content--categories-medium-photo menu-content">
    <section class="menu-products-section menu-products-section--grid">
        @include('front.home.products')
    </section>
</div>

<?php $total = 0 ?>

@if(session('cart'))
    @foreach(session('cart') as $id => $details)
        <?php $total += $details['price']  ?>
    @endforeach
@endif

<div class="mainCartWrapper">
    <div class="row" id="cartDetails">
        <div class="col-11">
            <a>Order {{ count((array) session('cart')) }} for ₹ {{ $total }}</a>
        </div>
        <div class="col-1">
            <a href="{{ url('clear-cart') }}" class="cart-icon"><i class="fa fa-trash"></i></a>
        </div>
    </div>

    <div class="orderDetails">        
        <div class="orderBottom">
            <div class="nav nav-tabs mb-3" role="tablist">
                <button class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Dinein</button>
                <button class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Takeaway</button>
                <button class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Delivery</button>
            </div>
            
            <?php $total = 0 ?>
                @if(session('cart'))
                    <div class="basket-page__content__products">
                        @foreach(session('cart') as $id => $details)
                            @include('front.layouts.message')

                            {{-- <form action="" method="POST" id="diningForm" name="diningForm"> --}}
                            <form action="dining" method="POST" >
                                @csrf

                                <div class="row mb-2">
                                    <div class="col-7">
                                        <p class="my-2"> {{ $details['quantity'] }} x {{ $details['name'] }} </p>
                                        <input type="hidden" multiple name="name" value="{{ $details['name'] }}">
                                        <input type="hidden" multiple name="qty" value="{{ $details['quantity'] }}">
                                    </div>
                                    <div class="col-3 p-0">
                                        <div class="flex">
                                            <?php 
                                                $isEmpty = $details['quantity'];   
                                            ?>

                                            <input type="hidden" multiple name="name" value="{{ $details['name'] }}">

                                            @if($isEmpty > 1)
                                                <div class="input-group-btn">
                                                    <button class="btn--icon sub" data-id=" ">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                            class="bi bi-dash-lg" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd"
                                                                d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8Z"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="input-group-btn">
                                                    <button class="btn--icon delete" data-id="{{ $id }}" title="Delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                            class="bi bi-dash-lg" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd"
                                                                d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8Z"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endif

                                            <div class="input-group-btn">
                                                <button class="btn--icon add" data-id=" ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                        class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="right">
                                            <p class="my-2">₹{{ $details['price'] }}</p>
                                            <input type="hidden" multiple name="price" value="{{ $details['price'] }}">
                                        </div>
                                    </div>
                                    <?php $total += $details['price'] * $details['quantity'] ?>
                                    {{-- <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity" />
                                    Rs.{{ $details['price'] * $details['quantity'] }} --}}
                                </div>
                        @endforeach
                    </div>
                @endif

                <input type="hidden" name="total" value="{{ $total }}">

            <div class="basket-page__content__total">
                @if(!empty($details))
                    <div>Total:</div>
                    <div style="flex-grow: 1;"></div>
                    ₹{{ $total }}
                @else
                    <div class="col-md-12">
                        <div class="emptyBag">
                            <img src="{{ asset('front-assets/images/empty_bag.png') }}">
                            <h5>Nothing to order</h5>
                        </div>
                    </div>
                @endif
            </div>

            @if(!empty($details))
            
                <div class="tab-content">
                    <div class="tab-pane p-3 active" id="tabs-1" role="tabpanel">
                        @include('front.home.tab_01')
                    </div>

                    <div class="tab-pane p-3" id="tabs-2" role="tabpanel">
                        @include('front.home.tab_02')
                    </div>

                    <div class="tab-pane p-3" id="tabs-3" role="tabpanel">
                        @include('front.home.tab_03')
                    </div>
                </div>
                
            @endif
        </div>
    </div>
</div>
<div class="orderOverlay"></div>

@endsection

@section('customJs')
<script>

    $("#orderItemForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("submit.order") }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);

                if(response["status"] == true){
                    window.location.href="{{ route('front.home') }}"
                } else {
                    var errors = response['errors']
                }

            }, error: function(jqXHR, exception) {
                console.log("Something event wrong");
            }
        })
    }); 


    $("#diningForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("submit.dining") }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);

                if(response["status"] == true){
                    window.location.href="{{ route('front.home') }}"
                } else {
                    var errors = response['errors']
                }

            }, error: function(jqXHR, exception) {
                console.log("Something event wrong");
            }
        })
    });

    $("#takeawayForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("submit.takeaway") }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);

                if(response["status"] == true){
                    window.location.href="{{ route('front.home') }}"
                } else {
                    var errors = response['errors']
                }

            }, error: function(jqXHR, exception) {
                console.log("Something event wrong");
            }
        })
    });  

    $("#deliveryForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("submit.delivery") }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);

                if(response["status"] == true){
                    window.location.href="{{ route('front.home') }}"
                } else {
                    var errors = response['errors']
                }

            }, error: function(jqXHR, exception) {
                console.log("Something event wrong");
            }
        })
    });  
        

    $(".delete").click(function(e) {
            e.preventDefault();
            var ele = $(this);
            if (confirm("Are you sure want to remove product from the cart.")) {
                $.ajax({
                    url: '{{ url("remove-from-cart") }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.attr("data-id")
                    },
                    success: function(response) {
                        window.location.reload();
                    }
            });
        }
    });

    $('.add').click(function(){
        var qtyElement = $(this).parent().prev(); // Qty Input
        var qtyValue = parseInt(qtyElement.val());
        if (qtyValue < 10) {
            qtyElement.val(qtyValue+1);

            var rowId = $(this).data('id');
            var newQty = qtyElement.val();
            updateCart(rowId,newQty)
        }            
    });

    $('.sub').click(function(){
        var qtyElement = $(this).parent().next();
        var qtyValue = parseInt(qtyElement.val());
        if (qtyValue > 1) {
            qtyElement.val(qtyValue-1);

            var rowId = $(this).data('id');
            var newQty = qtyElement.val();
            updateCart(rowId,newQty)
        }
    });


    //Hide alert 
    $(function() {
        setTimeout(function() { $(".alert").fadeOut(1500); }, 1500)
    })

    $(document).ready(function() {
        $('.add-to-cart-button').on('click', function() {
            var productId = $(this).data('product-id');

            $.ajax({
                type: 'GET',
                url: '/add-to-cart/' + productId,
                success: function(data) {
                    $("#adding-cart-" + productId).show();
                    $("#add-cart-btn-" + productId).hide();
                    window.location.href='{{ route("front.home") }}';
                },
                error: function(error) {
                    console.error('Error adding to cart:', error);
                }
            });
        });
    });
</script>
@endsection