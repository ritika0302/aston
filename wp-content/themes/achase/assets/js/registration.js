(function ($, root, undefined) {

	$(function () {
		'use strict';

		   jQuery("#reset_pwd_frm").validate({
        	errorElement: 'span',
        	errorClass: 'auth-error',
			rules: {
				"password": {
					required: true,
					minlength: "6"
				},
				"cpassword": {
					required: true,
					minlength: "6",
					equalTo: "#password"
				},
				
			},

			messages: {
				"password": {
					required: "Required field.",
					minlength: "Password is not less than 6 character."
				},
				"cpassword": {
					required: "Required field.",
					minlength: "Password is not less than 6 character."
				},
				
			},
			submitHandler: function(form) {

				var datas = $( "#reset_pwd_frm" ).serialize() + '&action=fn_reset_password';
				var $alert = $( "#reset_pwd_frm_alert" );
				$.ajax({
						type 		: 'post',
		          		url  		: ast_var.admin_ajax,
		          		data 		: datas,
		          		dataType 	: 'json',
		          		success 	: function( response ) {
		          			
							$alert.fadeIn( 'slow' );
							$alert.html( response.alert );
							if( response.code == 1 ){

								$alert.removeClass( 'alert-danger' );
								$alert.addClass( 'alert-success' );
					
				                setTimeout(function(){
						                    window.location.href = response.login_redirect;
						                }, 2000);
							}
							else{

								$alert.removeClass( 'alert-success' );
								$alert.addClass( 'alert-danger' );

							}
			
		          		},
		          		error: function (xhr, ajaxOptions, thrownError) {
			       		//$( "#registartion_alert" ).fadeIn( 'slow' );
			       		//$( "#registartion_alert" ).addClass( 'alert-danger' );
						//$( "#registartion_alert" ).html("Password reset link not sent.");
			      		},
					});
					
					return false;
			}
	    });

		 jQuery("#register_form").validate({
        	ignore: ".ignore",
        	errorElement: 'span',
        	errorClass: 'auth-error',
			rules: {
				"uname": "required",
				"gdpr" : "required",
				
				"emailid": {
					required: true,
					email: true
				},
				"password": {
					required: true,
					minlength: "6"
				},
				"cpassword": {
					required: true,
					minlength: "6",
					equalTo: "#password"
				},
				
			},

			messages: {
				"uname": "Required field.",
				"gdpr": "GDPR checkbox is required.",
				"emailid": {
					required: "Required field.",
					email: "Enter valid email address."
				},
				"password": {
					required: "Required field.",
					minlength: "Password must be bigger then 6 characters."
				},
				"cpassword": {
					required: "Required field.",
					minlength: "Password must be bigger then 6 characters."
				},
				
			},
			
			
			submitHandler: function(form) {
					var datas = $( "#register_form" ).serialize() + '&action=fn_Registration';
					var $alert = $( "#registartion_alert" );
					$.ajax({
						type 		: 'post',
		          		url  		: ast_var.admin_ajax,
		          		data 		: datas,
		          		dataType 	: 'json',
		          		beforeSend: function(){
		                    jQuery("#register_submit_btn").prop('disabled', true);
		                    jQuery(".auth-ajax-loder").show();
		                },
		          		success 	: function( response ) {
		          			$alert.fadeIn( 'slow' );
							$alert.html( response.alert );
							if( response.code == 1 ){
								$alert.removeClass( 'alert-danger' );
								$alert.addClass( 'alert-success' );
								
							}else
							{
								$alert.removeClass( 'alert-success' );
								$alert.addClass( 'alert-danger' );
								
							}
		          		},
		          		error: function (xhr, ajaxOptions, thrownError) {
			           		$alert.fadeIn( 'slow' );
				       		$alert.addClass( 'alert-danger' );
							$alert.html(thrownError);
							
				  		},
			      		complete: function(){
		                    jQuery("#register_submit_btn").prop('disabled', false);
		                    jQuery(".auth-ajax-loder").hide();
		                },
					});
					
					return false;	
			}

        });

		jQuery("#login_form").validate({
			errorElement: 'span',
        	errorClass: 'auth-error',
			rules: {
				"emailid": {
					required: true,
					email: true
				},
				"password": {
					required: true
				}
			},

			messages: {
				"emailid": {
					required: "Required field.",
					email: "Enter valid email address.",
				},
				"password": {
					required: "Required field.",
				}
			},
			submitHandler: function(form) {
				var data_s = jQuery( "#login_form" ).serialize() + '&action=fn_Login';
				var $alert = jQuery( "#registartion_alert" );
				jQuery.ajax({
					type 		: 'post',
	          		url  		: ast_var.admin_ajax,
	          		data 		: data_s,
	          		dataType 	: 'json',
	          		beforeSend: function(){
		                    jQuery("#login_submit_btn").prop('disabled', true);
		                    jQuery(".auth-ajax-loder").show();
		            },
	          		success 	: function( response ) {
	          			
	          			$alert.fadeIn( 'slow' );
						$alert.html( response.alert );

						if( response.code == 1 ){

							$alert.removeClass( 'alert-danger' );
							$alert.addClass( 'alert-success' );

							setTimeout(function(){
                	
			                    setTimeout(function(){
				                    $( "#registartion_alert" ).html( 'Redirecting...' );
				                }, 2000);

			                    setTimeout(function(){
				                    window.location.href = response.redirect;
				                }, 300);

			                }, 1000);

						}else{

							$alert.removeClass( 'alert-success' );
							$alert.addClass( 'alert-danger' );
						}
	          		},
	          		error: function (xhr, ajaxOptions, thrownError) {
			       		$alert.fadeIn( 'slow' );
			       		$alert.addClass( 'alert-danger' );
						$alert.html("Username or password is incorrect.");
			      	},
			      	complete: function(){
		                jQuery("#login_submit_btn").prop('disabled', false);
		                jQuery(".auth-ajax-loder").hide();
		            },
				});
				
				return false;
			}
		//	submitHandler: submitLogin

        });

        jQuery("#forgot_password_form").validate({
        	errorElement: 'span',
        	errorClass: 'auth-error',
			rules: {
				"emailid": {
					required: true,
					email: true,
				},
				"password": {
					required: true,
					minlength: "6"
				},
				"cpassword": {
					required: true,
					minlength: "6",
					equalTo: "#password"
				},
			},

			messages: {
				"emailid": {
					required: "Required field.",
					email: "Enter valid email address.",
				},
				"password": {
					required: "Required field.",
					minlength: "Password is not less than 6 character."
				},
				"cpassword": {
					required: "Required field.",
					minlength: "Password is not less than 6 character."
				},
			},
			submitHandler: function(form) {
					var datas = $( "#forgot_password_form" ).serialize() + '&action=fn_ForgotPassword';
					var $alert = $( "#registartion_alert" );
					$.ajax({
						type 		: 'post',
		          		url  		: ast_var.admin_ajax,
		          		data 		: datas,
		          		dataType 	: 'json',
		          		beforeSend: function(){
		                    jQuery("#forgot_password_submit_btn").prop('disabled', true);
		                    jQuery(".auth-ajax-loder").show();
		                },
		          		success 	: function( response ) {
		          			
							$alert.fadeIn( 'slow' );
							$alert.html( response.alert );

							if( response.code == 1 ){

								$alert.removeClass( 'alert-danger link-not-sent' );
								$alert.addClass( 'alert-success link-sent' );
								jQuery("input[type='email'][name='emailid']").val(''); 
								//jQuery(".alert-success.link-sent").delay(3000).fadeOut(800);
								//jQuery(".alert-danger.link-not-sent").delay(3000).fadeOut(800);

				
							}else if( response.code == 2 ){
								$alert.removeClass( 'alert-danger' );
								$alert.addClass( 'alert-success' );
								setTimeout(function(){
                	
					                    setTimeout(function(){
						                    $( "#registartion_alert" ).html( 'Redirecting...' );
						                }, 3000);

					                    setTimeout(function(){
						                    window.location.href = response.redirect;
						                }, 4000);

					                }, 1000);
	
							}else{

								$alert.removeClass( 'alert-success' );
								$alert.addClass( 'alert-danger' );
								//jQuery(".alert-danger").delay(3000).fadeOut(800);

							}
		          		},
		          		error: function (xhr, ajaxOptions, thrownError) {
			       			$alert.fadeIn( 'slow' );
			       			$alert.addClass( 'alert-danger' );
							$alert.html("Password reset link not sent.");
							//jQuery(".alert-danger").delay(4000).fadeOut(800);
			      		},
			      		complete: function(){
		                    jQuery("#forgot_password_submit_btn").prop('disabled', false);
		                    jQuery(".auth-ajax-loder").hide();
		                },
					});
					
					return false;	
			}
			

        });
        
       

        jQuery("#myprofile").validate({
        	errorElement: 'span',
        	errorClass: 'auth-error',
			rules: {
				"emailid": {
					required: true,
					email: true,
				},
				"uname": {
					required: true,
				},
				"telphone": {
					minlength: 10,
					maxlength: 15,
					digits: true,
				},
				"postcode": {
					maxlength: 8,
				},
			},

			messages: {
				"emailid": {
					required: "Required field.",
					email: "Enter valid email address.",
				},
				"uname": {
					required: "Required field.",
				},
				"telphone": {
					minlength: "Please enter at least 10 digit.",
				},
				"postcode": {
					maxlength: "Allow only 8 characters.",
				},
				
			},
			submitHandler: function(form) {
					var datas = $( "#myprofile" ).serialize() + '&action=fn_Profile_update';
					var $alert = $( "#profile_alert" );
					$.ajax({
						type 		: 'post',
		          		url  		: ast_var.admin_ajax,
		          		data 		: datas,
		          		dataType 	: 'json',
		          		success 	: function( response ) {
		          			
							$alert.fadeIn( 'slow' );
							$alert.html( response.alert );
							if( response.code == 1 ){

								$alert.removeClass( 'alert-danger' );
								$alert.addClass( 'alert-success' );
								setTimeout(function(){
                	
				                	$('body, html').animate({
						                scrollTop: 274
						            }, 'slow');

				                }, 1000);
							}
							else{

								$alert.removeClass( 'alert-success' );
								$alert.addClass( 'alert-danger' );

							}
			
		          		},
		          		error: function (xhr, ajaxOptions, thrownError) {
			       		//$( "#registartion_alert" ).fadeIn( 'slow' );
			       		//$( "#registartion_alert" ).addClass( 'alert-danger' );
						//$( "#registartion_alert" ).html("Password reset link not sent.");
			      		},
					});
					
					return false;

				},
        });

        var saved_val = jQuery(".savedproperties-section .dropdown-list li.active").text();
        jQuery(".savedproperties-section .dropdown-btn").text(saved_val);
	});

	  

/* Forgot Password */
 
})(jQuery, this);

