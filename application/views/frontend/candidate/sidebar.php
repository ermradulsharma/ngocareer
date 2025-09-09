<div class="container candiate_area">
    <div class="row">
        <div class="col-sm-3">
            <div class="avatar upload_image" style="margin-top: 25px;">
                <img src="<?php echo getPhoto($picture); ?>" alt="<?php echo $full_name; ?>" class="img-thumbnail">
            </div>
        <h3><?php echo $full_name; ?></h3>

            <?php 
            echo Ngo::menu([
                    [
                        'name' => 'Job Alert',
                        'icon' => 'fa-bell',
                        'link' => 'myaccount/alert',
                    ],[
                        'name' => 'Update Profile',
                        'icon' => 'fa-list-alt',
                        'link' => 'myaccount/profile',
                    ],[
                        'name' => 'Resume/CV',
                        'icon' => 'fa-file-text-o',
                        'link' => 'myaccount/cv',
                    ],[
                        'name' => 'My Fav Jobs',
                        'icon' => 'fa-heart',
                        'link' => 'myaccount/shortlisted',
                    ],[
                        'name' => 'My Applied Job',
                        'icon' => 'fa-check',
                        'link' => 'myaccount/applied_job',
                    ],[
                        'name' => 'Change Password',
                        'icon' => 'fa-random',
                        'link' => 'myaccount/changepassword',
                    ],[
                        'name' => 'Sign Out',
                        'icon' => 'fa-check',
                        'link' => 'logout',
                    ]
                ]); 
            ?>
        </div>
        <div class="col-sm-9 main">
            <!-- Candidate Content Area Body Start -->