<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1>Subscriber  <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/newsletter_subscriber') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/newsletter_subscriber">Subscriber</a></li>
        <li class="active"><?php echo $button ?></li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $button ?> Subscriber</h3>
        </div>

        <div class="box-body">
            <form class="form-horizontal" action="<?php echo $action; ?>" method="post">
                <div class="form-group">
                    <label for="varchar" class="col-sm-2 control-label">Name :</label>
                    <div class="col-sm-6">                    
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $name; ?>" />

                    </div>
                </div>
                <div class="form-group">
                    <label for="varchar" class="col-sm-2 control-label">Email :</label>
                    <div class="col-sm-6">                    
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
                        <?php echo form_error('email') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="enum" class="col-sm-2 control-label">Status :</label>
                    <div class="col-sm-6" style="padding-top: 8px;">
                        <?php echo htmlRadio('status', $status, ['Subscribe' => 'Subscribe', 'Unsubscribe' => 'Unsubscribe']) ?>                                                
                    </div>
                </div>


                <div class="col-md-8 text-right">    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                    <a href="<?php echo site_url('admin/newsletter_subscriber') ?>" class="btn btn-default">Cancel</a>
                </div></form>
        </div>
    </div>
</section>