<div class="listing_details_newsletter">
    <form name="newsletter" id="listing_details_newsletter" action="">
        <input type="hidden" name="job_category" value="<?php echo $job_category_id; ?>">
        <h6><strong style="color: #2D7DC0;">Alert me to jobs like these:<br><?php echo $job_title; ?></strong></h6>
        <input type="text" name="first_name" id="ld_first_name" class="form-control" placeholder="First Name"
               required="required">
        <br>
        <input type="text" name="last_name" id="ld_last_name" class="form-control" placeholder="Last Name"
               required="required">
        <br>
        <input type="email" name="email" id="listing_details_email" class="form-control" placeholder="Email Address"
               required="required">
        <div id="listing_details_msg"></div>
        <div class="clearfix" style="padding-top: 10px;"></div>
        <input onclick="listingDetailsSubscribe()" type="button" class="btn btn-info" value="Create Alert">
    </form>
</div>

<script type="text/javascript">
    function listingDetailsSubscribe() {
        var formData = jQuery('#listing_details_newsletter').serialize();
        var error = 0;
        var listing_details_email = jQuery('#listing_details_email').val();
        if (!listing_details_email) {
            jQuery('#listing_details_email').addClass('required');
            error = 1;
        } else {
            jQuery('#listing_details_email').removeClass('required');
        }

        var ld_first_name = jQuery('#ld_first_name').val();
        if (!ld_first_name) {
            jQuery('#ld_first_name').addClass('required');
            error = 1;
        } else {
            jQuery('#ld_first_name').removeClass('required');
        }

        var ld_last_name = jQuery('#ld_last_name').val();
        if (!ld_last_name) {
            jQuery('#ld_last_name').addClass('required');
            error = 1;
        } else {
            jQuery('#ld_last_name').removeClass('required');
        }

        var email = $('#listing_details_email').val();
        if (validateEmail(email) === false || !email) {
            $('#listing_details_msg').html('<span class="text-danger">Invalid Email</span>').show();
            error = 1;
        } else {
            $('#listing_details_msg').hide();
        }
        if (error === 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('frontend/alert_action_listing_details'); ?>",
                dataType: 'json',
                data: formData,
                success: function (jsonData) {
                    $('#listing_details_msg').html(jsonData.Msg).slideDown('slow');
                    if (jsonData.Status === 'OK') {
                        $('#listing_details_msg').delay(5000).slideUp('slow');
                        document.getElementById("listing_details_newsletter").reset();
                    } else {
                        $('#listing_details_msg').delay(5000).slideUp('slow');
                    }
                    console.log(jsonData);
                }
            });
        }
    }
</script>