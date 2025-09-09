<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1>Acls  <small>Read</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url( Backend_URL )?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo site_url( Backend_URL .'acls' )?>">Acls</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Single View</h3>
        </div>
        <table class="table table-striped">
	    <tr><td width="150">Module Id</td><td width="5">:</td><td><?php echo $module_id; ?></td></tr>
	    <tr><td width="150">Permission Name</td><td width="5">:</td><td><?php echo $permission_name; ?></td></tr>
	    <tr><td width="150">Permission Key</td><td width="5">:</td><td><?php echo $permission_key; ?></td></tr>
	    <tr><td width="150">Order Id</td><td width="5">:</td><td><?php echo $order_id; ?></td></tr>
	    <tr><td></td><td></td><td><a href="<?php echo site_url( Backend_URL .'acls') ?>" class="btn btn-default"><i class="fa fa-long-arrow-left"></i> Back</a><a href="<?php echo site_url( Backend_URL .'acls/update/'.$id ) ?>" class="btn btn-primary"> <i class="fa fa-edit"></i> Edit</a></td></tr>
	</table>
	</div></section>