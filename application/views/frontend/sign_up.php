<div class="container">
    <div class="row">
        <!--        <div class="col-md-2"></div>-->
        <div class="col-md-8 col-md-offset-2">
            <h3 class="text-center" style="padding-bottom: 50px;">Sign Up For a Free Account</h3>

            <form action="sign_up_action" method="post" id="sign_up" class="form-horizontal"
                  enctype="multipart/form-data">

                <div class="form-group">
                    <label for="first_name" class="col-sm-2 control-label">Full Name <sup>*</sup></label>
                    <div class="col-sm-10">
                        <div class="row">
                            <span class="col-md-4">
                                <input type="text" class="form-control" name="fname" id="fname"
                                       placeholder="First Name" value="<?php echo $fname; ?>"/>
                                       <?php echo form_error('fname') ?>
                            </span>
                            <span class="col-md-4">
                                <input type="text" class="form-control" name="mname" id="mname"
                                       placeholder="Middle Name" value="<?php echo $mname; ?>"/>
                                       <?php echo form_error('mname') ?>
                            </span>
                            <span class="col-md-4">
                                <input type="text" class="form-control" name="lname" id="lname"
                                       placeholder="Last Name" value="<?php echo $lname; ?>"/>
                                       <?php echo form_error('lname') ?>
                            </span>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email <sup>*</sup></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" id="your_email" placeholder="Email Address"
                               value="<?php echo $email; ?>"/>
                        <?php echo form_error('email') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="ethnicity_id" class="col-sm-2 control-label">Ethnicity <sup>*</sup></label>
                    <div class="col-sm-10">
                        <select name="ethnicity_id" class="form-control" id="ethnicity_id">
                            <option value="">--Select Ethnicity--</option>
                            <?php echo getDropDownEthnicitys($ethnicity_id); ?>
                        </select>
                        <?php echo form_error('ethnicity_id'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="country_id" class="col-sm-2 control-label">Country <sup>*</sup></label>
                    <div class="col-sm-10">
                        <select name="country_id" class="form-control" id="country_id">
                            <?php echo getDropDownCountries($country_id); ?>
                        </select>
                        <?php echo form_error('country_id') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="gmc_number" class="col-sm-2 control-label">GMC <sup>*</sup></label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" name="gmc_number" id="gmc_number"
                                   placeholder="GMC Number"
                                   value="<?php echo $gmc_number; ?>"/>
                            <span class="input-group-addon">Must be Unique</span>
                        </div>
                        <?php echo form_error('gmc_number') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">Phone <sup>*</sup></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number"
                               value="<?php echo $phone; ?>" onkeypress="return DigitOnly(event);"/>
                        <?php echo form_error('phone') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password <sup>*</sup></label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                               value="<?php echo $password; ?>"/>
                        <div id="sign_up_respond_length"></div>
                        <?php echo form_error('password') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="passconf" class="col-sm-2 control-label">Confirm Password <sup>*</sup></label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="passconf" id="passconf" placeholder="Confirm Password"/>
                        <?php echo form_error('passconf') ?>
                        <div id="sign_up_respond2"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="gender" class="col-sm-2 control-label">Gender <sup>*</sup></label>
                    <div class="col-sm-10" style="padding-top:8px;">
                        <?php echo htmlRadio('gender', $gender, array('Male' => 'Male', 'Female' => 'Female')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10 col-md-offset-2">
                        <button type="button" class="btn btn-primary" onclick="sign_up();">Sign Up</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<script type="text/javascript">
    function sign_up() {
        var error = 0;

        var fname = $('#fname').val();
        if (!fname) {
            $('#fname').addClass('required');
            error = 1;
        } else {
            $('#fname').removeClass('required');
        }

        var lname = $('#lname').val();
        if (!lname) {
            $('#lname').addClass('required');
            error = 1;
        } else {
            $('#lname').removeClass('required');
        }

        var your_email = $('#your_email').val();
        if(!your_email){
            $('#your_email').addClass('required');
            $("#your_email_error").remove();
            $("#your_email").after("<span id='your_email_error' class=\"error\">Please enter a valid E-mail address.</span>" );
            error = 1;
        } else {
            $('#your_email').removeClass('required');
            $("#your_email_error").empty();
        }

        var ethnicity_id = $('#ethnicity_id').val();
        if (!ethnicity_id) {
            $('#ethnicity_id').addClass('required');
            error = 1;
        } else {
            $('#ethnicity_id').removeClass('required');
        }

        var country_id = $('#country_id').val();
        if (!country_id) {
            $('#country_id').addClass('required');
            error = 1;
        } else {
            $('#country_id').removeClass('required');
        }

        var gmc_number = $('#gmc_number').val();
        if (!gmc_number) {
            $('#gmc_number').addClass('required');
            error = 1;
        } else {
            $('#gmc_number').removeClass('required');
        }

        var phone = $('#phone').val();
        if (!phone) {
            $('#phone').addClass('required');
            error = 1;
        } else {
            $('#phone').removeClass('required');
        }

        var password = jQuery('#password').val();
        if(!password){
            $('#password').addClass('required');
            error = 1;
        } else{
            $('#password').removeClass('required');
        }

        var passconf = jQuery('#passconf').val();
        if(!passconf){
            $('#passconf').addClass('required');
            error = 1;
        } else{
            $('#passconf').removeClass('required');
        }

        if(password.length <= 5 && ( password.length <= 5 || passconf.length <= 5 ) ){
            $('#sign_up_respond_length').html( '<span class="error">Password need minimum 6 character.</span>' );
            error = 1;
        } else {
            $('#sign_up_respond_length').empty();
        }

        if(password !== passconf ){
            $('#sign_up_respond2').html( '<span class="error">Confirm password not match...</span>' );
            error = 1;
        }

        if (error) {
            return false;
        } else {
            $("#sign_up").submit()
        }
    }
</script>