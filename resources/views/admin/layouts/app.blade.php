<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Laravel Shop :: Administrative Panel</title>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{ asset('admin-assets/plugins/fontawesome-free/css/all.min.css') }}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{ asset('admin-assets/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin-assets/plugins/dropzone/min/dropzone.min.css') }}">
		<link rel="stylesheet" href="{{ asset('admin-assets/css/custom.css') }} ">
        <link rel="stylesheet" href="{{ asset('admin-assets/plugins/summernote/summernote-bs4.min.css') }} ">
        <link rel="stylesheet" href="{{ asset('admin-assets/plugins/select2/css/select2.min.css') }} ">
        <link rel="stylesheet" href="{{ asset('admin-assets/css/datetimepicker.css') }} ">
        <meta name="csrf-token" content="{{ csrf_token() }}">

	</head>

	<body class="hold-transition sidebar-mini">
		<!-- Site wrapper -->
		<div class="wrapper">
			<!-- Navbar -->
			<nav class="main-header navbar navbar-expand navbar-white navbar-light">
				<!-- Right navbar links -->
				<ul class="navbar-nav">
					<li class="nav-item">
					  	<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
					</li>
				</ul>
				<div class="navbar-nav pl-2">
					<ol class="breadcrumb p-0 m-0 bg-white">
						<li class="breadcrumb-item active">Dashboard</li>
					</ol>
				</div>

				<ul class="navbar-nav ml-auto">
					<!-- Navbar Search -->
					<li class="nav-item">
					  <a class="nav-link" data-widget="navbar-search" href="#" role="button">
						<i class="fas fa-search"></i>
					  </a>
					  <div class="navbar-search-block" style="display: none;">
						<form class="form-inline">
						  <div class="input-group input-group-sm">
							<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
							<div class="input-group-append">
							  <button class="btn btn-navbar" type="submit">
								<i class="fas fa-search"></i>
							  </button>
							  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
								<i class="fas fa-times"></i>
							  </button>
							</div>
						  </div>
						</form>
					  </div>
					</li>
			  
					<!-- Messages Dropdown Menu -->
					<li class="nav-item dropdown">
					  <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
						<i class="far fa-comments"></i>
						<span class="badge badge-danger navbar-badge">3</span>
					  </a>
					  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
						<a href="#" class="dropdown-item">
						  <!-- Message Start -->
						  <div class="media">
							<img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
							<div class="media-body">
							  <h3 class="dropdown-item-title">
								Brad Diesel
								<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
							  </h3>
							  <p class="text-sm">Call me whenever you can...</p>
							  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
							</div>
						  </div>
						  <!-- Message End -->
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
						  <!-- Message Start -->
						  <div class="media">
							<img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
							<div class="media-body">
							  <h3 class="dropdown-item-title">
								John Pierce
								<span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
							  </h3>
							  <p class="text-sm">I got your message bro</p>
							  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
							</div>
						  </div>
						  <!-- Message End -->
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
						  <!-- Message Start -->
						  <div class="media">
							<img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
							<div class="media-body">
							  <h3 class="dropdown-item-title">
								Nora Silvester
								<span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
							  </h3>
							  <p class="text-sm">The subject goes here</p>
							  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
							</div>
						  </div>
						  <!-- Message End -->
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
					  </div>
					</li>
					<!-- Notifications Dropdown Menu -->
					<li class="nav-item dropdown">
					  <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
						<i class="far fa-bell"></i>
						<span class="badge badge-warning navbar-badge">15</span>
					  </a>
					  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
						<span class="dropdown-item dropdown-header">15 Notifications</span>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
						  <i class="fas fa-envelope mr-2"></i> 4 new messages
						  <span class="float-right text-muted text-sm">3 mins</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
						  <i class="fas fa-users mr-2"></i> 8 friend requests
						  <span class="float-right text-muted text-sm">12 hours</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
						  <i class="fas fa-file mr-2"></i> 3 new reports
						  <span class="float-right text-muted text-sm">2 days</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
					  </div>
					</li>
					
				 
					<li class="nav-item">
						<a class="nav-link" data-widget="fullscreen" href="#" role="button">
							<i class="fas fa-expand-arrows-alt"></i>
						</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
							<img src="{{ asset('admin-assets/img/avatar5.png') }}" class='img-circle elevation-2' width="40" height="40" alt="">
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
							<h4 class="h4 mb-0"><strong>{{ Auth::guard('admin')->user()->name }}</strong></h4>
							<div class="mb-3">{{ Auth::guard('admin')->user()->email }}</div>
							
							<div class="dropdown-divider"></div>
							<a href="{{ route('admin.showChangePasswordForm') }}" class="dropdown-item">
								<i class="fas fa-lock mr-2"></i> Change Password
							</a>
							<div class="dropdown-divider"></div>
							<a href="{{ route('admin.logout') }}" class="dropdown-item text-danger">
								<i class="fas fa-sign-out-alt mr-2"></i> Logout
							</a>
						</div>
					</li>
				</ul>
			</nav>
			<!-- /.navbar -->

            @include('admin/layouts/sidebar')

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">

                @yield('content')

			</div>
			<!-- /.content-wrapper -->
			<footer class="main-footer">

				<strong>Copyright &copy; 2014-2022 AmazingShop All rights reserved.
			</footer>

		</div>
		<!-- ./wrapper -->
		<!-- jQuery -->
		<script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<!-- AdminLTE App -->
		<script src="{{ asset('admin-assets/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('admin-assets/plugins/dropzone/min/dropzone.min.js') }}"></script>
        <script src="{{ asset('admin-assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('admin-assets/plugins/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('admin-assets/js/datetimepicker.js') }}"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="{{ asset('admin-assets/js/demo.js') }}"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function(){
                $(".summernote").summernote({
                    //height:250;
                });

				$('.addBtn').click(function() {
                	$(this).parent().addClass('active');
        		});
				$('.removeBtn').click(function() {
                	$(this).parent().removeClass('active');
        		});
            })

            //Alert timeout
            setTimeout(function () {
                $('.alert').fadeOut(300);
            }, 1500);


        </script>

        @yield('customJs')

	</body>
</html>
