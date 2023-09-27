<!DOCTYPE html>
<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 11 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
	<head>
		<base href="../../../../">
		<meta charset="utf-8" />
		<title>Dashboard Login</title>
		<meta name="description" content="Login page example" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="https://keenthemes.com/metronic" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Custom Styles(used by this page)-->
		<link href="<?php echo base_url();?>template/metronic/dist/assets/css/pages/login/classic/login-5.css" rel="stylesheet" type="text/css" />
		<!--end::Page Custom Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="<?php echo base_url();?>template/metronic/dist/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>template/metronic/dist/assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>template/metronic/dist/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="<?php echo base_url();?>template/metronic/dist/assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>template/metronic/dist/assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>template/metronic/dist/assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url();?>template/metronic/dist/assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="<?php echo base_url();?>template/metronic/dist/assets/media/logos/favicon.ico" />
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-5 login-signin-on d-flex flex-row-fluid" id="kt_login">
				<div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid" style="background-image: url(<?php echo base_url();?>template/metronic/dist/assets/media/bg/bg-2.jpg);">
					<div class="login-form text-center text-white p-7 position-relative overflow-hidden">
						<!--begin::Login Header-->
						<div class="d-flex flex-center mb-15">
							<a href="#">
								<img src="<?php echo base_url();?>assets/logo/Logo_FieldPass.png" class="max-h-75px" alt="" />
							</a>
						</div>
						<!--end::Login Header-->
						<!--begin::Login Sign in form-->
						<div class="login-signin">
							<div class="mb-20">
								<h3 class="opacity-40 font-weight-normal">Sign In To Dashboard</h3>
								<p class="opacity-40">Enter your details to login to your account</p>
							</div>
							<form class="form" id="kt_login_signin_form">
								<div class="form-group">
									<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8 login-email" type="text" placeholder="Email" name="email" autocomplete="off" />
								</div>
								<div class="form-group">
									<div class="input-group">
										<input class="form-control h-auto text-white bg-white-o-5 rounded-left border-0 py-4 px-8 login-password" style="border-top-left-radius:50rem !important;border-bottom-left-radius:50rem !important;" type="password" placeholder="Password" name="password" />
										<div class="input-group-append">
											<button class="btn btn-secondary bg-white-o-5 view_password rounded-right rounded border-0" type="button" style="border-top-right-radius:50rem !important;border-bottom-right-radius:50rem !important;display: none;"><i class="text-dark-50 icon-md far fa-eye"></i></button>
											<button class="btn btn-secondary  bg-white-o-5 unview_password rounded-right rounded border-0" type="button" style="border-top-right-radius:50rem !important;border-bottom-right-radius:50rem !important;" ><i class="text-dark-50 icon-md far fa-eye-slash"></i></button>
										</div>
									</div>
								</div>
								<div class="form-group d-flex flex-wrap justify-content-between align-items-center px-8 opacity-60">
									<div class="checkbox-inline">
										<label class="checkbox checkbox-outline checkbox-white text-white m-0">
										<input type="checkbox" name="remember" class="remember-me"/>
										<span></span>Remember me</label>
									</div>
									 <!--<a href="javascript:;" id="kt_login_forgot" class="text-white font-weight-bold">Forget Password ?</a>-->
								</div>
								<div class="form-group text-center mt-10">
									<button id="kt_login_signin_submit" class="btn btn-pill btn-primary opacity-90 px-15 py-3">Sign In</button>
								</div>
							</form>
                                                        <!--
							<div class="mt-10">
								<span class="opacity-40 mr-4">Don't have an account yet?</span>
								<a href="javascript:;" id="kt_login_signup" class="text-white opacity-30 font-weight-normal">Sign Up</a>
							</div>
                                                        -->
						</div>
						<!--end::Login Sign in form-->
						<!--begin::Login Sign up form-->
						<div class="login-signup">
							<div class="mb-20">
								<h3 class="opacity-40 font-weight-normal">Sign Up</h3>
								<p class="opacity-40">Enter your details to create your account</p>
							</div>
							<form class="form text-center" id="kt_login_signup_form">
								<div class="form-group">
									<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="text" placeholder="Fullname" name="fullname" />
								</div>
								<div class="form-group">
									<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="text" placeholder="Email" name="email" autocomplete="off" />
								</div>
								<div class="form-group">
									<div class="input-group">
										<input class="form-control h-auto text-white bg-white-o-5 rounded-left border-0 py-4 px-8" style="border-top-left-radius:50rem !important;border-bottom-left-radius:50rem !important;" type="password" placeholder="Password" name="password" />
										<div class="input-group-append">
											<button class="btn btn-secondary bg-white-o-5 view_password rounded-right rounded border-0" type="button" style="border-top-right-radius:50rem !important;border-bottom-right-radius:50rem !important;display: none;"><i class="text-dark-50 icon-md far fa-eye"></i></button>
											<button class="btn btn-secondary  bg-white-o-5 unview_password rounded-right rounded border-0" type="button" style="border-top-right-radius:50rem !important;border-bottom-right-radius:50rem !important;" ><i class="text-dark-50 icon-md far fa-eye-slash"></i></button>
										</div>
									</div>
								</div>
								<div class="form-group">
									<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="password" placeholder="Confirm Password" name="cpassword" />
								</div>
								<div class="form-group text-left px-8">
									<div class="checkbox-inline">
										<label class="checkbox checkbox-outline checkbox-white opacity-60 text-white m-0">
										<input type="checkbox" name="agree" />
										<span></span>I Agree the
										<a href="#" class="text-white font-weight-bold ml-1">terms and conditions</a>.</label>
									</div>
									<div class="form-text text-muted text-center"></div>
								</div>
								<div class="form-group">
									<button id="kt_login_signup_submit" class="btn btn-pill btn-primary opacity-90 px-15 py-3 m-2">Sign Up</button>
									<button id="kt_login_signup_cancel" class="btn btn-pill btn-outline-white opacity-70 px-15 py-3 m-2">Cancel</button>
								</div>
							</form>
						</div>
						<!--end::Login Sign up form-->
						<!--begin::Login forgot password form-->
						<div class="login-forgot">
							<div class="mb-20">
								<h3 class="opacity-40 font-weight-normal">Forgotten Password ?</h3>
								<p class="opacity-40">Enter your email to reset your password</p>
							</div>
							<form class="form" id="kt_login_forgot_form">
								<div class="form-group mb-10">
									<input class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8" type="text" placeholder="Email" name="email" autocomplete="off" />
								</div>
								<div class="form-group">
									<button id="kt_login_forgot_submit" class="btn btn-pill btn-primary opacity-90 px-15 py-3 m-2">Request</button>
									<button id="kt_login_forgot_cancel" class="btn btn-pill btn-outline-white opacity-70 px-15 py-3 m-2">Cancel</button>
								</div>
							</form>
						</div>
						<!--end::Login forgot password form-->
					</div>
				</div>
			</div>
			<!--end::Login-->
		</div>
		<!--end::Main-->
		
		<script type="text/javascript">
			var baseUrl = '<?php echo base_url() ?>';
		</script>
		
		<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="<?php echo base_url();?>template/metronic/dist/assets/plugins/global/plugins.bundle.js"></script>
		<script src="<?php echo base_url();?>template/metronic/dist/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="<?php echo base_url();?>template/metronic/dist/assets/js/scripts.bundle.js"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Scripts(used by this page)-->
		<script src="<?php echo base_url();?>template/metronic/dist/assets/js/pages/custom/login/login-general.js?v=<?php echo time();?>"></script>
		<!--end::Page Scripts-->
	
		<script type="text/javascript">
	
			$(function() {
				
				if (localStorage.getItem("email") && localStorage.getItem("password") === null) 
				{
					$('.login-email').val("")
					$('.login-password').val("")
				}
				else
				{
					$('.login-email').val(localStorage.getItem("email"))
					$('.login-password').val(localStorage.getItem("password"))
				}	
				
				$('.view_password, .unview_password').click(function()
				{
					var input = $(this).parents('.input-group').find('input');
		
					if (input.attr("type") == "password") 
					{
						// alert('zas here');
						$(this).css('display', 'none');
						$(this).parents('.input-group-append').find('.view_password').css('display', 'inline-block');
						input.attr("type", "text");
					} 
					else 
					{
						$(this).css('display', 'none');
						$(this).parents('.input-group-append').find('.unview_password').css('display', 'inline-block');
						input.attr("type", "password");
					}
				});
				
				
				$('#individual-option').change(function(){
					var state = $(this).is(":checked");
					
					if(state == true)
					{
						$('.register-fullname').attr("placeholder", "Name");	
					}
					
				});
				
				
				$('#organization-option').change(function(){
					var state = $(this).is(":checked");
					
					if(state == true)
					{
						$('.register-fullname').attr("placeholder", "Organization Name");
					}
					
				});
				
				
				$('#host-option').change(function(){
					var state = $(this).is(":checked");
					
					if(state == true)
					{
						$('.register-fullname').attr("placeholder", "Centres Name");
					}
					
				});
				
			});
	
		</script>
		
	</body>
	<!--end::Body-->
</html>