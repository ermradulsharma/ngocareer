<div id="logreg-forms">
    <form class="form-signin" id="reset_pass">
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Setup your new password</h1>
                
        <div id="respond"></div>        
        
        <div class="form-group">
            <input type="password" id="new_pass" name="new_pass" maxlength="12" class="form-control" placeholder="New Password" required="">
        </div>
        <div class="form-group">
            <input type="password" id="con_pass" name="con_pass" maxlength="12" class="form-control" placeholder="Confirm Password" required="">
        </div>

        
        <!-- <p>Don't have an account!</p>  -->
        <button class="btn btn-primary btn-block" type="button" id="reset_pass_action">
            <i class="fa fa-random"></i>
            Reset Now
        </button>
    </form>
  
</div>
<script type="text/javascript">
    $('#reset_pass_action').click(function(){
        var formData = $('#reset_pass').serialize();    
        $.ajax({
            url: 'auth_candidate/reset_pass_action',
            type: "POST",
            dataType: 'json',
            data: formData,
            beforeSend: function () {
                $('#respond').html('<p class="ajax_processing">Processing, Please Wait...</p>')
                        .css('display','block');
            },
            success: function ( respond ) {
                if( respond.Status === 'OK'){
                    location.href = '<?php echo site_url('myaccount') ?>';
                } else {
                    $('#respond').html( respond.Msg );
                }                
            }
        });
        return false;
    });
</script>