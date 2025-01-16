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

<div id="menu-page" class="page">
	<header class="sticky-header" >
		<div class="header">
			<div style="flex-grow:1;position:relative;height:45px;">
				<div style="display:flex;gap:10px;align-items:center;position:absolute;left:0;right:0;top:0;bottom:0;overflow-x:auto;">					
					<div class="header__restaurant-name">
						<a href="{{ route('front.home') }}" class="text-decoration-none">
							<span class="h1 text-uppercase text-primary bg-dark px-2">Online</span>
						</a>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-sm-12 col-12 main-section">
					<div class="cart-table dropdown">
						<a href="{{ url('cart') }}" class="cart-icon">
							<i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill cart-count">{{ count((array) session('cart')) }}</span>
						</a>
						<a href="{{ url('clear-cart') }}" class="cart-icon"><i class="fa fa-trash-o"></i> Clear</a>
					</div>
				</div>
			</div>
			<button class="btn btn--icon" style="font-size:0.9rem;">English</button>
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
				
				{{-- <div class="menu-category menu-category--active" data-category-id="-2" data-long-press-delay="1000">
					<div class="menu-category__highlight" id="menu-category__highlight" style="transform: translateX(7.95312px); display: block;"></div>
					<div class="menu-category__img">
						<a href="/menu/s/en/wagamama/popular/all/"><img src="https://instalacarte.com/media/cache/emoji_small/emoji/popular.png?v3" alt="Popular"><!--]--></a></div><div class="menu-category__name no-wrap"><div><a href="/menu/s/en/wagamama/popular/all/"><!--[-->Popular<!--]--></a></div><!----></div></div><div class="menu-category" data-category-id="85" data-long-press-delay="1000"><!----><div class="menu-category__img"><a href="/menu/s/en/wagamama/curry/all/"><!--[--><img src="https://instalacarte.com/media/cache/emoji_small/emoji/curry-rice_1f35b3.png?v3" alt="curry"><!--]--></a></div><div class="menu-category__name no-wrap"><div><a href="/menu/s/en/wagamama/curry/all/"><!--[-->curry<!--]--></a></div><!----></div></div><div class="menu-category" data-category-id="86" data-long-press-delay="1000"><!----><div class="menu-category__img"><a href="/menu/s/en/wagamama/ramen/all/"><!--[--><img src="https://instalacarte.com/media/cache/emoji_small/emoji/steaming-bowl_1f35c5.png?v3" alt="ramen"><!--]--></a></div><div class="menu-category__name no-wrap"><div><a href="/menu/s/en/wagamama/ramen/all/"><!--[-->ramen<!--]--></a></div><!----></div></div><div class="menu-category" data-category-id="87" data-long-press-delay="1000"><!----><div class="menu-category__img"><a href="/menu/s/en/wagamama/teppanyaki/all/"><!--[--><img src="https://instalacarte.com/media/cache/emoji_small/emoji/steaming-bowl_1f35c4.png?v3" alt="teppanyaki"><!--]--></a></div><div class="menu-category__name no-wrap"><div><a href="/menu/s/en/wagamama/teppanyaki/all/"><!--[-->teppanyaki<!--]--></a></div><!----></div></div><div class="menu-category" data-category-id="88" data-long-press-delay="1000"><!----><div class="menu-category__img"><a href="/menu/s/en/wagamama/donburi/all/"><!--[--><img src="https://instalacarte.com/media/cache/emoji_small/emoji/shallow-pan-of-food_1f9582.png?v3" alt="donburi"><!--]--></a></div><div class="menu-category__name no-wrap"><div><a href="/menu/s/en/wagamama/donburi/all/"><!--[-->donburi<!--]--></a></div><!----></div></div><div class="menu-category" data-category-id="89" data-long-press-delay="1000"><!----><div class="menu-category__img"><a href="/menu/s/en/wagamama/kokoro-bowls/all/"><!--[--><img src="https://instalacarte.com/media/cache/emoji_small/emoji/shallow-pan-of-food_1f9583.png?v3" alt="kokoro bowls"><!--]--></a></div><div class="menu-category__name no-wrap"><div><a href="/menu/s/en/wagamama/kokoro-bowls/all/"><!--[-->kokoro bowls<!--]--></a></div><!----></div></div><div class="menu-category" data-category-id="90" data-long-press-delay="1000"><!----><div class="menu-category__img"><a href="/menu/s/en/wagamama/sides/all/"><!--[--><img src="https://instalacarte.com/media/cache/emoji_small/emoji/green-salad_1f957.png?v3" alt="sides"><!--]--></a></div><div class="menu-category__name no-wrap"><div><a href="/menu/s/en/wagamama/sides/all/"><!--[-->sides<!--]--></a></div><!----></div></div><div class="menu-category" data-category-id="91" data-long-press-delay="1000"><!----><div class="menu-category__img"><a href="/menu/s/en/wagamama/desserts/all/"><!--[--><img src="https://instalacarte.com/media/cache/emoji_small/emoji/shortcake_1f370.png?v3" alt="desserts"><!--]--></a></div><div class="menu-category__name no-wrap"><div><a href="/menu/s/en/wagamama/desserts/all/"><!--[-->desserts<!--]--></a></div><!----></div></div><div class="menu-category" data-category-id="92" data-long-press-delay="1000"><!----><div class="menu-category__img"><a href="/menu/s/en/wagamama/drinks/all/"><!--[--><img src="https://instalacarte.com/media/cache/emoji_small/emoji/tropical-drink_1f379.png?v3" alt="drinks"><!--]--></a></div><div class="menu-category__name no-wrap"><div><a href="/menu/s/en/wagamama/drinks/all/"><!--[-->drinks<!--]--></a></div><!----></div></div><div class="menu-category" data-category-id="99" data-long-press-delay="1000"><!----><div class="menu-category__img"><a href="/menu/s/en/wagamama/kids/all/"><!--[--><img src="https://instalacarte.com/media/cache/emoji_small/emoji/23/5037cb1f26a8125dba31b1d1bb460c15.png?v3" alt="kids"><!--]--></a></div><div class="menu-category__name no-wrap"><div><a href="/menu/s/en/wagamama/kids/all/"><!--[-->kids<!--]--></a></div><!----></div></div><div class="menu-category" data-category-id="100" data-long-press-delay="1000"><!----><div class="menu-category__img"><a href="/menu/s/en/wagamama/extras/all/"><!--[--><img src="https://instalacarte.com/media/cache/emoji_small/emoji/cooked-rice_1f35a1.png?v3" alt="extras"><!--]--></a></div><div class="menu-category__name no-wrap"><div>
					<a href="/menu/s/en/wagamama/extras/all/"><!--[-->extras<!--]--></a></div><!---->
					</div>
				</div> --}}
			</div>
		</section>
	</header>

	@yield('content')
</div>	
</body>

{{-- 
<nav class="bottom-bar">
	<ul class="bottom-bar__list">
	  <div class="bottom-bar__active-indicator"></div>
	  <li class="bottom-bar__link selected"><span class="material-symbols-outlined">
		  home
		</span>Home</i>
	  <li class="bottom-bar__link"><span class="material-symbols-outlined">
		  Search
		</span>Explore</li>
	  <li class="bottom-bar__link"><span class="material-symbols-outlined">
		  Favorite
		</span>Saved</li>
	  <li class="bottom-bar__link"><span class="material-symbols-outlined">
		  Notifications
		</span>Notifications</li>
	  <li class="bottom-bar__link"><span class="material-symbols-outlined">
		  Person
		</span>Profile</li>
	</ul>
  </nav> --}}

  
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

</body>
</html>
