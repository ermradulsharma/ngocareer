<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1> Dashboard <small>as Admin</small> </h1>    
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<?php load_module_asset('dashboard', 'css'); ?>

<section class="content">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua-active">
                    <i class="fa fa-edit"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Job Post</span>
                    <span class="info-box-number"><?php echo $job; ?></span>
                    <a href="<?php echo site_url( Backend_URL . 'job');?>">
                        View All 
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red">
                    <i class="fa fa-flag"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Event Post</span>
                    <span class="info-box-number"><?php echo $event; ?></span>
                    <a href="<?php echo site_url( Backend_URL . 'event');?>">
                        View All 
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-navy">
                    <i class="fa fa-address-card-o"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Applications</span>
                    <span class="info-box-number"><?php echo $applications; ?></span>
                    <a href="<?php echo site_url( Backend_URL . 'job/application');?>">
                        View All 
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
    
    
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Recent Job Posts</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered no-margin">
                            <thead>
                                <tr>
                                    <th class="text-center" width="60">Job ID</th>
                                    <th>Job Title</th>
                                    <th>Location</th>
                                    <th>Vacancy</th>
                                    <th width="110">Post Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo getRecentJobPosts(10, $login_user_id); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <a href="<?php echo base_url('admin/job'); ?>" class="btn btn-sm btn-default btn-flat pull-right">
                        View All Job Posts
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Recent Job Application</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered no-margin">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Job</th>
                                    <th width="140">Date & Time</th>
                                    <th class="text-center" width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo getRecentJobApplication(10, $login_user_id); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <a href="<?php echo site_url(Backend_URL.'job/application'); ?>" class="btn btn-sm btn-default btn-flat pull-right">
                        View All Job Application
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
