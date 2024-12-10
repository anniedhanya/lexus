<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Reset Password</title>

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
<!-- <div class="col-md-6">
<div class="login-left-box text-center">
<h2>Now go any place<br>with full energy</h2>
<p>In order to have clean air in your cities, you have to Electric</p>
</div>
</div> -->
<div class="col-md-6">
<div class="user_card">
     @if(!empty($error))
        <div class="alert alert-danger alert-dismissible position-absolute login-alert px-2 pt-2 pb-1">
            <button type="button" class="close pl-2 pr-2 py-1 m-0" data-dismiss="alert" aria-hidden="true" aria-label="Close">
             &times;
            </button>
            {{$error}}
        </div>
    @endif
    @if(session()->has('successmsg'))
              <div class="alert alert-success alert-dismissable position-absolute login-alert px-2 pt-2 pb-1">
               <button type="button" class="close pl-2 pr-2 py-1 m-0" data-dismiss="alert" aria-hidden="true" aria-label="Close">
             &times;
            </button>
              {{ session()->get('successmsg') }}
               </div>
    @endif
    @if (!empty($msg))
       <div class="form-group">
        <div class="alert alert-success alert-dismissable position-absolute login-alert px-2 pt-2 pb-1">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{$msg}}
        </div>
        </div>

    @endif   
    <div class="login-logo w-100 my-2">
 <img src="{{asset('production/images/logo-ibell.png')}}" class="img-fluid" alt="logo">
 </div>                                      
<div class="d-flex justify-content-center form_container">

 <form action="" class="form-horizontal js-parsley" method="POST">

<div class="input-group mb-0 forg-pass">
<h2>Reset Password</h2>
</div>
 <div class="form-group{{ $errors->has('Mailserver') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="hidden" id="Mailserver" name="Mailserver" id="Mailserver" value=<?php echo env('APP_ENV'); ?> >

                                @if ($errors->has('Mailserver'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Mailserver') }}</strong>
                                    </span>
                                @endif
                            </div>
</div>

<div class="input-group mb-2">
<input name="email" type="text" class="form-control input_pass" placeholder="E-Mail Address" class="form-control" name="email" value="{{ old('email') }}" required>
                             <span class="form-control-feedback"></span>  

</div>
@if ($errors->has('email'))
                         <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
<div class="form-group text-left">

</div>
<div class="d-flex justify-content-center mt-3 login_container">
<button type="submit" name="button" class="btn login_btn m-0">Send Password Reset Link</button>
</div>

                           

{{ csrf_field() }}
</form>
</div>
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
</body>
</html>
