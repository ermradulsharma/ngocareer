<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ldnModal">Alert me to jobs like these</button>
<br><br>

<!-- Modal -->
<div class="modal fade" id="ldnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ldnModalLabel">Alert me to jobs like these</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="newsletter" id="ldp_newsletter" action="">
                    <input type="hidden" name="job_category" value="0">

                    <input type="text" name="first_name" id="ldp_first_name" class="form-control" placeholder="First Name"
                           required="required">
                    <br>
                    <input type="text" name="last_name" id="ldp_last_name" class="form-control" placeholder="Last Name"
                           required="required">
                    <br>
                    <input type="email" name="email" id="ldp_email" class="form-control" placeholder="Email Address"
                           required="required">
                    <br>
                    <input type="email" name="confirm_email" id="ldp_email_confirm" class="form-control" placeholder="Confirm Email Address"
                           required="required">
                    <br>
                    <div class="g-recaptcha"
                         data-sitekey="6LdTfDAbAAAAAOUuYBDPXWAVO3fhem1sRVkGSVYO"></div>
                    <div id="captcha_pop_list_msg"></div>
                    <div id="ldp_pop_list_msg"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input onclick="LDSubscribePopUp()" type="button" class="btn btn-info" value="Create Alert">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function LDSubscribePopUp() {
        var formData = jQuery('#ldp_newsletter').serialize();
        var error = 0;
        var ldp_email = jQuery('#ldp_email').val();
        if (!ldp_email) {
            jQuery('#ldp_email').addClass('required');
            error = 1;
        } else {
            jQuery('#ldp_email').removeClass('required');
        }

        var ldp_email_confirm = jQuery('#ldp_email_confirm').val();
        if (!ldp_email_confirm) {
            jQuery('#ldp_email_confirm').addClass('required');
            error = 1;
        } else {
            jQuery('#ldp_email_confirm').removeClass('required');
        }

        var ldp_first_name = jQuery('#ldp_first_name').val();
        if (!ldp_first_name) {
            jQuery('#ldp_first_name').addClass('required');
            error = 1;
        } else {
            jQuery('#ldp_first_name').removeClass('required');
        }

        var ldp_last_name = jQuery('#ldp_last_name').val();
        if (!ldp_last_name) {
            jQuery('#ldp_last_name').addClass('required');
            error = 1;
        } else {
            jQuery('#ldp_last_name').removeClass('required');
        }

        var email = $('#ldp_email').val();
        if (validateEmail(email) === false || !email) {
            $('#ldp_pop_list_msg').html('<span class="text-danger">Invalid Email</span>').show();
            error = 1;
        } else {
            $('#ldp_pop_list_msg').hide();
        }

        var confirm_email = $('#ldp_email_confirm').val();
        if (validateEmail(confirm_email) === false || !confirm_email) {
            $('#ldp_pop_list_msg').html('<span class="text-danger">Invalid Confirm Email</span>').show();
            error = 1;
        } else {
            $('#ldp_pop_list_msg').hide();
        }
        if(email != confirm_email) {
            $('#ldp_pop_list_msg').html('<span class="text-danger">Email and Confirm email must match</span>').show();
            error = 1;
        }

        var v = grecaptcha.getResponse();
        if(v.length == 0) {
            document.getElementById('captcha_pop_list_msg').innerHTML="<span style='color: red'>You can't leave Captcha Code empty</span>";
            error = 1;
        } else {
            document.getElementById('captcha_pop_list_msg').innerHTML="";
        }

        if (error === 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('frontend/alert_action_ldp'); ?>",
                dataType: 'json',
                data: formData,
                success: function (jsonData) {
                    $('#ldp_pop_list_msg').html(jsonData.Msg).slideDown('slow');
                    if (jsonData.Status === 'OK') {
                        $('#ldp_pop_list_msg').delay(5000).slideUp('slow');
                        document.getElementById("ldp_newsletter").reset();
                    } else {
                        $('#ldp_pop_list_msg').delay(5000).slideUp('slow');
                    }
                    console.log(jsonData);
                }
            });
        }
    }
</script>