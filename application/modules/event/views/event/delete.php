<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>
<section class="content-header">
    <h1>Event <small>Delete</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>event">Event</a></li>
        <li class="active">Delete</li>
    </ol>
</section>

<section class="content">
    <?php echo eventTabs($id, 'delete'); ?>
    <div class="box no-border">
        <div class="box-header with-border">
            <h3 class="box-title">Preview Before Delete</h3>
        </div>
        <table class="table table-striped">
            <tr>
                <td width="150">Title</td>
                <td width="5">:</td>
                <td><?php echo $title; ?></td>
            </tr>
            <tr>
                <td width="150">Location</td>
                <td width="5">:</td>
                <td><?php echo $location; ?></td>
            </tr>
            <tr>
                <td width="150">Start Date</td>
                <td width="5">:</td>
                <td><?php echo globalDateFormat($start_date); ?></td>
            </tr>
            <tr>
                <td width="150">End Date</td>
                <td width="5">:</td>
                <td><?php echo globalDateFormat($end_date); ?></td>
            </tr>
            <tr>
                <td width="150">Summary</td>
                <td width="5">:</td>
                <td><?php echo $summary; ?></td>
            </tr>
            <tr>
                <td width="150">Organizer Name</td>
                <td width="5">:</td>
                <td><?php echo $organizer_name; ?></td>
            </tr>
            <tr>
                <td width="150">Status</td>
                <td width="5">:</td>
                <td><?php echo $status; ?></td>
            </tr>
            <tr>
                <td width="150">Remark</td>
                <td width="5">:</td>
                <td><?php echo $remark; ?></td>
            </tr>
            <tr>
                <td width="150">Created At</td>
                <td width="5">:</td>
                <td><?php echo globalDateTimeFormat($created_at); ?></td>
            </tr>
            <tr>
                <td width="150">Updated At</td>
                <td width="5">:</td>
                <td><?php echo globalDateTimeFormat($updated_at); ?></td>
            </tr>
        </table>
        <div class="box-header">
            <?php echo anchor(site_url(Backend_URL . 'event/delete_action/' . $id), '<i class="fa fa-fw fa-trash"></i> Confrim Delete ', 'class="btn btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); ?>
        </div>
    </div>
</section>