<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>
<section class="content-header">
    <h1>Mailbox  <small>Read</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo site_url(Backend_URL . 'mailbox') ?>">Mailbox</a></li>
        <li class="active">Details</li>
    </ol>
</section>

<section class="content">    
    <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">Details View</h3>            
        </div>
        <div class="box-body">
            
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-bordered table-striped">                        
                        <tr><td width="100">From</td><td width="5">:</td><td><?php echo $sender_id ." | ". $mail_from; ?></td></tr>
                        <tr><td>To</td><td>:</td><td><?php echo $receiver_id ." | " . $mail_to; ?></td></tr>                                
                        <tr><td>Subject</td><td>:</td><td><?php echo $subject; ?></td></tr>                        
                    </table>
                    
                    
                </div>
                <div class="col-md-4">
                    <table class="table table-bordered table-striped">
                        <tr><td width="100">Mail Type</td><td width="5">:</td><td><?php echo $mail_type; ?></td></tr>                                      
                        <tr><td>Sent At</td><td>:</td><td><?php echo globalDateTimeFormat($sent_at); ?></td></tr>
                        <tr><td>Status</td><td>:</td><td><?php echo $status; ?></td></tr>
                    </table>
                </div>
            </div>            
            <?php echo $body; ?>
                        
            <a href="<?php echo site_url(Backend_URL . 'mailbox') ?>" class="btn btn-default">
                <i class="fa fa-long-arrow-left"></i> Back to Mailbox
            </a>
            
        </div>
    </div>
</section>