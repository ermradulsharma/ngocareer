<style type="text/css">
    h1.advertiser {
        color: #1f8c49;
        text-shadow: 2px 2px 0px #fff;
    }    
</style>
<div class="container">
    <div class="relatedjobsec">
        <h1 class="advertiser">Jobs From <?php echo $Advertiser; ?> <small>(<?php echo $total_job; ?> jobs posted)</small></h1>
        <div class="jobcontent">
            
            <?php 
            if($Advertiser_jobs){
                foreach ($Advertiser_jobs as $job) {
                    $com_job_url = site_url("job-details/{$job->id}/" . slugify($job->title) .'.html');

            ?>
            <div class="shortview white">
                <h3>
                    <a href="<?php echo $com_job_url; ?>">
                       <?php echo $job->title; ?>
                    </a> 
                </h3>
                <h4> <?php echo $job->location; ?></h4>
                <div class="text-justify" style="word-break: break-all;">
                    <?php echo getShortContent($job->description, 350); ?>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 search-details-text">
                        <ul>
                            <li><b>Salary: </b><?php echo isSpecify($job->salary_type); ?> </li>
                            <li><b>Vacancy : </b> <?php echo vacancyFormat($job->vacancy); ?></li>
                            <li><b>Job Type : </b> <?php echo isSpecify($job->type); ?></li>
                        </ul>
                    </div>
                    <div class="col-md-6 search-details-text">
                        <ul>
                            <li><b>Category: </b> <?php echo $job->category; ?></li>
                            <li><b>Published on: </b> <?php echo globalDateFormat($job->created_at); ?> </li>
                            <li><b>Deadline: </b>  <?php echo globalDateFormat($job->deadline); ?> </li>
                        </ul>
                    </div>
                </div>
                <div style="padding:25px 15px 0;" class="row">
                    <a target="_blank" class="btn btn-info" href="<?php echo $com_job_url; ?>">
                        <i class="fa fa-external-link-square"></i>
                        View Details
                    </a>
                </div>
            </div>
            <?php 
                }//foreach
            } else {
                echo '<p class="ajax_notice">No job found!</p>';
            }
            ?>
            <div class="pagination-box">                        
                <?php echo $pagination; ?>                        
            </div>
        </div>
    </div>
</div>