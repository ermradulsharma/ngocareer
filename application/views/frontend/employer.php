<?php
    $this->session->set_userdata('captcha_val1', rand(9,19));
    $this->session->set_userdata('captcha_val2', rand(1,8));
?>
<style type="text/css">

    /* sign in FORM */
    #logreg-forms{
        text-align: center;
        padding-top: 30px;
        margin:5vh auto;
        background-color:#f3f3f3;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    #logreg-forms form {
        width: 100%;
        max-width: 410px;
        padding: 15px;
        margin: auto;
    }
    #logreg-forms .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }
    #logreg-forms .form-control:focus { z-index: 2; }
    #logreg-forms .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    #logreg-forms .form-signin input[type="password"] {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    #logreg-forms .social-login{
        width:390px;
        margin:0 auto;
        margin-bottom: 14px;
    }
    #logreg-forms .social-btn{
        font-weight: 100;
        color:white;
        width:190px;
        /*font-size: 0.9rem;*/
    }

    #logreg-forms a{
        /*display: block;*/
        padding-top:10px;
        color:lightseagreen;
    }

    #logreg-form .lines{
        width:200px;
        border:1px solid red;
    }


    #logreg-forms button[type="submit"]{ margin-top:10px; }

    #logreg-forms .facebook-btn{  background-color:#3C589C; }

    #logreg-forms .google-btn{ background-color: #DF4B3B; }

    #logreg-forms .form-reset { display: none; }
    /*#logreg-forms .form-signup{ display: none; }*/

    #logreg-forms .form-signup .social-btn{ width:210px; }

    #logreg-forms .form-signup input,
    #logreg-forms .form-signup select { margin-bottom: 2px;}

    .form-signup .social-login{
        width:210px !important;
        margin: 0 auto;
    }

    /* Mobile */

    @media screen and (max-width:500px){
        #logreg-forms{
            width:300px;
        }

        #logreg-forms  .social-login{
            width:200px;
            margin:0 auto;
            margin-bottom: 10px;
        }
        #logreg-forms  .social-btn{
            font-size: 1.3rem;
            font-weight: 100;
            color:white;
            width:200px;
            height: 56px;

        }
        #logreg-forms .social-btn:nth-child(1){
            margin-bottom: 5px;
        }
        #logreg-forms .social-btn span{
            display: none;
        }
        #logreg-forms  .facebook-btn:after{
            content:'Facebook';
        }

        #logreg-forms  .google-btn:after{
            content:'Gmail';
        }
        
    }
    
    #logreg-forms p {
      margin: 0 0 5px!important;
    }
    li {
    list-style: inside;
}
</style>
<div class="container">
    <h1>Sign in to your Recruiter account</h1>
    <div class="row">
        <div class="col-md-6">
            <div id="logreg-forms">
                <h3>Already Registered</h3>
                <form class="form-signin" method="post" id="credential" <?php echo $loginFormStyle; ?>>
                    <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Sign in</h1>
                    <div class="social-login">
                        <a title="Facebook Login" href="<?php echo $fbLoginURL; ?>"><button class="btn facebook-btn social-btn" type="button"><span><i class="fa fa-facebook-f"></i> Sign in with Facebook</span> </button></a>
                        <a title="Google Login" href="<?php echo $googleLoginURL; ?>" ><button class="btn google-btn social-btn" type="button"><span><i class="fa fa fa-google"></i> Sign in with Gmail</span> </button></a>
                    </div>
                    <p style="text-align:center"> OR  </p>
                    <?php echo $this->session->flashdata('message'); ?>
                    <div id="respond"></div>
                    <div class="form-group">
                        <input type="email" id="username" class="form-control" name="username" placeholder="Email address" required="" autofocus="">
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="">
                    </div>

                    <button class="btn btn-success btn-block" id="employersignin" type="submit"><i class="fa fa-sign-in-alt"></i> Sign in</button>
                    <a href="#" id="forgot_pswd">Forgot password?</a>
                    <hr>
                    <!-- <p>Don't have an account!</p>  -->
<!--                    <button class="btn btn-primary btn-block" type="button" id="btn-signup"><i class="fa fa-user-plus"></i> Sign up New Account</button>-->
                </form>

                <form method="post" id="forgotForm" class="form-reset" <?php echo $resetPassFormStyle; ?>>
                    <div id="respond_pwd"></div>
                    <div class="form-group">
                        <input type="email" name="forgot_mail" id="forgot_mail" class="form-control" placeholder="Enter Email address" required="required" autofocus="">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="button" id="employer_forgot_pass">Reset Password</button>
                    </div>
                    <a href="#" id="cancel_reset"><i class="fa fa-angle-left"></i> Back to Sign in</a>
                </form>

            </div>
        </div>
        <div class="col-md-6">
            <div id="logreg-forms">
                <h3>Not Yet Registered</h3>
                <form class="form-signup" id="form-signup" name="sign_up" method="POST" action="<?= base_url('employer/singup/action') ?>" <?php // echo $singupFormStyle; ?>>
                    <div class="social-login">
                        <a href="<?php echo $fbLoginURL; ?>"><button class="btn facebook-btn social-btn" type="button"><span><i class="fa fa-facebook-f"></i> Register with Facebook</span> </button></a>
                    </div>
                    <div class="social-login">
                        <a href="<?php echo $googleLoginURL; ?>" ><button class="btn google-btn social-btn" type="button"><span><i class="fa fa-google"></i> Register with Gmail</span> </button></a>
                    </div>

                    <p style="text-align:center">OR</p>
                    <?php echo validation_errors(); ?>
                    <?php echo $this->session->flashdata('message'); ?>
                    <input type="text" id="employer_first_name" name="first_name" class="form-control" placeholder="First Name" required="" autofocus=""  value="<?php echo set_value('first_name'); ?>">
                    <input type="text" id="employer_last_name" name="last_name" class="form-control" placeholder="Last Name" required="" autofocus=""  value="<?php echo set_value('last_name'); ?>">
                    <input type="text" id="employer_company_name" name="company_name" class="form-control" placeholder="Company Name" required autofocus=""  value="<?php echo set_value('company_name'); ?>">
                    <select name="org_type_id" id="employer_org_type_id" class="form-control">
                        <?php echo getOrganizationTypes($org_type_id)?>
                    </select>
                    <input type="email" id="employer_email" name="email" class="form-control" placeholder="Email Address" required autofocus=""  value="<?php echo set_value('email'); ?>">

                    <input type="password" id="employer_password" name="password" class="form-control" placeholder="Password" required autofocus="">
                    <input type="password" id="employer_retype_password" name="retype_password" class="form-control" placeholder="Repeat Password" required autofocus="">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->session->userdata('captcha_val1') .' + '. $this->session->userdata('captcha_val2').' = ';  ?></span>
                            <input type="number" name="captcha" id="captcha" placeholder="Total" class="form-control" style="margin-bottom: 0;">
                            <input type="hidden" name="captcha_total" id="captcha_total" value="<?php echo $this->session->userdata('captcha_val1') + $this->session->userdata('captcha_val2'); ?>">
                        </div>
                        <div id="captcha_total_error"></div>
                    </div>
                    <button class="btn btn-primary btn-block"  type="submit"><i class="fa fa-user-plus"></i> Sign Up</button>
<!--                    <a href="#" id="cancel_signup"><i class="fa fa-angle-left"></i> Back</a>-->
                </form>
                <br>

            </div>
        </div>
        <div class="col-sm-12 employer">
            <p>As a recruiter, when  you on NGOcareer.com, we will be able to make the right match when you post a job, so only the most suitable candidates will be shortlisted for the role.</p>
            <p>Please provide much  information as possible on your profile, as this will help us tailor our services and give you the best possible chance of success in recruiting the right person.</p>
            <p>Recruiters use our service, as it’s quick and easy to set up a profile and post a job, and you have access to the most qualified and experience candidates within the technology and engineering sectors.</p>
            <p>Job seekers often like to find out a bit more about the company they are applying to, and by creating your profile, our job seekers can gain an understanding of the size and type of company you are looking to secure talent for.</p>
            <p>In some cases, job seekers can’t find the opportunity they are looking for, and they will often sign up for <a href="http://localhost/ngocareer//job-alert">job alerts</a>.</p>
            <p>We send a job alert to suitable qualified Job  Seekers when you <a href="http://localhost/ngocareer//admin/job/create">post a job</a>, so that you will never miss out on the best quality of candidates for your role.</p>
            <p>We are also always on hand if you need any support or have any questions or comments about our services. You can <a href="http://localhost/ngocareer//contact">contact us</a> at any time, and we will do our best to assist you.</p>
            <p>We know the frustrations of having a role to fill, but not being sure where to look for candidates. You don’t really want to advertise your job on various websites, as this just gives you the extra challenge of trying to coordinate the screening of candidates via different sources.</p>
            <p>Our aim is to work in partnership with  you and build a relationship, so we can help take care of your recruitment needs, quickly and without hassle.</p>
            <p>We want to work side by side with you and offer you a great service, and real value for money, and we have achieved this with our NGO Job Portal.</p>
        </div>
    </div>
</div>


<script>

    $(document).ready(function(){
        $('#form-signup').on('submit', function(e){
            e.preventDefault();
            var captcha = jQuery('#captcha').val();
            if(!captcha){
                jQuery('#captcha').addClass('required');
                error = 1;
            } else{
                jQuery('#captcha').removeClass('required');
            }

            var captcha_total = jQuery('#captcha_total').val();
            if(captcha_total !== captcha){
                jQuery("#captcha_total_error").html( "<span style='color:red'><p>Please enter a valid value.</p></span>" );
                error = 1;
            } else{
                jQuery("#captcha_total_error").html(' ');
                this.submit();
            }
        });
    });

    function toggleResetPswd(e) {
        e.preventDefault();
        $('#logreg-forms .form-signin').toggle(); // display:block or none
        $('#logreg-forms .form-reset').toggle(); // display:block or none
    }

    function toggleSignUp(e) {
        e.preventDefault();
        $('#logreg-forms .form-signin').toggle(); // display:block or none
        $('#logreg-forms .form-signup').toggle(); // display:block or none
    }


    $(() => {
        // Login Register Form
        $('#logreg-forms #forgot_pswd').click(toggleResetPswd);
        $('#logreg-forms #cancel_reset').click(toggleResetPswd);
        $('#logreg-forms #btn-signup').click(toggleSignUp);
        $('#logreg-forms #cancel_signup').click(toggleSignUp);
    });
</script>
<script src="assets/theme/js/login.js"></script>