<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Dr.Nutrition Admin Login</title>

        <meta name="description" content="User login page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link rel="icon" href="/images/common/imgFavIcon.png" type="image/x-icon">

        <!-- bootstrap -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}" />
        <link rel="stylesheet" href="{{asset('components/font-awesome/css/font-awesome.css')}}" />

        <!-- text fonts -->
        <link rel="stylesheet" href="{{asset('assets/css/ace-fonts.css')}}" />

        <!-- ace styles -->
        <link rel="stylesheet" href="{{asset('assets/css/ace.css')}}" />

        <!--[if lte IE 9]>
            <link rel="stylesheet" href="/assets/css/ace-part2.css" />
        <![endif]-->
        <link rel="stylesheet" href="{{asset('assets/css/ace-rtl.css')}}" />

        <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
      <link rel="stylesheet" href="{{ asset('css/styleuserside.css') }}">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    

    </head>

    <body class="login-layout blur-login">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container"><br>
                            <div class="center">
                                <h1>
                                    <!--  <img src="{{asset('img/logo1.png')}}" alt="24x7">  -->
                                    <br>
                                </h1>
                            </div>

                            <div class="space-6"></div>

                            <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main center">
                                           
                        <div>
                                   <h4> <i class="fa fa-key margin_key_"></i>Reset Password</h4>
                                            <div class="space-6"></div>
    @if (session('status'))
                      <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
    @if (!empty($errors) && count($errors) > 0)
                                            <div class="form-group">
                                                <div class="alert alert-danger alert-dismissable reset-field-one">
                                             
                                               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <ul>
                                                    @foreach ($errors as $error)
                                                        <li>{{$error}}</li><br>
                                                    @endforeach
                                                </ul>
                                                </div>
                                            </div>
                                            @endif

                                        @if (!empty($msg))
                                            <div class="form-group">
                                                <div class="alert alert-success alert-dismissable reset-field-one">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    {{$msg}}
                                                </div>
                                            </div>

                                            @endif

          <form action="" class="form form--flex form--auth js-register-form js-parsley" method="POST" id="reset-password">
                        {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}"><br/>
              
              <div class="form-group block clearfix">
                <div class="block input-icon input-icon-right">
                  <input id="email" placeholder="Email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
                  <i class="ace-icon fa fa-envelope"></i>
                  <span  form-control-feedback"></span>  
                </div>
              </div>
              <div class="form-group block clearfix">
                <div class="iblock input-icon input-icon-right">
                  <input id="password" placeholder="New Password" type="password" class="form-control" name="password" required>
                  <i class="ace-icon fa fa-unlock-alt"></i>
                  <span class="form-control-feedback"></span>
                </div>
              </div>             
              <div class="form-group block clearfix">
                <div class="iblock input-icon input-icon-right">
                  <input id="password-confirm" placeholder="Confirm New Password" type="password" class="form-control" name="password_confirm" required>
                    <i class="ace-icon fa fa-unlock-alt"></i>
                    <span class="form-control-feedback"></span>
                </div>
              </div>                                 
              <button class="width-35 pull-right btn btn-sm btn-primary" type="submit">
                <span class="icon icon-xs fa fa-sign-in fa-lg"></span>
                <span class="btn-text">Reset Password</span>
              </button>                                      
          </form>       
          <div class="clearfix"></div>
                  
                                        </div>
                                    </div>
                                </div>

                     
                            </div><!-- /.position-relative -->
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.main-content -->
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->
        <script src="{{asset('components/jquery/dist/jquery.js')}}"></script>
        <script src="{{ asset('js/core.min.js')}}"></script>
        <script src="{{ asset('js/script.js')}}"></script>
        <!-- <![endif]-->

        <!--[if IE]>
<script src="/components/jquery.1x/dist/jquery.js"></script>
<![endif]-->
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
