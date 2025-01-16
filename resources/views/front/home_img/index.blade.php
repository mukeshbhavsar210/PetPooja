@extends('front.layouts.app')

@section('content')

<div class="menu-content--categories-medium-photo menu-content">
    <section class="menu-products-section menu-products-section--grid" >
        @include('front.home.products')
    </section>
</div>

<div class="mainCartWrapper">
  	<a id="cartDetails">Order {{ count((array) session('cart')) }}</a> 
        
    <div class="orderDetails">
        <div class="orderBottom">  
            <nav>
                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                @if (Session::has('success'))
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! Session::get('success') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ Session::get('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif 

                <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    {{-- @include('front.home.tab_01') --}}
                </div>

                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    @include('front.home.tab_02')
                </div>

                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    @include('front.home.tab_03')
                </div>
            </div>
        </div>
    </div>
        <div class="orderOverlay"></div>
    </div>
</div>
@endsection



@section('customJs')
<script>
    function addToCart(id){
        $.ajax({
            url: '{{ route("front.addToCart") }}',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response){
                if(response.status == true){
                    $('.mainCartWrapper').addClass('addedProduct');
                    window.location.href= "{{ route('front.home') }}";
                } else {
                    alert(response.message);
                }
            }
        })
    }

    function addToWishlist(id){
        $.ajax({
            url: '{{ route("front.addToWishlist",) }}',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response){
                if(response.status == true){
                    $("#wishlistModal .modal-body").html(response.message);
                    $("#wishlistModal").modal('show');
                } else {
                    window.location.href= "{{ route('account.login') }}";
                    //alert(response.message);
                }
            }
        })
    }

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

        function updateCart(rowId,qty){
            $.ajax({
                url: '{{ route("front.updateCart") }}',
                type: 'post',
                data: {rowId:rowId, qty:qty},
                dataType: 'json',
                success: function(response){
                    window.location.href='{{ route("front.home") }}';
                    $('.mainCartWrapper').addClass('addedProduct');
                }
            })
        }

        function deleteItem(rowId){           
            $.ajax({
                url: '{{ route("front.deleteItem.cart") }}',
                type: 'post',
                data: {rowId:rowId},
                dataType: 'json',
                success: function(response){
                    window.location.href='{{ route("front.home") }}';
                    $('.mainCartWrapper').addClass('addedProduct');
                }
            })            
        }

        //Order form
        $("#orderForm").submit(function(event){
            event.preventDefault();

            $('button[type="submit"]').prop('disabled', true);

            $.ajax({
                url: '{{ route("front.processCheckout") }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response){
                    var errors = response.errors;
                    $('button[type="submit"]').prop('disabled', false);

                    //front thankyou page
                    if(response.status == false){
                        if(errors.name){
                            $("#name").addClass('is-invalid').siblings("p").addClass('invalid-feedback').html(errors.name)
                        } else {
                            $("#name").removeClass('is-invalid').siblings("p").removeClass('invalid-feedback').html('')
                        }
                       
                    } else {
                        window.location.href="{{ url('thanks/') }}/"+response.orderId;
                    }

                }
            });
        });


        //Country
        $("#country").change(function(){
            $.ajax({
                url: '{{ route("front.getOrderSummary") }}',
                type: 'post',
                data: {country_id: $(this).val()},
                dataType: 'json',
                success: function(response){
                    if(response.status == true)
                        $("#shippingAmount").html(response.shippingCharge);
                        $("#grandTotal").html(response.grandTotal);
                    }
            });
        });

        $("#apply-discount").click(function(){
            $.ajax({
                url: '{{ route("front.applyDiscount") }}',
                type: 'post',
                data: {code: $("#discount_code").val(), country_id: $('#country').val()},
                dataType: 'json',
                success: function(response){
                    if(response.status == true) {
                        $("#shippingAmount").html(response.shippingCharge);
                        $("#grandTotal").html(response.grandTotal);
                        $("#discount_value").html(response.discount);
                        $("#discount-response-wrapper").html(response.discountString);
                    } else {
                        $("#discount-response-wrapper").html("<span class='text-danger'>"+response.message+"</span>");
                    }
                }
            })
        });

        $('body').on('click','#remove-discount',function(){
            $.ajax({
                url: '{{ route("front.removeCoupon") }}',
                type: 'post',
                data: {country_id: $('#country').val()},
                dataType: 'json',
                success: function(response){
                    if(response.status == true) {
                        $("#shippingAmount").html(response.shippingCharge);
                        $("#grandTotal").html(response.grandTotal);
                        $("#discount_value").html(response.discount);
                        $("#discount-response").html();
                        $("#discount_code").val('');
                    }
                }
            })
        })

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
                    },
                    error: function(error) {
                        console.error('Error adding to cart:', error);
                    }
                });
            });
        });
</script>
@endsection