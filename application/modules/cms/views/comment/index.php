<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Comments <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>cms">Cms</a></li>
        <li class="active">Comment</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header">
            <?php $this->load->view('filter'); ?>
        </div>

        <div class="box-body">
            <?php if($comments): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-condensed">
                    <thead>
                    <tr>
                        <th width="40">S/L</th>
                        <th width="220">User</th>
                        <th>Comment</th>
                        <th>In response to</th>
                        <th>Status</th>
                        <th width="150">Submitted on</th>
                        <th width="150">Updated on</th>
                        <th width="140">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($comments as $comment) { ?>
                        <tr>
                            <td><?php echo ++$start ?></td>
                            <td>
                                <?php if($comment->user_id): ?>
                                    <strong><?php echo $comment->first_name.' '.$comment->last_name; ?></strong><br>
                                    <?php echo $comment->user_email; ?>
                                <?php else: ?>
                                    <strong><?php echo $comment->name; ?></strong><br>
                                    <?php echo $comment->email; ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $comment->comment; ?></td>
                            <td>
                                <a href="<?php echo site_url($comment->post_url); ?>" target="_blank">
                                    <?php echo getShortContent($comment->post_title, 30); ?>
                                </a>
                            </td>
                            <td><?php echo $comment->status; ?></td>
                            <td><?php echo globalDateTimeFormat($comment->created_at); ?></td>
                            <td><?php echo globalDateTimeFormat($comment->updated_at); ?></td>
                            <td>
                                <?php
                                echo anchor(site_url(Backend_URL . 'cms/comment/update/' . $comment->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-warning"');
                                echo anchor(site_url(Backend_URL . 'cms/comment/delete/' . $comment->id), '<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="return confirm(\'Are you sure!\');"');
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <span class="total_rows_count">Total Comment: <?php echo $total_rows ?></span>

                </div>
                <div class="col-md-6 text-right">
                    <?php echo $pagination ?>
                </div>
            </div>
            <?php else:
            echo noResult();
            endif; ?>
        </div>
    </div>
</section>