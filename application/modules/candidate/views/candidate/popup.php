<div class="row">
    <div class="col-md-8">
        <table class="table table-striped table-bordered">                       
            <tr><td width="150">Full Name</td><td width="5">:</td><td><?php echo $full_name; ?></td></tr>
            <tr><td>Email</td><td>:</td><td><?php echo $email; ?></td></tr>                                                
            <tr><td>Country</td><td>:</td><td><?php echo $country; ?></td></tr>
            <tr><td>Permanent Address</td><td>:</td><td><?php echo $permanent_address; ?></td></tr>
            <tr><td>Present Address</td><td>:</td><td><?php echo $present_address; ?></td></tr>
            <tr><td>Home Phone</td><td>:</td><td><?php echo $home_phone; ?></td></tr>
            <tr><td>Mobile Number</td><td>:</td><td><?php echo $mobile_number; ?></td></tr>                                                                        
            <tr><td>Career Summary</td><td>:</td><td><?php echo $career_summary; ?></td></tr>
            <tr><td>Qualifications</td><td>:</td><td><?php echo $qualifications; ?></td></tr>
            <tr><td>Keywords</td><td>:</td><td><?php echo $keywords; ?></td></tr>
            <tr><td>Additional Information</td><td>:</td><td><?php echo $additional_information; ?></td></tr>                        
        </table>
    </div>
    <div class="col-md-4">
        <img src="<?php echo getCandidatePhoto($picture); ?>" class="img-thumbnail">

        <table class="table table-striped table-bordered">
            <tr><td>Date of Birth</td><td>:</td><td><?php echo $date_of_birth; ?></td></tr>
            <tr><td>Marital Status</td><td>:</td><td><?php echo $marital_status; ?></td></tr>                        
            <tr><td>Gender</td><td>:</td><td><?php echo $gender; ?></td></tr>
            <tr><td>Status</td><td>:</td><td><?php echo $status; ?></td></tr>                      
            <tr><td>Register at</td><td>:</td><td><?php echo $created_at; ?></td></tr>
            <tr><td>Last Update</td><td>:</td><td><?php echo $modified; ?></td></tr>

        </table>
    </div>
</div>

