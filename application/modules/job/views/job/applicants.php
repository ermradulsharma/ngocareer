<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>
<style type="text/css">
    .application .table td a.btn {
        margin: 2px 2px;
    }
</style>
<section class="content-header">
    <h1>Job <small>Read</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo site_url(Backend_URL . 'job') ?>">Job</a></li>
        <li class="active">Details</li>
    </ol>
</section>

<section class="content">
    <?php echo jobTabs($id, 'applicants'); ?>
    <div class="box no-border">

        <div class="box-header with-border">
            <?php echo $this->load->view('applicants_filter'); ?>
        </div>
        
        <div class="box-body">            
            <div class="table-responsive application">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th width="40">S/L</th>                            
                            <th width="150">Candidate Photo</th>
                            <th width="200">Candidate</th>
                            <th class="text-right" width="100">Exp. Salary</th>
                            <th>Cover Letter</th>
                            <th width="150">Applied At</th>
                            <th width="100" class="text-center">Status</th>
                            <th width="180" class="text-center">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php
                        foreach ($applicants as $app) {
                            $job_url = site_url("job-details/{$app->id}/abc.html");
                            ?>
                            <tr>
                                <td><?php echo ++$start; ?></td>
                                <td><img src="<?php echo getCandidatePhoto($app->picture); ?>" 
                                         alt="<?php echo $app->full_name; ?>" 
                                         class="img-thumbnail">
                                </td>
                                <td>
                                    <?php echo $app->full_name; ?> ( ID# <?php echo $app->can_id; ?>)<br/>
                                    <i class="fa fa-envelope-o"></i> <?php echo $app->email; ?><br/>
                                    <i class="fa fa-phone"></i> <?php echo $app->mobile_number; ?><br/>
                                    
                                    <span class="btn btn-xs btn-primary" 
                                          onClick="popup_profile(<?= $app->can_id; ?>)"
                                          id="<?php echo $app->can_id; ?>">
                                        <i class="fa fa-bars"></i>
                                        Profile
                                    </span>                                
                                </td>
                                
                                
                                <td class="text-right"><?php echo globalCurrencyFormat($app->expected_salary); ?></td>                               
                                <td><?php echo $app->cover_letter; ?></td>                                
                                <td><?php echo globalDateTimeFormat($app->applied_at); ?></td>
                                <td class="text-center" id="status_<?php echo $app->id;?>"><?php echo applicantStatus($app->status);?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url('my_account/download/' . $app->cv_id); ?>" class="btn btn-sm btn-primary" title="CV Download"><i class="fa fa-download"></i></a>
                                    <a href="<?php echo googlePreviewLink( $app->cv_id ); ?>" class="btn btn-sm btn-info" title="CV Preview" target="_blank"><i class="fa fa-external-link"></i></a>
                                    <a class="btn btn-sm btn-success"id="application_shortlisted_<?php echo $app->id;?>" target="_blank" title="Shortlist" onclick="applicationStatus('Shortlisted', '<?php echo $app->id; ?>')"><i class="fa fa-check-circle-o"></i></a>
                                    <a class="btn btn-sm btn-danger" id="application_rejected_<?php echo $app->id;?>" target="_blank" title="Reject" onclick="applicationStatus('Rejected', '<?php echo $app->id; ?>')"><i class="fa fa-close"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9">
                                    <em><?php echo $app->remarks; ?></em>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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
                <h4 class="modal-title">Profile Preview</h4>
            </div>
            <div class="modal-body" >                    
                <div class="preview_box"></div>
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

    function popup_profile(id) {  
        $('#popup_modal').modal({show: 'false'});

        $.ajax({
            url: "admin/candidate/popup/" + id,
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
    
    function applicationStatus(status, application_id) {
        
        if (confirm('Are you sure, you want to '+status+'?')) {
            
            $.ajax({
                url: '<?php echo site_url('admin/job/application_status'); ?>',
                type: "POST",
                dataType: "json",
                cache: false,
                data: {
                    status: status,
                    application_id: application_id
                },
                beforeSend: function () {
//                    toastr.warning("Please Wait...");
                },
                success: function (jsonRespond) {
                    // Remove current toasts using animation
                    toastr.clear();

                    if (jsonRespond.Status === 'OK') {
                        if(status==='Shortlisted'){
                            $('#status_'+application_id).html('<span class="badge label-success">'+status+'</span>');
                        }else if(status==='Rejected'){
                            $('#status_'+application_id).html('<span class="badge label-danger">'+status+'</span>');
                        }
                        toastr.success("This application has been " + status);
                    } else {
                        toastr.error(res.Msg);
                    }
                }
            });
        }
        return false;
    }
</script>