<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Job <small>Control
            panel</small> <?php echo anchor(site_url(Backend_URL . 'job/create'), ' + Add New', 'class="btn btn-default"'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Job</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header">
            <?php $this->load->view('job_filter_form'); ?>
        </div>
        <div class="box-body">
            <?php if($jobs): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered job-data">
                    <thead>
                    <tr>
                        <th width="40">S/L</th>
                        <th width="80">Ref.ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th width="110">Deadline</th>
                        <th class="text-center">Vacancy</th>
                        <th class="text-center">Hit</th>
                        <th class="text-center">Applicant</th>
                        <th>Status</th>
                        <th width="140">Post Date</th>
                        <th width="220" class="text-center">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($jobs as $job) { ?>
                        <tr>
                            <td><?php echo ++$start ?></td>
                            <td><?php echo $job->id; ?></td>
                            <td>
                                <a target="_blank" href="<?php echo site_url("job-details/{$job->id}/preview.html"); ?>">
                                    <?php echo $job->title; ?>
                                    <i class="fa fa-external-link"></i>
                                </a>                                
                                </td>
                            <td><?php echo $job->category_name; ?></td>
                            <td><?php echo $job->location; ?></td>
                            <td><?php echo deadline($job->deadline); ?></td>
                            <td class="text-center"><?php echo sprintf('%02d',$job->vacancy); ?></td>
                            <td class="text-center"><?php echo $job->hit_count; ?></td>
                            <td class="text-center">
                                <a href="<?php echo site_url( Backend_URL . 'job/applicants/' . $job->id); ?>">
                                    <?php echo viewApplication($job->id); ?>
                                    &nbsp;
                                    <i class="fa fa-external-link"></i>
                                </a>
                                
                            </td>
                            <td><?php echo $job->status; ?></td>
                            <td><?php echo globalDateTimeFormat($job->created_at); ?></td>
                            <td class="text-center">
                                <?php
                                echo anchor(site_url(Backend_URL . 'job/preview/' . $job->id), '<i class="fa fa-fw fa-external-link"></i> View', 'class="btn btn-xs btn-primary"');
                                echo anchor(site_url(Backend_URL . 'job/update/' . $job->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-warning"');
                                echo '<br/>';
                                echo anchor(site_url(Backend_URL . 'job/applicants/' . $job->id), '<i class="fa fa-fw fa-list"></i> Applicants', 'class="btn btn-xs btn-success"');
                                echo anchor(site_url(Backend_URL . 'job/payment_form/' . $job->id), '<i class="fa fa-fw fa-list"></i> Make Payment', 'class="btn btn-xs btn-info"');
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <span class="total_rows_count">Total Job: <?php echo $total_rows ?></span>
                </div>
                <div class="col-md-6 text-right">
                    <?php echo $pagination ?>
                </div>
            </div>

            <?php else: ?>
            <p class="ajax_notice">No record found!</p>
            <?php endif; ?>

        </div>
    </div>
</section>