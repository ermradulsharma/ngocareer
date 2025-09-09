<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Payment  <small>Control panel</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Payment</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">            
        <div class="box-header with-border">                                   
            <div class="col-md-5 col-md-offset-7 text-right">
                <form action="<?php echo site_url(Backend_URL . 'payment'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php if ($q <> '') { ?>
                                <a href="<?php echo site_url(Backend_URL . 'payment'); ?>" class="btn btn-default">Reset</a>
                            <?php } ?>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="box-body">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                    <thead>
                        <tr>
                            <th width="40">S/L</th>
                            <th>Ref.ID</th>
                            <th>Job Title</th>
                            <th class="text-right">Paid Amount</th>                            
                            <th>Payment Status</th>
                            <th>Email</th>
                            <th width="140">TimeStamp</th>
                            <th width="200" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($payments as $payment) { ?>
                            <tr>
                                <td><?php echo ++$start; ?></td>
                                <td><?php echo $payment->ref_id; ?></td>
                                <td>
                                    <a target="_blank" href="<?php echo site_url("job-details/{$payment->ref_id}/preview.html"); ?>">
                                        <?php echo $payment->job_title; ?>
                                        <i class="fa fa-external-link"></i>
                                    </a>
                                </td>
                                <td class="text-right"><?php echo $payment->paid_amount ?></td>                                
                                <td><?php echo $payment->payment_status ?></td>
                                <td><?php echo $payment->email ?></td>
                                <td><?php echo globalDateTimeFormat($payment->created_at); ?></td>
                                <td class="text-center">
                                    <span class="btn btn-xs btn-primary" 
                                          onclick="popup_details(<?php echo $payment->id; ?>)">
                                        <i class="fa fa-bars"></i>
                                        Payment Log
                                    </span>
                                    <?php                                
                                        echo anchor(
                                            site_url(Backend_URL . 'job/update/' . $payment->ref_id),
                                            '<i class="fa fa-fw fa-edit"></i> Modify Job', 
                                            'class="btn btn-xs btn-warning"'
                                        );
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


            <div class="row">                
                <div class="col-md-6">
                    <span>Total Payment: <?php echo $total_rows ?></span>

                </div>
                <div class="col-md-6 text-right">
                    <?php echo $pagination ?>
                </div>                
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="popup_modal" tabindex="-1" role="dialog" aria-labelledby="popup_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Payment Details</h4>
            </div>
            <div class="modal-body">
                <div class="preview_box table-responsive"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span> Close
                </button>                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function popup_details(id) {  
        $('#popup_modal').modal({show: 'false'});

        $.ajax({
            url: "admin/payment/details/" + id,
            type: "GET",
            dataType: "html",            
            beforeSend: function () {
                $('.preview_box').html('<p class="ajax_processing">Loading...</p>');
            },
            success: function (msg) {
                $('.preview_box').html(msg);
            }
        });
    }
</script>