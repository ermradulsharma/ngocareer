<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="contact_us_left">
                    <?php echo $content; ?>
                </div>
            </div>
            <div class="col-md-7">
                <div class="contact_us_right">
                    <form class="contact-form" id="contactForm" method="post" onsubmit="return contactForm(event);">
                        <h2>Email us</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="cf_name" name="name" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" class="form-control" id="cf_email" name="email"
                                           placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="tel" class="form-control" id="cf_contact_no" name="contact"
                                           placeholder="Phone">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="cf_subject" name="subject"
                                           placeholder="Subject">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                <textarea id="cf_message" class="form-control" name="cf_message" placeholder="Comments"
                                          rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="g-recaptcha"
                                             data-sitekey="6LdTfDAbAAAAAOUuYBDPXWAVO3fhem1sRVkGSVYO"></div>
                                        <div id="captcha_msg"></div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <div class="form-group text-right">
                                            <input class="btn btn-success donation" type="submit" value="Submit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div id="cf_ajax_respond"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    function contactForm(e) {
        e.preventDefault();
        var formData = $('#contactForm').serialize();
        var error = 0;
        var name = $('#cf_name').val();
        if (!name) {
            $('#cf_name').addClass('required');
            error = 1;
        } else {
            $('#cf_name').removeClass('required');
        }
        var email = $('#cf_email').val();
        if (!email) {
            $('#cf_email').addClass('required');
            error = 1;
        } else {
            $('#cf_email').removeClass('required');
        }
        var phone = $('#cf_contact_no').val();
        if (!phone) {
            $('#cf_contact_no').addClass('required');
            error = 1;
        } else {
            $('#cf_contact_no').removeClass('required');
        }
        var subject = jQuery('#cf_subject').val();
        if (!subject) {
            $('#cf_subject').addClass('required');
            error = 1;
        } else {
            $('#cf_subject').removeClass('required');
        }

        var v = grecaptcha.getResponse();
        if(v.length == 0) {
            document.getElementById('captcha_msg').innerHTML="<span style='color: red'>You can't leave Captcha Code empty</span>";
            error = 1;
        } else {
            document.getElementById('captcha_msg').innerHTML="";
        }

        if (!error) {
            $.ajax({
                type: "POST",
                url: "mail/contact_us",
                dataType: 'json',
                data: formData,
                beforeSend: function () {
                    jQuery('#cf_ajax_respond').html('<p class="ajax_processing">Sending...</p>');
                },
                success: function (jsonData) {
                    jQuery('#cf_ajax_respond').html(jsonData.Msg);
                    if (jsonData.Status === 'OK') {
                        document.getElementById("contactForm").reset();
                        setTimeout(function () {
                            $('#cf_ajax_respond').html('');
                            $('#cf_ajax_respond').css('display', 'block');
                        }, 2000);
                    }
                }
            });
        }
    }

</script>