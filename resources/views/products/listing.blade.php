@extends('layouts.frontLayout.front_design')
@section('content')
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Category</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							@foreach($categories as $category)
								@if($category->parent_id == 0 && $category->status == "1")
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordian" href="#{{$category->id}}">
													<span class="badge pull-right"><i class="fa fa-plus"></i></span>
													{{$category->name}}
												</a>
											</h4>
										</div>
										<div id="{{$category->id}}" class="panel-collapse collapse">
											<div class="panel-body">
												<ul>
													@foreach($category->subCategories as $subCategory)
														@if ($subCategory->status == "1")
															<li><a href="{{url('/products/'.$category->url.'/'.$subCategory->url)}}">{{$subCategory->name}}</a></li>
														@endif
													@endforeach
												</ul>
											</div>
										</div>
									</div>
								{{-- this condition just to prevent dublicate brand name --}}
								@elseif ($category->parent_id == 3 && $category->status == "1")
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title"><a href="{{url('/products/'.$category->url)}}">{{$category->name}}</a></h4>
										</div>
									</div>
								@endif
							@endforeach

						</div><!--/category-products-->		
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">{{$requestedCategory->name}}</h2>
								@if ( is_array($requestedProducts) )
									@foreach ($requestedProducts as $product)
										@foreach ($product as $oneProduct)
											<div class="col-sm-4">
												<div class="product-image-wrapper">
													<div class="single-products">
														<div class="productinfo text-center">
															<a href="{{url('/product/'.$oneProduct->id)}}">
																<img src="{{asset('images/backend_images/products/sm/'.$oneProduct->product_image)}}" alt="" />
															</a>
															<h2> USD {{$oneProduct->product_price}}</h2>
															<p>{{ucwords($oneProduct->product_name)}}</p>
															<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
														</div>
													</div>
													<div class="choose">
														<ul class="nav nav-pills nav-justified">
															<li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
															<li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
														</ul>
													</div>
												</div>
											</div>
										@endforeach
									@endforeach
								@else
									@foreach ($requestedProducts as $product)
										<div class="col-sm-4">
											<div class="product-image-wrapper">
												<div class="single-products">
													<div class="productinfo text-center">
														<a href="{{url('/product/'.$product->id)}}">
															<img src="{{asset('images/backend_images/products/sm/'.$product->product_image)}}" alt="" />
														</a>
														<h2> USD {{$product->product_price}}</h2>
														<p>{{ucwords($product->product_name)}}</p>
														<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
													</div>
												</div>
												<div class="choose">
													<ul class="nav nav-pills nav-justified">
														<li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
														<li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
													</ul>
												</div>
											</div>
										</div>
									@endforeach
								@endif
					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>
@endsection