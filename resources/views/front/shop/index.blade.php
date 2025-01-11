@extends('front.layouts.app')

@section('content')

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title mt-5"><h2>Price</h3></div>                    
                    <div class="card">
                        <div class="card-body">
                            <input type="text" class="js-range-slider" name="my_range" value="" />
                        </div>
                    </div>                                        
                </div>

                <div class="col-md-9">
                    <div class="row pb-3">
                        @if ($products->isNotEmpty())
                            @foreach ($products as $value)
                                @php
                                    $productImage = $value->product_images->first();
                                @endphp
                    
                                <div class="col-md-4">
                                    <div class="card product-card">
                                        <div class="product-image position-relative">
                                            <a href="{{ route('front.product',$value->slug) }}" class="product-img">
                                                @if (!empty($productImage->image))
                                                    <img class="card-img-top" src="{{ asset('uploads/product/small/'.$productImage->image) }}" >
                                                @else
                                                    <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
                                                @endif
                                            </a>
                                        </div>
                                        <div class="card-body text-center mt-3">
                                            <a class="h6 link" href="product.php">{{ $value->title }}</a>
                                            <p>{{ $value->price }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    
                        <div class="col-md-12 pt-5">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    </div>                    
                    {{-- all products end --}}
                </div>
            </div>
        </div>
    </section>

@endsection

@section('customJs')
<script>
    $(".brand-label").change(function(){
        apply_filters();
    });

    rangeSlider = $(".js-range-slider").ionRangeSlider({
        type: "double",
        min: 0,
        max: 1000,
        from: {{ ($priceMin) }},
        to: {{ ($priceMax) }},
        step: 10,
        skin: "round",
        max_position: "+",
        prefix: "₹",
        onFinish: function(){
            apply_filters()
        }
    });

    var slider = $(".js-range-slider").data("ionRangeSlider");

    $("#sort").change(function(){
        apply_filters()
    });


    function apply_filters(){
        var brands = [];
        $(".brand-label").each(function(){
            if ($(this).is(":checked") == true){
                brands.push($(this).val());
            }
        });

        var url = '{{ url()->current() }}?';

        //Brand filter
        if (brands.length > 0) {
            url += '&brand='+brands.toString();
        }

        //Price range filter
        url += '&price_min='+slider.result.from+'&price_max='+slider.result.to;

        //Sorting filter
        var keyword = $('#search').val();
        if(keyword.length > 0){
            url += '&search='+keyword;
        }

        url += '&sort='+$("#sort").val();

        window.location.href = url;
    }
</script>
@endsection
