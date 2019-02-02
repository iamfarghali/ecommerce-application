<html>
<head>
	<title>Welcome Email</title>
</head>
<body>
	<table>
		<tr><td>Dear {{$name}}</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Your account has been successfully activated.<br>You can login now.</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td><a href="{{url('/login-register')}}">Login</a></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Thanks.</td></tr>
		<tr><td>E-Commerce Website.</td></tr>
	</table>
</body>
</html>