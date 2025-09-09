<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>
<section class="content-header">
    <h1>Job  <small>Read</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo site_url(Backend_URL . 'job') ?>">Job</a></li>
        <li class="active">Details</li>
    </ol>
</section>

<section class="content">
    <?php echo jobTabs($id, 'preview'); ?>
    <div class="box no-border">

        <div class="box-header with-border">
            <h3 class="box-title">Details View</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-7">
                    <table class="table table-bordered table-striped">
                        <tr><td width="150">Title</td><td width="5">:</td><td><?php echo $title; ?></td></tr>	                        
                        <tr><td>Job Type</td><td>:</td><td><?php echo $job_type_id; ?></td></tr>
                        <tr><td>Job Category</td><td>:</td><td><?php echo "{$job_category_id} / {$sub_cat_id}"; ?></td></tr>

                        <tr><td>Description</td><td>:</td><td><?php echo $description; ?></td></tr>
                        <tr><td>Recruiter Note</td><td>:</td><td><?php echo $recruiters_note; ?></td></tr>

                        <?php if($login_role_id != 4): ?>
                        <tr><td>Admin Note</td><td>:</td><td><?php echo $admin_note; ?></td></tr>
                        <?php endif; ?>                        
                    </table>
                </div>
                <div class="col-md-5">
                    <table class="table table-bordered table-striped">
                        <tr><td width="150">Vacancy</td><td width="5">:</td><td><?php echo $vacancy; ?></td></tr>
                        <tr><td>Location</td><td>:</td><td><?php echo $location; ?></td></tr>
                        <tr><td>Country</td><td>:</td><td><?php echo getCountryName($country_id); ?></td></tr>
                        <tr><td>Application Deadline</td><td>:</td><td><?php echo $deadline; ?></td></tr>
                        <tr><td>Salary</td><td>:</td><td><?php echo Ngo::getSalary($salary_type, $salary_min, $salary_max, $salary_period, $salary_currency); ?></td></tr>
                        <tr><td>Job Benefits</td><td>:</td><td><?php echo $job_benefit_ids; ?></td></tr>
                        <tr><td>Job Skills</td><td>:</td><td><?php echo $job_skill_ids; ?></td></tr>
                        <tr><td>Created At</td><td>:</td><td><?php echo $created_at; ?></td></tr>
                        <tr><td>Updated At</td><td>:</td><td><?php echo $updated_at; ?></td></tr>                        
                        <tr><td>View in Website</td><td>:</td>
                            <td>
                                <a target="_blank" href="<?php echo site_url("job-details/{$id}/abc.html"); ?>">
                                    Preview Job Details
                                    <i class="fa fa-external-link"></i>
                                </a>                            
                            </td>
                        </tr>                        
                    </table>                   
                </div>
            </div>
        </div>
    </div>
</section>