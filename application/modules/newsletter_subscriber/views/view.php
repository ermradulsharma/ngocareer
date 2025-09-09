<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1>Newsletter_subscriber  <small>Read</small> </h1>
    <ol class="breadcrumb">
        <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/newsletter_subscriber">Newsletter_subscriber</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Single View</h3>
        </div>
        <table class="table table-striped">
	    <tr><td width="150">Name</td><td width="5">:</td><td><?php echo $name; ?></td></tr>
	    <tr><td width="150">Email</td><td width="5">:</td><td><?php echo $email; ?></td></tr>
	    <tr><td width="150">Status</td><td width="5">:</td><td><?php echo $status; ?></td></tr>
	    <tr><td width="150">Created</td><td width="5">:</td><td><?php echo $created; ?></td></tr>
	    <tr><td width="150">Modified</td><td width="5">:</td><td><?php echo $modified; ?></td></tr>
	    <tr><td></td><td></td><td><a href="<?php echo site_url('newsletter_subscriber') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
	</div></section>