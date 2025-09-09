<div class="listing_newsletter">
    <form name="newsletter" id="listing_newsletter" action="">
        <div class="row">
            <div class="col-md-3">Send my jobs like this:</div>
            <div class="col-md-6">
                <input type="email" name="newsletter_email" id="listing_newsletter_email" class="form-control" placeholder="Email Address" required="required">
                <div id="listing_newsletter-msg"></div>
            </div>
            <div class="col-md-3">
                <input onclick="listingNewsletterSubscribe()" type="button" class="btn btn-primary" value="Subscribe">
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    function listingNewsletterSubscribe() {
        var formData = jQuery('#listing_newsletter').serialize();
        var error = 0;
        var listing_newsletter_email = jQuery('#listing_newsletter_email').val();
        if (!listing_newsletter_email) {
            jQuery('#listing_newsletter_email').addClass('required');
            error = 1;
        } else {
            jQuery('#listing_newsletter_email').removeClass('required');
        }

        var email = $('#listing_newsletter_email').val();
        if (validateEmail(email) === false || !email) {
            $('#listing_newsletter-msg').html('<span class="text-danger">Invalid Email</span>').show();
            error = 1;
        } else {
            $('#listing_newsletter-msg').hide();
        }
        if (error === 0) {
            $.ajax({
                type: "POST",
                url: "newsletter_subscriber/ajax/subscribe",
                dataType: 'json',
                data: formData,
                success: function (jsonData) {
                    $('#listing_newsletter-msg').html(jsonData.Msg).slideDown('slow');
                    if (jsonData.Status === 'OK') {
                        $('#listing_newsletter-msg').delay(5000).slideUp('slow');
                        document.getElementById("listing_newsletter").reset();
                    } else {
                        $('#newsletter-msg').delay(5000).slideUp('slow');
                    }
                    console.log(jsonData);
                }
            });
        }
    }
</script>