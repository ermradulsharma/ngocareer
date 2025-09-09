<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Package <small>Control panel</small>
        <?php
        if ($role_id == 1) {
            echo anchor(site_url(Backend_URL . 'package/create'), ' + Add New', 'class="btn btn-default"');
        }
        ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Package</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Package List</h3>
        </div>

        <div class="box-body">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th width="40">S/L</th>
                            <th>Package For</th>
                            <th>Package Name</th>
                            <th class="text-right">Price</th>
                            <th class="text-right">Duration</th>  
                            <th width="20">&nbsp;</th>
                            <th width="150">Created At</th>
                            <th width="150">Updated At</th>
                            <th width="80" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($packages as $package) { ?>
                            <tr>
                                <td><?php echo ++$start ?></td>
                                <td><?php echo $package->type; ?></td>
                                <td><?php echo $package->name; ?></td>
                                <td class="text-right"><?php echo globalCurrencyFormat($package->price); ?></td>
                                
                                <td class="text-right"><?php echo $package->duration; ?> Days</td>
                                <td>&nbsp;</td>
                                <td><?php echo globalDateTimeFormat($package->created_at); ?></td>
                                <td><?php echo globalDateTimeFormat($package->updated_at); ?></td>
                                <td class="text-center">
                                    <?php
                                    echo anchor(site_url(Backend_URL . 'package/update/' . $package->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-warning"');
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <span>Total Package: <?php echo $total_rows ?></span>
                </div>
                <div class="col-md-6 text-right">
                    <?php echo $pagination ?>
                </div>
            </div>
        </div>
    </div>
</section>