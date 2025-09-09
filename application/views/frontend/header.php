<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="google-site-verification" content="DxvJlqOTLps3IRgifQGngkYQIDmOGXd9AghNk30izQA" />
    <meta name="msvalidate.01" content="1FB1A01B00AA360596F7AFDD0AD4BAA6" />
    <title><?php
        $title = isset($title) ? $title . ' | ' : '';
        echo (isset($meta_title) && !empty($meta_title)) ? $meta_title : $title . getSettingItem('SiteTitle'); ?></title>
    <meta name="description" content="<?php echo @$meta_description; ?>" />
    <meta name="keywords" content="<?php echo @$meta_keywords; ?>" />

    <base href="<?php echo base_url(); ?>" />
    <!--<link rel="canonical" href="<?php //echo $GLOBALS['canonical']; ?>" />-->
    <link rel="icon" href="assets/theme/images/favicon.ico">

    <link href="https://fonts.googleapis.com/css?family=Philosopher:400,400i,700,700i&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.min.css" type='text/css' media='all' />
    <link rel="stylesheet" href='assets/lib/font-awesome/font-awesome.min.css' type='text/css' media='all' />
    <link rel="stylesheet" href="assets/theme/css/layout.css">
    <link rel="stylesheet" href="assets/theme/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/theme/css/my_account.css">
    <link rel="stylesheet" href="assets/theme/css/jobseeker_profile.css">
    <link rel="stylesheet" href="assets/theme/css/jobseeker.css">
    <link rel="stylesheet" href="assets/theme/css/responsive.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/lib/ajax.css">
    <link rel="stylesheet" href="assets/print.css">
    <link rel="stylesheet" href="assets/lib/loader/jquery.loading.min.css">
    <link href="assets/lib/toast/toastr.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="assets/theme/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="assets/theme/css/owl.theme.default.min.css">

    <!--    <link rel="stylesheet" type="text/css" href="assets/theme/css/owl.carousel.min.css">
        <link rel="stylesheet" type="text/css" href="assets/theme/css/owl.theme.default.min.css">-->

    <script src="assets/lib/plugins/jQuery/jquery-2.2.3.min.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/theme/js/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.6/holder.min.js" type="text/javascript"></script>
    <script src="assets/lib/toast/toastr.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-182258541-40"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-182258541-40');
    </script>

</head>
<body>
<section class="header no-padding">
    <div class="container">
        <div class="row clearfix">
            <div class="col-sm-4 col-xs-12">
                <div class="logo hidden-xs">
                    <a href="<?php echo site_url(); ?>">
                        <img src="assets/theme/images/logo.png" class="img-responsive">
                    </a>
                </div>
                <div class="logo hidden-lg hidden-md hidden-sm mobile-logo-sec text-center">
                    <a href="<?php echo site_url(); ?>">
                        <img src="assets/theme/images/logo.png" class="img-responsive">
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 text-center hide_on_print mobilesection-header-right">
                <h1 style="color: #005CB3;">NGO JOB PORTAL</h1>
            </div>
            <div class="col-sm-2 col-xs-12 pull-right hide_on_print mobilesection-header-right">
                <div class="header-right">
                    <div class="header-donation text-right">
                        <div class="dropdown">
                            <a class="btn btn-primary jobalert" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Login/Register 
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="login">Candidates</a>
                                <a class="dropdown-item" href="recruiter">Recruiter</a>
                            </div>
                        </div>
<!--                        <a class="btn btn-primary jobalert" href="job-alert">Create Job Alerts</a>-->
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>

<nav class="navbar navbar-primary hide_on_print">
    <div class="container">
        <div class="row">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <?php echo getNavigationMenu(3); ?>
        </div>
    </div>
</nav>
