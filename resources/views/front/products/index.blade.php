@extends('front.layouts.app')

@section('content')
    <div class="container">
            @if ($product->product_images)
                @foreach ($product->product_images as $key => $productImage)
                    <img src="{{ asset('uploads/product/large/'.$productImage->image) }}" alt="Image">
                @endforeach
            @endif
            <div class="bg-light">
                <h1>{{ $product->title }}</h1>
                <span class="price"> ₹{{ $product->price }}</span>
                @if ($product->compare_price > 0)
                    <span class="price text-secondary"><del> ₹{{ $product->compare_price }}</del></span>
                @endif
                <div class="mt-2">{!! $product->short_description !!}</div>
            
                <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }})">
                    <i class="fa fa-shopping-cart"></i> &nbsp;ADD TO CART
                </a>
                {!! $product->description !!}
                
                    @if (!empty($relatedProducts))
                        <div id="related-products" >                                
                            @foreach ($relatedProducts as $relProduct)                                
                            @php
                                $productImage = $relProduct->product_images->first();
                            @endphp
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
                                            @if ($relProduct->track_qty == 'Yes')
                                                @if ($relProduct->qty > 0)
                                                    <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $relProduct->id }})">
                                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                                    </a>
                                                @else
                                                    <a class="btn btn-dark" href="javascript:void(0);">
                                                        <i class="fa fa-shopping-cart"></i> Out of Stock
                                                    </a>
                                                @endif
                                            @else
                                            <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $relProduct->id }})">
                                                <i class="fa fa-shopping-cart"></i> Add To Cart
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link" href="">{{ $relProduct->title }}</a>
                                        <div class="price mt-2">
                                            <span class="h5"><strong>₹{{ $relProduct->price }}</strong></span>
                                            @if ($relProduct->compare_price > 0)
                                                <span class="h6 text-underline"><del>₹{{ $relProduct->compare_price }}</del></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
            </div> 
        </div>
    </div>
@endsection

@section('customJs')
@endsection
