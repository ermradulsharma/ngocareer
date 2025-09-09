<style>
    .candiate_area .nav-sidebar {
        margin: 0;
    }
</style>
<h3 class="page-header">My Profile</h3>
<div class="row">

    <div class="col-md-8">

        <form class="form-horizontal" name="jobseeker_profile" id="jobseeker_profile" method="POST" action="<?= base_url('my_account/profile_update') ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile">
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label">User Name/Email</label> 
                            <div class="col-md-8">
                                <input name="email" placeholder="Enter Email" class="form-control" required="required" type="text" readonly="" value="<?php echo $email; ?>" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label">First Name<span class="mandatory">*</span></label> 
                            <div class="col-md-8">
                                <input id="name" name="first_name" placeholder="Enter First Name" class="form-control" type="text" value="<?php echo $first_name; ?>" />
                                <span class="text-danger"><?php echo form_error('first_name') ?></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label">Last Name<span class="mandatory">*</span></label> 
                            <div class="col-md-8">
                                <input id="last_name" name="last_name" placeholder="Enter Last Name" class="form-control" type="text" value="<?php echo $last_name; ?>" />
                                <span class="text-danger"><?php echo form_error('last_name') ?></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date_of_birth" class="col-md-4 col-form-label">Date Of Birth</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <select id="days" class="form-control" name="day">
                                        <option value="0">Day</option>
                                        <?php echo selectOptions($day, $days) ?>
                                    </select>
                                    <span class="input-group-addon" style="padding:  0"></span>
                                    <select id="months" class="form-control" name="month">
                                        <option value="0">Month</option>
                                        <?php echo selectOptions($month, $months) ?>
                                    </select>
                                    <span class="input-group-addon" style="padding:  0"></span>
                                    <select id="year"  class="form-control" name="year">
                                        <option value="0">Year</option>
                                        <?php echo selectOptions($year, $years) ?>
                                    </select>
                                </div>
                                
                                
                                <span class="text-danger"><?php echo form_error('day') ?></span>
                                <span class="text-danger"><?php echo form_error('month') ?></span>
                                <span class="text-danger"><?php echo form_error('year') ?></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label">Gender<span class="mandatory">*</span></label> 
                            <div class="col-md-8">
                                <select id="gender" name="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <?php echo selectOptions($gender, array('Male' => 'Male', 'Female' => 'Female', 'Prefer not to say'=>'Prefer not to say')) ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('gender') ?></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="marital_status" class="col-md-4 col-form-label">Marital Status<span class="mandatory">*</span></label> 
                            <div class="col-md-8">
                                <?php echo htmlRadio('marital_status', $marital_status, [
                                    'Married' => 'Married',
                                    'Single' => 'Single'
                                ]);?>                                
                                <span class="text-danger"><?php echo form_error('marital_status') ?></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="country_id" class="col-md-4 col-form-label">Country<span class="mandatory">*</span></label> 
                            <div class="col-md-8">
                                <select name="country_id" class="form-control">
                                    <?php echo getDropDownCountries($country_id); ?>
                                </select>                                
                                <span class="text-danger"><?php echo form_error('country_id') ?></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="permanent_address" class="col-md-4 col-form-label">Permanent Address</label>
                            <div class="col-md-8">
                                <textarea id="permanent_address" rows="5"
                                          name="permanent_address" 
                                          placeholder="Enter Permanent Address" 
                                          class="form-control"><?php echo $permanent_address; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="present_address" class="col-md-4 col-form-label">Current Address</label> 
                            <div class="col-md-8">
                                <textarea id="present_address" rows="5" name="present_address" placeholder="Enter Current Address" class="form-control"><?php echo $present_address; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="home_phone" class="col-md-4 col-form-label">Home Phone</label> 
                            <div class="col-md-8">
                                <input type="text" id="home_phone" name="home_phone" placeholder="Enter Home Phone" class="form-control" value="<?php echo $home_phone; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mobile_number" class="col-md-4 col-form-label">Mobile<span class="mandatory">*</span></label> 
                            <div class="col-md-8">
                                <input id="mobile_number" name="mobile_number" placeholder="Enter Mobile" class="form-control" type="text" value="<?php echo $mobile_number; ?>">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="col-md-12">
                    <h3>Other Relevant Information</h3>
                    <div class="profile">
                        <div class="form-group row">
                            <label for="career_summary" class="col-md-4 col-form-label">Work Experience</label>
                            <div class="col-md-8">
                                <textarea cols="40" rows="4" id="career_summary" name="career_summary" class="form-control" maxlength="500"><?php echo $career_summary; ?></textarea>
                                <div class="totalCharcter"><span><strong id="career_summary_char"><?php echo strlen($career_summary); ?></strong> &nbsp;characters and maximum characters <strong>500</strong> </span></div>
                                <div id="errorMsg"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="qualifications" class="col-md-4 col-form-label">Qualifications</label> 
                            <div class="col-md-8">
                                <textarea id="qualifications" name="qualifications" cols="40" rows="4" class="form-control" maxlength="500"><?php echo $qualifications; ?></textarea>
                                <div class="totalCharcter"><span><strong id="qualifications_char"><?php echo strlen($qualifications); ?></strong> &nbsp; characters and maximum characters <strong>500</strong></span></div>
                                <div id="errorMsgQualification"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="keywords" class="col-md-4 col-form-label">Your Skills  And Knowledge</label> 
                            <div class="col-md-8">
                                <textarea id="keywords" name="keywords" cols="40" rows="4" class="form-control" maxlength="500"><?php echo $keywords; ?></textarea>
                                <div class="totalCharcter"><span><strong id="keywords_char"><?php echo strlen($keywords); ?></strong> &nbsp;characters and maximum characters <strong>500</strong></span></div>
                                <div id="errorMsgKeyword"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="additional_information" class="col-md-4 col-form-label">Additional information</label> 
                            <div class="col-md-8">
                                <textarea id="keywords" name="additional_information" cols="40" rows="4" class="form-control"><?php echo $additional_information; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group row" style="margin-top: 10px;">
                        <div class="col-md-offset-4 col-md-8">
                            <button name="submit" type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-4">
        <form class="form-horizontal" id="upload_profile_image" action="" method="POST">
            <div class="card hovercard">

                <div class="info">
                    <label class="btn btn-info btn-file">
                        <input type="file" id="upload_picture" 
                               name="upload_picture" accept="image/*"
                               onchange="validate_image();">
                    </label>
                    <div class="title">
                        Standard image uploading guideline.
                    </div>
                    <div class="desc">File must be less than 5MB.</div>
                    <div class="desc">File format should be gif, jpg, jpeg or png.</div>

                </div>
                <div class="bottom">
                    <button name="submit" type="submit" class="btn btn-primary" style="background-color: #ec4523;border-color: #ec4523;">Update Profile</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12"><div id="respond"></div></div>
            </div>
        </form>
    </div>

</div>
<script type="text/javascript">
    $( "#upload_picture").change(function() {
        photoPreview(this, '.upload_image');
    });

    function validate_image() {
        var file_err = 'file_err';
        var upload_picture = $('#upload_picture');
        var file = $('#upload_picture')[0].files[0]; //for single file upload
        console.log(upload_picture);
        //hide previous error
        $(`#${file_err}`).html('');
        //Multiple File Upload

        if (file === undefined) {
            upload_picture.parent().after('<span id=' + file_err + '><p class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Please upload image/* File</p></span>');
            return false;
        } else {
            $(`#${file_err}`).html('');
        }

        var fileType = file.type; // holds the file types
        var match = ["image/gif", "image/jpg", "image/jpeg", "image/png"]; // defined the file types
        var fileSize = file.size; // holds the file size
//        console.log(fileSize);
        var maxSize = 5 * 1024*1024; // defined the file max size 1M

        // Checking the Valid Image file types  
        if (!((fileType === match[0]) || (fileType === match[1]) || (fileType === match[2]) || (fileType === match[3])))
        {
            upload_picture.val("");
            upload_picture.parent().after('<span id=' + file_err + '><p class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Please select a valid (.gif, .jpg, .jpeg, .png) image.</p></span>');
            return false;
        } else {
            $(`#${file_err}`).html('');
        }
        // Checking the defined image size
        if (fileSize > maxSize)
        {
            upload_picture.val("");
            upload_picture.parent().after('<span id=' + file_err + '><p class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Please select ' + file.name + ' file less than 1mb of size.</p></span>');
            return false;
        } else {
            $(`#${file_err}`).html('');
        }
    }

    $(document).ready(function () {

        $('#career_summary').bind('keyup change paste', function () {
            var txtMessage = $('#career_summary').val();
            var number_of_charcters = txtMessage.length;

            $('.totalCharcter strong#career_summary_char').html(number_of_charcters);

            if (number_of_charcters >= 500) {
                $('#errorMsg').html(
                        '<span style="color:red;">' +
                        ' Maximum character limit reached</span>&nbsp');
            }
        });

        $('#qualifications').bind('keyup change paste', function () {
            var txtMessage = $('#qualifications').val();
            var number_of_charcters = txtMessage.length;

            $('.totalCharcter strong#qualifications_char').html(number_of_charcters);

            if (number_of_charcters >= 500) {
                $('#errorMsgQualification').html(
                        '<span style="color:red;">' +
                        ' Maximum character limit reached</span>&nbsp');
            }
        });

        $('#keywords').bind('keyup change paste', function () {
            var txtMessage = $('#keywords').val();
            var number_of_charcters = txtMessage.length;

            $('.totalCharcter strong#keywords_char').html(number_of_charcters);

            if (number_of_charcters >= 500) {
                $('#errorMsgKeyword').html(
                        '<span style="color:red;">' +
                        ' Maximum character limit reached</span>&nbsp');
            }
        });
    });


    $('#upload_profile_image').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo site_url('my_account/profile_picture_upload/'); ?>',
            type: "post",
            data: new FormData(this), //this is formData
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            beforeSend: function () {
                toastr.success('Please Wait...');
            },
            success: function (data) {
                //received this text from a web server:
                var response = JSON.parse(data);
                if (response.status == 'error'){
                    toastr.clear();
                    toastr.error(response.msg);
                } else {
                    toastr.clear();
                    toastr.success(response.msg);
                }
            }
        });
    });
</script>