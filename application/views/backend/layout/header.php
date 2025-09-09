<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <title><?php echo  getSettingItem('SiteTitle'); ?></title>   
        <meta name="description" content="Admin Area" />
        <meta name="keywords" content="Admin Area" />  

        <link rel="icon" href="assets/theme/images/favicon.jpg">
        <!-- Tell the browser to be responsive to screen width -->  
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <base href="<?php echo base_url(); ?>"/>
        <link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.min.css">
        
        <!-- Theme style -->
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="assets/admin/dist/css/skins/_all-skins.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="assets/admin/dist/css/AdminLTE.min.css">
        <!--<link rel="stylesheet" href="assets/theme/css/responsive.css">-->

        <!-- Font Awesome -->
        <link rel="stylesheet" href="assets/lib/font-awesome/font-awesome.min.css">
      

        <!-- jQuery 2.2.3 -->
        <script src="assets/lib/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="assets/lib/plugins/jQueryUI/jquery-ui.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="assets/lib/bootstrap/js/bootstrap.min.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="assets/lib/plugins/select2/select2.min.css">   
        <script type='text/javascript' src="assets/lib/plugins/select2/select2.min.js"></script>

        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800" rel="stylesheet">

        <link rel="stylesheet" href="assets/lib/plugins/jquery-toggles/toggles.css">  
        <link rel="stylesheet" href="assets/lib/plugins/jquery-toggles/toggles-full.css">  
        <script type='text/javascript' src="assets/lib/plugins/jquery-toggles/toggles.min.js"></script>
        <link rel="stylesheet" href="assets/lib/iCheck/flat/green.css">
        <link rel="stylesheet" href="assets/lib/plugins/datepicker/datepicker3.css">
        <link href="assets/lib/toast/toastr.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="assets/lib/ajax.css">
        <link rel="stylesheet" href="assets/print.css">

        <link rel="stylesheet" href="assets/admin/dist/css/style.css">
        <script src="assets/admin/flick_cms.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.6/holder.min.js" type="text/javascript"></script>
    </head>

    <body class="hold-transition skin-green-light sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->

                <a href="<?php echo base_url('admin'); ?>" class="logo">
                    <span class="logo-lg">
                        <img src="assets/admin/dist/img/logo.png" title="Logo">
                    </span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
<!--                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>-->
                    

                    <div class="navbar-custom-menu">


                        <ul class="nav navbar-nav">
                            <li class="messages-menu">
                                <a href="<?php echo base_url( Backend_URL . 'job/create'); ?>">
                                    <i class="fa fa-plus"></i>
                                    Post a Job                                    
                                </a>
                            </li>
                            
                            <li class="messages-menu">
                                <a href="<?php echo base_url(); ?>">
                                    <i class="fa fa-home"></i>
                                    View Frontend Portal
                                </a>
                            </li>

                            <li class="dropdown user user-menu">
                                <a href="admin/profile">
                                    <img src="<?php echo getPhoto(getLoginUserData('logo')) ?>" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo getLoginUserData('name');  ?></span>
                                </a>                                
                            </li>                            
                        </ul>
                    </div>
                </nav>
            </header>