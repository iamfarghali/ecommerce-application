/*price range*/

 $('#sl2').slider();

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};	
		
/*scroll to top*/

$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});

$(document).ready(function(){
	$("#selSize").change(function() {
		var idSize = $(this).val();
		if (idSize == "") { return false; }
		$.ajax({
			type:'get',
			url:'http://localhost/ecommerce-application/public/get-product-price',
			data:{idSize:idSize},
			success: function(res) {
				if (res.stock == 0) {
					$('#cartBtn').hide();
					$('#availability').text('Out Of Stock');
				} else {
					$('#cartBtn').show(); 
					$('#availability').text('In Stock');
				}
				$("#product-price").empty().append(' $ '+res.price);
				$("#price").attr('value', res.price);
				$("#sku").attr('value', res.sku);
				$("#product-stock").attr('value', res.stock);
			},
			error: function() {
				alert('Error: get-product-price');
			}
		});
	});

	// Change main image with alt images
	$('.changeImage').click(function(e) {
		e.preventDefault();
		var image = $(this).attr('src');
		$('.mainImage').attr('src', image);
		// alert(image);
	});

	// Instantiate EasyZoom instances
	var $easyzoom = $('.easyzoom').easyZoom();

	// Setup thumbnails example
	var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

	$('.thumbnails').on('click', 'a', function(e) {
		var $this = $(this);

		e.preventDefault();

		// Use EasyZoom's `swap` method
		api1.swap($this.data('standard'), $this.attr('href'));
	});

	// Setup toggles example
	var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

	$('.toggle').on('click', function() {
		var $this = $(this);

		if ($this.data("active") === true) {
			$this.text("Switch on").data("active", false);
			api2.teardown();
		} else {
			$this.text("Switch off").data("active", true);
			api2._init();
		}
	});
});

$().ready(function() {
	$('#signupForm').validate({
		rules:{
			name:{
				required:true,
				minlength:2,
				accept:"[a-zA-Z]+"
			},
			password:{
				required:true,
				minlength:6
			},
			email:{
				required:true,
				email:true,
				remote:"http://localhost/ecommerce-application/public/check-email"
			}
		},
		messages:{
			name:{
				required:"Name is required.",
				minlength:"Your name must be more than 2 characters.",
				accept:"Enter characters only."
			},
			password:{
				required:"Password is required.",
				minlength:"Your password must be more than 6 characters."
			},
			email:{
				required:"Email is required.",
				remote:"Email is already exist."
			}
		}

	});

	$('#loginForm').validate({
		rules:{
			password:{
				required:true
			},
			email:{
				required:true,
				email:true
			}
		},
		messages:{
			password:{
				required:"Password is required."
			},
			email:{
				required:"Email is required.",
				email:"Your email is not valid."
			}
		}
	});

	$('#accountForm').validate({
		rules:{
			name:{
				required:true,
				minlength:2,
				accept:"[a-zA-Z]+"
			},
			address:{
				required:true
			},
			city:{
				required:true
			},
			state:{
				required:true
			},
			country:{
				required:true
			},
			pincode:{
				required:true
			},
			mobile:{
				required:true,
				accept:"[0-9]+"
			}
		},
		messages:{
			name:{
				required:"Name is required.",
				minlength:"Your name must be more than 2 characters.",
				accept:"Enter characters only."
			},
			address:{
				required:"Address is required."
			},
			city:{
				required:"City is required."
			},
			state:{
				required:"State is required."
			},
			country:{
				required:"Country is required."
			},
			pincode:{
				required:"Pincode is required."
			},
			mobile:{
				required:"Mobile Number is required.",
				accept:"Enter numbers only."
			}
		}
	});

	$('#r-password').passtrength({
		minChars: 6,
		passwordToggle: true,
		tooltip: true,
		eyeImg: "eye.svg"
	});

	$("#newPassword").click(function() {
		var curPass = $("#curPassword").val();
		var csrfToken = $("#csrf-token").val();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': csrfToken
			},
			type:'post',
			url:'check-user-password',
			data:{currentPassword:curPass},
			success: function(res) {
				if (res == 'false') {
					$('font').remove();
					$('#curPassword').after('<font style="color:red;">Incorrect Password, Try Again.</font>');
				}
				else if (res == 'true') {
					$('font').remove();
					$('#curPassword').after('<font style="color:green;">Correct Password.</font>');
				} 
				else {
					$('font').remove();
					$('#curPassword').after('<font style="color:#c9c9c9;">Checking...</font>');
				}
			},
			error: function() {
				alert('Error');
			}
		});
	});

	$("#billToShip").click(function() {
		if(this.checked) {
			$("#shipping_name").val($("#billing_name").val());
			$("#shipping_address").val($("#billing_address").val());
			$("#shipping_city").val($("#billing_city").val());
			$("#shipping_country").val($("#billing_country").val());
			$("#shipping_pincode").val($("#billing_pincode").val());
			$("#shipping_mobile").val($("#billing_mobile").val());
		} else {
			$("#shipping_name").val('');
			$("#shipping_address").val('');
			$("#shipping_city").val('');
			$("#shipping_country").val('');
			$("#shipping_pincode").val('');
			$("#shipping_mobile").val('');
		}
	});
});

