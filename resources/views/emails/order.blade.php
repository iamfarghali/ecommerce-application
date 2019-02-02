<html>
<head>
	<title>Order Placed - E-Commerce Website</title>
</head>
<body>
	<table width="700px" border="0" cellpadding="5px" cellspacing="2px">
		<tr><td>&nbsp;</td></tr>
		<tr><td> <img src="{{asset('images/frontend_images/home/logo.png')}}"> </td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Hi, {{$name}}</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Thanks for shipping with us. Your order details are as below:-</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Order No. : {{$order_id}}</td></tr>
		<tr><td>&nbsp;</td></tr>
	</table>
</body>
</html>