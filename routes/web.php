<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\AreaController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DiscountCodeController;
use App\Http\Controllers\admin\MenuController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\QrController;
use App\Http\Controllers\admin\SeatController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\admin\ArticleController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


// In your routes/web.php
Route::post('dining',[FrontController::class, 'dinening_store'])->name('submit.dining');
Route::post('takeaway',[FrontController::class, 'takeaway_store'])->name('submit.takeaway');
Route::post('delivery',[FrontController::class, 'delivery_store'])->name('submit.delivery');
Route::post('order',[FrontController::class, 'order_store'])->name('submit.order');

//add to cart
//Route::get('cart', [FrontController::class, 'showCartTable']);
Route::get('add-to-cart/{id}', [FrontController::class, 'addToCart']);
Route::delete('remove-from-cart', [FrontController::class, 'removeCartItem']);
Route::get('clear-cart', [FrontController::class, 'clearCart']);

//add to wishlist
Route::get('favorites',[FrontController::class,'wishlist'])->name('front.wishlist');
Route::get('add-to-wishlist/{id}', [FrontController::class, 'addToWish']);
Route::delete('remove-from-wishlist', [FrontController::class, 'removeWishlistItem']);
Route::get('clear-wishlist', [FrontController::class, 'clearWishlist']);


//Front pages routes
Route::get('/', [FrontController::class, 'show'])->name('front.home');
Route::get('/menu/{menuSlug?}',[ShopController::class,'index'])->name('front.menu');
Route::get('/{areaSlug?}',[FrontController::class,'restaurant'])->name('front.restaurant');

//Route::get('/cart',[CartController::class,'cart'])->name('front.cart');
//Route::post('/add-to-cart',[CartController::class,'addToCart'])->name('front.addToCart');
//Route::post('/update-cart',[FrontController::class,'updateCart'])->name('front.updateCart');
//Route::post('/delete-item',[CartController::class,'deleteItem'])->name('front.deleteItem.cart');
//Route::get('/checkout',[CartController::class,'checkout'])->name('front.checkout');

Route::get('/thanks/{orderId}',[CartController::class,'thankyou'])->name('front.checkout.thankyou');
Route::post('/get-order-summary',[CartController::class,'getOrderSummary'])->name('front.getOrderSummary');
Route::post('/apply-discount',[CartController::class,'applyDiscount'])->name('front.applyDiscount');
Route::post('/remove-discount',[CartController::class,'removeCoupon'])->name('front.removeCoupon');
Route::post('/add-to-wishlist',[FrontController::class,'addToWishlist'])->name('front.addToWishlist');
Route::get('/page/{slug}',[FrontController::class,'page'])->name('front.page');
Route::post('/send-contact-email',[FrontController::class,'sendContactEmail'])->name('front.sendContactEmail');

//Payment routes
Route::post('checkout/razorpay',[CartController::class,'razorpayPayment'])->name('checkout.razorpay');
Route::get('checkout/payment-success',[CartController::class,'razorpaySuccess'])->name('checkout.success');
Route::get('checkout/payment-failed',[CartController::class,'razorpayFailed'])->name('checkout.failed');




//User realted
Route::group(['prefix' => 'account'], function(){
    Route::group(['middleware' => 'guest'], function(){
        Route::get('/login',[AuthController::class,'login'])->name('account.login');
        Route::post('/login',[AuthController::class,'authenticate'])->name('account.authenticate');
        Route::get('/register',[AuthController::class,'register'])->name('account.register');
        Route::post('/process-register',[AuthController::class,'processRegister'])->name('account.processRegister');
    });

    Route::group(['middleware' => 'auth'], function(){
        //Users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/profile',[AuthController::class,'profile'])->name('account.profile');
        Route::post('/update-profile',[AuthController::class,'updateProfile'])->name('account.updateProfile');
        Route::post('/update-address',[AuthController::class,'updateAddress'])->name('account.updateAddress');
        Route::get('/change-password',[AuthController::class,'changePasswordForm'])->name('account.changePassword');
        Route::post('/process-change-password',[AuthController::class,'changePassword'])->name('account.processChangePassword');
        Route::post("/updatePassword",[AccountController::class, 'updatePassword'])->name('account.updatePassword');

        Route::get('/my-orders',[AuthController::class,'orders'])->name('account.orders');
        Route::get('/my-wishlist',[AuthController::class,'wishlist'])->name('account.wishlist');
        Route::post('/remove-product-from-wishlist',[AuthController::class,'removeProductFromWishlist'])->name('account.removeProductFromWishlist');
        Route::get('/order-detail/{orderId}',[AuthController::class,'orderDetail'])->name('account.orderDetail');
        Route::get('/logout',[AuthController::class,'logout'])->name('account.logout');

    });
});

//Admin related
Route::group(['prefix' => 'admin',], function(){
    Route::group(['middleware' => 'admin.guest'], function(){
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function(){
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');
        Route::post("/updateProfilePic",[AccountController::class, 'updateProfilePic'])->name('profile.updatePic');
        Route::post("/updateWebsite",[SettingController::class, 'update'])->name('website.update');
        //Route::post("/updateWebsite",[SettingController::class, 'updateWebsite'])->name('website.update');
        Route::post("/updateWebsiteLogo",[SettingController::class, 'update_logo'])->name('website.logo');

        //Category Routes
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');        
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.delete');

        //Sub Category Routes
        Route::get('/menus', [MenuController::class, 'index'])->name('menu.index');        
        Route::post('/menus', [MenuController::class, 'store'])->name('menu.store');
        Route::get('/menus/{menu}/edit', [MenuController::class, 'edit'])->name('menu.edit');
        Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menu.update');
        Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menu.delete');

        //Areas Routes
        Route::get('/areas', [AreaController::class, 'index'])->name('areas.index');        
        Route::post('/areas', [AreaController::class, 'store'])->name('areas.store');
        Route::post('/tables', [AreaController::class, 'store_table'])->name('seatings.store');
        Route::get('/areas/{area}/edit', [AreaController::class, 'edit'])->name('areas.edit');
        Route::put('/areas/{area}', [AreaController::class, 'update'])->name('areas.update');
        Route::delete('/areas/{area}', [AreaController::class, 'destroy'])->name('areas.delete');

        //Orders Routes
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'detail'])->name('orders.detail');
        Route::post('/order/change-status/{id}', [OrderController::class, 'changeOrderStatus'])->name('orders.changeOrderStatus');
        Route::post('/order/send-email/{id}', [OrderController::class, 'sendInvoiceEmail'])->name('orders.sendInvoiceEmail');

        //Table Routes
        Route::get('/tables', [SeatController::class, 'index'])->name('tables.index');
        Route::post('/seatings', [SeatController::class, 'store'])->name('seatings.store');
        Route::get('/tables/{table}/edit', [SeatController::class, 'edit'])->name('tables.edit');
        Route::put('/tables/{table}', [SeatController::class, 'update'])->name('tables.update');
        Route::delete('/tables/{table}', [SeatController::class, 'destroy'])->name('tables.delete');

        //QR Codes Routes
        // Route::get('/qr_codes', [QrController::class, 'index'])->name('qr_codes.index');
        // Route::post('/qr_codes', [QrController::class, 'store'])->name('qr_codes.store');
        // Route::get('/qr_codes/{seating}/edit', [QrController::class, 'edit'])->name('qr_codes.edit');
        // Route::put('/qr_codes/{seating}', [QrController::class, 'update'])->name('qr_codes.update');
        // Route::delete('/qr_codes/{seating}', [QrController::class, 'destroy'])->name('qr_codes.delete');

        //Product Route
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::post('/product_view', [ProductController::class, 'view_store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.delete');
        Route::get('/get-products',[ProductController::class,'getProducts'])->name('products.getProducts');

        //Sub Categories Connect to main Categories
        Route::get('/product-subcategories', [ProductSubCategoryController::class, 'index'])->name('product-subcategories.index');

        //Delete Product Images Route
        Route::post('/product-images/update', [ProductImageController::class, 'update'])->name('product-images.update');
        Route::delete('/product-images', [ProductImageController::class, 'destroy'])->name('product-images.destroy');

        //Shipping Routes
        Route::get('/shipping/create', [ShippingController::class, 'create'])->name('shipping.create');
        Route::post('/shipping', [ShippingController::class, 'store'])->name('shipping.store');
        Route::get('/shipping/{id}', [ShippingController::class, 'edit'])->name('shipping.edit');
        Route::put('/shipping/{id}', [ShippingController::class, 'update'])->name('shipping.update');
        Route::delete('/shipping/{id}', [ShippingController::class, 'destroy'])->name('shipping.delete');

        //Coupon Code Routes
        Route::get('/coupons', [DiscountCodeController::class, 'index'])->name('coupons.index');
        Route::get('/coupons/create', [DiscountCodeController::class, 'create'])->name('coupons.create');
        Route::post('/coupons', [DiscountCodeController::class, 'store'])->name('coupons.store');
        Route::get('/coupons/{coupon}/edit', [DiscountCodeController::class, 'edit'])->name('coupons.edit');
        Route::put('/coupons/{coupon}', [DiscountCodeController::class, 'update'])->name('coupons.update');
        Route::delete('/coupons/{coupon}', [DiscountCodeController::class, 'destroy'])->name('coupons.delete');

        //Permissions
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::post('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/permissions', [PermissionController::class, 'destroy'])->name('permissions.destroy');        

        //Roles
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::post('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles', [RoleController::class, 'destroy'])->name('roles.destroy');

        //Articles
        Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
        Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
        Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
        Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
        Route::post('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
        Route::delete('/articles', [ArticleController::class, 'destroy'])->name('articles.destroy');

        //Users Routes
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::post('/user_role', [UserController::class, 'store_role'])->name('users.role');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.delete');

        //Settings Routes
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');        
        Route::post('/settings/website_information', [SettingController::class, 'websiteInformation'])->name('settings.websiteInformation');                
        Route::post('/settings/branch', [SettingController::class, 'branch'])->name('settings.branch');                

        
        
        //Password
        Route::get('/change-password', [SettingController::class, 'showChangePasswordForm'])->name('admin.showChangePasswordForm');
        Route::post('/process-change-password', [SettingController::class, 'processChangePassword'])->name('admin.processChangePassword');
        
        //Route::post('/process-website', [SettingController::class, 'websiteInformation'])->name('admin.website');

        //Pages Routes
        Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
        Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
        Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
        Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('pages.delete');

        //Temp image controller
        Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');

        

        Route::get('/getSlug', function(Request $request){
            $slug = '';
            if (!empty($request->title)) {
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);
        })->name('getSlug');
    });
});
