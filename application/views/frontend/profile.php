<div class="change-password">
    <h3>My Profile</h3>
</div>

<form action="student_portal/profile_update_action" method="post" id="user_form" class="form-horizontal"
      enctype="multipart/form-data">

    <div class="form-group">
        <label for="first_name" class="col-sm-3 control-label">Full Name <sup>*</sup></label>
        <div class="col-sm-9">
            <div class="row">
                <span class="col-md-4">
                    <input type="text" class="form-control" name="fname" id="fname"
                           placeholder="First Name" value="<?php echo $student->fname; ?>"/>
                           <?php echo form_error('fname') ?>
                </span>
                <span class="col-md-4">
                    <input type="text" class="form-control" name="mname" id="mname"
                           placeholder="Middle Name" value="<?php echo $student->mname; ?>"/>
                           <?php echo form_error('mname') ?>
                </span>
                <span class="col-md-4">
                    <input type="text" class="form-control" name="lname" id="lname"
                           placeholder="Last Name" value="<?php echo $student->lname; ?>"/>
                           <?php echo form_error('lname') ?>
                </span>
            </div>

        </div>
    </div>

    <div class="form-group">
        <label for="email" class="col-sm-3 control-label">Email <sup>*</sup></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="email" id="email" placeholder="Email Address"
                   value="<?php echo $student->email; ?>" readonly/>
            <?php echo form_error('email') ?>
        </div>
    </div>

    <div class="form-group">
        <label for="ethnicity_id" class="col-sm-3 control-label">Ethnicity <sup>*</sup></label>
        <div class="col-sm-9">
            <select name="ethnicity_id" class="form-control" id="ethnicity_id">
                <option value="">--Select Ethnicity--</option>
                <?php echo getDropDownEthnicitys($student->ethnicity_id); ?>
            </select>
            <?php echo form_error('ethnicity_id'); ?>
        </div>
    </div>

    <div class="form-group">
        <label for="country_id" class="col-sm-3 control-label">Country <sup>*</sup></label>
        <div class="col-sm-9">
            <select name="country_id" class="form-control" id="country_id">
                <?php echo getDropDownCountries($student->country_id); ?>
            </select>
            <?php echo form_error('country_id') ?>
        </div>
    </div>

    <div class="form-group">
        <label for="gmc_number" class="col-sm-3 control-label">GMC Number <sup>*</sup></label>
        <div class="col-sm-9">
            <div class="input-group">
                <input type="text" class="form-control" name="gmc_number" id="gmc_number"
                       placeholder="GMC Number"
                       value="<?php echo $student->gmc_number; ?>"/>
                <span class="input-group-addon">Must be Unique</span>
            </div>
            <?php echo form_error('gmc_number') ?>
        </div>
    </div>

    <div class="form-group">
        <label for="phone" class="col-sm-3 control-label">Phone <sup>*</sup></label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number"
                   value="<?php echo $student->phone; ?>"/>
            <?php echo form_error('phone') ?>
        </div>
    </div>

    <div class="form-group">
        <label for="gender" class="col-sm-3 control-label">Gender <sup>*</sup></label>
        <div class="col-sm-9" style="padding-top:8px;">
            <?php echo htmlRadio('gender', $student->gender, array('Male' => 'Male', 'Female' => 'Female')); ?>
        </div>
    </div>

    <div class="form-group">
        <label for="photo" class="col-sm-3 control-label">Photo</label>
        <div class="col-sm-9">
            <p><img src="<?php echo getPhoto($student->photo, $student->fname, 100, 100); ?>" width="100"
                    alt="<?php echo $student->fname; ?>"></p>
            <input type="file" name="photo" id="photo"/>
            <input type="hidden" name="photo_old" value="<?php echo $student->photo; ?>"/>
            <?php echo form_error('photo'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-9 col-md-offset-3">
            <input type="hidden" name="id" value="<?php echo $student->id; ?>"/>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </div>

</form>

<!--<form method="POST" class="form-horizontal" role="form" id="change_pwd" action="">-->
<!---->
<!--    <div class="col-md-12">-->
<!--        <div class="form-group">-->
<!--            <div id="ajax_respond"></div>-->
<!--        </div>-->
<!---->
<!--        <div class="form-group">-->
<!--            <label for="old_pass">Current Password</label>-->
<!--            <input autocomplete="off" type="password" name="old_pass" id="old_pass" class="form-control">-->
<!--        </div>-->
<!---->
<!--        <div class="form-group">-->
<!--            <label for="new_pass">New Password</label>-->
<!--            <input autocomplete="off" type="password" name="new_pass" id="new_pass" class="form-control">-->
<!--        </div>-->
<!---->
<!--        <div class="form-group">-->
<!--            <label for="con_pass">Confirm Password</label>-->
<!--            <input autocomplete="off" type="password" name="con_pass" id="con_pass" class="form-control">-->
<!--        </div>-->
<!---->
<!--        <div class="form-group">-->
<!--            <button type="submit" class="btn btn-primary" id="personalSubmit">Update</button>-->
<!--        </div>-->
<!--    </div>-->
<!--</form>-->


<script type="text/javascript">
    $(document).on('submit', '#change_pwd', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var error = 0;

        var old_pass = $('#old_pass').val();
        if (!old_pass) {
            $('#old_pass').addClass('required');
            error = 1;
        } else {
            $('#old_pass').removeClass('required');
        }

        var new_pass = $('#new_pass').val();
        if (!new_pass) {
            $('#new_pass').addClass('required');
            error = 1;
        } else {
            $('#new_pass').removeClass('required');
        }

        var con_pass = $('#con_pass').val();
        if (!con_pass) {
            $('#con_pass').addClass('required');
            error = 1;
        } else {
            $('#con_pass').removeClass('required');
        }

        if (!error) {
            jQuery.ajax({
                url: 'student_portal/change_password_action',
                type: "POST",
                dataType: 'json',
                data: formData,
                beforeSend: function () {
                    jQuery('#ajax_respond')
                        .html('<p class="ajax_processing">Updating...</p>')
                        .css('display', 'block');
                },
                success: function (jsonRespond) {
                    jQuery('#ajax_respond').html(jsonRespond.Msg);
                    if (jsonRespond.Status === 'OK') {
                        document.getElementById("change_pwd").reset();
                        setTimeout(function () {
                            jQuery('#ajax_respond').slideUp('slow');
                        }, 2000);
                    }
                }
            });
        }
    });
</script>