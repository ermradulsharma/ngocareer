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
        <div class="col-md-12 text-center" style="border-bottom: 1px solid #D7D7D7; margin-bottom: 15px;">
            <h4>Today</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo $new_job; ?></h3>
                            <p>New Job Post</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-bar-chart"></i>
                        </div>
                        <a href="<?php echo site_url( Backend_URL . 'job');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-fuchsia">
                        <div class="inner">
                            <h3><?php echo $new_event; ?></h3>
                            <p>New Event Post</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-area-chart"></i>
                        </div>
                        <a href="<?php echo site_url( Backend_URL . 'event');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php echo $new_candidate; ?></h3>
                            <p>New Job Seeker Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user-plus"></i>
                        </div>
                        <a href="<?php echo site_url( Backend_URL . 'candidate');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="row">
                <div class="col-lg-6 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3><?php echo $new_employer; ?></h3>
                            <p>New Recruiter Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user-plus"></i>
                        </div>
                        <a href="<?php echo site_url( Backend_URL . 'users?role_id=4');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-6 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?php echo globalCurrencyFormat($new_payment); ?></h3>
                            <p>New Payment</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-dollar"></i>
                        </div>
                        <a href="<?php echo site_url( Backend_URL . 'payment');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>
        </div>

    </div>






    <div class="row">
        <div class="col-md-12 text-center" style="border-bottom: 1px solid #D7D7D7; margin-bottom: 15px;">
            <h4>All Time</h4>
        </div>
    </div>

    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
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

        <div class="col-md-3 col-sm-6 col-xs-12">
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

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-navy">
                    <i class="fa fa-address-card-o"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Job Seeker</span>
                    <span class="info-box-number"><?php echo $candidate; ?></span>
                    <a href="<?php echo site_url( Backend_URL . 'candidate');?>">
                        View All
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-olive">
                    <i class="fa fa-vcard"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Recruiter</span>
                    <span class="info-box-number"><?php echo $employer; ?></span>
                    <a href="<?php echo site_url( Backend_URL . 'users?role_id=4');?>">
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
                                    <th class="text-center" width="60">ID</th>
                                    <th>Title</th>
                                    <th>Vacancy</th>
                                    <th>Status</th>
                                    <th width="110">Post Date</th>
                                    <th width="60">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo getRecentJobPosts(10); ?>
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
                    <h3 class="box-title">Recent Event Posts</h3>

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
                                    <th class="text-center" width="70">ID</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Post Date</th>
                                    <th width="60">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo getRecentEventPosts(10); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <a href="<?php echo base_url('admin/event'); ?>" class="btn btn-sm btn-default btn-flat pull-right">
                        View All Event Posts
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

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
                                <th>Date & Time</th>
                                <th class="text-center" width="100">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo getRecentJobApplication(10); ?>
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

        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Recent Payment Log</h3>

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
                                <th>Email</th>
                                <th class="text-right">Amount</th>
                                <th>Status</th>
                                <th width="150">Date & Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo getRecentPaymentLog(10); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <a href="<?php echo site_url(Backend_URL.'payment'); ?>" class="btn btn-sm btn-default btn-flat pull-right">
                        View All Payment Log
                    </a>
                </div>
            </div>
        </div>


    </div>
</section>
