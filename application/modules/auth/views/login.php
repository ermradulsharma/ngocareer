<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sign In</title>
    <base href="<?php echo base_url(); ?>" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/admin/dist/css/AdminLTE.min.css">

    <link rel="stylesheet" href="assets/lib/ajax.css">
    <style type="text/css">
        #loginPart .social-login {
            width: 390px;
            margin: 0 auto;
            margin-bottom: 14px;
        }

        #loginPart .social-btn {
            font-weight: 100;
            color: white;
            width: 160px;
            /*font-size: 0.9rem;*/
        }

        #loginPart a {
            /*display: block;*/
            padding-top: 10px;
            color: lightseagreen;
        }

        #loginPart .facebook-btn {
            background-color: #3C589C;
        }

        #loginPart .google-btn {
            background-color: #DF4B3B;
        }

        #loginPart .form-signup .social-btn {
            width: 210px;
        }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?php echo base_url(); ?>"><?php echo getSettingItem('SiteTitle') ?></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">


            <form id="credential" action="<?php echo base_url('auth/login'); ?>" method="post">
                <div id="loginPart">
                    <p class="login-box-msg">Sign in to start your session</p>
                    <div id="respond"></div>
                    <div class="form-group has-feedback">
                        <input type="text" id="username" name="username" class="form-control" placeholder="Email" />
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <span id='username_error'></span>

                    <div class="form-group has-feedback">
                        <input type="password" id="password" name="password" autocomplete="false"
                            class="form-control" placeholder="Password" />
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox"> Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" id="signin" class="btn btn-primary btn-block btn-flat">Sign In
                            </button>
                        </div>
                    </div>

                    <a href="#" id="forgotPwd">I forgot my password</a><br>

                </div>

                <div id="recoveryPart" style="display: none;">

                    <p class="login-box-msg">Enter Your Email Address.</p>
                    <div id="respond_pwd"></div>

                    <div class="form-group has-feedback">
                        <input type="text" id="recovery_email" name="recovery_email" class="form-control"
                            placeholder="Enter Email Address" />
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <button type="button" id="recovery" class="btn btn-primary btn-block btn-flat">Reset My Password
                            </button>
                        </div>
                        <div class="col-xs-6">
                            <span id="view_login" class="btn btn-default btn-block btn-flat">Login Box</span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </form>

            <!-- /.social-auth-links -->

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 2.2.3 -->
    <script src="assets/lib/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="assets/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script type="text/javascript">
        $(function() {
            $('#forgotPwd, #view_login').click(function(e) {
                e.preventDefault();
                $('#recoveryPart, #loginPart').slideToggle();
            });

            $('#recovery').on('click', function(e) {
                e.preventDefault();
                var forgot_mail = $('#recovery_email').val();
                $.ajax({
                    url: 'auth/forgot_pass',
                    type: "POST",
                    dataType: "json",
                    cache: false,
                    data: {
                        forgot_mail: forgot_mail
                    },
                    beforeSend: function() {
                        $('#respond_pwd').html('<p class="ajax_processing">Please Wait... Checking....</p>');
                    },
                    success: function(jsonData) {
                        if (jsonData.Status === 'OK') {
                            $('#respond_pwd').html(jsonData.Msg);
                        } else {
                            $('#respond_pwd').html(jsonData.Msg);
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $('#respond_pwd').html('<p> XML: ' + XMLHttpRequest + '</p>');
                        $('#respond_pwd').append('<p>  Status: ' + textStatus + '</p>');
                        $('#respond_pwd').append('<p> Error: ' + errorThrown + '</p>');
                    }
                });

            });


            $('#signin').on('click', function(e) {
                e.preventDefault();
                var credential = $('#credential').serialize();
                var error = 0;

                var username = jQuery('#username').val();
                if (!username) {
                    jQuery('#username').addClass('required');
                    error = 1;
                } else {
                    jQuery('#username').removeClass('required');
                }

                var password = jQuery('#password').val();
                if (!password) {
                    jQuery('#password').addClass('required');
                    error = 1;
                } else {
                    jQuery('#password').removeClass('required');
                }

                if (!error) {
                    $.ajax({
                        url: 'auth/login',
                        type: "POST",
                        dataType: "json",
                        cache: false,
                        data: credential,
                        beforeSend: function() {
                            $('#respond').html('<p class="ajax_processing">Please Wait... Checking....</p>');
                        },
                        success: function(jsonData) {
                            if (jsonData.Status === 'OK') {
                                $('#respond').html(jsonData.Msg);
                                window.location.href = '<?php echo base_url(Backend_URL); ?>';
                            } else {
                                $('#respond').html(jsonData.Msg);
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            $('#respond').html('<p> XML: ' + XMLHttpRequest + '</p>');
                            $('#respond').append('<p>  Status: ' + textStatus + '</p>');
                            $('#respond').append('<p> Error: ' + errorThrown + '</p>');
                        }
                    });
                }
            });


            jQuery('#username').on('keyup', function(e) {
                e.preventDefault();
                jQuery("#username_error").empty();
                jQuery("#respond").empty();
                var mail = jQuery(this).val();

                var isValide = validateEmail(mail);
                if (!isValide) {
                    jQuery("#username").addClass('required');
                    //jQuery("#username").after( "<span id='username_error'><p class='ajax_error'>Invalid email address.</p></span>" );
                } else {
                    jQuery("#username").removeClass('required');
                    jQuery("#username").addClass('required_pass');
                }
            });
        });

        function validateEmail(sEmail) {
            var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
            if (filter.test(sEmail)) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</body>

</html>