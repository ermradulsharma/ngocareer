<div class="search-top">
    <div class="container">
        <div class="row">

            <div class="col-sm-12">
                <form method="get">
                    <div class="row">
                        <div class="col-sm-4 no-padding">
                            <div class="form-group">
                                <input type="text" name="q" class="form-control"
                                       placeholder="Advertiser Name"
                                       value="<?php echo $q; ?>"/>
                            </div>
                        </div>                        
                        <div class="col-sm-2">
                            <input type="submit" class="btnContactSubmit" value="Find Advertiser"/>
                        </div>
                        <div class="col-sm-2">
                            <a href="<?php echo site_url('advertisers'); ?>" class="btn btn-link">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container search">
    <div class="row">
        <div class="search-short clearfix">
            <div class="row">
                <div class="col-sm-8">
                    <p class="search-short-t">
                        All Jobs Found by <span><?php echo $total_advertiser; ?></span> Advertisers
                    </p>
                </div>
                <div class="col-sm-4">
                    <a href="<?php echo site_url('admin/job/create'); ?>" class="btn btn-primary pull-right">
                        Post A Job 
                    </a>
                </div>
            </div>
        </div>
        <div class="search-list-all">

            <div class="row">
                <div class="col-sm-12">
                    <div class="jobcontent">
                        <?php
                        if ($advertisers) {
                             /*echo"<pre>";
                                print_r($advertisers);
                                die;*/
                            foreach ($advertisers as $advertiser) {
                               
                                $url = site_url('company/profile/'.($advertiser->AdvertiserName) );
                                ?>

                                <div class="shortview white">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="<?php echo getPhoto('uploads/no-photo.jpg'); ?>"
                                                 class="img-responsive"/>
                                        </div>
                                        <div class="col-md-10">
                                            <h3>
                                                <a href="<?php echo $url; ?>">
                                                    <?php echo $advertiser->AdvertiserName; ?>
                                                </a>
                                            </h3>                                           
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6 search-details-text">
                                                    <ul>                                                        
                                                        <li><b>Active Job Found: </b> <?php echo $advertiser->Qty; ?></li>                                                        
                                                    </ul>
                                                </div>
                                                <div class="col-md-6 search-details-text text-right">
                                                    <div class="">
                                                        <a class="btn btn-info viewdetailsjobsearch"
                                                           href="<?php echo $url; ?>">View Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <?php
                            }
                        } else {
                            echo '<p class="ajax_notice">No Organisation Found!</p>';
                        }
                        ?>

                        <div class="pagination-box">
                            <?php echo $pagination; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function shortListJob(jobId, candidateId) {
        if (candidateId === null || candidateId === 0 ) {
            toastr.error("Redirecting to login page...");
            setTimeout(function(){ location.href = "<?php echo site_url('login'); ?>"; }, 1000);
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
//                    $('tr#shortlist_' + jobId).remove();
                } else {
                    toastr.error(res.Msg);
                }
            }
        });

    }

    function deleteShortListJob(jobFavouriteId) {

        $.ajax({
            url: 'myaccount/shortlisted_job_delete/' + jobFavouriteId,
            type: "get",
            success: function (jsonRespond) {
                var res = jQuery.parseJSON(jsonRespond);
                if (res.Status === 'OK') {
                    toastr.success("You have removed this job from shortlist!");
                    $('tr#shortlist_' + jobFavouriteId).remove();
                } else {
                    toastr.error(res.Msg);
                }
            }
        });
        return false;

    }
</script>
