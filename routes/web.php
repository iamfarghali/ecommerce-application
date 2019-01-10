<?php
// Last Video Number is 75


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Website Routes
	// Homepage 
	Route::get('/', 'IndexController@index');
	// Products shown according to category url
	Route::get('/products/{categoryName?}/{brandName?}', 'ProductsController@products');
	// Show product detials
	Route::get('/product/{id}', 'ProductsController@product');
	// get product price according to size
	Route::get('/get-product-price', 'ProductsController@getProductPrice');
	// Add to crat
	Route::match(['get', 'post'], '/add-cart', 'ProductsController@addToCart');
	//  Crat
	Route::match(['get', 'post'], '/cart', 'ProductsController@cart');
	// Delete Product from cart
	Route::get('/cart/delete-product/{id}', 'ProductsController@deleteCartProduct');
	// Update cart quantity
	Route::get('/cart/update-quantity/{id}/{quantity}', 'ProductsController@updateCartQuantity');
	// Apply Coupon
	Route::post('/cart/apply-coupon', 'ProductsController@applyCoupon');
	// Register, Login
	Route::get('/login-register', 'UserController@loginRegister');
	Route::post('/user-register', 'UserController@register');
	Route::match(['get', 'post'], '/login-user', 'UserController@login');
	// check email, Logout
	Route::match(['get', 'post'], '/check-email', 'UserController@checkEmail');
	Route::get('/user-logout', 'UserController@logout');
	Route::group(['middleware' => ['userAuth']], function() {

		// account
		Route::match(['get', 'post'], '/account', 'UserController@account');

		// check user password [AJAX Request]
		Route::post('/check-user-password', 'UserController@checkPassword');

	});



// Admin Routes
	Route::match(['get', 'post'], 'admin/', 'AdminController@login');
	Route::get('logout', 'AdminController@logout');

	Route::group(['middleware' => ['auth']], function () {

			Route::get('/admin/dashboard', 'AdminController@dashboard');
			Route::get('/admin/setting', 'AdminController@setting');
			Route::match(['get', 'post'], '/admin/update-pwd', 'AdminController@updatePassword');

			// Categories Routes
			Route::match(['get', 'post'], 'admin/add-category', 'CategoryController@addCategory')->name('admin.add-category');
			Route::match(['get', 'post'], 'admin/edit-category/{id}', 'CategoryController@editCategory')->name('admin.edit-category');
			Route::match(['get', 'post'], 'admin/delete-category/{id}', 'CategoryController@deleteCategory')->name('admin.delete-category');
			Route::get('admin/category/{id}', 'CategoryController@showCategory')->name('admin.show-category');
			Route::get('admin/view-categories', 'CategoryController@viewCategories')->name('admin.show-categories');

			//// Products Routes
			Route::match(['get', 'post'], 'admin/add-product', 'ProductsController@addProduct')->name('admin.add-product');
			Route::get('admin/view-products', 'ProductsController@viewProducts')->name('admin.show-products');
			Route::get('admin/product/{id}', 'ProductsController@showProduct')->name('admin.show-product')->where('id', '[0-9]+');
			Route::match(['get', 'post'], 'admin/edit-product/{id}', 'ProductsController@editProduct')->name('admin.edit-product');
			Route::match(['get', 'post'], 'admin/delete-product/{id}', 'ProductsController@deleteProduct')->name('admin.delete-product');
			Route::match(['get', 'post'], 'admin/add-images/{id}', 'ProductsController@addProductImages')->name('admin.add-images');
			Route::match(['get', 'post'], 'admin/delete-alt-image/{id}', 'ProductsController@deleteAltImage')->name('admin.delete-image');

			// Product Attributes Routes
			Route::match(['get', 'post'], 'admin/add-attribute/{id}', 'ProductsController@addAttribute');
			Route::post('admin/edit-attribute', 'ProductsController@editAttribute');
			Route::get('admin/delete-attribute/{id}', 'ProductsController@deleteAttribute');

			// Coupon
				// Add Coupon
				Route::match(['get', 'post'], 'admin/add-coupon', 'CouponsController@addCoupon');
				// Show All Coupons
				Route::get('admin/view-coupons', 'CouponsController@viewCoupons')->name('admin.show-coupons');
				// Edit Coupon
				Route::match(['get', 'post'], 'admin/edit-coupon/{id?}', 'CouponsController@editCoupon');
				// Delete Coupon
				Route::get('admin/delete-coupon/{id}', 'CouponsController@deleteCoupon');

			// Bannners
				// Add Banner
				Route::match(['get', 'post'], 'admin/add-banner', 'BannersController@addBanner');
				// Show All Banners
				Route::get('admin/view-banners', 'BannersController@viewBanners')->name('admin.show-banners');

				Route::match(['get', 'post'], 'admin/edit-banner/{id}', 'BannersController@editBanner')->name('admin.edit-banner');
				Route::match(['get', 'post'], 'admin/delete-banner/{id}', 'BannersController@deleteBanner')->name('admin.delete-banner');
				

			// Product AJAX
			// Load Sub-Categories For Main Category
			Route::get('admin/product/sub-categories', 'ProductsController@loadSubCategories');
			// Ajax Route Admin Check Password
			Route::get('/admin/check-pwd', 'AdminController@checkPassword');
		});

	Auth::routes();
	Route::get('/home', 'HomeController@index')->name('home');

