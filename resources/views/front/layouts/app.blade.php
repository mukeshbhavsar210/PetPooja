<!DOCTYPE html>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>@yield('title')</title>

   

	
	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/style.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/style.css') }}" />
	
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
	<div class="page">
		<header class="page-header" >
			<div class="header">
				<div class="header__restaurant-name">
					<a href="{{ route('front.home') }}" class="logo"><img style="width: 120px" src="{{ asset('front-assets/images/logo.jpg') }} " alt=""></a>
				</div>
			</div>	

			<section class="categories-section categories-section--medium-photo">
				<div class="categories-section__container">				
					@if (getProducts()->isNotEmpty())
						@foreach (getProducts() as $value )	
						<div class="menu-category">	
							<div class="menu-category__img">
								<a href="{{ route('front.menu',[$value->slug])}}" >
									@if ($value->image != "")
										<img src="{{ asset('uploads/menu/thumb/'.$value->image) }} " alt="">
									@endif
								</a>	
							</div>
							<div class="menu-category__name no-wrap">
								<div><a href="{{ route('front.menu',[$value->slug])}}" >{{ $value->name }}</a></div>
							</div>
						</div>
						@endforeach
					@endif
					
					
				</div>
			</section>
		</header>

    @yield('content')
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script src="{{ asset('front-assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('front-assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
<script src="{{ asset('front-assets/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('front-assets/js/lazyload.17.6.0.min.js') }}"></script>
<script src="{{ asset('front-assets/js/slick.min.js') }}"></script>
<script src="{{ asset('front-assets/js/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('front-assets/js/custom.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
$(document).ready(function() {
	var slider_width = $('.orderDetails').height();
	$('#cartDetails').click(function() {
		if($(this).css("margin-bottom") == slider_width+"px" && !$(this).is(':animated')) {
			$('.orderDetails,#cartDetails').animate({"margin-bottom": '-='+slider_width});	
			$('.mainCartWrapper').removeClass("overlay");		
		}
		else {
			$('.mainCartWrapper').addClass("overlay");
				if(!$(this).is(':animated')) {
					$('.orderDetails,#cartDetails').animate({"margin-bottom": '+='+slider_width});				
				}
			}
		});

		var slider_width = $('.orderDetails').height();
		$('#cartDetails').click(function() {
			if($(this).css("margin-bottom") == slider_width+"px" && !$(this).is(':animated')) {
				$('.orderDetails,#cartDetails').animate({"margin-bottom": '-='+slider_width});	
				$('.mainCartWrapper').removeClass("overlay");		
			}
			else {
				$('.mainCartWrapper').addClass("overlay");
					if(!$(this).is(':animated')) {
						$('.orderDetails,#cartDetails').animate({"margin-bottom": '+='+slider_width});				
					}
				}
			});
	 });     
	</script>


{{-- <script>
	let list = document.querySelector(".bottom-bar__list");
	let activeItemIndex = 1;
	let items = list.children;
	const handleClick = (index) => {
	if (index !== activeItemIndex) {
		items[activeItemIndex].classList.remove("selected");
		items[index].classList.add("selected");

		let direction;
		index - activeItemIndex > 0 ? (direction = 1) : (direction = -1);

		let magnitude = Math.abs(index - activeItemIndex);

		activeItemIndex = index;

		items[0].style.transform =
		"translate(" + (activeItemIndex - 1) * 100 + "%, -0.5rem)";

		items[0].classList.add("active--" + magnitude);
		items[0].classList.add(direction > 0 ? "active-right" : "active-left");
		console.log(items[0].classList);

		setTimeout(() => {
		items[0].classList.remove("active--" + magnitude);
		items[0].classList.remove(direction > 0 ? "active-right" : "active-left");
		}, 200);
	}
	};

	Object.keys(items).forEach((item, index) => {
	items[index].addEventListener("click", () => {
		handleClick(index);
	});
	});
</script> --}}

@yield('customJs')

{{-- @yield('scripts') --}}

</body>
</html>