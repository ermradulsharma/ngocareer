<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Event <small>Control
            panel</small> <?php echo anchor(site_url(Backend_URL . 'event/create'), ' + Add New', 'class="btn btn-default"'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Event</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <?php $this->load->view('filter_form'); ?>
        </div>

        <div class="box-body">
            
            <?php if($events): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th width="40">S/L</th>
                        <th width="100">Image</th>
                        <th>Category</th>
                        <th>Title & Location</th>                        
                        <th width="100">Start Date</th>
                        <th width="100">End Date</th>
                        <th>Organizer</th>
                        <th>View</th>
                        <th>Status</th>
                        <th class="text-center" width="140">Created</th>
                        <th class="text-center" width="190">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($events as $event) { ?>
                        <tr>
                            <td><?php echo ++$start ?></td>
                            <td><img src="<?php echo getPhoto($event->image); ?>" alt="Photo" width="80"></td>
                            <td><?php echo $event->cat_name; ?></td>
                            <td><?php echo $event->title; ?> <br/><?php echo $event->location; ?></td>                            
                            <td><?php echo globalDateFormat($event->start_date); ?></td>
                            <td><?php echo globalDateFormat($event->end_date); ?></td>
                            <td><?php echo $event->organizer_name; ?></td>
                            <td><?php echo $event->hit_count; ?></td>
                            <td><?php echo $event->status; ?></td>
                            <td class="text-center"><?php echo globalDateTimeFormat($event->created_at); ?></td>
                            <td class="text-center">
                                <?php
                                echo anchor(site_url(Backend_URL . 'event/read/' . $event->id), '<i class="fa fa-fw fa-external-link"></i> View', 'class="btn btn-xs btn-primary"');
                                echo anchor(site_url(Backend_URL . 'event/update/' . $event->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-warning"');
                                echo anchor(site_url(Backend_URL . 'event/delete/' . $event->id), '<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger"');
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <span>Total Event: <?php echo $total_rows ?></span>

                </div>
                <div class="col-md-6 text-right">
                    <?php echo $pagination ?>
                </div>
            </div>

            <?php else: ?>
            <p class="ajax_notice">No event found!</p>
            <?php endif; ?>

        </div>
    </div>
</section>