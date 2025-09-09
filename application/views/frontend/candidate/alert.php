<link rel="stylesheet" href="assets/lib/plugins/select2/select2.min.css">
<script type='text/javascript' src="assets/lib/plugins/select2/select2.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&key=AIzaSyCSuu_Ag9Z2CEMxzzXdCcPNIUtPm0-GIXs"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.1/css/bootstrapValidator.min.css">

<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.1/js/bootstrapValidator.min.js"></script>

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
<h3 class="page-header">
    <span>Job Alerts</span>
    <span style="float: right;">
        <a class="btn btn-sm btn-info" 
            data-toggle="modal" 
            data-controls-modal="jobAlertModal"
            data-backdrop="static" 
            data-keyboard="true" href="#jobAlertModal">
            <i class="fa fa-gears"></i>
            Job Alert Setting
        </a>
    </span>
</h3>

<div class="row">
    <div class="col-md-12">
        <?php if ($mailbox): ?>
            <table class="table applied-job">
                <thead class="thead-light">
                    <tr>                        
                        <th scope="col">From</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Total Jobs</th>
                        <th scope="col" class="text-center">Sent At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mailbox as $mail){ ?>
                        <tr>
                            
                            <td><?php echo $mail->mail_from; ?></td>
                            <td><?php echo $mail->subject; ?></td>
                            <td>0</td>
                            <td class="text-center"><?php echo globalDateTimeFormat($mail->sent_at); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="ajax_notice">No job alert found! Please setting job alert first.</p>
            
            <div class="text-center">
                <a class="btn btn-lg btn-primary" 
                    data-toggle="modal" 
                    data-controls-modal="jobAlertModal"
                    data-backdrop="static" 
                    data-keyboard="true" href="#jobAlertModal">
                    <i class="fa fa-gears"></i>
                    Job Alert Setting
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="jobAlertModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-horizontal" name="job_alert" id="job_alert" method="POST">
                <div class="modal-header">
                    <h3 class="modal-title">Job Alert Setting</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="margin-top: -20px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="status" class="col-md-3 col-form-label">Alerts Status<sup>*</sup></label>
                                <div class="col-md-9">
                                    <label class="radio-inline">
                                        <input type="radio"
                                               name="status" <?php echo ($status == 'On') ? 'checked="checked"' : ''; ?>
                                               value="On">On
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio"
                                               name="status" <?php echo ($status == 'Off') ? 'checked="checked"' : ''; ?>
                                               value="Off">Off
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="keywords" class="col-md-3 col-form-label">Keywords</label>
                                <div class="col-md-9">
                                    <input type="text" name="keywords" id="keywords_01" class="form-control"
                                           data-role="tagsinput" value="<?php echo $keywords; ?>"/>
                                </div>
                            </div>

                            <div class="form-group row hidden">
                                <label for="job_category_ids" class="col-md-3 col-form-label">Job Category</label>
                                <div class="col-md-9">
                                    <select class="form-control select2" data-placeholder="Select a category"
                                            name="job_category_ids[]" id="job_category_ids" multiple>
                                        <?php echo getJobCategoriesDropDown($job_category_ids); ?>
                                    </select>
                                    <p class="help-block text-right">Keep it blank to all ads.</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="location" class="col-md-3 col-form-label">Location</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="location" id="autocomplete"
                                       value="<?php echo $location; ?>" style="width: 100%"/>
                                    <input type="hidden" name="lat" id="latitude" value="<?php echo $lat; ?>"/>
                                    <input type="hidden" name="lng" id="longitude" value="<?php echo $lng; ?>"/>
                                    <?php echo form_error('location') ?>
                                </div>
                            </div>

                            <select name="distance" class="form-control hidden" style="min-width: 100px;">
                                <?php echo getDistances($distance); ?>
                            </select>

                            <div class="form-group row">
                                <label for="email_frequency" class="col-md-3 col-form-label">Email Frequency<sup>*</sup></label>
                                <div class="col-md-9">
                                    <label class="radio-inline">
                                        <input type="radio"
                                               name="email_frequency" <?php echo ($email_frequency == 'Daily') ? 'checked="checked"' : ''; ?>
                                               value="Daily">Daily
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio"
                                               name="email_frequency" <?php echo ($email_frequency == 'Weekly') ? 'checked="checked"' : ''; ?>
                                               value="Weekly">Weekly
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio"
                                               name="email_frequency" <?php echo ($email_frequency == 'Monthly') ? 'checked="checked"' : ''; ?>
                                               value="Monthly">Monthly
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12 text-center">
                                    <label>
                                        <input type="checkbox" name="agree" value="Yes" id="agree">
                                        I have read and agree to the <a target="_blank" href="terms-and-conditions">Terms and Conditions</a>.</label>
                                    <br>
                                    <div id="tos_respond"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" style="padding: 6px 15px;"><i class="fa fa-save"></i>
                        Update
                    </button>
                </div>
            </form>
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
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.select2').select2({width: '100%'});

        $('#job_alert').submit(function (e) {
            e.preventDefault();
            var error    = 0;

            var agree = $('input[name=agree]:checked').val();
            if(!agree){
                $('#tos_respond').html('<span style="color: red">You must agree to the terms and conditions</span>');
                error = 1;
            } else {
                $('#tos_respond').empty();
            }

            if(!error) {
                $.ajax({
                    url: '<?php echo site_url('myaccount/alert_action'); ?>',
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
                        // Remove current toasts using animation
                        toastr.clear()
                        //received this text from a web server:
                        var response = JSON.parse(data);
                        var message = response.Msg;
                        if (response.Status === 'FAIL') {
                            // Display an error toast, with a title
                            toastr.error(message, 'Invalid Data!');
                            toastr.options.escapeHtml = true;

                        } else {
                            $('#jobAlertModal').modal('hide');
                            // Override global options
                            toastr.success(message, 'Success');
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