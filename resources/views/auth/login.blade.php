<!DOCTYPE html>
<html ng-app="wx">
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta ng-model="viewport" name="viewport" content="width=device-width, initial-scale=1">
        <title>Material Admin</title>
        
        <!-- Vendor CSS -->
        <link href="{{asset('vendors/animate-css/animate.min.css')}}" rel="stylesheet">
        <link href="{{asset('vendors/sweet-alert/sweet-alert.min.css')}}" rel="stylesheet">
        <link href="{{asset('vendors/material-icons/material-design-iconic-font.min.css')}}" rel="stylesheet">
        <link href="{{asset('vendors/socicon/socicon.min.css')}}" rel="stylesheet">
            
        <!-- CSS -->
        <link href="{{asset('css/app.min.1.css')}}" rel="stylesheet">
        <link href="{{asset('css/app.min.2.css')}}" rel="stylesheet">
        <script type="text/javascript">
            window.baseUrl = '{{url()}}';
        </script>
    </head>
    
    <body class="login-content" ng-controller="Auth">
         <!-- Login -->
        <div class="lc-block toggled" id="l-login">
            <form method="POST" action="{{url('/auth/login')}}">
                {!! csrf_field() !!}
                <div class="input-group m-b-20">
                    <span class="input-group-addon"><i class="md md-person"></i></span>
                    <div class="fg-line">
                        <input type="text" ng-model="login.name" name="name"class="form-control" placeholder="用户名">
                    </div>
                </div>
                
                <div class="input-group m-b-20">
                    <span class="input-group-addon"><i class="md md-accessibility"></i></span>
                    <div class="fg-line">
                        <input type="password" ng-model="login.password" name="password" class="form-control" placeholder="密码">
                    </div>
                </div>
                
                <div class="clearfix"></div>
                
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="" ng-model="remember" name="remember">
                        <i class="input-helper"></i>
                        保持登录
                    </label>
                </div>
                <div>
                
                    <button type="button" ng-click="doLogin()" class="m-t-20 pull-left btn btn-primary"><i class="md md-arrow-forward"></i> 登录</button>
                    
                    <ul class="login-navigation-link m-t-20 pull-left p-l-20">
                        <li data-block="#l-register" class="btn btn-default">注册</li>
                    </ul>
                </div>
            </form>
        </div>
        
        <!-- Register -->
        <div class="lc-block" id="l-register">
            <form method="POST" action="{{url('/auth/register')}}">
                {!! csrf_field() !!}
                <div class="input-group m-b-20">
                    <span class="input-group-addon"><i class="md md-person"></i></span>
                    <div class="fg-line">
                        <input type="text" ng-model="register.name" name="name" class="form-control" placeholder="用户名">
                    </div>
                </div>
                
                <div class="input-group m-b-20">
                    <span class="input-group-addon"><i class="md md-accessibility"></i></span>
                    <div class="fg-line">
                        <input type="password" ng-model="register.password" name="password" class="form-control" placeholder="密码">
                    </div>
                </div>
                
                <div class="clearfix"></div>
                <div>
                    <button type="button" ng-click="doRegister()" class="m-t-20 pull-left btn btn-login btn-success"><i class="md md-arrow-forward"></i> 注册</button>
                    <ul class="login-navigation-link m-t-20 pull-left">
                        <li data-block="#l-login" class="btn btn-default">登录</li>
                    </ul>
                </div>
                
            </form>
        </div>

        <!-- Forgot Password -->
        <div class="lc-block" id="l-forget-password">
            <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu risus. Curabitur commodo lorem fringilla enim feugiat commodo sed ac lacus.</p>
            
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-email"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Email Address">
                </div>
            </div>
            
            <button type="button" ng-click="forget()" class="btn btn-login btn-danger btn-float"><i class="md md-arrow-forward"></i></button>
            
            <ul class="login-navigation-link">
                <li data-block="#l-login" class="bgm-green">登录</li>
                <li data-block="#l-register" class="bgm-red">注册</li>
            </ul>
        </div>
        
        <!-- Older IE warning message -->
        <!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">IE SUCKS!</h1>
                <p>You are using an outdated version of Internet Explorer, upgrade to any of the following web browser <br/>in order to access the maximum functionality of this website. </p>
                <ul class="iew-download">
                    <li>
                        <a href="http://www.google.com/chrome/">
                            <img src="img/browsers/chrome.png" alt="">
                            <div>Chrome</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.mozilla.org/en-US/firefox/new/">
                            <img src="img/browsers/firefox.png" alt="">
                            <div>Firefox</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://www.opera.com">
                            <img src="img/browsers/opera.png" alt="">
                            <div>Opera</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.apple.com/safari/">
                            <img src="img/browsers/safari.png" alt="">
                            <div>Safari</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                            <img src="img/browsers/ie.png" alt="">
                            <div>IE (New)</div>
                        </a>
                    </li>
                </ul>
                <p>Upgrade your browser for a Safer and Faster web experience. <br/>Thank you for your patience...</p>
            </div>   
        <![endif]-->
        
        <!-- Javascript Libraries -->
        <script src="{{asset('js/jquery-2.1.1.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('vendors/bootstrap-growl/bootstrap-growl.min.js')}}"></script>
        <script src="{{asset('vendors/sweet-alert/sweet-alert.min.js')}}"></script>

        <script src="{{asset('vendors/waves/waves.min.js')}}"></script>
        <script src="{{asset('vendors/angular/angular.js')}}"></script>
        <script src="{{asset('vendors/angular-cookies/angular-cookies.js')}}"></script>
        <script src="{{asset('vendors/angular-ui-router/release/angular-ui-router.js')}}"></script>
        <script src="{{asset('vendors/angular-sanitize/angular-sanitize.js')}}"></script>
        
        <script src="{{asset('js/functions.js')}}"></script>
        <script src="{{asset('js/demo.js')}}"></script>
        <script src="{{asset('app/app.js')}}"></script>
        <script src="{{asset('app/auth.js')}}"></script>
        
    </body>
</html>