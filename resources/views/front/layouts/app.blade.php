<!DOCTYPE html>
<html class="no-js" lang="en_AU" />
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Laravel Online Shop</title>
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />

	<meta name="HandheldFriendly" content="True" />
	<meta name="pinterest" content="nopin" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick-theme.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/style.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/ion.rangeSlider.min.css') }}" />

	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Fav Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="#" />
</head>
<body data-instant-intensity="mousedown">

<div class="container-fluid">
	<div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
		<div class="col-lg-4 logo">
			<a href="{{ route('front.home') }}" class="text-decoration-none">
				<span class="h1 text-uppercase text-primary bg-dark px-2">Online</span>
			</a>
		</div>
		<div class="col-lg-6 col-6 text-left  d-flex justify-content-end align-items-center">
			@if (Auth::check())
				<a href="{{ route('account.profile')}}" class="nav-link text-dark">My Account</a>
			@else
				<a href="{{ route('account.login')}}" class="nav-link text-dark">Login/Register</a>
			@endif

			<form action="{{ route('front.shop') }}">
				<div class="input-group">
					<input value="{{ Request::get('search') }}" type="text" placeholder="Search For Products" class="form-control" name="search" id="search">
					<button type="submit" class="input-group-text">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<header>
	<div class="container-fluid">
		<a href="index.php" class="text-decoration-none mobile-logo">
			<span class="h2 text-uppercase text-primary bg-dark">Online</span>
			<span class="h2 text-uppercase text-white px-2">SHOP</span>
		</a>
		<a href="{{ route('front.cart') }}" >Cart</a>
					
		<section class="section-3">
			<div class="container">
				<div class="row">
					
						{{-- @if (getCategories()->isNotEmpty())
							@foreach (getCategories() as $value )
							<div class="col-3">
								{{ $value->name }}	
								@if ($value->menu->isNotEmpty())
									<div class="col-3">
										@foreach ($value->menu as $menu)
										<a href="{{ route('front.shop',[$value->slug,$menu->slug])}}">
											@if ($value->image != "")
												<img src="{{ asset('uploads/menu/thumb/'.$value->image) }} " alt="" class="img-fluid">
											@endif
											{{ $menu->name }}
										</a>
										@endforeach
									</div>
								@endif
								</div>
						@endforeach
					@endif
						</div> --}}

					@if (getProducts()->isNotEmpty())
						@foreach (getProducts() as $value )
							<div class="col-3">
								<a href="{{ route('front.shop',[$value->slug])}}">
									@if ($value->image != "")
										<img src="{{ asset('uploads/menu/thumb/'.$value->image) }} " alt="" class="img-fluid">
									@endif
									{{ $value->name }}
								</a>	
							</div>
						@endforeach
					@endif
				</div>
			</div>
		</section>   	
  	</div>
</header>

<main>
    @yield('content')
</main>


<script src="{{ asset('front-assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('front-assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
<script src="{{ asset('front-assets/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('front-assets/js/lazyload.17.6.0.min.js') }}"></script>
<script src="{{ asset('front-assets/js/slick.min.js') }}"></script>
<script src="{{ asset('front-assets/js/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('front-assets/js/custom.js') }}"></script>
<script>
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function addToCart(id){
        $.ajax({
            url: '{{ route("front.addToCart") }}',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response){
                if(response.status == true){
                    window.location.href= "{{ route('front.cart') }}";
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

    //Alert timeout
    //setTimeout(function () {
        //$('.alert').fadeOut(300);
    //}, 2000);
</script>

@yield('customJs')

</body>
</html>
