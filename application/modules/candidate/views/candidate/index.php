<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Candidate <small>Control
            panel</small> <?php echo anchor(site_url(Backend_URL . 'candidate/create'), ' + Add New', 'class="btn btn-default"'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Candidate</li>
    </ol>
</section>

<style type="text/css">ul.dropdown-menu li {cursor: pointer;}</style>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <?php $this->load->view('index_filter'); ?>
            <?php // echo $sql; ?>
        </div>

        <div class="box-body">
            <?php echo $this->session->flashdata('message'); ?>
            <?php if($candidates): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-condensed">
                        <thead>
                        <tr>
                            <th width="40">S/L</th>
                            <th width="100">Photo</th>
                            <th width="200">Full Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>

                            <th>Status</th>

                            <th width="100">Created At</th>
                            <th width="100">Modified</th>
                            <th class="text-center" width="100">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($candidates as $cn) { ?>
                            <tr>
                                <td><?php echo ++$start; ?></td>
                                <td>
                                    <img src="<?php echo getCandidatePhoto($cn->picture); ?>"
                                         alt="<?php echo $cn->full_name; ?>"
                                         class="img-thumbnail">
                                </td>
                                <td><p><?php echo $cn->full_name; ?><br/>
                                        <?php echo $cn->gender; ?><br/>
                                        <?php echo $cn->marital_status; ?><br/>
                                        <?php echo globalDateFormat($cn->date_of_birth); ?>
                                    </p>
                                </td>
                                <td><?php echo $cn->email; ?> <br/>
                                    <?php echo getCountryName($cn->country_id); ?></td>
                                <td>Primary: <?php echo $cn->mobile_number; ?><br/>
                                    Home: <?php echo $cn->home_phone; ?></td>

                                <td><?php echo candidateStatus($cn->status, $cn->id); ?></td>
                                <td><?php echo globalDateFormat($cn->created_at); ?></td>
                                <td><?php echo globalDateFormat($cn->modified); ?></td>
                                <td class="text-center">
                                    <?php
                                    echo anchor(
                                        site_url(Backend_URL.'candidate/read/'.$cn->id),
                                        '<i title="View" class="fa fa-fw fa-external-link"></i>',
                                        'class="btn btn-xs btn-primary"'
                                    );
                                    echo anchor(
                                        site_url(Backend_URL . 'candidate/update/' . $cn->id),
                                        '<i title="Edit" class="fa fa-fw fa-edit"></i>',
                                        'class="btn btn-xs btn-info"'
                                    );
//                                    echo anchor(
//                                        site_url(Backend_URL . 'candidate/delete/' . $cn->id),
//                                        '<i title="Delete" class="fa fa-fw fa-trash"></i>',
//                                        'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'
//                                    );
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <span>Total Candidate: <?php echo $total_rows ?></span>
                    </div>
                    <div class="col-md-6 text-right">
                        <?php echo $pagination ?>
                    </div>
                </div>
            <?php else: ?>
                <p class="ajax_notice">No result found!</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<script type="text/javascript">
    function statusUpdate(post_id, status){
        $.ajax({
            url: 'admin/candidate/set_status',
            type: 'POST',
            dataType: "json",
            data: { status: status, post_id: post_id  },
            beforeSend: function(){
                $('#active_status_'+ post_id ).html('Updating...');
            },
            success: function ( jsonRespond ) {
                $('#active_status_'+post_id)
                    .html(jsonRespond.Status)
                    .removeClass( 'btn-default btn-danger btn-warning btn-success')
                    .addClass( jsonRespond.Class );
            }
        });
    }
</script>