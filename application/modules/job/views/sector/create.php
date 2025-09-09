<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>
<section class="content-header">
    <h1>Job_Sector<small><?php echo $button ?></small> </h1>
    <ol class="breadcrumb">
         <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>job">Job</a></li>
        <li><a href="<?php echo Backend_URL ?>job/sub_category">Job Sector</a></li>
        <li class="active">Update</li>
    </ol>
</section>