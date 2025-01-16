@if (Cart::count() > 0)
<div class="cartWrapper">
    @foreach ($cartContent as $item)    
        <div class="row mb-2">
            <div class="col-7">
                <p class="my-2">{{ $item->qty }} x {{ $item->name }}</p>
            </div>
            <div class="col-3 p-0">
                <div class="flex">
                    <div class="input-group-btn">
                        @if($item->qty > 1)
                            <button class="btn--icon sub" data-id="{{ $item->rowId }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8Z"></path></svg>
                            </button>
                        @else    
                            <button class="btn--icon sub" onclick="deleteItem('{{ $item->rowId}}' );">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8Z"></path></svg>
                            </button>
                        @endif  
                    </div>
                    <input type="hidden" class="form-control form-control-sm  border-0 text-center" value="{{ $item->qty }}">
                    <div class="input-group-btn">
                        <button class="btn--icon add" data-id="{{ $item->rowId }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="right">
                    <p class="my-2">₹{{ $item->price }}</p>
                </div>
            </div>
        </div>
    @endforeach 
</div>

<div class="basket-page__content__total">
    <div>Total:</div>
    <div style="flex-grow: 1;"></div>
    <div>₹{{ Cart::subtotal() }}</div>
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

@else
    <div class="col-md-12">		
        <div class="emptyBag">
            <img src="{{ asset('front-assets/images/empty_bag.png') }}" >
            <h5>Nothing to order</h5>
            <h2>Order</h2>
        </div>						
    </div>	
@endif 
