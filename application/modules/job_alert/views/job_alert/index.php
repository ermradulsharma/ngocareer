<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Job Alert  <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Job alert</li>
    </ol>
</section>

<section class="content">       
    <div class="box">            
        <div class="box-header with-border">                                   
            <h3 class="box-title">Job Alert Candidate List</h3>
        </div>

        <div class="box-body">            
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th width="40">S/L</th>
                            <th width='150'>Candidate / User</th>
                            <th width='120'>Email</th>
                            <th>Job Categories</th>
                            <th width='150'>Location</th>
                            <th width='120'>Status</th>
                            <th width='120'>Created At</th>
                            <th width="80">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($job_alerts as $job_alert) { ?>
                            <tr>
                                <td><?php echo ++$start; ?></td>
                                <td>
                                    <?php if($job_alert->candidate_id): ?>
                                        <a href="admin/candidate/details/<?php echo $job_alert->candidate_id; ?>">
                                            <?php echo $job_alert->full_name; ?>
                                            <i class="fa fa-external-link"></i>
                                        </a>
                                    <?php else: ?>
                                        <?php echo $job_alert->first_name.' '.$job_alert->last_name; ?>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $job_alert->email; ?></td>
                                <td><?php echo findCategoriesName($categories, $job_alert->job_category_ids); ?></td>
                                <td><?php echo $job_alert->location; ?></td>
                                <td><?php echo $job_alert->status; ?></td>
                                <td><?php echo globalDateFormat($job_alert->created_at); ?></td>
                                <td>
                                    <?php echo anchor(site_url(Backend_URL . 'job_alert/delete/' . $job_alert->id), '<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); ?>
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


            <div class="row">                
                <div class="col-md-6">
                    <span class="btn btn-primary">Total: <?php echo $total_rows; ?></span>

                </div>
                <div class="col-md-6 text-right">
                    <?php echo $pagination; ?>
                </div>                
            </div>
        </div>
    </div>
</section>