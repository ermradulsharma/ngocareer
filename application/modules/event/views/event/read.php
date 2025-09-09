<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users','css'); ?>
<section class="content-header">
    <h1>Event  <small>Read</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url( Backend_URL )?>"><i class="fa fa-dashboard"></i> Admin</a></li>
	<li><a href="<?php echo site_url( Backend_URL .'event' )?>">Event</a></li>
        <li class="active">Details</li>
    </ol>
</section>

<section class="content">
    <?php echo eventTabs($id, 'read'); ?>
    <div class="box no-border">
        
        <div class="box-header with-border">
            <h3 class="box-title">Details View</h3>
            <?php echo $this->session->flashdata('message'); ?>
        </div>
        <table class="table table-striped">
	    <tr><td width="150">Event Category Id</td><td width="5">:</td><td><?php echo $event_category_id; ?></td></tr>
	    <tr><td width="150">Title</td><td width="5">:</td><td><?php echo $title; ?></td></tr>
	    <tr><td width="150">Location</td><td width="5">:</td><td><?php echo $location; ?></td></tr>
	    <tr><td width="150">Lat</td><td width="5">:</td><td><?php echo $lat; ?></td></tr>
	    <tr><td width="150">Lng</td><td width="5">:</td><td><?php echo $lng; ?></td></tr>
	    <tr><td width="150">Physical Address</td><td width="5">:</td><td><?php echo $physical_address; ?></td></tr>
	    <tr><td width="150">Region</td><td width="5">:</td><td><?php echo $region; ?></td></tr>
	    <tr><td width="150">Country Id</td><td width="5">:</td><td><?php echo $country_id; ?></td></tr>
	    <tr><td width="150">Event Link</td><td width="5">:</td><td><?php echo $event_link; ?></td></tr>
	    <tr><td width="150">Start Date</td><td width="5">:</td><td><?php echo $start_date; ?></td></tr>
	    <tr><td width="150">End Date</td><td width="5">:</td><td><?php echo $end_date; ?></td></tr>
	    <tr><td width="150">Description</td><td width="5">:</td><td><?php echo $description; ?></td></tr>
	    <tr><td width="150">Full Description</td><td width="5">:</td><td><?php echo $full_description; ?></td></tr>
	    <tr><td width="150">Summary</td><td width="5">:</td><td><?php echo $summary; ?></td></tr>
	    <tr><td width="150">Image</td><td width="5">:</td><td><?php echo $image; ?></td></tr>
	    <tr><td width="150">Organizer Name</td><td width="5">:</td><td><?php echo $organizer_name; ?></td></tr>
	    <tr><td width="150">Organization Type</td><td width="5">:</td><td><?php echo $organization_type; ?></td></tr>
	    <tr><td width="150">Organization Details</td><td width="5">:</td><td><?php echo $organization_details; ?></td></tr>
	    <tr><td width="150">Status</td><td width="5">:</td><td><?php echo $status; ?></td></tr>
	    <tr><td width="150">Hit Count</td><td width="5">:</td><td><?php echo $hit_count; ?></td></tr>
	    <tr><td width="150">Remark</td><td width="5">:</td><td><?php echo $remark; ?></td></tr>
	    <tr><td width="150">Created At</td><td width="5">:</td><td><?php echo $created_at; ?></td></tr>
	    <tr><td width="150">Updated At</td><td width="5">:</td><td><?php echo $updated_at; ?></td></tr>
	    <tr><td></td><td></td><td><a href="<?php echo site_url( Backend_URL .'event') ?>" class="btn btn-default"><i class="fa fa-long-arrow-left"></i> Back</a><a href="<?php echo site_url( Backend_URL .'event/update/'.$id ) ?>" class="btn btn-primary"> <i class="fa fa-edit"></i> Edit</a></td></tr>
	</table>
	</div></section>