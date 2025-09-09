<script type="application/ld+json">
{
    "@context" : "http://schema.org/",
    "@type" : "JobPosting",
    "title" : "<?php echo $job->title; ?>",
    "description" : "<?php echo $job->description; ?>",
    "jobLocation" : {
        "@type" : "Place",
        "address" : {
            "@type" : "PostalAddress",
            "addressLocality" : "<?php echo $job->city; ?>",
            "addressRegion" : "<?php echo $job->state; ?>",
            "postalCode" : "<?php echo $job->postcode; ?>",
            "addressCountry": "<?php echo getCountryName($job->u_country_id); ?>"
        }
    },
    "datePosted" : "<?php echo $job->created_at; ?>",
    "employmentType" : "<?php echo isSpecify($job->job_type); ?>",
    "identifier": {
        "@type": "PropertyValue",
        "name": "<?php echo $job->company_name; ?>",
        "value": "<?php echo rand(11111, 99999); ?>"
    },
    "hiringOrganization" : {
        "@type" : "Organization",
        "name" : "<?php echo $job->company_name; ?>"
    }
}
</script>
<div class="search-top">
    <div class="container">
        <div class="row">

            <div class="col-sm-10">
                <form method="get" action="" id="find-jobs-form-top">

                    <div class="clearfix">
                        <div class="col-sm-4 no-padding">
                            <div class="form-group">
                                <input type="text" name="keyword_top" id="keyword_top" class="form-control"
                                       placeholder="Job Title, Job Sector, Occupation or Recruiter"
                                       value="<?php echo $keyword; ?>" style="font-size: 14px;"/>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <input type="text" class="form-control" name="loc" id="autocomplete" placeholder="Location"
                                       value="<?php echo $location; ?>"/>
                                <input type="hidden" name="lat" id="latitude" value="<?php echo $lat; ?>"/>
                                <input type="hidden" name="lng" id="longitude" value="<?php echo $lng; ?>"/>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <input type="button" class="btnContactSubmit" onclick="return findJob();" value="Find Job"/>
                            <a href="<?php echo site_url('ngo-job-search'); ?>" class="btn btn-link">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-sm-2 text-right">
                <a class="browsejob_btn" href="<?php echo site_url('browse-job'); ?>">
                    Browse jobs
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<!--<div class="container hide_on_print">-->
<!--    <div class="row back-to-joblist">-->
<!--        <div class="col-sm-12">-->
<!--            <span onclick="window.history.back(-1);"-->
<!--                  class="btn btn-default btn-primary back-to-joblist-a hide_on_print">-->
<!--                <i class="fa fa-chevron-left" aria-hidden="true"></i>-->
<!--                Go Back To Page-->
<!--            </span>-->
<!---->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<div class="container" style="padding-top: 15px;">
    <?php $this->load->view('frontend/template/job_alert_short'); ?>
</div>

<style>
.popup_trf_1 {
    width: 80%;
}
button.bot_dr_1 {
    background-color: #1e8e46 !important;
    border-bottom: 2px;
}
.popup_trf_1 form.form_rtgf_1 {
    width: 80%;
    margin: 3% auto;
}
.rst_dv_but_1 {
    float: right;
}
.rst_dv_but_1 input.btn.btn-success {
    width: 150px;
}
button.bot_dr_1 {
    width: 140px;
}
</style>
<!-- Modal start-->

<div class="container">
  <div class="modal fade" id="Apply_Now" role="dialog">
    <div class="modal-dialog popup_trf_1">
      <!-- Modal content-->
      <div class="modal-content">
            <form  class="form_rtgf_1" action="<?php echo site_url('myaccount/apply'); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden"  id="job_ids" name="job_ids" value="<?php echo $job->id ?>"/>
                <input type="hidden"  id="job_ids" name="candidate_ids" value="<?php echo $candidate_id; ?>"/>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company_nam">Company Name:</label>
                            <input type="text" class="form-control" id="company_nam" name="company_nam" 
                            value="<?php echo $job->AdvertiserName; ?>" readonly/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="job_title">Job Title:</label>
                            <input type="text" class="form-control" id="job_title"  name="job_title" 
                            value="<?php echo $job->title; ?>" readonly/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="expected_salary">Expected salary:</label>
                            <input type="number" class="form-control" id="expected_salary" name="expected_salary" placeholder="How much Expected salary" required="required"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="full_name">Full Name:</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter Your Full Name" required="required"/>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter Your Email" required="required"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact">Contact No:</label>
                            <input type="number" name="contact" id="contact" class="form-control" placeholder="Enter Your Contact No" required="required"/>
                        </div>
                    </div>
                    
                     <div class="col-md-6">
                        <label class="col-md-4 control-label">Upload CV <span>*</span></label>
                            <input type="file" id="file_name_doc" name="file_name_doc" accept=".doc,.docx,.pdf">
                        <span class="help-block">File must be less than 2MB and File format should be .pdf, .doc or .docx.<span>
                    </div>
                    <div class="col-md-2 col-sm-6 rst_dv_but_1">
                        <div class="form-group text-right">
                            <input type="submit" value="Submit" name="apply_now" class="btn btn-success">
                        </div> 
                    </div> 
                </div>     
            </form>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="container job-details">
    <?php $this->load->view('frontend/template/listing_details_newsletter_popup', ['job_title' => $job->title, 'job_category_id' => $job->job_category_id]); ?>

    <div class="border-all-details job_details_fs job-details-info" id="mydiv">
        <div class="row">
            <div class="col-sm-12 job-details-area">
                <div class="job_details_title clearfix">
                    <div class="col-sm-8">
                        <h2><?php echo $job->title; ?></h2>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="bot_dr_1 btn btn-info btn-lg pop_po_1" data-toggle="modal" data-target="#Apply_Now">Apply Now</button>
                    </div>
                    <div class="col-sm-2">
                        <div class="social-up-image pull-right hide_on_print">
                            <span class="btn btn-link" onclick="print('document');">
                                <i class="fa fa-print" aria-hidden="true"></i>
                                Print
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-topjoint">
            <div class="col-sm-8 jd-left-side">
                <h5 style=""><strong>Job Description / Responsibility</strong></h5>
                <?php echo $job->description; ?>

                <?php echo Ngo::getJobBenefits($job->job_benefit_ids); ?>
                <?php echo Ngo::getJobSkills($job->job_skill_ids); ?>

                <hr>

                <div class="row">
                    <div class="col-md-2 no-padding">
                        <div class="sharethis-inline-share-buttons"></div>
                    </div>
                    <div class="col-md-3 social-up-image">
                        <a class="btn btn-default btn-primary job-alert"
                           target="_blank" href="<?php echo site_url('job-alert'); ?>">
                            <i class="fa fa-bell"></i>
                            Job Alert
                        </a>
                    </div>
                    <div class="col-md-3 social-up-image">
                        <a class="btn btn-default btn-primary save-job"
                           onclick="shortListJob(<?php echo "{$job->id},{$candidate_id}"; ?>);"
                           id="<?php echo $job->id; ?>">
                            <i class="fa fa-heart"></i>
                            Save This Job
                        </a>
                    </div>
                    <div class="col-md-3 social-up-image">
                        <a class="btn btn-default btn-primary email-job"
                           data-toggle="modal"
                           data-controls-modal="emailThisJobToFriendModal"
                           data-backdrop="static" data-keyboard="true"
                           href="#emailThisJobToFriendModal">
                            <i class="fa fa-envelope-o"></i>
                            Email to Friend
                        </a>
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="company-info">
                            <div class="information">
                                <h5>Company Information</h5>
                                <p><?php echo $job->company_name; ?></p>
                                <p>Address : <?php
                                    $address = '';
                                    if ($job->add_line1) {
                                        $address .= $job->add_line1 . ', ';
                                    }
                                    if ($job->add_line2) {
                                        $address .= $job->add_line2 . ', ';
                                    }
                                    if ($job->city) {
                                        $address .= $job->city . ', ';
                                    }
                                    if ($job->state) {
                                        $address .= $job->state . ', ';
                                    }
                                    if ($job->postcode) {
                                        $address .= $job->postcode . ', ';
                                    }
                                    if ($job->country_id) {
                                        $address .= getCountryName($job->u_country_id) . '.';
                                    }
                                    echo rtrim($address, ',');
                                    ?></p>
                                <p>Web : <a href="<?php echo $job->company_website; ?>"
                                            target="_blank"><?php echo $job->company_website; ?></a></p>

                                <h5>About Company</h5>
                                <?php echo $job->about_company; ?>

                            </div>
                        </div>

                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <!-- job details middle -->
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-client="ca-pub-7967136455598756"
                             data-ad-slot="3243990024"
                             data-ad-format="auto"
                             data-full-width-responsive="true"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>

                    </div>
                </div>
            </div>
            <div class="col-sm-4 jd-right-side">
                <h3>Job Summary</h3>
                <div class="">
                    <?php if ($job->company_id) { ?>
                        <a href="<?php echo site_url("company-details/{$job->company_id}/" . slugify($job->company_name) . '.html'); ?>">
                            <div class="company_logo_right">
                                <div class="com_logo">
                                    <img src="<?php echo getPhoto($job->company_logo) ?>" class="img-responsive">
                                </div>
                                <h4><?php echo $job->company_name; ?></h4>
                            </div>
                        </a>
                    <?php } else { ?>
                        <div class="company_logo_right">
                            <div class="com_logo">
                                <img src="<?php echo getPhoto($job->company_logo); ?>" class="img-responsive">
                            </div>
                            <a href="<?php echo site_url('company/profile/') . urlencode($job->AdvertiserName); ?>">
                                <h4><?php echo $job->AdvertiserName; ?></h4>
                            </a>
                        </div>
                    <?php } ?>

                    <?php $this->load->view('frontend/template/listing_details_newsletter', ['job_title' => $job->title, 'job_category_id' => $job->job_category_id]); ?>

                    <ul class="jd-widget-1 margin0">
                        <li><strong>Category: </strong> <?php echo isSpecify($job->category_name); ?></li>
                        <li><strong>Sub Category: </strong> <?php echo isSpecify($job->sub_category_name); ?></li>
                        <li><strong>Posted on: </strong> <?php echo globalDateFormat($job->created_at); ?> </li>
                        <li><strong>Job Type: </strong> <?php echo isSpecify($job->job_type); ?></li>
                        <li><strong>No. of Vacancies : </strong> <?php echo vacancyFormat($job->vacancy); ?></li>
                        <li><strong>Salary: </strong>
                            <?php echo Ngo::getSalary($job->salary_type, $job->salary_min, $job->salary_max, $job->salary_period, $job->salary_currency); ?>
                        </li>
                        <li><strong>Location: </strong><?php echo $job->location; ?></li>
                        <li><strong>Country: </strong><?php echo getCountryName($job->country_id); ?></li>
                        <li><strong>Application Deadline: </strong><?php echo globalDateFormat($job->deadline); ?></li>
                    </ul>
                    <h3 class="read-doc">
                        <img src="assets/theme/images/read-icon.png">
                        Read this before applying
                    </h3>
                    <ul class="readthisappyling">
                        <li>No Specification here</li>
                    </ul>
                    <h3 class="read-doc"><i class="fa fa-sticky-note" style="font-size: 18px;"></i> Instruction</h3>
                    <ul class="readthisinsturction">
                        <p>Interested and qualified candidates should click apply on company website to apply.</p>
                    </ul>
                    <div class="text-center">

                        <?php if ($jobg8) { ?>
                            <a href="<?php echo jobG8AppLink($jobg8); ?>" target="_blank"
                               class="btn btn-lg btn-warning job-view-apply">
                                Apply for the job
                            </a>
                        <?php } else { ?>
                            <?php if (Ngo::CheckAlreadyAppliedForThisJob($job->id, $candidate_id)) { ?>
                                <a href="#" class="btn btn-lg btn-warning job-view-apply" disabled="disabled">You
                                    already applied for the job</a>
                            <?php } else { ?>
                                <a href="<?php echo site_url("myaccount/job-apply/{$job->id}/" . slugify($job->title) . '.html'); ?>"
                                   class="btn btn-lg btn-warning job-view-apply">Apply for the job</a>
                                <?php if (empty($candidate_id)) {
                                    echo '<p>Please <a class="btn btn-link no-padding" href="login">log in</a> first before apply for the job</p>';
                                } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <br>
                    <p>If you have any concerns about this job then please
                        <a href="<?php echo site_url('contact'); ?>">
                            <span style="color:#00a94e;">report it to our Customer Service team.</span>
                        </a>
                    </p>
                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- job details square -->
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-7967136455598756"
                         data-ad-slot="5678581673"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('frontend/template/listing_details_newsletter_popup', ['job_title' => $job->title, 'job_category_id' => $job->job_category_id]); ?>
</div>
<div class="container hide_on_print">
    <div class="relatedjobsec">
        <h3>Related Jobs</h3>
        <div class="jobcontent">
            <?php
            if ($relaated_jobs) {
                foreach ($relaated_jobs as $job) {
                    $rel_job_url = site_url("job-details/{$job->id}/" . slugify($job->title) . '.html');
                    ?>
                    <div class="shortview white">
                        <h3>
                            <a href="<?php echo $rel_job_url; ?>">
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
                                    <li>
                                        <b>Salary: </b> <?php echo Ngo::getSalary($job->salary_type, $job->salary_min, $job->salary_max, $job->salary_period, $job->salary_currency); ?>
                                    </li>
                                    <li><b>Vacancy: </b> <?php echo vacancyFormat($job->vacancy); ?></li>
                                    <li><b>Job Type: </b> <?php echo isSpecify($job->job_type); ?></li>
                                </ul>
                            </div>
                            <div class="col-md-6 search-details-text">
                                <ul>
                                    <li><b>Category: </b> <?php echo isSpecify($job->category_name); ?></li>
                                    <li><b>Published on: </b> <?php echo globalDateFormat($job->created_at); ?> </li>
                                    <li><b>Deadline: </b> <?php echo globalDateFormat($job->deadline); ?> </li>
                                </ul>
                            </div>
                        </div>
                        <div style="padding:25px 15px 0;" class="row">
                            <a target="_blank" class="btn btn-info" href="<?php echo $rel_job_url; ?>">
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

<!--<div class="add-left">-->
<!--    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>-->
<!--    <!-- Job details left -->-->
<!--    <ins class="adsbygoogle"-->
<!--         style="display:block"-->
<!--         data-ad-client="ca-pub-7967136455598756"-->
<!--         data-ad-slot="5131786766"-->
<!--         data-ad-format="auto"-->
<!--         data-full-width-responsive="true"></ins>-->
<!--    <script>-->
<!--        (adsbygoogle = window.adsbygoogle || []).push({});-->
<!--    </script>-->
<!--</div>-->
<!--<div class="add-right">-->
<!--    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>-->
<!--    <!-- job details right -->-->
<!--    <ins class="adsbygoogle"-->
<!--         style="display:block"-->
<!--         data-ad-client="ca-pub-7967136455598756"-->
<!--         data-ad-slot="1957708952"-->
<!--         data-ad-format="auto"-->
<!--         data-full-width-responsive="true"></ins>-->
<!--    <script>-->
<!--        (adsbygoogle = window.adsbygoogle || []).push({});-->
<!--    </script>-->
<!--</div>-->
<!-- Modal -->
<div class="modal fade" id="emailThisJobToFriendModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" name="share_by_email" id="share_by_email" method="POST">
                <div class="modal-header">
                    <h3 class="modal-title">Email this job to a friend</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="margin-top: -20px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="your_name" class="col-md-4 col-form-label">Your Name<span class="mandatory">*</span></label>
                                <div class="col-md-8">
                                    <input name="your_name" id="your_name" placeholder="Enter Your Name"
                                           class="form-control" required="required" type="text"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="your_email" class="col-md-4 col-form-label">Your Email Address<span
                                            class="mandatory">*</span></label>
                                <div class="col-md-8">
                                    <input id="your_email" name="your_email" placeholder="Enter Your Email"
                                           class="form-control" type="email" required="required"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="friend_name" class="col-md-4 col-form-label">Friend Name<span
                                            class="mandatory">*</span></label>
                                <div class="col-md-8">
                                    <input id="friend_name" name="friend_name" placeholder="Enter Friend Name"
                                           class="form-control" type="text" required="required"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="friend_email" class="col-md-4 col-form-label">Friend Email Address<span
                                            class="mandatory">*</span></label>
                                <div class="col-md-8">
                                    <input id="friend_email" name="friend_email" placeholder="Enter Friend Email"
                                           class="form-control" type="text" required="required"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" style="padding: 6px 15px;"><i class="fa fa-send"></i>
                        Send
                    </button>
                    <input type="hidden" name="job_id" value="<?php echo $job->id; ?>"/>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">

    $('#share_by_email').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: '<?php echo site_url('job_share_by_email'); ?>',
            type: "post",
            data: new FormData(this), //this is formData
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            beforeSend: function () {
                toastr.warning("Please Wait...");
            },
            success: function (data) {
                // Remove current toasts using animation
                toastr.clear();
                //received this text from a web server:
                var response = JSON.parse(data);
                if (response.Status === 'FAIL') {
                    var message = response.Msg;
                    // Display an error toast, with a title
                    toastr.error(message, 'Invalid Data!');
                    toastr.options.escapeHtml = true;

                } else {
                    $('#emailThisJobToFriendModal').modal('hide');
                    $("#your_name").val('');
                    $("#your_email").val('');
                    $("#friend_name").val('');
                    $("#friend_email").val('');
                    // Override global options
                    toastr.success('Email Send Successfully!.', 'Success');
                }
            }
        });

        return false;
    });


    function shortListJob(jobId, candidateId) {
        if (candidateId === null || candidateId === 0) {
            toastr.error("Redirecting to login page...");
            setTimeout(function () {
                location.href = "<?php echo site_url('login'); ?>";
            }, 1000);
            return false;
        }

        $.ajax({
            url: 'myaccount/shortlist_job',
            type: "POST",
            data: {
                job_id: jobId,
                candidate_id: candidateId
            },
            success: function (jsonRespond) {
                var res = jQuery.parseJSON(jsonRespond);
                if (res.Status === 'OK') {
                    toastr.success("This job has been successfully shortlisted.");
                } else {
                    toastr.error(res.Msg);
                }
            }
        });
    }

</script>
<script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=5e60c236b0e9af001248abcb&product=inline-share-buttons"
        async="async"></script>
