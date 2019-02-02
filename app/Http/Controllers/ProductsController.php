<?php

namespace App\Http\Controllers;
use App\Category;
use App\Coupon;
use App\Country;
use App\DeliveryAddress;
use App\Products;
use App\ProductsImage;
use App\ProductsAttribute;
use App\Order;
use App\OrdersProduct;
use App\User;
use DB;
use Mail;
use Image;

class ProductsController extends Controller {
	// Methods For Admin Panel
		public function addProduct() {
			if (request()->isMethod('post')) {
				$product   = new Products;
				$data      = request()->except(['_token', 'product_image']);
				$image_tmp = request()->file('product_image');
 
				$product->category_id     = $data['category_id'];
				$product->sub_category_id = $data['sub_category_id'];
				$product->product_name    = $data['product_name'];
				$product->product_code    = $data['product_code'];
				$product->product_color   = $data['product_color'];

				if ($image_tmp->isValid()) {
					$ext         = $image_tmp->getClientOriginalExtension();
					$filename    = rand(11, 9999).'.'.$ext;
					$lr_img_path = 'images/backend_images/products/lr/'.$filename;
					$md_img_path = 'images/backend_images/products/md/'.$filename;
					$sm_img_path = 'images/backend_images/products/sm/'.$filename;
					// Resize Image
					Image::make($image_tmp)->save($lr_img_path);
					Image::make($image_tmp)->resize(600, 600)->save($md_img_path);
					Image::make($image_tmp)->resize(300, 300)->save($sm_img_path);
					// Insert in products tb
					$product->product_image = $filename;
				}
				$product->product_description = $data['product_description'];
				if ( !empty($data['care']) ) {
					$product->care 	= $data['care'];
				} else {
					$product->care 	= '';
				}
				$product->product_price = $data['product_price'];
				if (!isset($data['status'])) {
					$product->status = 0;
				}
				$product->save();

				return redirect('admin/view-products')->withSuccessMessage('Product is added successfully.');

			} else {
				$mainCategories = Category::where(['parent_id' => 0])->get();
				return view('admin.products.add_product', compact('mainCategories'));
			}
		}

		public function addProductImages() {
			if (request()->isMethod('post')) {

				$product_id     = request()->product_id;
				if (!request()->hasFile('product_image')) {
					return redirect('admin/add-images/'.$product_id)->withErrorMessage('Add Images Please.');
				}

				$images_tmp = request()->file('product_image');	
				foreach ($images_tmp as $image_tmp) {
					if ($image_tmp->isValid()) {
						$productImage   = new ProductsImage;
						$ext         = $image_tmp->getClientOriginalExtension();
						$filename    = rand(11, 9999999).'.'.$ext;
						$lr_img_path = 'images/backend_images/products/lr/'.$filename;
						$md_img_path = 'images/backend_images/products/md/'.$filename;
						$sm_img_path = 'images/backend_images/products/sm/'.$filename;
						// Resize Image
						Image::make($image_tmp)->save($lr_img_path);
						Image::make($image_tmp)->resize(600, 600)->save($md_img_path);
						Image::make($image_tmp)->resize(300, 300)->save($sm_img_path);
						// Insert in products tb
						$productImage->image = $filename;
						$productImage->product_id = $product_id;
						$productImage->save();
					}
				}
				return redirect('admin/add-images/'.$product_id)->withSuccessMessage('Images are added successfully.');

			} else {

				$productImages = ProductsImage::where('product_id', request()->id)->get();
				$product = Products::where(['id' => request()->id])->first();
				return view('admin.products.add_images', compact('product', 'productImages'));
			}
		}

		public function deleteAltImage( $id = null ) {
			$img = 	ProductsImage::find($id);
			if ($img) {
				// Delete image form storing folders.
				$currnetImage = $img->image;
				// Paths for current image
				$currentImagePaths = [
					'lr_img_path' => 'images/backend_images/products/lr/'.$currnetImage,
					'md_img_path' => 'images/backend_images/products/md/'.$currnetImage,
					'sm_img_path' => 'images/backend_images/products/sm/'.$currnetImage
				];

				foreach ($currentImagePaths as $path) {
					if (file_exists($path)) {
						unlink($path);
					}
				}
				$img->delete();
				return redirect()->back()->withSuccessMessage('Image is deleted successfully.');
		    }
		}

		public function viewProducts() {
			$products = Products::get();
			return view('admin.products.view_products', compact('products'));
		}

		public function showProduct() {
			$product                  = Products::with('attributes')->find(request()->id);
			$product['category_name'] = Category::where('id', $product->category_id)->value('name');

			return view('admin.products.show_product', compact('product'));
		}

		public function editProduct( $id = null ) {
			if (request()->isMethod('post')) {

				$data = request()->all();
				$image = isset($data['product_image']) ? $data['product_image'] : null;

				$currentProduct = Products::firstOrCreate(['id' => $id]);

				$currentProduct->category_id = $data['category_id'];
				$currentProduct->sub_category_id = $data['sub_category_id'];
				$currentProduct->product_name = $data['product_name'];
				$currentProduct->product_code = $data['product_code'];
				$currentProduct->product_price = $data['product_price'];
				$currentProduct->product_color = $data['product_color'];
				$currentProduct->product_description = $data['product_description'];
				if ( !empty($data['care']) ) {
					$currentProduct->care 	= $data['care'];
				} else {
					$currentProduct->care 	= '';
				}

				if ($image != null && $image->isValid()) {
					// Delete previous image form storing folders before update image
					$currnetImage = $currentProduct->product_image;
					// Paths for current image
					$currentImagePaths = [
						'lr_img_path' => 'images/backend_images/products/lr/'.$currnetImage,
						'md_img_path' => 'images/backend_images/products/md/'.$currnetImage,
						'sm_img_path' => 'images/backend_images/products/sm/'.$currnetImage
					];

					foreach ($currentImagePaths as $path) {
						if (file_exists($path)) {
							unlink($path);
						}
					}

					// Add a new image in table and folders
					$ext         = $image->getClientOriginalExtension();
					$filename    = rand(11, 9999).'.'.$ext;
					$lr_img_path = 'images/backend_images/products/lr/'.$filename;
					$md_img_path = 'images/backend_images/products/md/'.$filename;
					$sm_img_path = 'images/backend_images/products/sm/'.$filename;
					// Resize Image
					Image::make($image)->save($lr_img_path);
					Image::make($image)->resize(600, 600)->save($md_img_path);
					Image::make($image)->resize(300, 300)->save($sm_img_path);
					// insert in db table
					$currentProduct->product_image = $filename;
				}
				if (!isset($data['status'])) {
					$currentProduct->status = 0;
				}
				$currentProduct->save();
				return redirect('admin/view-products')->withSuccessMessage('Product Is Updated Successfully.');
			
			} else {
				$currentProductData = Products::where('id', request()->id)->first();

				$data = $this->loadSubCategories($currentProductData->category_id, $currentProductData->sub_category_id);
				foreach ($data as $key => $val) {
					$currentProductData[$key] = $val;
				}
				$mainCategories = Category::where(['parent_id' => 0])->get();
				return view('admin.products.edit_product', compact('currentProductData', 'mainCategories'));
			}
		}

		public function deleteProduct( $id = null ) {
			if (request()->isMethod('post')) {
				Products::where('id', $id)->delete();	
				return redirect('admin/view-products')->withSuccessMessage('Product Is Deleted Successfully.');
			}

			$currentProductData = Products::where('id', $id)->first();
			return view('admin.products.delete_product', compact('currentProductData'));
		}

		public function loadSubCategories(int $catId = null, int $subId = null) {
			if ($catId != null && $subId != null) {
				$data                      = [];
				$data['category_name']     = Category::where('id', $catId)->value('name');
				$data['sub_category_name'] = Category::where('id', $subId)->value('name');
				return $data;
			} else {
				$categoryName  = request()->get('main_category');
				$categoryId    = Category::where('name', $categoryName)->value('id');
				$subCategories = Category::where('parent_id', $categoryId)->get();
				return $subCategories;
			}
		}

		// Product Attributes Section
			public function addAttribute($id) {
				if (request()->isMethod('post')) {
					$data = request()->all();
					foreach ($data['sku'] as $key => $val) {
						if (!empty($val)) {

							$countSku = ProductsAttribute::where('sku', $val)->count();
							if ($countSku > 0) {
								return redirect()->back()->withErrorMessage('The SKU " ' . $val . ' " is already exist.');
							}

							$countSize = ProductsAttribute::where([ 'product_id' => $id, 'size' => $data['size'][$key] ])->count();
							if ($countSize > 0) {
								return redirect()->back()->withErrorMessage('The Size " ' . $data['size'][$key] . ' " is already exist.');
							}

							$attributes = new ProductsAttribute;
							$attributes->product_id = $id;
							$attributes->sku = $val;
							$attributes->size = $data['size'][$key];
							$attributes->price = $data['price'][$key];
							$attributes->stock = $data['stock'][$key];
							$attributes->save();	
						}
					}
					return redirect('admin/product/'.$id)->withSuccessMessage('Product Attributes are added successfully.');
				}

				$product = Products::with('attributes')->where('id', $id)->first();
				return view('admin.products.add_attributes', compact('product'));
			}

			public function deleteAttribute( $id = null ) {
				ProductsAttribute::where('id', $id)->delete();
				return redirect()->back()->withSuccessMessage('Attribute is deleted successfully.');
			}

			public function editAttribute() {
				if ( ! request()->isMethod('post') ) abort(404);
				$data = request()->except('_token');
				foreach ($data['attributeIDs'] as $k => $id) {
					ProductsAttribute::where('id', $data['attributeIDs'][$k])->update(['price' => $data['attributePrices'][$k], 'stock' => $data['attributeStocks'][$k]]);
				}
				return redirect()->back()->withSuccessMessage('Data Is Update Successfully.');
			}

		// show Orders
		public function viewOrders() {
			$orders = Order::with('orders')->orderBy('id', 'DESC')->get();
			return view('admin.orders.view_orders', compact('orders'));
		}

		// show order details
		public function viewOrderDetails($order_id) {
			$orderDetails = Order::with('orders')->where('id', $order_id)->first();
			$userDetails = User::where('id', $orderDetails->user_id)->first();
			return view('admin.orders.order_details', compact('orderDetails', 'userDetails'));
		}

		// update order status
		public function updateOrderStatus() {
			if (request()->isMethod('post')) {
				$data = request()->all();
				Order::where('id', $data['order_id'])->update(['order_status' => $data['order_status']]);
				return redirect()->back()->withSuccessMessage('Order Status is Updated Successfully.');
			}
		}



	// Methods For Application
		public function products($categoryName = null, $brandName = null) {
			$countMainCategories = Category::where(['url'=>$categoryName, 'status'=>1])->count();
			$countBrand = Category::where([ ['url', '=', $brandName], ['parent_id', '<>', 0], ['status', '=', '1'] ])->count();

			if ($countMainCategories > 0 && $countBrand > 0) {
				$mainCategory = Category::where('url', $categoryName)->first();
				$requestedCategory = Category::where(['parent_id'=>$mainCategory->id, 'url'=>$brandName])->first();
				$requestedProducts = Products::where(['category_id'=>$requestedCategory->parent_id, 'sub_category_id'=>$requestedCategory->id, 'status'=>1])->get();
			} 
			else if ($countMainCategories > 0 && $countBrand == 0 && $brandName == null) {
				$requestedCategory = Category::where(['url'=>$categoryName])->first();
				if ( $requestedCategory->parent_id == 0 ) {
					$requestedProducts = Products::where(['category_id'=>$requestedCategory->id, 'status'=>1])->get();
				} 
				else {
					$requestedCategoryIds = Category::where(['url'=>$categoryName])->pluck('id');
					$requestedProducts = [];
					foreach ( $requestedCategoryIds as $id ) {
						$requestedProducts[] = Products::where(['sub_category_id'=>$id, 'status'=>1])->get();
					}
				}
			}
			else {
				abort(404);
			}

			$categories = Category::with('subCategories')->get();
			return view('products.listing', compact('requestedProducts', 'requestedCategory', 'categories'));
		}

		public function product($id=null) {
			$productDetails = Products::with('attributes')->where(['status'=>1])->findOrFail($id);
			$productAltImg = ProductsImage::where('product_id', $id)->get();
			$totalStock = ProductsAttribute::where('product_id', $id)->sum('stock');
			$relatedProducts = Products::where('id', '!=', $productDetails->id)->where(['product_code'=>$productDetails->product_code, 'status'=>1])->get();

			return view('products.product_details', compact('productDetails', 'productAltImg', 'totalStock', 'relatedProducts'));
		}

		public function cart() {
			if (auth()->check()) {
				$user_email = auth()->user()->email;
				$userCart = DB::table('cart')->where('user_email', $user_email)->get();
			} else {			
				$session_id = session()->get('session_id');
				$userCart = DB::table('cart')->where('session_id', $session_id)->get();
			}

			foreach ($userCart as $key => $product) {
				$productDetails = Products::where('id', $product->product_id)->first();
				$userCart[$key]->image = $productDetails->product_image;
			}
			return view('products.cart', compact('userCart'));
		}

		public function addToCart() {
			session()->forget('couponCode');
			session()->forget('couponAmount');

			$data = request()->except('_token');
			$data['size'] = strtolower((explode('-', $data['size']))[1]);
			$productExist = DB::table('cart')->where([
				'product_code'	=>	$data['sku'],
				'session_id'	=>	session()->get('session_id')
			])->count();
			if ($productExist > 0) {
				return redirect('/cart')->withErrorMessage('Product Is Already Exist, You can update the quantity from here');
			}

			if (! auth()->check() ) {
				$data['user_email'] = '';
			} else {
				$data['user_email'] = auth()->user()->email;
			}

			$session_id = session()->get('session_id');
			if (empty($session_id)) {
				$session_id = str_random(40);
				session()->put('session_id', $session_id);
			}
			$productSKU = ProductsAttribute::where(['product_id' => $data['product_id'], 'size' => $data['size']])->first();
			DB::table('cart')->insert([
				'product_id'	=>	$data['product_id'],
				'product_name'	=>	$data['product_name'],
				'product_code'	=>	$productSKU->sku,
				'product_color'	=>	$data['product_color'],
				'size'			=>	$data['size'],
				'price'			=>	$data['price'],
				'quantity'		=>	$data['quantity'],
				'user_email'	=>	$data['user_email'],
				'session_id'	=>	$session_id
			]);
			return redirect('cart')->withSuccessMessage('Item is added successfully to cart.');
		}

		public function deleteCartProduct( $id = null ) {
			session()->forget('couponCode');
			session()->forget('couponAmount');
			DB::table('cart')->where('id', $id)->delete();
			return redirect()->back()->withSuccessMessage('Item is deleted Successfully.');
		}

		public function updateCartQuantity( $id = null, $quantity = null) {
			session()->forget('couponCode');
			session()->forget('couponAmount');
			$cartDetails = DB::table('cart')->where('id', $id)->first();
			$attributeStock = ProductsAttribute::where('sku', $cartDetails->product_code)->first();
			$updateQuantity = $cartDetails->quantity + $quantity;
			if ($attributeStock->stock >= $updateQuantity) {
				if ( $quantity == 1 ) {
					DB::table('cart')->where('id', $id)->increment('quantity');
				} else if ( $quantity == -1 ) {
					DB::table('cart')->where('id', $id)->decrement('quantity');	
				} else {
					abort(404);
				}
			} else {
				return redirect()->back()->withErrorMessage('Required Product Is Not Available.');
				
			} 
			return redirect('/cart')->withSuccessMessage('Quantity Is Updated');
		}

		public function applyCoupon() {
			session()->forget('couponCode');
			session()->forget('couponAmount');

			$coupon_code = request()->coupon_code;
			$couponCount = Coupon::where('coupon_code', $coupon_code)->count();

			if ( $couponCount == 0 ) {
				return redirect()->back()->withErrorMessage('Your Coupon Incorrect.');
			} else {
				$coupon = Coupon::where('coupon_code', $coupon_code)->first();

				// if its status is inactive
				if ($coupon->status == 0) {
					return redirect()->back()->withErrorMessage('This coupon is Inactive.');
				}

				// if coupon's expiry date is gone
				$current_date = date('Y-m-d');
				if ($coupon->expiry_date < $current_date) {
					return redirect()->back()->withErrorMessage('This coupon is expiry.');
				}

				// coupon is valid
				if (auth()->check()) {
					$user_email = auth()->user()->email;
					$userCart = DB::table('cart')->where('user_email', $user_email)->get();
				} else {
					$session_id = session('session_id');
					$userCart = DB::table('cart')->where('session_id', $session_id)->get();
				}
				$total_amount = 0;
				foreach ($userCart as $item) {
					$total_amount += $item->quantity * $item->price;
				}

				if ($coupon->amount_type == 'Fixed') {
					$couponAmount = $coupon->amount;
				} else {
					$couponAmount = $total_amount * ($coupon->amount/100);
				}

				session()->put('couponAmount', $couponAmount);
				session()->put('couponCode', $coupon_code);

				return redirect()->back()->withSuccessMessage('Coupon Code is applied successfully.');

			}
		}

		// For Ajax request [ Get Product Price ]
		public function getProductPrice() {
			$data = request()->all();
			$dataArr = explode('-', $data['idSize']);
			$proAttr = ProductsAttribute::where(['product_id'=>$dataArr[0], 'size'=>$dataArr[1]])->first();
			$productData = [
				'sku' 	=> $proAttr->sku, 
				'price' => $proAttr->price,
				'stock' => $proAttr->stock
			]; 
			return $productData;
		}

		// checout
		public function checkout() {
			$user = auth()->user();
			if (request()->isMethod('post')) {
				$data = request()->all();
				foreach ($data as $k => $val) {
					if (empty($val)) {
						return redirect()->back()->withErrorMessage('Please fill all fields to checkout!');
					}
				}
				$user->name = $data['billing_name'];
				$user->address = $data['billing_address'];
				$user->city = $data['billing_city'];
				$user->state = $data['billing_state'];
				$user->country = $data['billing_country'];
				$user->pincode = $data['billing_pincode'];
				$user->mobile = $data['billing_mobile'];
				$user->update();

				$shippingAddresses = DeliveryAddress::where('user_id', $user['id'])->count();
				if ($shippingAddresses > 0 ) {
					$shippingAddresses = DeliveryAddress::where('user_id', $user['id'])->first();
					$shippingAddresses->name = $data['shipping_name'];
					$shippingAddresses->address = $data['shipping_address'];
					$shippingAddresses->city = $data['shipping_city'];
					$shippingAddresses->state = $data['shipping_state'];
					$shippingAddresses->country = $data['shipping_country'];
					$shippingAddresses->pincode = $data['shipping_pincode'];
					$shippingAddresses->mobile = $data['shipping_mobile'];
					$shippingAddresses->update();

				} else {
					// dd($data);
					$shippingAddresses = new DeliveryAddress;
					$shippingAddresses->name = $data['shipping_name'];
					$shippingAddresses->user_id = $user['id'];
					$shippingAddresses->user_email = $user['email'];
					$shippingAddresses->address = $data['shipping_address'];
					$shippingAddresses->city = $data['shipping_city'];
					$shippingAddresses->state = $data['shipping_state'];
					$shippingAddresses->country = $data['shipping_country'];
					$shippingAddresses->pincode = $data['shipping_pincode'];
					$shippingAddresses->mobile = $data['shipping_mobile'];
					$shippingAddresses->save();
				}
				return redirect()->action('ProductsController@orderReview');
			}

			// update cart table with user email
			$session_id = session()->get('session_id');
			DB::table('cart')->where(['session_id' => $session_id])->update(['user_email' => $user['email']]);

			$countries = Country::get();
			$shippingAddresses = [];
			$shippingAddresses = DeliveryAddress::where('user_id', $user['id'])->count();
			if ($shippingAddresses > 0 ) {
				$shippingAddresses = DeliveryAddress::where('user_id', $user['id'])->first();
			}
			return view('products.checkout', compact('user', 'countries', 'shippingAddresses'));
		}

		public function orderReview() {
			$user = auth()->user();
			$shippingAddress = DeliveryAddress::where('user_id', $user['id'])->first();
			$userCart = DB::table('cart')->where(['user_email' => $user->email])->get();
			foreach ($userCart as $key => $product) {
				$productDetails = Products::where('id', $product->product_id)->first();
				$userCart[$key]->image = $productDetails->product_image;
			}

			return view('products.order-review', compact('user', 'shippingAddress', 'userCart'));
		}

		public function placeOrder() {
			if (request()->isMethod("post")) {
				$data = request()->except('_token');

				if ( empty(session()->get('couponCode')) ) {
					$data['coupon_code'] = "";
					$data['coupon_amount'] = "";
				} else {
					$data['coupon_code'] = session()->get('couponCode');
					$data['coupon_amount'] = session()->get('couponAmount');
				}

				$user_id = auth()->user()->id;
				$user_email = auth()->user()->email;

				// get shipping address of this user
					$shipping = DeliveryAddress::where('user_email', $user_email)->first();
				// create order model
					$order = new Order;
					$order->user_id = $shipping->user_id;
					$order->user_email = $shipping->user_email;
					$order->name = $shipping->name;
					$order->address = $shipping->address;
					$order->city = $shipping->city;
					$order->state = $shipping->state;
					$order->country = $shipping->country;
					$order->pincode = $shipping->pincode;
					$order->mobile = $shipping->mobile;
					$order->order_status = "New";
					$order->shipping_charges = 0;
					$order->coupon_code = $data['coupon_code'];
					$order->coupon_amount = $data['coupon_amount'];
					$order->grand_total = $data['grand_total'];
					$order->payment_method = $data['payment_method'];
					$order->save();

				$order_id = DB::getPdo()->lastInsertId();

				$cartProducts = DB::table("cart")->where("user_email", $user_email)->get();
				foreach ($cartProducts as $p) {
					$cartPro = new OrdersProduct;
					$cartPro->order_id = $order_id;
					$cartPro->user_id = $user_id;
					$cartPro->product_id = $p->product_id;
					$cartPro->product_name = $p->product_name;
					$cartPro->product_code = $p->product_code;
					$cartPro->product_color = $p->product_color;
					$cartPro->product_size = $p->size;
					$cartPro->product_price = $p->price;
					$cartPro->product_qty = $p->quantity;
					$cartPro->save();
				}
				session()->put('order_id', $order_id);
				session()->put('grand_total', $data['grand_total']);

				if ($data['payment_method'] === 'COD') {
					// send order email
                    $email = $user_email;
                    $messageData = ['email' => $email, 'name' => $shipping->name, 'order_id' => $order_id];
                    Mail::send('emails.order', $messageData, function($message) use($email) {
                        $message->to($email)->subject('Order Placed - E-Comm Application');
                    });
					return redirect("/thanks");
				} else {
					return redirect("/paypal");
				}
			}
		}

		public function thanks() {
			$user_email = auth()->user()->email;
			DB::table('cart')->where('user_email', $user_email)->delete();
			return view('orders.thanks');
		}

		public function userOrders() {
			$orders = Order::with('orders')->where('user_id', auth()->user()->id)->get();
			return view('orders.user_orders', compact('orders'));
		}

		public function userOrderDetails($order_id) {
			$orderDetails =  Order::with('orders')->where('id', $order_id)->first();
			return view('orders.order_details', compact('orderDetails'));
		}

		public function paypal() {
			$user_email = auth()->user()->email;
			DB::table('cart')->where('user_email', $user_email)->delete();
			return view('orders.paypal');
		}

		public function thanksPaypal() {
			return view('orders.thanks_paypal');
		}

		public function cancelPaypal() {
			return view('orders.cancel_paypal');
		}
}
