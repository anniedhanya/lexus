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
<div class="col-md-6">
<div class="login-left-box text-center">
<h2>Now go any place<br>with full energy</h2>
<p>In order to have clean air in your cities, you have to Electric</p>
</div>
</div>
<div class="col-md-6">
<div class="user_card">
   
      @if (session('status'))
                      <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
    @if (!empty($errors) && count($errors) > 0)
                                            <div class="form-group">
                                                <div class="alert alert-danger alert-dismissable reset-field-one position-absolute login-alert login-alert-list-a  px-2 pt-2 pb-1">
                                             
                                               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <ul class=list-alart-a>
                                                    @foreach ($errors as $error)
                                                        <li>{{$error}}</li><br>
                                                    @endforeach
                                                </ul>
                                                </div>
                                            </div>
                                            @endif

                                        @if (!empty($msg))
                                            <div class="form-group">
                                                <div class="alert alert-success alert-dismissable reset-field-one position-absolute login-alert px-2 pt-2 pb-1">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    {{$msg}}
                                                </div>
                                            </div>

                                            @endif
                                            <div class="login-logo w-100 my-2">
 <img src="{{asset('production/images/logo-ibell.png')}}" class="img-fluid" alt="logo">
 </div>  
<div class="d-flex justify-content-center form_container">
 
<form method="post" id="reset-password">
<input type="hidden" name="token" value="{{ $token }}">
<div class="input-group mb-1">
<label class="block clearfix w-100"> <span class="block input-icon input-icon-right d-flex"><i class="ace-icon fa fa-envelope pt-2 pr-3 font-size-10"></i> 
<input name="email" type="text" class="form-control" placeholder="E-Mail Address" value="{{ old('email') }}" required=""> </span> </label>
<span class="form-control-feedback"></span> 
</div>
<div class="input-group mb-0">
<label class="block clearfix w-100"> <span class="block input-icon input-icon-right d-flex"><i class="ace-icon fa fa-unlock-alt pt-2 pr-3"></i> 
<input name="password" id="password" type="password" class="form-control" placeholder="New Password"  value="" required="">
</span> </label>
 <span class="form-control-feedback"></span>  
 </div>
<div class="input-group mb-0">
 <label class="block clearfix w-100"> <span class="block input-icon input-icon-right d-flex"><i class="ace-icon fa fa-unlock-alt pt-2 pr-3"></i> 
 <input id="password-confirm" name="password_confirm" type="password" class="form-control" placeholder="Confirm New Password"  value="" required=""> </span> </label>
<span class="form-control-feedback"></span> 
</div>

<div class="form-group text-left">

</div>
<div class="d-flex justify-content-center mt-3 login_container">
<button type="submit" name="button" class="btn login_btn m-0">Reset Password</button>
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

</div>
</div>
  <script type="text/javascript">
            if('ontouchstart' in document.documentElement) document.write("<script src='../components/_mod/jquery.mobile.custom/jquery.mobile.custom.js'>"+"<"+"/script>");
        </script>

        <!-- inline scripts related to this page -->
        <script type="text/javascript">
            jQuery(function($) {
             $(document).on('click', '.toolbar a[data-target]', function(e) {
                e.preventDefault();
                var target = $(this).data('target');
                $('.widget-box.visible').removeClass('visible');//hide others
                $(target).addClass('visible');//show target
             });
            });



            //you don't need this, just used for changing background
            jQuery(function($) {
             $('#btn-login-dark').on('click', function(e) {
                $('body').attr('class', 'login-layout');
                $('#id-text2').attr('class', 'white');
                $('#id-company-text').attr('class', 'blue');

                e.preventDefault();
             });
             $('#btn-login-light').on('click', function(e) {
                $('body').attr('class', 'login-layout light-login');
                $('#id-text2').attr('class', 'grey');
                $('#id-company-text').attr('class', 'blue');

                e.preventDefault();
             });
             $('#btn-login-blur').on('click', function(e) {
                $('body').attr('class', 'login-layout blur-login');
                $('#id-text2').attr('class', 'white');
                $('#id-company-text').attr('class', 'light-blue');

                e.preventDefault();
             });

            });
        </script>
</body>
</html>
