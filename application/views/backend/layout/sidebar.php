</div>

<aside class="main-sidebar">
    
    <section class="sidebar">                             
        <ul class="sidebar-menu">       
            <?php              
                // General
                echo add_main_menu('Dashboard', 'admin', 'dashboard', 'fa-dashboard');
                echo Modules::run('job/_menu');
                echo Modules::run('job/sector');
                echo Modules::run('event/_menu');
                echo Modules::run('users/_menu');
                echo Modules::run('job_alert/_menu');
                echo Modules::run('candidate/_menu'); 
                echo Modules::run('payment/_menu'); 
                echo Modules::run('package/_menu'); 
                echo Modules::run('cms/_menu');
                echo Modules::run('slider/_menu');           
                echo Modules::run('mailbox/_menu');
                echo add_main_menu('Newsletter Subscribers', 'admin/newsletter_subscriber', 'newsletter_subscriber', 'fa-gear');                
                echo Modules::run('email_templates/menu');
                echo add_main_menu('Settings', 'admin/settings', 'settings', 'fa-gear');            
                
                echo add_main_menu('DB Backup & Restore', 'admin/db_sync', 'db_sync', 'fa-hdd-o');
                echo Modules::run('module/menu');
                echo Modules::run('profile/_menu');
           ?>
            <li>
                <a href="sitemap?key=RmxpY2sgTWVkaWE=" target="_blank" onclick="return confirm('Are you sure to generate sitemap?')">
                    <i class="fa fa-file"></i><span>Generate Sitemap</span>
                </a>
            </li>
           <li><a href="admin/logout"><i class="fa fa-sign-out"></i><span>Sign Out</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- Body Content Start -->
<div class="content-wrapper">
	<div id="ajaxContent">