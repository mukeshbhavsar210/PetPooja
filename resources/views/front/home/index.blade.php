@extends('front.layouts.app')

@section('content')

    
    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>Latest Products</h2>
            </div>
            <div class="row pb-3">
                @if ($latestProducts->isNotEmpty())
                    @foreach ($latestProducts as $product)
                        @php
                            $productImage = $product->product_images->first();
                        @endphp
    
                        <div class="col-md-3">
                            <div class="card product-card">
                                <div class="product-image position-relative">
    
                                    <a href="" class="product-img">
                                        @if (!empty($productImage->image))
                                            <img class="card-img-top" src="{{ asset('uploads/product/small/'.$productImage->image) }}" >
                                        @else
                                            <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
                                        @endif
                                    </a>
    
                                    <a onclick="addToWishlist({{ $product->id }})" class="whishlist" href="javascript:void(0)"><i class="far fa-heart"></i></a>
    
                                    <div class="product-action">
                                        @if ($product->track_qty == 'Yes')
                                            @if ($product->qty > 0)
                                                <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }})">
                                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                                </a>
                                            @else
                                                <a class="btn btn-dark" href="javascript:void(0);">
                                                    <i class="fa fa-shopping-cart"></i> Out of Stock
                                                </a>
                                            @endif
                                        @else
                                        <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }})">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body text-center mt-3">
                                    <a class="h6 link" href="product.php">{{ $product->title }}</a>
                                    <div class="price mt-2">
                                        <span class="h5"><strong>₹ {{ $product->price }}</strong></span>
                                        @if ($product->compare_price > 0)
                                            <span class="h6 text-underline"><del>₹ {{ $product->compare_price }}</del></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

@endsection
