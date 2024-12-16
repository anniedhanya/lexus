<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Jih - Ngo</title>

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
                                    <!-- <img src="{{asset('images/ImgLogo.png')}}" alt="Jamia"> -->
                                    <br><br>
                                </h1>
                            </div>

                            <div class="space-6"></div>

                       
                            <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main center">
                                          
                        <div>
                          <h4><i class="fa fa-key margin_key_"></i>Reset Passwords</h4>

                                            <div class="space-6"></div>
    @if (session('status'))
                      <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                      @if(!empty($error))
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>

                              {{$error}}
                            </div>
                            @endif
                                        @if (!empty($msg))
                                            <div class="form-group">
                                                <div class="alert alert-success alert-dismissable col-sm-6">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    {{$msg}}
                                                </div>
                                            </div>

                                            @endif
             @if(session()->has('successmsg'))
      
              <div class="alert alert-success alert-dismissable col-sm-12">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              {{ session()->get('successmsg') }}
               </div>


              @endif
                     <form action="" class="form-horizontal js-parsley" method="POST">
                  
                        {{ csrf_field() }}
                        <br/>

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

                        
                       
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="block clearfix">
                                <span class="block input-icon input-icon-right">
                                <input id="email" type="email" placeholder="E-Mail Address" class="form-control" name="email" value="{{ old('email') }}" required>
                                <i class="ace-icon fa fa-envelope"></i>
                                <span class="form-control-feedback"></span>  
                                </span>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </label>
                        </div>

                        <button class="width-35 pull-right btn btn-sm btn-primary" type="submit">
                            <span class="icon icon-xs fa fa-sign-in fa-lg"></span>
                            <span class="btn-text">Send Password Reset Link</span>
                        </button>
                    
                    
                    
                </form>
                                        </div><!-- /.widget-main -->

                                        <!-- <div class="toolbar clearfix">
                                            <div>
                                                <a href="#" data-target="#forgot-box" class="forgot-password-link">
                                                    I forgot my password
                                                </a>
                                            </div>
                                        </div> -->
                                        <div class="clearfix"></div>
                                    </div><!-- /.widget-body -->
                                </div><!-- /.login-box -->

                                <div id="forgot-box" class="forgot-box widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header red lighter bigger">
                                                <i class="ace-icon fa fa-key"></i>
                                                Retrieve Password
                                            </h4>

                                            <div class="space-6"></div>
                                            <p>
                                                Enter your email and to receive instructions
                                            </p>

                                            <form>
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="email" class="form-control" placeholder="Email" />
                                                            <i class="ace-icon fa fa-envelope"></i>
                                                        </span>
                                                    </label>

                                                    <div class="clearfix">
                                                        <button type="button" class="width-35 pull-right btn btn-sm btn-danger">
                                                            <i class="ace-icon fa fa-lightbulb-o"></i>
                                                            <span class="bigger-110">Send Me!</span>
                                                        </button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div><!-- /.widget-main -->

                                        <div class="toolbar center">
                                            <a href="#" data-target="#login-box" class="back-to-login-link">
                                                Back to login
                                                <i class="ace-icon fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div><!-- /.widget-body -->
                                </div><!-- /.forgot-box -->
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
