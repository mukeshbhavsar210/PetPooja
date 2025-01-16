<div class="cartWrapper">
    <?php $total = 0 ?>
        @if(session('cart'))
            @foreach(session('cart') as $id => $details)
                <div class="row mb-2">
                    <div class="col-7">
                        <p class="my-2"> {{ $details['quantity'] }} x {{ $details['name'] }} </p>
                    </div>
                    <div class="col-3 p-0">
                        <div class="flex">
                            <?php 
                                $isEmpty = $details['quantity'];   
                            ?>
                            @if($isEmpty > 1)
                                <div class="input-group-btn">
                                    <button class="btn--icon sub" data-id=" ">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8Z"></path></svg>
                                    </button>
                                </div>
                            @else
                                <div class="input-group-btn">
                                    <button class="btn--icon delete" data-id="{{ $id }}" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8Z"></path></svg>
                                    </button>
                                </div>
                            @endif
                                <div class="input-group-btn">
                                    <button class="btn--icon add" data-id=" ">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"></path></svg>
                                    </button>
                                </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="right">
                            <p class="my-2">₹{{ $details['price'] }}</p>
                        </div>
                    </div>
                    <?php $total += $details['price'] * $details['quantity'] ?>
                    {{-- <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity" /> --}}
                    {{-- Rs.{{ $details['price'] * $details['quantity'] }} --}}
                </div>
            @endforeach
        @endif

        <div class="basket-page__content__total">
            @if(!empty($details))
                <div>Total:</div>
                <div style="flex-grow: 1;"></div>
                ₹{{ $total }}
            @else
            
            <div class="col-md-12">		
                <div class="emptyBag">
                    <img src="{{ asset('front-assets/images/empty_bag.png') }}" >
                    <h5>Nothing to order</h5>
                    <h2>Order</h2>
                </div>						
            </div>
            @endif
        </div>

        <div class="fillRequired">Fill all required fields</div>

<form action=" " name="orderForm" id="orderForm" method="POST">
    <div class="row">                    
        <div class="col-md-12">
            <div class="mb-3">
                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value={{ (!empty($customerAddress)) ? $customerAddress->name : '' }}>
                <p></p>
            </div>
        </div>   
        {{-- <div class="col-md-6">
            <div class="mb-3">
                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="mobile" value={{ (!empty($customerAddress)) ? $customerAddress->mobile : '' }}>
                <p></p>
            </div>
        </div>               
        <div class="col-md-6">
            <div class="mb-3">
                <input type="text" name="email" id="email" class="form-control" placeholder="Email" value={{ (!empty($customerAddress)) ? $customerAddress->email : '' }}>
                <p></p>
            </div>
        </div>                                               
        <div class="col-md-12">
            <div class="mb-3">
                <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control" >{{ (!empty($customerAddress)) ? $customerAddress->address : '' }}</textarea>
                <p></p>
            </div>
        </div>                            
        <div class="col-md-6">
            <div class="mb-3">
                <select name="country" id="country" class="form-control">
                    <option value="">Select a Country</option>
                        @if ($countries->isNotEmpty())
                            @foreach ($countries as $country)
                                <option {{ (!empty($customerAddress) && $customerAddress->country_id == $country->id) ? 'selected' : '' }} value="{{ $country->id }}" >{{ $country->name }}</option>
                            @endforeach
                            <option value="rest_of_world">Rest of the world</option>
                        @endif
                </select>
                <p></p>
            </div>
        </div>          --}}
                         
    </div>

    {{-- <div class="input-group apply-coupan">
        <input type="text" placeholder="Coupon Code" class="form-control" name="discount_code" id="discount_code">
        <button class="btn btn-dark" type="button" id="apply-discount">Apply Coupon</button>
    </div> --}}
        
        <div id="discount-response-wrapper">
            @if (Session::has('code'))
                <div class="mt-4" id="discount-response">
                    <strong>{{ Session::get('code')->code }}</strong>
                    <a class="btn btn-sm btn-danger" id="remove-discount"><i class="fa fa-times"></i></a>
                </div>
            @endif
        </div>

        <button class="btn-dark btn btn-block w-100 mt-4" type="submit">Order</button>
</form>

</div>