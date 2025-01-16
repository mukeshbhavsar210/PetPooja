@extends('front.layouts.app')
@section('content')

    <div class="menu-content--categories-medium-photo menu-content">
        <section class="menu-products-section menu-products-section--grid" >
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
            <div class="col-10">
                <a>Order {{ count((array) session('cart')) }} for ₹ {{ $total }}</a> 
            </div>
            <div class="col-2">
                <a href="{{ url('clear-cart') }}" class="cart-icon"><i class="fa fa-trash-o"></i> Clear</a>
            </div>
        </div>
        
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
                        @include('front.home.tab_01') 
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
    
<script type="text/javascript">
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