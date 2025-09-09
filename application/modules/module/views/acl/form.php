<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1> Access Control List  <small><?php echo $button ?></small> 
        <a href="<?php echo site_url( Backend_URL . 'module/acl') ?>" class="btn btn-default">Back</a> 
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL; ?>module/acl">Acls</a></li>
        <li class="active">Update Key</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Update ACL Key</h3>
        </div>
<?php echo validation_errors(); ?>
        <div class="box-body">
            <form class="form-horizontal" action="<?php echo $action; ?>" method="post">
                <input type="hidden" name="update" value="<?php echo $update; ?>" />
                <div class="form-group">
                    <label for="module_id" class="col-sm-2 control-label">Select Module:</label>
                    <div class="col-sm-3">                    
                        <select class="form-control" name="module_id" id="module_id">
                            <?php echo get_all_modules($module_id); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="permission_name" class="col-sm-2 control-label">Permission Name :</label>
                    <div class="col-sm-3">                    
                        <input type="text" class="form-control" name="permission_name" id="permission_name" placeholder="Permission Name" value="<?php echo $permission_name; ?>" />
                        <?php echo form_error('permission_name') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="permission_key" class="col-sm-2 control-label">Permission Key :</label>
                    <div class="col-sm-3">                    
                        <input type="text" class="form-control" name="permission_key" id="permission_key" placeholder="Permission Key" value="<?php echo $permission_key; ?>" />
                        <?php echo form_error('permission_key') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="order_id" class="col-sm-2 control-label">Order No :</label>
                    <div class="col-sm-3">                    
                        <input type="text" class="form-control" name="order_id" id="order_id" placeholder="Order Id" value="<?php echo $order_id; ?>" />
                        <?php echo form_error('order_id') ?>
                    </div>
                </div>
                <div class="col-md-5 text-right">
                    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                    <a href="<?php echo site_url( Backend_URL . 'module/acl'); ?>" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>