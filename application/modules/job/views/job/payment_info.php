<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>
<section class="content-header">
    <h1>Job  <small>Payment</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo site_url(Backend_URL . 'job') ?>">Job</a></li>
        <li class="active">Make Payment</li>
    </ol>
</section>

<section class="content">
    <?php echo jobTabs($id, 'payment_form'); ?>
    <div class="box no-border">
        <div class="box-header with-border">
            <h3 class="box-title">Payment</h3>
        </div>
        <div class="box-body">
            <table class="table table-striped table-bordered">
                <tr><td width="200">Payment of </td><td width='5'>:</td><td><?php echo $table; ?></td></tr>
                <tr><td>Ref ID</td><td width='5'>:</td><td><?php echo $ref_id; ?></td></tr>
                <tr><td>Paid Amount</td><td>:</td><td><?php echo $paid_amount; ?></td></tr>    
                <tr><td>Payment Status</td><td>:</td><td><?php echo $payment_status; ?></td></tr>
                <tr><td>Email</td><td>:</td><td><?php echo $email; ?></td></tr>
                <tr><td>Created At</td><td>:</td><td><?php echo GDF($created_at); ?></td></tr>    
            </table>            
        </div>
    </div>
</section>