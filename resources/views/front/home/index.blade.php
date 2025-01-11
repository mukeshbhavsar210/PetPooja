@extends('front.layouts.app')

@section('content')

<div class="container-fluid">            
    <div class="row">
        @if ($latestProducts->isNotEmpty())
            @foreach ($latestProducts as $product)
                @php
                    $productImage = $product->product_images->first();
                @endphp

                <div class="col-6">
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
                                <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }})">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>
                            </div>
                        </div>
                        <div class="card-body text-center mt-3">
                            {{ $product->title }}
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
   
@endsection