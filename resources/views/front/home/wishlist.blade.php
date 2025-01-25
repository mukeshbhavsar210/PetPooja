@extends('front.layouts.app')

@section('content')

<div class="menu-content--categories-medium-photo menu-content">
    <section class="menu-products-section menu-products-section--grid">
        <div class="menu-grid">
        @if(session('wishlist'))
            @foreach(session('wishlist') as $id => $details)
            <div class="menu-product">
                <div class="menu-product__item">
                    <div class="wishlist">
                        <a class="delete-wishlist" data-id="{{ $id }}" title="Delete">
                            <img src="https://instalacarte.com/media/cache/emoji_small/emoji/favourite.png?v3" >
                        </a>
                    </div>
                    <div class="menu-product__item__img">
                        <img src="{{ asset('uploads/product/small/'.$details['product_image']['image']) }}" > 
                    </div>
                    <div class="menu-product__item__top-block">
                        <div class="menu-product__item__name text-overflow">{{ $details['name'] }}</p></div>
                        <div class="menu-product__item__price no-wrap">
                            ₹  {{ $details['price'] }}
                        </div>

                        <div class="product-details">
                        </div>
                    </div>
                </div>
            </div>
                
            @endforeach
        @endif
        </div>
    </section>
</div>

@endsection

@section('customJs')
<script>
    $(".delete-wishlist").click(function(e) {
            e.preventDefault();
            var ele = $(this);
            if (confirm("Are you sure want to remove product from the wishlist.")) {
                $.ajax({
                    url: '{{ url("remove-from-wishlist") }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.attr("data-id")
                    },
                    success: function(response) {
                        //$isEmpty = $details['quantity'];   
                        if(response["status"] == true){
                            window.location.reload();
                        } else {
                            window.location.href='{{ route("front.restaurant") }}';
                        }
                    }
            });
        }
    });
</script>
@endsection