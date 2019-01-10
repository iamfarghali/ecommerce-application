@extends('layouts.frontLayout.front_design')
@section('content')
		<section id="form">
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<!--login form-->
					<div class="login-form">
						<h2>Login to your account</h2>
						<form id="loginForm" action="{{url('/login-user')}}" method="post">
							{{csrf_field()}}
							<input name="email" id="l-email" type="email" placeholder="Email Address" />
							<input name="password" id="l-password" type="password" placeholder="Password" />
{{-- 							<span>
								<input type="checkbox" class="checkbox"> 
								Keep me signed in
							</span> --}}
							<button type="submit" class="btn btn-default">Login</button>
						</form>
					</div>
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<!--sign up form-->
					<div class="signup-form">
						<h2>New User Signup!</h2>
						<form id="signupForm" method="post" action="{{url('/user-register')}}">
							{{csrf_field()}}
							<input id="r-name" name="name" type="text" placeholder="Name"/>
							<input id="r-email" name="email" type="email" placeholder="Email Address"/>
							<input id="r-password" name="password" type="password" placeholder="Password"/>
							<button type="submit" class="btn btn-default">Signup</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection