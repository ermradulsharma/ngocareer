<link rel="stylesheet" href="assets/lib/plugins/select2/select2.min.css">
<script type='text/javascript' src="assets/lib/plugins/select2/select2.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&key=AIzaSyCSuu_Ag9Z2CEMxzzXdCcPNIUtPm0-GIXs"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<style type="text/css">
    .select2-search__field {
        width: 100% !important;
    }

    .pac-container.pac-logo {
        z-index: 9999 !important;
    }

    .bootstrap-tagsinput input {
        min-width: 400px;
    }
</style>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.1/css/bootstrapValidator.min.css">
<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.1/js/bootstrapValidator.min.js"></script>

<div class="container">
    <div class="job-alert">
        <h3 class="title">Create Job Alerts</h3>
        <div class="col-sm-5">
            <form class="form-horizontal" name="job_alert" id="job_alert" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="first_name" class="col-sm-12 col-form-label">First Name <sup>*</sup></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="first_name" id="first_name"
                                           placeholder="Enter your first name"/>
                                    <?php echo form_error('first_name') ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="last_name" class="col-sm-12 col-form-label">Last Name <sup>*</sup></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="last_name" id="last_name"
                                           placeholder="Enter your last name"/>
                                    <?php echo form_error('last_name') ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-12 col-form-label">Email <sup>*</sup></label>
                                <div class="col-sm-12">
                                    <input type="email" class="form-control" name="email" id="email"
                                           placeholder="Enter your email address"/>
                                    <?php echo form_error('email') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="confirm_email" class="col-sm-12 col-form-label">Confirm Email <sup>*</sup></label>
                                <div class="col-sm-12">
                                    <input type="email" class="form-control" name="confirm_email" id="confirm_email"
                                           placeholder="Enter your Confirm email address"/>
                                    <?php echo form_error('confirm_email') ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="keywords" class="col-sm-12 col-form-label">Keywords <sup>*</sup></label>
                                <div class="col-sm-12">
                                    <input type="text" name="keywords" id="keywords_01" class="form-control"
                                           data-role="tagsinput" placeholder="Job Title, Job Sector, Occupation"
                                           style="width: 100% !important;"/>
                                    <?php echo form_error('keywords'); ?>
                                </div>
                            </div>

                            <!--                    <div class="form-group row">-->
                            <!--                        <label for="job_category_ids" class="col-sm-12 col-form-label">Job Keywords</label>-->
                            <!--                        <div class="col-sm-12">-->
                            <!--                            <select class="form-control select2" data-placeholder="Select a category"-->
                            <!--                                    name="job_category_ids[]" id="job_category_ids" multiple>-->
                            <!--                                --><?php //echo getJobCategoriesDropDown(); ?>
                            <!--                            </select>-->
                            <!--                            <p class="help-block text-right">Keep it blank to all ads.</p>-->
                            <!--                        </div>-->
                            <!--                    </div>-->

                            <div class="form-group row">
                                <label for="location" class="col-sm-12 col-form-label">Location <sup>*</sup></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="location" id="autocomplete"
                                           style="width: 100%"/>
                                    <input type="hidden" name="lat" id="latitude"/>
                                    <input type="hidden" name="lng" id="longitude"/>
                                    <?php echo form_error('location') ?>
                                </div>
                            </div>

                            <select name="distance" class="form-control hidden" style="min-width: 100px;">
                                <?php echo getDistances(); ?>
                            </select>

                            <div class="form-group row">
                                <label for="email_frequency" class="col-sm-12 col-form-label">Email
                                    Frequency<sup>*</sup></label>
                                <div class="col-sm-12">
                                    <?php echo htmlRadio('email_frequency', 'Weekly', ['Daily' => 'Daily', 'Weekly' => 'Weekly', 'Monthly' => 'Monthly']); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label>
                                        <input type="checkbox" name="agree" value="Yes" id="agree">
                                        I have read and agree to the <a target="_blank" href="terms-and-conditions">Terms and Conditions</a>.</label>
                                    <br>
                                    <div id="tos_respond"></div>
                                </div>
                            </div>
                            <div class="g-recaptcha" data-sitekey="6LdTfDAbAAAAAOUuYBDPXWAVO3fhem1sRVkGSVYO"></div>
                            <div id="captcha_msg"></div>
                            <div id="ldp_msg"></div>
                            <div class="form-group row" style="padding-top: 30px;">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary btn-lg"></i>
                                        Send
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-7">
            <h2>Why should job seekers register to job alerts?</h2>
            <p>Job alerts are an essential tool in your job search strategy. They can be a powerful way to keep up to
                date with the latest jobs and they offer a number of benefits.</p>

            <h2>Jobs Straight to your Inbox</h2>
            <p>When you sign up for job alerts, you can stay up to date with the latest jobs matching. Our platform has
                advanced functionality that will scan for suitable vacancies and send them to your inbox if they match
                the criteria that you specify. These job alerts can be accessed through your computer or mobile
                device.</p>

            <h2>First to Apply</h2>
            <p>Many recruiters and business owners are now so inundated with applications that they often stop reviewing
                applications when they receive so many or they may have a cap on the number of applications they
                receive. This makes it even more important for you to be one of the first candidates to apply. With your
                CV online and an easy application process, you can apply for new vacancies in a few simple steps.</p>

            <h2>Simple and Straightforward</h2>
            <p>When you sign up for a job alert, it’s easy to do. You can manage your alerts at any time or change the
                types of jobs that you wish to receive alerts for. This enables your job search to be completely
                tailored at all times, so you only receive alerts to the jobs you are interested in.</p>
            <p>To find out more about our job alerts or to sign up, visit our page to discover all you need to know. You
                can set up multiple alerts too for different types of job and different industries if you are keeping
                your options open and you are looking for a broad range of jobs.</p>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#job_alert')
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
            // .bootstrapValidator({
            //     // excluded: ':disabled',
            //     feedbackIcons: {
            //         valid: 'glyphicon glyphicon-ok',
            //         invalid: 'glyphicon glyphicon-remove',
            //         validating: 'glyphicon glyphicon-refresh'
            //     },
            //     fields: {
            //         cities: {
            //             validators: {
            //                 notEmpty: {
            //                     message: 'Please enter at least one keyword you like the most'
            //                 }
            //             }
            //         }
            //     }
            // })
            .on('success.form.bv', function (e) {
                // Prevent form submission
                e.preventDefault();
            });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#job_category_ids').select2();

        $('#job_alert').submit(function (e) {
            e.preventDefault();
            var error = 0;

            var first_name = $('#first_name').val();
            if (!first_name) {
                $('#first_name').addClass('required');
                error = 1;
            } else {
                $('#first_name').removeClass('required');
            }

            var last_name = $('#last_name').val();
            if (!last_name) {
                $('#last_name').addClass('required');
                error = 1;
            } else {
                $('#last_name').removeClass('required');
            }

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

            var location = $('input[name=location]').val();
            if (!location) {
                $('#autocomplete').addClass('required');
                error = 1;
            } else {
                $('#autocomplete').removeClass('required');
            }

            var agree = $('input[name=agree]:checked').val();
            if (!agree) {
                $('#tos_respond').html('<span style="color: red">You must agree to the terms and conditions</span>');
                error = 1;
            } else {
                $('#tos_respond').empty();
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

<?php load_module_asset('job', 'js'); ?>