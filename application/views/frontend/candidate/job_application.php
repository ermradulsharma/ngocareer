<h3 class="page-header">Apply Resume</h3>
<?php echo validation_errors(); ?>
<div class="row">
    <form class="form-horizontal" name="my_job_application" id="my_job_application" method="POST" action="<?php echo site_url('my_account/job_application_action') ?>">
        <div class="col-md-12">
            <div class="form-group row">
                <label for="my_email" class="col-md-4 col-form-label">My Email</label> 
                <div class="col-md-8">
                    <input name="my_email" class="form-control" required="required" type="text" readonly="" value="<?php echo $my_email; ?>" />
                </div>
            </div>
            <div class="form-group row">
                <label for="candidate_cv_id" class="col-md-4 col-form-label">My CV Format<sup>*</sup></label>
                <div class="col-md-8">
                    <select name="candidate_cv_id" id="candidate_cv_id" class="form-control" required="required" >
                        <?php echo getMyCvFormat($candidate_id, $candidate_cv_id); ?>
                    </select>
                    <?php echo form_error('candidate_cv_id') ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="expected_salary" class="col-md-4 col-form-label">Expected Salary<sup>*</sup></label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="number" name="expected_salary" id="expected_salary"
                               class="form-control" required="required" value="<?php echo $expected_salary; ?>"/>
                        <div class="input-group-addon"><?php echo getSettingItem('Currency'); ?></div>
                    </div>

                    <?php echo form_error('expected_salary') ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="cover_letter" class="col-md-4 col-form-label">Cover Lettert<sup>*</sup></label>
                <div class="col-md-8">
                    <textarea name="cover_letter" id="cover_letter" class="form-control" cols="40" rows="4" maxlength="500" required="required"/><?php echo $cover_letter; ?></textarea>
                    <div class="totalCharcter"><span><strong id="cover_letter_char"><?php echo strlen($cover_letter); ?></strong>&nbsp;characters and maximum character limits <strong>500</strong></span></div>
                    <div id="errorMsgCoverLetter"></div>
                    <?php echo form_error('cover_letter') ?>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-offset-4 col-md-8">
                    <input type="hidden" name="job_id" name="job_id" value="<?php echo $job_id; ?>" />
                    <button name="submit" type="submit" class="btn btn-primary"><i class="fa fa-send" aria-hidden="true"></i> Apply</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">

    $(document).ready(function () {

        $('#cover_letter').bind('keyup change paste', function () {
            var txtMessage = $('#cover_letter').val();
            var number_of_charcters = txtMessage.length;

            $('.totalCharcter strong#cover_letter_char').html(number_of_charcters);

            if (number_of_charcters >= 500) {
                $('#errorMsgCoverLetter').html(
                        '<span style="color:red;">' +
                        ' Maximum character limit reached</span>&nbsp')
            }
        });

    });
</script>
