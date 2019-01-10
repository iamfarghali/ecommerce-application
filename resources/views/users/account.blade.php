@extends('layouts.frontLayout.front_design')
@section('content')
		<section id="form" style="margin-top: 20px;">
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<!--login form-->
					<div class="login-form">
						<h2>Update Account Info</h2>
						<form id="accountForm" name="accountForm" action="{{url('/account')}}" method="post">
							{{csrf_field()}}
							<input type="hidden" name="user_id" value="{{ $userDetails->id }}">
							<input id="name" type="text" name="name" value="{{ $userDetails->name }}">
							<input id="address" type="text" name="address" placeholder="Address" value="{{ $userDetails->address }}">
							<input id="city" type="text" name="city" placeholder="City" value="{{ $userDetails->city }}">
							<input id="state" type="text" name="state" placeholder="State" value="{{ $userDetails->state }}">
							<select name="country" id="country" style="margin-bottom: 10px;">
								<option value="">Select Country</option>
								@foreach( $countries as $country )
									<option value="{{$country->country_name}}" @if( $userDetails->country == $country->country_name ) selected @endif >
										{{$country->country_name}}
									</option>
								@endforeach
							</select>
							<input id="pincode" type="text" name="pincode" placeholder="Pincode" value="{{ $userDetails->pincode }}">
							<input id="mobile" type="text" name="mobile" placeholder="Mobile" value="{{ $userDetails->mobile }}">
							<button type="submit" class="btn btn-default">Update</button>
						</form>
					</div>
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<!--sign up form-->
					<div class="signup-form">
						<h2>Update Password</h2>
						<form id="updatePasswordForm" name="updatePasswordForm" action="{{url('/update-password')}}" method="post">
							<input id="csrf-token" type="hidden" name="_token" value="{{csrf_token()}}">
							<input id="curPassword" type="password" name="currentPassword" placeholder="Current Password">
							<input id="newPassword" type="password" name="newPassword" placeholder="New Password">
							<input id="conPassword" type="password" name="confirmPassword" placeholder="Confirm Password">
							<button type="submit" class="btn btn-default">Update</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection