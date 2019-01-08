@extends('layouts.frontLayout.front_design')
@section('content')
	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Shopping Cart</li>
				</ol>
			</div>
	        @if(session()->has('success_message'))
		        <br>
	          <div class="alert alert-success fade in">
	              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	              <p>{{session()->get('success_message')}}</p>
	          </div>
	        @elseif(session()->has('error_message'))
	           <br>
	          <div class="alert alert-danger fade in">
	              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	              <p>{{session()->get('error_message')}}</p>
	          </div>
		    @endif
			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="description"></td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<?php $total = 0; ?>
						@foreach($userCart as $cart)
							<tr>
								<td class="cart_product">
									<a href="{{url('product/'.$cart->product_id)}}">
										<img style="width: 120px;" src="{{asset('images/backend_images/products/sm/'.$cart->image)}}" alt="">
									</a>
								</td>
								<td class="cart_description">
									<h4><a href="{{url('product/'.$cart->product_id)}}">{{$cart->product_name}}</a></h4>
									<p>{{$cart->product_code}} | {{$cart->size}}</p>
								</td>
								<td class="cart_price">
									<p>$ {{$cart->price}}</p>
								</td>
								<td class="cart_quantity">
									<div class="cart_quantity_button">
										<a class="cart_quantity_up" href="{{url('/cart/update-quantity/'.$cart->id.'/1')}}"> + </a>
										<input class="cart_quantity_input" type="text" name="quantity" value="{{$cart->quantity}}" autocomplete="off" size="2">
										@if($cart->quantity > 1)
										<a class="cart_quantity_down" href="{{url('/cart/update-quantity/'.$cart->id.'/-1')}}"> - </a>
										@endif
									</div>
								</td>
								<td class="cart_total">
									<p class="cart_total_price">$ {{ $cart->quantity * $cart->price}}</p>
								</td>
								<td class="cart_delete">
									<a class="cart_quantity_delete" href="{{url('cart/delete-product', $cart->id)}}"><i class="fa fa-times"></i></a>
								</td>
							</tr>
							<?php $total +=  $cart->quantity * $cart->price; ?>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section> <!--/#cart_items-->

	<section id="do_action">
		<div class="container">
			<div class="heading">
				<h3>What would you like to do next?</h3>
				<p>If you have a coupon code want to use.</p>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="chose_area">
						<ul class="user_option">
							<li>
								<form action="{{url('/cart/apply-coupon')}}" method="post">
									{{csrf_field()}}
									<label>Coupon Code</label>
									<input type="text" name="coupon_code">
									<input type="submit" value="Apply" class="btn btn-default">
								</form>
							</li>
						</ul>
					</div>
				</div>

				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							@if (! empty(session('couponCode')))
								<li>Sub Total <span>$ {{$total}}</span></li>
								<li>Discond <span>$ {{session('couponAmount')}}</span></li>
								<li>Grand Total <span>$ {{$total - session('couponAmount')}}</span></li>
							@else
								<li>Total <span>$ {{$total}}</span></li>
							@endif
						</ul>
							<a class="btn btn-default update" href="">Update</a>
							<a class="btn btn-default check_out" href="">Check Out</a>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->
@endsection
