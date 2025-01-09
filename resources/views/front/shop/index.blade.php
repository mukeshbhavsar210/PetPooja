@extends('front.layouts.app')

@section('content')

    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title"><h2>Categories</h3></div>
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">                    
                                @if ($categories->isNotEmpty())
                                    @foreach ($categories as $key => $value)
                                        <div class="accordion-item">
                                            @if ($value->menu->isNotEmpty())
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-{{ $key }}" aria-expanded="false" aria-controls="collapseOne-{{ $key }}">
                                                        {{ $value->name }}
                                                    </button>
                                                </h2>
                                            @else
                                                <a href="{{ route("front.shop",$category->slug) }}" class="nav-item nav-link  {{ ($categorySelected == $category->id) ? 'text-primary' : '' }}">{{ $category->name }}</a>
                                            @endif
                    
                                            {{-- @if ($categories->menu->isNotEmpty())
                                                <div id="collapseOne-{{ $key }}" class="accordion-collapse collapse {{ ($categorySelected == $category->id) ? 'show' : ' '}}" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                    <div class="accordion-body">
                                                        <div class="navbar-nav">
                                                            @foreach ($categories->menu as $subCategory)
                                                                <a href="{{ route("front.shop",[$category->slug,$subCategory->slug]) }}" class="nav-item nav-link {{ ($subCategorySelected == $subCategory->id) ? 'text-primary' : '' }}">{{ $subCategory->name }}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif --}}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- Categories filters end  --}}
                                        
                   
                    <div class="sub-title mt-5"><h2>Price</h3></div>                    
                    <div class="card">
                        <div class="card-body">
                            <input type="text" class="js-range-slider" name="my_range" value="" />
                        </div>
                    </div>                    
                    {{-- Price filters end --}}
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
                                            <a class="h6 link" href="product.php">{{ $product->title }}</a>
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
