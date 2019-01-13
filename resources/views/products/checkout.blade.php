@extends('layouts.frontLayout.front_design')
@section('content')
	<section id="form" style="margin-top: 20px;">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{url('/')}}">Home</a></li>
				  <li class="active">Check out</li>
				</ol>
			</div>
			<form action="{{url('/checkout')}}" method="post">
				{{csrf_field()}}
				<div class="row">
					<div class="col-sm-4 col-sm-offset-1">
						<div class="login-form">
							<h2>Bill To</h2>
							<div class="form-group">
								<input class="form-control" type="text" id="billing_name" name="billing_name" value="{{$user->name}}" placeholder="Billing Name" />
							</div>
							<div class="form-group">
								<input class="form-control" type="text" id="billing_address" name="billing_address" value="{{$user->address}}" placeholder="Billing Address" />
							</div>
							<div class="form-group">
								<input class="form-control" type="text" id="billing_city" name="billing_city" value="{{$user->city}}" placeholder="Billing City" />
							</div>
							<div class="form-group">
								<input class="form-control" type="text" id="billing_state" name="billing_state" value="{{$user->state}}" placeholder="Billing State" />
							</div>
							<div class="form-group">
								<select  class="form-control" name="billing_country" id="billing_country">
									<option value="">Select Country</option>
									@foreach( $countries as $country )
										<option value="{{$country->country_name}}" @if( $user->country == $country->country_name ) selected @endif >
											{{$country->country_name}}
										</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<input class="form-control" type="text" id="billing_pincode" name="billing_pincode" value="{{$user->pincode}}" placeholder="Billing Pincode" />
							</div>
							<div class="form-group">
								<input class="form-control" type="text" id="billing_mobile" name="billing_mobile" value="{{$user->mobile}}" placeholder="Billing Mobile" />
							</div>
							<div class="form-check">
								<input type="checkbox" class="form-check-input" id="billToShip">
								<label class="form-check-label" for="billToShip"> Shipping address is same as billing address</label>
							</div>
						</div>
					</div>
					<div class="col-sm-1">
						<h2></h2>
					</div>
					<div class="col-sm-4">
						<div class="signup-form">
							<h2>Ship To</h2>
							<div class="form-group">
								<input class="form-control" type="text" id="shipping_name" name="shipping_name" value="{{$shippingAddresses->name}}" placeholder="Shipping Name" />
							</div>
							<div class="form-group">
								<input class="form-control" type="text" id="shipping_address" name="shipping_address" value="{{$shippingAddresses->address}}" placeholder="Shipping Address" />
							</div>
							<div class="form-group">
								<input class="form-control" type="text" id="shipping_city" name="shipping_city" value="{{$shippingAddresses->city}}" placeholder="Shipping City" />
							</div>
							<div class="form-group">
								<input class="form-control" type="text" id="shipping_state" name="shipping_state" value="{{$shippingAddresses->state}}" placeholder="Shipping State" />
							</div>
							<div class="form-group">
								<select  class="form-control" name="shipping_country" id="shipping_country">
									<option value="">Select Country</option>
									@foreach( $countries as $country )
										<option value="{{$country->country_name}}"  @if( $shippingAddresses->country == $country->country_name ) selected @endif >
											{{$country->country_name}}
										</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<input class="form-control" type="text" id="shipping_pincode" name="shipping_pincode" value="{{$shippingAddresses->pincode}}" placeholder="Shipping Pincode" />
							</div>
							<div class="form-group">
								<input class="form-control" type="text" id="shipping_mobile" name="shipping_mobile" value="{{$shippingAddresses->mobile}}"placeholder="Shipping Mobile" />
							</div>
							<button type="submit" class="btn btn-default">Checkout</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
@endsection