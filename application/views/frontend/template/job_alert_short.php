
<style type="text/css">
    /*.bootstrap-tagsinput input {*/
    /*    min-width: 300px;*/
    /*}*/

    .search label {
        display: inline-block;
    }
    .job_alert_search {
        background: #efefef;
        padding: 5px 15px;
        border-radius: 11px;
    }
    .job_alert_search h4 {
        color: #333333;
        font-weight: 700;
    }
    .pop_po_dv_1 {
       width: 100%;
       float: left;
    }
    .job_alert_search h5.pop_po_2 {
       width: auto;
       float: left;
    }
    button.pop_po_1 {
    width: auto;
    float: right;
    background-color: red !important;
    }
    .modal_dialog_1 .modal-content {
    padding: 2%;
}
.modal_dialog_1 {
    width: 88%;
}
.modal_dialog_1 .form-group label {
    font-size: 15px;
}
.modal_dialog_1 .form-group button.btn-primary {
    margin-top: 23%;
}

button.pop_po_1:hover {
    background-color: #269AC7 !important;
}
.pop_ter_re_1 h5.pop_po_2 {
    width: auto;
    float: left;
}
.pop_ter_re_1 button.pop_po_1 {
    width: 300px;
}
</style>
<script type="text/javascript" src="/js/plugin/jquery.js"></script>

<script type="text/javascript" src="/js/jquery.validate.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.1/css/bootstrapValidator.min.css">

<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.1/js/bootstrapValidator.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="pop_ter_re_1 ">
<h5 class="pop_po_2">Leave us your email address and we'll send you all the new jobs according to your preferences.</h5>
<button type="button" class="btn btn-info btn-lg pop_po_1" data-toggle="modal" data-target="#Subscribe">Subscribe Now</button>
</div>
<!-- Modal start-->
        <div class="container">
          <div class="modal fade" id="Subscribe" role="dialog">
            <div class="modal-dialog modal_dialog_1">
              <!-- Modal content-->
              <div class="job_alert_search hidden-xs">
            <div class="pop_po_dv_1">
                <h5 class="pop_po_2">Leave us your email address and we'll send you all the new jobs according to your preferences.</h5>
                
            </div>
            <form name="job_alert" id="job_alert_search" method="POST">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label for="first_name" class="col-form-label">First Name <sup>*</sup></label>
                            <input type="text" class="form-control" name="first_name" id="first_name"
                                   placeholder="Enter your first name"/>
                            <?php echo form_error('first_name') ?>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label for="last_name" class="col-form-label">Last Name <sup>*</sup></label>
                            <input type="text" class="form-control" name="last_name" id="last_name"
                                   placeholder="Enter your last name"/>
                            <?php echo form_error('last_name') ?>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email <sup>*</sup></label>
                            <input type="email" class="form-control" name="email" id="email"
                                   placeholder="Enter your email address"/>
                            <?php echo form_error('email') ?>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label for="confirm_email" class="col-form-label">Confirm Email <sup>*</sup></label>
                            <input type="email" class="form-control" name="confirm_email" id="confirm_email"
                                   placeholder="Enter your Confirm email address"/>
                            <?php echo form_error('confirm_email') ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="keywords" class="col-form-label">Keywords <sup>*</sup></label>
                            <input type="text" name="keywords" id="keywords_01" class="form-control"
                                   data-role="tagsinput" placeholder="Job Title, Job Sector, Occupation or Recruiter" />
                            <?php echo form_error('keywords'); ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="email_frequency" class="col-form-label">Email Frequency<sup>*</sup></label><br>
                            <?php echo htmlRadio('email_frequency', 'Weekly', ['Daily' => 'Daily', 'Weekly' => 'Weekly', 'Monthly' => 'Monthly']); ?>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="g-recaptcha" data-sitekey="6LdTfDAbAAAAAOUuYBDPXWAVO3fhem1sRVkGSVYO"></div>

                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg"></i> Send</button>
                        </div>
                        <div id="captcha_msg"></div>
                        <div id="ldp_msg"></div>
                    </div>
                </div>
            </form>
        </div>
        <div class="visible-xs">
            <div class="job_alert_box">
                <p>Become the frist to know about every new job.</p>
                <p><a class="btn btn-primary" href="job-alert">Register for Jobs Alert Now</a></p>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal end-->
<style>
    .bootstrap-tagsinput input {font-size: 12px;}
</style>

<script type="text/javascript">
    $(document).ready(function () {
        $('#job_alert_search')
            .find('[name="keywords"]')
            // Revalidate the color when it is changed
            .change(function (e) {
                console.warn($('[name="keywords"]').val());
                console.info($('#keywords_01').val());
                console.info($("#keywords_01").tagsinput('items'));
                var a = $("#keywords_01").tagsinput('items');
                console.log(typeof (a));
                console.log(a.length);
                $('#defaultForm').bootstrapValidator('revalidateField', 'keywords');
            })
            .end()
            .bootstrapValidator({
                excluded: ':disabled',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    cities: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter at least one keyword you like the most'
                            }
                        }
                    }
                }
            })
            .on('success.form.bv', function (e) {
                // Prevent form submission
                e.preventDefault();
            });
    });

    $(document).ready(function () {
        $('#job_alert_search').submit(function (e) {
            e.preventDefault();
            var error = 0;

            var email = $('input[name=email]').val();
            if (!email) {
                $('#email').addClass('required');
                error = 1;
            } else {
                $('#email').removeClass('required');
            }
            var confirm_email = jQuery('#confirm_email').val();
            if (!confirm_email) {
                jQuery('#confirm_email').addClass('required');
                error = 1;
            } else {
                jQuery('#confirm_email').removeClass('required');
            }

            var first_name = $('input[name=first_name]').val();
            if (!first_name) {
                $('#first_name').addClass('required');
                error = 1;
            } else {
                $('#first_name').removeClass('required');
            }

            var last_name = $('input[name=last_name]').val();
            if (!last_name) {
                $('#last_name').addClass('required');
                error = 1;
            } else {
                $('#last_name').removeClass('required');
            }

            var confirm_email = $('#confirm_email').val();
            if (validateEmail(confirm_email) === false || !confirm_email) {
                $('#ldp_msg').html('<span class="text-danger">Invalid Confirm Email</span>').show();
                error = 1;
            } else {
                $('#ldp_msg').hide();
            }
            if(email != confirm_email) {
                $('#ldp_msg').html('<span class="text-danger">Email and Confirm email must match</span>').show();
                error = 1;
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
                    url: '<?php echo site_url('frontend/alert_action'); ?>',
                    type: "post",
                    data: new FormData(this), //this is formData
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false,
                    beforeSend: function () {
                        toastr.warning("Please Wait...");
                    },
                    success: function (data) {
                        toastr.clear()
                        var response = JSON.parse(data);
                        var message = response.Msg;
                        if (response.Status === 'FAIL') {
                            toastr.error(message, 'Invalid Data!');
                            toastr.options.escapeHtml = true;
                        } else {
                            toastr.success(message, 'Success');
                            window.location.reload(true);
                        }
                    }
                });
            } else {
                return false;
            }
        });
    });

</script>

