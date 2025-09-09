<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1> Package <small><?php echo $button ?></small> <a href="<?php echo site_url(Backend_URL . 'package') ?>"
                                                         class="btn btn-default">Back</a></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>package">Package</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Add New Package</h3>
        </div>

        <div class="box-body">
            <?php echo form_open($action, array('class' => 'form-horizontal', 'method' => 'post')); ?>
            
            <div class="form-group">
                <label for="type" class="col-sm-2 control-label">Package For<sup>*</sup></label>
                <div class="col-sm-10"
                     style="padding-top:8px;"><?php echo htmlRadio('type', $type, array('Event' => 'Event', 'Job' => 'Job')); ?></div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Package Name<sup>*</sup></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Package Name"
                           value="<?php echo $name; ?>"/>
                    <?php echo form_error('name') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="price" class="col-sm-2 control-label">Price<sup>*</sup></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="price" id="price" placeholder="Price"
                           value="<?php echo $price; ?>" onkeypress="return DigitOnly(event);"/>
                    <?php echo form_error('price') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="duration" class="col-sm-2 control-label">Duration<sup>*</sup></label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" name="duration" id="duration" placeholder="Duration"
                               value="<?php echo $duration; ?>" onkeypress="return DigitOnly(event);"/>
                        <div class="input-group-addon">Days</div>
                    </div>
                    <?php echo form_error('duration') ?>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-md-10 col-md-offset-2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                    <a href="<?php echo site_url(Backend_URL . 'package') ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>