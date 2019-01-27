@extends('layouts.frontLayout.front_design')
@section('content')
	<section id="form" style="margin-top: 20px;">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{url('/')}}">Home</a></li>
				  <li class="active">Order Review</li>
				</ol>
			</div>
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form">
						<h2>Billing Detials</h2>
						<div class="form-group"> {{$user->name}} </div>
						<div class="form-group"> {{$user->address}} </div>
						<div class="form-group"> {{$user->city}} </div>
						<div class="form-group"> {{$user->state}} </div>
						<div class="form-group"> {{$user->country}} </div>
						<div class="form-group"> {{$user->pincode}} </div>
						<div class="form-group"> {{$user->mobile}} </div>
					</div>
				</div>
				<div class="col-sm-1">
					<h2></h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form">
						<h2>Shipping Details</h2>
						<div class="form-group"> {{$shippingAddress->name}} </div>
						<div class="form-group"> {{$shippingAddress->address}} </div>
						<div class="form-group"> {{$shippingAddress->city}} </div>
						<div class="form-group"> {{$shippingAddress->state}} </div>
						<div class="form-group"> {{$shippingAddress->country}} </div>
						<div class="form-group"> {{$shippingAddress->pincode}} </div>
						<div class="form-group"> {{$shippingAddress->mobile}} </div>
					</div>
				</div>
			</div>

			<section id="cart_items">
				<div class="review-payment">
					<h2>Review & Payment</h2>
				</div>
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
							<?php $total_price =0; ?>
							@foreach($userCart as $item)
								<?php $total_price += $item->quantity*$item->price; ?>
								<tr>
									<td class="cart_product">
										<a href=""><img src="{{asset("images/backend_images/products/sm/$item->image")}}" width="100px" height="100px" alt=""></a>
									</td>
									<td class="cart_description">
										<h4><a href="">{{$item->product_name}}</a></h4>
										<p>{{$item->product_code}}</p>
									</td>
									<td class="cart_price">
										<p>$ {{$item->price}}</p>
									</td>
									<td class="cart_quantity">
										<div class="cart_quantity_button">
											<label class="cart_quantity_input">{{$item->quantity}}</label>
										</div>
									</td>
									<td class="cart_total">
										<p class="cart_total_price">${{$item->quantity*$item->price}}</p>
									</td>
									<td class="cart_delete">
										<a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
									</td>
								</tr>
							@endforeach

							<tr>
								<td colspan="4">&nbsp;</td>
								<td colspan="2">
									<table class="table table-condensed total-result">
										<tr>
											<td>Cart Sub Total</td>
											<td>$ {{$total_price}}</td>
										</tr>
										<tr>
											<td>Discount Amount</td>
											<td>$ @if(!empty(session()->get('couponAmount'))) {{session()->get('couponAmount')}} @else 0 @endif</td>
										</tr>
										<tr class="shipping-cost">
											<td>Shipping Cost</td>
											<td>Free</td>										
										</tr>
										<tr>
											<td>Total</td>
											<td><span>$ @if(!empty(session()->get('couponAmount'))) {{$grand_total = $total_price - session()->get('couponAmount')}} @else {{$grand_total = $total_price}} @endif</span></td>
										</tr>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<form id="paymentForm" name="paymentForm" action="{{url('/place-order')}}" method="post" accept-charset="utf-8">
					{{csrf_field()}}
					<input type="hidden" name="grand_total" value="{{$grand_total}}">
					<div class="payment-options">
						<span>
							<label><strong>Select Payment Method : </strong></label>
						</span>
						<span>
							<label><input type="radio" name="payment_method" id="COD" value="COD"><strong> COD</strong></label>
						</span>
						<span>
							<label><input type="radio" name="payment_method" id="Paypal" value="Paypal"><strong> Paypal</strong></label>
						</span>
						<span style="float:right;">
							<button type="submit" class="btn btn-default"> Place Order </button>
						</span>
					</div>

				</form>

			</section>
		</div>
	</section>
@endsection
