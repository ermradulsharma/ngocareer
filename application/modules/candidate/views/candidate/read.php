<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>
<section class="content-header">
    <h1>Candidate <small>Read</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo site_url(Backend_URL . 'candidate') ?>">Candidate</a></li>
        <li class="active">Details</li>
    </ol>
</section>

<section class="content">
    <?php echo candidateTabs($id, 'read'); ?>
    <div class="box no-border">

        <div class="box-header with-border">
            <h3 class="box-title">Details View</h3>
        </div>

        <div class="box-body">

            <div class="row">
                <div class="col-md-8">
                    <table class="table table-striped table-bordered">
                        <tr><td width="150">Full Name</td><td width="5">:</td><td><?php echo $full_name; ?></td></tr>
                        <tr><td>Email</td><td>:</td><td><?php echo $email; ?></td></tr>
                        <tr><td>Country</td><td>:</td><td><?php echo $country; ?></td></tr>
                        <tr><td>Permanent Address</td><td>:</td><td><?php echo $permanent_address; ?></td></tr>
                        <tr><td>Present Address</td><td>:</td><td><?php echo $present_address; ?></td></tr>
                        <tr><td>Home Phone</td><td>:</td><td><?php echo $home_phone; ?></td></tr>
                        <tr><td>Mobile Number</td><td>:</td><td><?php echo $mobile_number; ?></td></tr>
                        <tr><td>Career Summary</td><td>:</td><td><?php echo $career_summary; ?></td></tr>
                        <tr><td>Qualifications</td><td>:</td><td><?php echo $qualifications; ?></td></tr>
                        <tr><td>Keywords</td><td>:</td><td><?php echo $keywords; ?></td></tr>
                        <tr><td>Additional Information</td><td>:</td><td><?php echo $additional_information; ?></td></tr>
                        <tr><td>CV</td><td>:</td><td>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="50">#</th>
                                        <th>CV Title</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $row = 1;
                                    foreach ($cvs as $key => $cv) {
                                        ?>
                                        <tr id="row_<?php echo $cv->id;?>">
                                            <th scope="row"><?php echo $row;?></th>
                                            <td><?php echo $cv->orig_name; ?></td>
                                            <td width="120" class="text-center">
                                                <!--                                                <button type="button" class="btn btn-xs btn-danger delete_file_link"-->
                                                <!--                                                        data-file_id="--><?php //echo $cv->id; ?><!--">-->
                                                <!--                                                    <i class="fa fa-times"></i>-->
                                                <!--                                                    Delete-->
                                                <!--                                                </button>-->

                                                <a  target="_blank" href="<?php echo site_url('uploads/cv/'.$cv->file); ?>"
                                                    class="btn btn-success btn-xs" data-file_id="<?php echo $cv->id?>">
                                                    <i class="fa fa-download"></i>
                                                    Download
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        $row++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4">
                    <img src="<?php echo getPhoto($picture); ?>" class="img-thumbnail">

                    <table class="table table-striped table-bordered">
                        <tr><td>Date of Birth</td><td>:</td><td><?php echo globalDateFormat($date_of_birth); ?></td></tr>
                        <tr><td>Marital Status</td><td>:</td><td><?php echo $marital_status; ?></td></tr>
                        <tr><td>Gender</td><td>:</td><td><?php echo $gender; ?></td></tr>
                        <tr><td>Status</td><td>:</td><td><?php echo $status; ?></td></tr>
                        <tr><td>Register at</td><td>:</td><td><?php echo globalDateTimeFormat($created_at); ?></td></tr>
                        <tr><td>Last Update</td><td>:</td><td><?php echo globalDateTimeFormat($modified); ?></td></tr>
                    </table>
                </div>
            </div>

        </div>

        <div class="box-footer text-right">
            <button class="btn btn-default" onclick="return history.go(-1);"><i class="fa fa-arrow-left"></i> Back</button>
        </div>

    </div>
</section>