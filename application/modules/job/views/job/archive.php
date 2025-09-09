<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>
<section class="content-header">
    <h1>Job <small>Delete</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>job">Job</a></li>
        <li class="active">Delete</li>
    </ol>
</section>

<section class="content">
    <?php echo jobTabs($id, 'archive'); ?>
    <div class="box no-border">
        <div class="box-header with-border">
            <h3 class="box-title">Preview Before Delete</h3>
        </div>
        <div class="box-body">
        <table class="table table-striped">
            <tr>
                <td width="200">Title</td>
                <td>:</td>
                <td><?php echo $title; ?></td>
            </tr>
            <tr>
                <td>Location</td>
                <td>:</td>
                <td><?php echo $location; ?></td>
            </tr>            
            <tr>
                <td>Salary</td>
                <td>:</td>
                <td><?php echo $salary; ?></td>
            </tr>            
            <tr>
                <td>Application Deadline</td>
                <td>:</td>
                <td><?php echo $deadline; ?></td>
            </tr>
            <tr>
                <td>Vacancy</td>
                <td>:</td>
                <td><?php echo $vacancy; ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td><?php echo $status; ?></td>
            </tr>
            <tr>
                <td>Recruiters Note</td>
                <td>:</td>
                <td><?php echo $recruiters_note; ?></td>
            </tr>
            <tr>
                <td>Admin Note</td>
                <td>:</td>
                <td><?php echo $admin_note; ?></td>
            </tr>
            <tr>
                <td>Created At</td>
                <td>:</td>
                <td><?php echo $created_at; ?></td>
            </tr>
            <tr>
                <td>Updated At</td>
                <td>:</td>
                <td><?php echo $updated_at; ?></td>
            </tr>
        </table>
        </div>
        <div class="box-footer with-border text-center">
            <?php 
            
                echo anchor(
                    site_url(Backend_URL . 'job/archive_action/' . $id), 
                    '<i class="fa fa-archive"></i> Confrim Archive ', 
                    'class="btn btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'
                );
            ?>
        </div>
    </div>
</section>