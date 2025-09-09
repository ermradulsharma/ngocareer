<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>
<section class="content-header">
    <h1>Comment<small><?php echo $button ?></small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>cms">Cms</a></li>
        <li><a href="<?php echo Backend_URL ?>cms/comment">Comment</a></li>
        <li class="active">Update</li>
    </ol>
</section>

<section class="content">
    <div class="box no-border">
        <div class="box-header with-border">
            <h3 class="box-title">Update Comment</h3>
        </div>

        <div class="box-body">
            <form class="form-horizontal" action="<?php echo $action; ?>" method="post">
                <div class="form-group">
                    <label for="comment" class="col-sm-2 control-label">Comment :</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="6" name="comment" id="comment"
                                  placeholder="Comment"><?php echo $comment; ?></textarea>
                        <?php echo form_error('comment') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Status :</label>
                    <div class="col-sm-10"
                         style="padding-top:8px;"><?php echo htmlRadio('status', $status, array('Approve' => 'Approve', 'Unapprove' => 'Unapprove', 'Pending' => 'Pending')); ?></div>
                </div>
                <div class="col-md-12 text-right">
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                    <a href="<?php echo site_url(Backend_URL . 'cms/comment') ?>" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>