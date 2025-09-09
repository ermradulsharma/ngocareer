<div class="loginpagee">
    <div class="container">

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-box-custom">
                    <div class="login-box">
                        <div class="login-box-body js_login">
                            <form id="credential" class="form-signin text-center"
                                  action="<?php echo base_url('auth/login'); ?>" method="post">
                                <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
                                <div id="respond"></div>
                                <label for="inputEmail" class="sr-only">Email address</label>
                                <input type="email" id="inputEmail" name="username" class="form-control"
                                       placeholder="Email address" required autofocus>
                                <label for="inputPassword" class="sr-only">Password</label>
                                <input type="password" id="inputPassword" name="password" class="form-control"
                                       placeholder="Password" required>
                                <button type="submit" id="signin" class="btn btn-lg btn-primary btn-block"
                                        type="submit">Sign in
                                </button>
                                <a class="js_forgot">Forgot Password?</a><br>

                                <div style="margin-top: 50px;">
                                    If you are not registered, click <a href="<?php echo site_url('createaccount'); ?>">Register FREE</a>
                                </div>
                            </form>
                        </div>

                        <div class="login-box-body form-signin js_forget_password" style="display: none; ">
                            <h1 class="h3 mb-3 font-weight-normal">Reset Password</h1>
                            <div id="maingReport"></div>
                            <div class="formresponse"></div>

                            <form action="auth/forgot_password" method="post" id="forgotForm">
                                <div class="form-group has-feedback">
                                    <input type="email" class="form-control" placeholder="Enter Your Email"
                                           name="forgot_mail" id="forgot_mail">

                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <span class="btn btn-default js_back_login">Back to Sign in</span>
                                    </div>
                                    <div class="col-xs-6">
                                        <button type="button" class="btn btn-primary btn-block btn-flat"
                                                id="forgot_pass">Reset
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<script src="assets/theme/js/login.js"></script>