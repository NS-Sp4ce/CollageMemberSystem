<!DOCTYPE html>
<?php
$resource_host = $_SERVER['HTTP_HOST'];
?>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
        <title>
            会员管理系统 - 登录
        </title>
        <!-- Vendor styles -->
        <link href="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
        <link href="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <!-- App styles -->
        <link href="<?php echo 'http://' . $resource_host; ?>/css/app.min.css" rel="stylesheet">
        <link href="<?php echo 'http://' . $resource_host; ?>/css/login.css" rel="stylesheet">
        <!-- Javascript -->
        <!-- Vendors -->
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/jquery/dist/jquery.min.js">
        </script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/tether/dist/js/tether.min.js">
        </script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js">
        </script>
        <script src="<?php echo 'http://' . $resource_host; ?>/vendors/bower_components/Waves/dist/waves.min.js">
        </script>
        <!--Canvas animat-->
        <script type='text/javascript' src="<?php echo 'http://' . $resource_host; ?>/js/jquery.particleground.min.js"></script>
        <!-- App functions and actions -->
        <script src="<?php echo 'http://' . $resource_host; ?>/js/app.min.js">
        </script>
        <script type="text/javascript">
        $(document).ready(function() {
            $('#username').focus();
            $('#particles').particleground({
                dotColor: '#5cbdaa',
                lineColor: '#5cbdaa'
            });
            $('.intro').css({
                'margin-top': -($('.intro').height() / 2)
            });
        });
        </script>
    </head>

    <body data-ma-theme="blue">
        <div id="particles">
            <!--div id="intro"-->
            <div class="login" id="intro">
                <!-- Login -->
                <div class="login__block active" id="l-login">
                    <div class="login__block__header">
                        高校会员管理系统
                        <i class="zmdi zmdi-account-circle"></i>
                        您好 请登录
                    </div>
                    <form action="check.php" enctype="multipart/form-data" method="post">
                        <div class="login__block__body">
                            <div class="form-group form-group--float form-group--centered">
                                <input class="form-control" type="text" name="username" id="username">
                                <label>
                                    用户名
                                </label>
                                <i class="form-group__bar">
                                </i>
                                </input>
                            </div>
                            <div class="form-group form-group--float form-group--centered">
                                <input class="form-control" type="password" name="password" id="password">
                                <label>
                                    密码
                                </label>
                                <i class="form-group__bar">
                                </i>
                                </input>
                            </div>
                            <button class="btn btn--icon login__block__btn" name="login" type="submit" value="login">
                                <i class="zmdi zmdi-long-arrow-right">
                            </i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <!-- Older IE warning message -->
        <!--[if IE]>
                <div class="ie-warning">
                    <h1>警告!</h1>
                    <p>您使用的是过时版本的Internet Explorer，请升级到以下任何一个web浏览器以访问本网站.</p>

                    <div class="ie-warning__downloads">
                        <a href="http://www.google.com/chrome">
                            <img src="<?php echo 'http://' . $resource_host; ?>/img/browsers/chrome.png" alt="">
                        </a>

                        <a href="https://www.mozilla.org/zh-CN/firefox/new">
                            <img src="<?php echo 'http://' . $resource_host; ?>/img/browsers/firefox.png" alt="">
                        </a>

                        <a href="http://www.opera.com">
                            <img src="<?php echo 'http://' . $resource_host; ?>/img/browsers/opera.png" alt="">
                        </a>

                        <a href="https://support.apple.com/downloads/safari">
                            <img src="<?php echo 'http://' . $resource_host; ?>/img/browsers/safari.png" alt="">
                        </a>

                        <a href="https://www.microsoft.com/en-us/windows/microsoft-edge">
                            <img src="<?php echo 'http://' . $resource_host; ?>/img/browsers/edge.png" alt="">
                        </a>

                        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                            <img src="<?php echo 'http://' . $resource_host; ?>/img/browsers/ie.png" alt="">
                        </a>
                    </div>
                    <p>抱歉给您带来的不便!</p>
                </div>
            <![endif]-->
    </body>

    </html>