<?php

namespace App\Http\Controllers;
use App\Category;
use App\Products;
use App\ProductsImage;
use App\ProductsAttribute;
use Image;
use DB;

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


	// Methods For Application [NOT] admin panel
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
			$session_id = session()->get('session_id');
			$userCart = DB::table('cart')->where('session_id', $session_id)->get();

			foreach ($userCart as $key => $product) {
				$productDetails = Products::where('id', $product->product_id)->first();
				$userCart[$key]->image = $productDetails->product_image;
			}
			return view('products.cart', compact('userCart'));
		}

		public function addToCart() {
			$data = request()->except('_token');

			$data['size'] = strtolower((explode('-', $data['size']))[1]);
			$productExist = DB::table('cart')->where([
				'product_code'	=>	$data['sku'],
				'session_id'	=>	session()->get('session_id')
			])->count();
			if ($productExist > 0) {
				return redirect('/cart')->withErrorMessage('Product Is Already Exist, You can update the quantity from here');
			}

			if (empty($data['user_eamil'])) {$data['user_email'] = '';}
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
			DB::table('cart')->where('id', $id)->delete();
			return redirect()->back()->withSuccessMessage('Item is deleted Successfully.');
		}

		public function updateCartQuantity( $id = null, $quantity = null) {
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
}
