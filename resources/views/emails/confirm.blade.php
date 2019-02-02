<html>
<head>
	<title>Confirmation Account</title>
</head>
<body>
	<table>
		<tr><td>Dear {{$name}}</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Your account has been successfully created.<br>
				But we need you to confirm your account Plz.
		</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td><a href="{{url('confirm/'.$code)}}">Click Here To Confirm</a></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Thanks.</td></tr>
		<tr><td>E-Commerce Website.</td></tr>
	</table>
</body>
</html>