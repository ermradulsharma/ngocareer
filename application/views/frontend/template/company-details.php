<div class="container job-details">
    <div class="border-all-details job_details_fs job-details-info" id="mydiv">
        <div class="row">
            <div class="col-sm-12 job-details-area">
                <div class="job_details_title clearfix">
                    <div class="col-sm-10">
                        <h2><?php echo $company->company_name; ?></h2>
                    </div>                    
                </div>
            </div>
        </div>

        <div class="row border-topjoint">
            <div class="col-sm-12 jd-left-side">
                <div class="company-info">
                    <div class="information">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="<?php echo getPhoto($company->logo); ?>"
                                     class="img-responsive"/>
                            </div>
                            <div class="col-md-10">
                                <h5>Company Information</h5>
                                <p><?php echo $company->company_name; ?></p>
                                <p>Address : <?php
                                    $address = '';
                                    if($company->add_line1){
                                        $address .= $company->add_line1.', ';
                                    }
                                    if($company->add_line2){
                                        $address .= $company->add_line2.', ';
                                    }
                                    if($company->city){
                                        $address .= $company->city.', ';
                                    }
                                    if($company->state){
                                        $address .= $company->state.', ';
                                    }
                                    if($company->postcode){
                                        $address .= $company->postcode.', ';
                                    }
                                    if($company->country_id){
                                        $address .= getCountryName($company->country_id).'.';
                                    }
                                    echo rtrim($address, ',');
                                    ?></p>
                                <p>Web : <a href="<?php echo $company->website; ?>" target="_blank"><?php echo $company->website; ?></a></p>

                                <h5>About Company</h5>
                                <?php echo $company->about_company; ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<div class="container hide_on_print">
    <div class="relatedjobsec">
        <h3>Company Jobs</h3>
        <div class="jobcontent">
            
            <?php 
            if($company_jobs){
                foreach ($company_jobs as $job) {
                    $com_job_url = site_url("job-details/{$job->id}/" . slugify($job->title) . '.html');

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
                            <li><b>Salary: </b><?php echo $job->salary_type; ?> </li>
                            <li><b>Vacancy : </b> <?php echo sprintf('%02d',$job->vacancy); ?></li>
                            <li><b>Job Type : </b> <?php echo $job->type; ?></li>
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
<!-- Modal -->
<div class="modal fade" id="emailThisJobToFriendModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" name="share_by_email" id="share_by_email" method="POST">
                <div class="modal-header">
                    <h3 class="modal-title">Email this job to a friend</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="your_name" class="col-md-4 col-form-label">Your Name<span class="mandatory">*</span></label> 
                                <div class="col-md-8">
                                    <input name="your_name" id="your_name" placeholder="Enter Your Name" class="form-control" required="required" type="text" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="your_email" class="col-md-4 col-form-label">Your Email Address<span class="mandatory">*</span></label> 
                                <div class="col-md-8">
                                    <input id="your_email" name="your_email" placeholder="Enter Your Email" class="form-control" type="email" required="required" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="friend_name" class="col-md-4 col-form-label">Friend Name<span class="mandatory">*</span></label> 
                                <div class="col-md-8">
                                    <input id="friend_name" name="friend_name" placeholder="Enter Friend Name" class="form-control" type="text" required="required"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="friend_email" class="col-md-4 col-form-label">Friend Email Address<span class="mandatory">*</span></label> 
                                <div class="col-md-8">
                                    <input id="friend_email" name="friend_email" placeholder="Enter Friend Email" class="form-control" type="text" required="required"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" style="padding: 6px 15px;"><i class="fa fa-send"></i> Send</button>
                    <input type="hidden" name="job_id" value="<?php echo $job->id;?>"/>
                </div>
            </form>
        </div>
    </div>
</div>