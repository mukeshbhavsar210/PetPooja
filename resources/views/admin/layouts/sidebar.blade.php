<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    @if (Auth::user()->restaurant_logo != '')
        <div style="display: flex">
            <img src="{{ asset('website_logo/'.Auth::user()->restaurant_logo) }}" alt="avatar"  class="img-fluid mt-4 ml-4" style="width: 50px;" >
            <p style="color: #fff; margin:35px 0 0 10px;">{{ Auth::user()->restaurant_name }}</p>
        </div>
    @else
        <img src="{{ asset('admin-assets/img/AdminLTELogo.png') }}" alt="avatar"  class="rounded-circle img-fluid" style="width: 100px;">
    @endif 
    
    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="dashboard.html" class="nav-link">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (\Request::route()->getName() == 'categories.index') ? 'active' : '' }}">
                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                        <p>Menu <i class="right fas fa-angle-left"></i> </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" class="nav-link {{ (\Request::route()->getName() == 'categories.index') ? 'active' : '' }}">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('menu.index') }}" class="nav-link {{ (\Request::route()->getName() == 'menu.index') ? 'active' : '' }}">Item Categories</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('products.index') }}" class="nav-link {{ (\Request::route()->getName() == 'products.index') ? 'active' : '' }}">Menu Item</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ (\Request::route()->getName() == 'areas.index') ? 'active' : '' }}">
                        <p>Tables <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('areas.index') }}" class="nav-link {{ (\Request::route()->getName() == 'areas.index') ? 'active' : '' }}">Areas</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('seatings.index') }}" class="nav-link {{ (\Request::route()->getName() == 'seatings.index') ? 'active' : '' }}">Tables</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('qr_codes.index') }}" class="nav-link {{ (\Request::route()->getName() == 'qr_codes.index') ? 'active' : '' }}">QR Code</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="fa fa-bell" aria-hidden="true"></i>

                        <p>Waiter Requests</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="fa fa-calendar-check" aria-hidden="true"></i>
                        <p>Reservations</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>POS</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ (\Request::route()->getName() == 'areas.index') ? 'active' : '' }}">
                        <p>Orders <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('areas.index') }}" class="nav-link {{ (\Request::route()->getName() == 'areas.index') ? 'active' : '' }}">KOT</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('orders.index') }}" class="nav-link {{ (\Request::route()->getName() == 'orders.index') ? 'active' : '' }}">Orders</a>
                        </li>
                        
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Customers</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Staff</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="nav-icon  fas fa-users"></i>
                        <p>Delivery Executive</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.index') }}" class="nav-link">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                        <p>Settings</p>
                    </a>
                </li>
               
            
                {{-- <li class="nav-item">
                    <a href="{{ route('shipping.create') }}" class="nav-link">
                        <i class="nav-icon fas fa-tag"></i>
                        <i class="fas fa-truck nav-icon"></i>
                        <p>Shipping</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('coupons.index') }}" class="nav-link">
                        <i class="nav-icon  fa fa-percent" aria-hidden="true"></i>
                        <p>Discount</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('pages.index') }}" class="nav-link">
                        <i class="nav-icon  far fa-file-alt"></i>
                        <p>Pages</p>
                    </a>
                </li>
                
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
 </aside>
