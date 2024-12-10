<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="{{ asset('img/faveicon.png') }}" />
<title>Otp</title>

<!-- Bootstrap -->
<link href="{{asset('vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
<!-- Font Awesome -->
<link href="{{asset('vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
<!-- NProgress -->
<link href="{{asset('vendors/nprogress/nprogress.css')}}" rel="stylesheet">
<!-- Animate.css -->
<link href="{{asset('vendors/animate.css/animate.min.css')}}" rel="stylesheet">

<!-- Custom Theme Style -->
<link href="{{asset('build/css/custom.min.css')}}" rel="stylesheet">
<link href="{{asset('build/css/style.css')}}" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>

<body class="login">
<div> <a class="hiddenanchor" id="signup"></a> <a class="hiddenanchor" id="signin"></a>
<div class="login_wrapper">
<div class="animate form login_form">
<section class="login_content "> 

<!--dons-->
<div class="login-box">
<div class="container">
<div class="row">
<div class="col-md-6">
<div class="login-left-box text-center">
<!-- <h2>Now go any place<br>with full energy</h2>
<p>In order to have clean air in your cities, you have to Electric</p> -->
</div>
</div>
<div class="col-md-6">
<div class="user_card">
@if(!empty($error))
        <div class="alert alert-danger alert-dismissible position-absolute login-alert px-2 pt-2 pb-1">
            <button type="button" class="close pl-2 pr-2 py-1 m-0" data-dismiss="alert"  aria-hidden="true aria-label="Close">
            &times;
            </button>
            {{$error}}
        </div>
    @endif
 <div class="login-logo w-100 my-2">
 <img src="{{asset('production/images/logo.svg')}}" class="img-fluid" alt="logo">
 </div>     
<div class="d-flex justify-content-center form_container">
<form method="post">
<div class="input-group mb-2">
<input type="password" name="otp" id="otp" class="form-control input_pass" value="" placeholder="OTP">
</div>
<div class="form-group text-left">
</div>
<div class="d-flex justify-content-center mt-3 login_container">
<button type="submit" name="button" class="btn login_btn">Sign in</button>
</div>
<div class="d-flex justify-content-end links resendotp"> <a href="#" onclick="resendotp()">Resend OTP</a> </div>
{{ csrf_field() }}
</form>

</div>
    <p class="color-green pt-3">OTP has send to your email address</p>
<div class="mt-4"> </div>
</div>
</div>
</div>
</div>
</div>

</section>
</div>
<div id="register" class="animate form registration_form">
<section class="login_content">
<form>
<h1>Create Account</h1>
<div>
<input type="text" class="form-control" placeholder="Username" required="" />
</div>
<div>
<input type="email" class="form-control" placeholder="Email" required="" />
</div>
<div>
<input type="password" class="form-control" placeholder="Password" required="" />
</div>
<div> <a class="btn btn-default submit" href="index.html">Submit</a> </div>
<div class="clearfix"></div>
<div class="separator">
<p class="change_link">Already a member ? <a href="#signin" class="to_register"> Log in </a> </p>
<div class="clearfix"></div>
<br />
<div>
<h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
<p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 4 template. Privacy and Terms</p>
</div>
</div>
</form>
</section>

</div>
</div>

</div>
<script type="text/javascript">
	 

      function resendotp(){
        $.ajax({
        	 type: "POST",
            url: '{{ url("/") }}/admin/resend_otp',
             data: {
        "_token": "{{ csrf_token() }}"
        
        },
            dataType : 'json',
              success: function (data) {


            }
        });
    }
   
</script>
 <script src="{{asset('vendors/jquery/dist/jquery.min.js')}}"></script>
   <script src="{{asset('vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
</body>
</html>
