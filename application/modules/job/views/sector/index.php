<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Job_Sector  <small>Control panel</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>job">Job</a></li>
        <li class="active">Job Sector</li>
    </ol>
</section>
<section class="content">

    <div class="row">
        <div class="col-md-4 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add New
                    </h3>
                </div>

                <div class="box-body">
                    <div style="padding:0 15px;">
                        <?php echo form_open(Backend_URL . 'job/sector/create_action', array('class' => 'form-horizontal', 'method' => 'post')); ?>
                        <div class="form-group">
                            <label for="name">Name<sup>*</sup></label>
                            <input type="text" class="form-control" name="name" id="name"
                                   placeholder="Enter sector name" value="<?php echo $name; ?>"/>
                            <?php echo form_error('name') ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save New</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
                        <?php echo form_close(); ?>

                    </div>
                </div>
            </div>
        </div>

        
    </div>
</section>

