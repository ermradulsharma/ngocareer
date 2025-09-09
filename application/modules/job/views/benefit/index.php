<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Job Benefit <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>job">Job</a></li>
        <li class="active">Benefit</li>
    </ol>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-4 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add New
                    </h3>
                </div>

                <div class="box-body">
                    <div style="padding:0 15px;">
                        <?php echo form_open(Backend_URL . 'job/benefit/create_action', array('class' => 'form-horizontal', 'method' => 'post')); ?>
                        <div class="form-group">
                            <label for="name">Benefit<sup>*</sup></label>
                            <input type="text" class="form-control" name="name" id="name"
                                   placeholder="Enter benefit" value="<?php echo $name; ?>"/>
                            <?php echo form_error('name') ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save New</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
                        <?php echo form_close(); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-xs-12">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="col-md-5 col-md-offset-7 text-right">
                        <form action="<?php echo site_url(Backend_URL . 'job/benefit'); ?>" class="form-inline"
                              method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                                <span class="input-group-btn">
                                    <?php if ($q <> '') { ?>
                                        <a href="<?php echo site_url(Backend_URL . 'job/benefit'); ?>"
                                           class="btn btn-default">Reset</a>
                                    <?php } ?>
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="box-body">
                    <?php if($benefits): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th width="40">S/L</th>
                                <th>Name</th>
                                <th width="150">Created At</th>
                                <th width="150">Updated At</th>
                                <th class="text-center" width="90">Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($benefits as $benefit) { ?>
                                <tr>
                                    <td><?php echo ++$start ?></td>
                                    <td><?php echo $benefit->name ?></td>
                                    <td><?php echo globalDateTimeFormat($benefit->created_at) ?></td>
                                    <td><?php echo globalDateTimeFormat($benefit->updated_at) ?></td>
                                    <td class="text-center">
                                        <?php
                                        echo anchor(site_url(Backend_URL . 'job/benefit/update/' . $benefit->id), '<i class="fa fa-fw fa-edit"></i>', 'class="btn btn-xs btn-default" title="Edit"');
                                        echo anchor(site_url(Backend_URL . 'job/benefit/delete/' . $benefit->id), '<i class="fa fa-fw fa-trash"></i>', 'onclick="return confirm(\'Confirm Delete\')" class="btn btn-xs btn-danger" title="Delete"');
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <span class="total_rows_count">Total benefit: <?php echo $total_rows ?></span>
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
        </div>
    </div>
</section>