@extends('layouts.frontLayout.front_design')
@section('content')
	<section>
		<div class="container">

			<div class="row">			
				<div class="col-sm-10 col-sm-offset-1 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
									<a href="{{asset('images/backend_images/products/lr/'.$productDetails->product_image)}}">
										{{-- <img src="example-images/3_standard_1.jpg" alt="" width="640" height="360" /> --}}
										<img style="width:300px;" class="mainImage" src="{{asset('images/backend_images/products/md/'.$productDetails->product_image)}}" alt="" />
									</a>
								</div>
							</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">
										<div class="item-active thumbnails">
											@if ($productAltImg->count() > 0 )
												@foreach($productAltImg as $altImg)
													<a href="{{asset('images/backend_images/products/lr/'.$altImg->image)}}" data-standard="{{asset('images/backend_images/products/sm/'.$altImg->image)}}">
														<img class="changeImage" src="{{asset('images/backend_images/products/sm/'.$altImg->image)}}" alt="" width="60px" height="60px" />
													</a>
												@endforeach
											@endif
										</div>	
									</div>

								  <!-- Controls -->
								  <a class="left item-control" href="#similar-product" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								  </a>
								  <a class="right item-control" href="#similar-product" data-slide="next">
									<i class="fa fa-angle-right"></i>
								  </a>
							</div>

						</div>
						<div class="col-sm-7">
							<form id="addToCartForm" name="addToCartForm" action="{{url('add-cart')}}" method="post">
								{{ csrf_field() }}
								<input type="hidden" name="product_id" value="{{ $productDetails->id }}">
								<input type="hidden" name="product_name" value="{{ $productDetails->product_name }}">
								<input type="hidden" name="product_code" value="{{ $productDetails->product_code }}">
								<input type="hidden" name="product_color" value="{{ $productDetails->product_color }}">
								<input type="hidden" name="price" id="price" value="{{ $productDetails->product_price }}">
								<input type="hidden" name="sku" id="sku" value="">

								<div class="product-information"><!-- product-information -->
									<img src="{{asset('images/frontend_images/product-details/new.jpg')}}" class="newarrival" alt="" />
									<h2>{{ucwords($productDetails->product_name)}}</h2>
									<p> Code : {{ucwords($productDetails->product_code)}}</p>
									<p> 
										<select id="selSize" name="size" style="width:120px">
											<option value="">Select Size</option>
											@foreach($productDetails->attributes as $attribute)
												<option value="{{$productDetails->id}}-{{$attribute->size}}">{{$attribute->size}}</option>
											@endforeach
										</select>
									</p>
									<span>
										<span id="product-price">$ {{ucwords($productDetails->product_price)}}</span>
										<label>Quantity:</label>
										<input id="product-stock" name="quantity" type="text" value="" />
										@if ($totalStock > 0)
											<button id="cartBtn" type="submit" class="btn btn-fefault cart">
												<i class="fa fa-shopping-cart"></i>
												Add to cart
											</button>
										@endif
									</span>
									<p><b>Availability:</b> @if($totalStock > 0) <span id="availability"> In Stock @else Out Of Stock @endif </span> </p>
									<p><b>Condition:</b> New</p>
									<p><b>Brand:</b> E-SHOPPER</p>
									<a href=""><img src="{{asset('images/frontend_images/product-details/share.png')}}" class="share img-responsive"  alt="" /></a>
								</div>
								<!-- product-information -->

							</form>
						</div>
					</div><!--/product-details-->
					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#description" data-toggle="tab">Description</a></li>
								<li><a href="#care" data-toggle="tab">Materials & Care</a></li>
								<li ><a href="#delivery" data-toggle="tab">Delivery Options</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="description" >
								<div class="col-sm-12">
									<p>{{ucwords($productDetails->product_description)}}</p> 	
								</div>
							</div>
							
							<div class="tab-pane fade" id="care" >
								<div class="col-sm-12">
									<p>{{ucwords($productDetails->care)}}</p>
								</div>
							</div>
							
							<div class="tab-pane fade" id="delivery" >
								<div class="col-sm-12">
									<p>static text</p>
								</div>
							</div>
							
						</div>
					</div><!--/category-tab-->
					
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<?php $count = 1; ?>
								@foreach($relatedProducts->chunk(3) as $chunk)
									<div class="item <?= $count == 1 ? 'active' : '' ?>">
										@foreach($chunk as $product)
											<div class="col-sm-4">
												<div class="product-image-wrapper">
													<div class="single-products">
														<div class="productinfo text-center">
															<a href="{{url('product', $product->id)}}">
																<img src="{{asset('images/backend_images/products/sm/'.$product->product_image)}}" alt="" />
															<h2>{{$product->product_name}}</h2>
															</a>
															<p> $ {{$product->product_price}}</p>
															<p>{{$product->product_description}}</p>
															<button type="button" class="btn btn-default add-to-cart">
																<i class="fa fa-shopping-cart"></i>Add to cart
															</button>
														</div>
													</div>
												</div>
											</div>
										@endforeach
									</div>
									<?php $count++; ?>
								@endforeach
							</div>

							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
					
				</div>
			</div>
		</div> 
	</section>
@endsection