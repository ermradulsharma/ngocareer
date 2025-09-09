<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users','css'); ?>
<section class="content-header">
    <h1>Candidate  <small>Delete</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url( Backend_URL )?>"><i class="fa fa-dashboard"></i> Admin</a></li>
	<li><a href="<?php echo Backend_URL ?>candidate">Candidate</a></li>
        <li class="active">Delete</li>
    </ol>
</section>

<section class="content">
    <?php echo candidateTabs($id, 'delete'); ?>
    <div class="box no-border">
        <div class="box-header with-border">
            <h3 class="box-title">Preview Before Delete</h3>
        </div>
        <table class="table table-striped">
	    <tr><td width="150">Oauth Provider</td><td width="5">:</td><td><?php echo $oauth_provider; ?></td></tr>
	    <tr><td width="150">Oauth Uid</td><td width="5">:</td><td><?php echo $oauth_uid; ?></td></tr>
	    <tr><td width="150">First Name</td><td width="5">:</td><td><?php echo $first_name; ?></td></tr>
	    <tr><td width="150">Last Name</td><td width="5">:</td><td><?php echo $last_name; ?></td></tr>
	    <tr><td width="150">Full Name</td><td width="5">:</td><td><?php echo $full_name; ?></td></tr>
	    <tr><td width="150">Email</td><td width="5">:</td><td><?php echo $email; ?></td></tr>
	    <tr><td width="150">Password</td><td width="5">:</td><td><?php echo $password; ?></td></tr>
	    <tr><td width="150">Date Of Birth</td><td width="5">:</td><td><?php echo $date_of_birth; ?></td></tr>
	    <tr><td width="150">Marital Status</td><td width="5">:</td><td><?php echo $marital_status; ?></td></tr>
	    <tr><td width="150">Country Id</td><td width="5">:</td><td><?php echo $country_id; ?></td></tr>
	    <tr><td width="150">Permanent Address</td><td width="5">:</td><td><?php echo $permanent_address; ?></td></tr>
	    <tr><td width="150">Present Address</td><td width="5">:</td><td><?php echo $present_address; ?></td></tr>
	    <tr><td width="150">Home Phone</td><td width="5">:</td><td><?php echo $home_phone; ?></td></tr>
	    <tr><td width="150">Mobile Number</td><td width="5">:</td><td><?php echo $mobile_number; ?></td></tr>
	    <tr><td width="150">Gender</td><td width="5">:</td><td><?php echo $gender; ?></td></tr>
	    <tr><td width="150">Status</td><td width="5">:</td><td><?php echo $status; ?></td></tr>
	    <tr><td width="150">Picture</td><td width="5">:</td><td><?php echo $picture; ?></td></tr>
	    <tr><td width="150">Career Summary</td><td width="5">:</td><td><?php echo $career_summary; ?></td></tr>
	    <tr><td width="150">Qualifications</td><td width="5">:</td><td><?php echo $qualifications; ?></td></tr>
	    <tr><td width="150">Keywords</td><td width="5">:</td><td><?php echo $keywords; ?></td></tr>
	    <tr><td width="150">Additional Information</td><td width="5">:</td><td><?php echo $additional_information; ?></td></tr>
	    <tr><td width="150">Created At</td><td width="5">:</td><td><?php echo $created_at; ?></td></tr>
	    <tr><td width="150">Modified</td><td width="5">:</td><td><?php echo $modified; ?></td></tr>
	</table>
	<div class="box-header">
			 <?php echo anchor(site_url(Backend_URL .'candidate/delete_action/'.$id),'<i class="fa fa-fw fa-trash"></i> Confrim Delete ', 'class="btn btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); ?>
	</div>
	</div></section>