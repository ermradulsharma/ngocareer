<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sign In</title>
  <base href="<?php echo base_url(); ?>"/>
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
   

      
  
        <div class="login-box-custom"> 
            <div class="login-box">

                <!-- /.login-logo -->
                <div class="login-box-body">


                    <form id="credential" action="" method="post">

                        <h3 style="margin:0;">Reset Your Password</h3>
                        <div id="respond"></div>


                        <input type="hidden" name="verify_token" value="<?php echo $this->input->get('token'); ?>" >


                        <div class="form-group has-feedback">

                            <input type="text" readonly class="form-control" id="email" name="email" value="<?php echo $this->input->get('email'); ?>">
                        </div>    

                        <div class="form-group has-feedback">
                            <input type="password" value="" name="new_password" id="new_password"  class="form-control" placeholder="New Password">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="password" value="" name="retype_password" id="retype_password"  class="form-control" placeholder="Retype password">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>

                         
                            <button type="button" id="reset_pass"  class="btn btn-primary btn-block btn-flat">Reset & Sign In</button>
                        

                    </form>


                </div>
                <!-- /.login-box-body -->
            </div>
        </div>

      
    

   
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="assets/lib/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="assets/lib/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
     
<script>


    var $ = jQuery;
    $('#reset_pass').on('click', function () {
        
        $('.validation_error').html('');
        
        var error = 0;
        var _email = $('#email').val();
        if (!_email) {
            $('#email').css('border', '1px solid red').css('background-color', '#FFF5AB');

            $('#email').closest('.form-group').append('<em class="validation_error">Enter Email address </em>');
            error = 1;
        } else {
            $('#email').addClass('required');
        }
        var new_password = $('#new_password').val();
        if (!new_password) {
            $('#new_password').addClass('required');

            $('#new_password').closest('.form-group').append('<em class="validation_error">Please enter new password</em>');
            error = 1;
        } else {
            $('#new_password').css('border', '1px solid #999').css('background-color', '#FFF');
        }
        var retype_password = $('#retype_password').val();
        if (!retype_password) {
            $('#retype_password').addClass('required');

            $('#retype_password').closest('.form-group').append('<em class="validation_error">Retype  password</em>');
            error = 1;
        } else {
            $('#retype_password').addClass('required');
        }


        if (error === 0) {
            var formData = jQuery('#credential').serialize();
            jQuery.ajax({
                url: 'auth/reset_password_action',
                type: "post",
                dataType: 'json',
                data: formData,
                beforeSend: function () {
                    jQuery('#respond').html('<p class="ajax_processing">Updating...</p>');
                },
                success: function (jsonRespond) {
                    jQuery('#respond').html(jsonRespond.Msg);                    
                    if(jsonRespond.Status === 'OK'){
                        setTimeout(function() {	                                                    
                            jQuery('.formresponse').fadeOut('slow');                           
                            window.location.href = "sign-in";
                        }, 4000);	  
                    }                                      	
                }
            });
            return false;
        } 
    });
</script>
</body>
</html>


