<script src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&key=AIzaSyCSuu_Ag9Z2CEMxzzXdCcPNIUtPm0-GIXs"></script>

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
                                <input type="text" class="form-control" name="loc" id="autocomplete"
                                       placeholder="Location"
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


<div class="container search">
    <?php $this->load->view('frontend/template/job_alert_short'); ?>
    <div class="row">
        <div class="search-short clearfix">
            <div class="row">
                <div class="col-md-12 text-center">
                    <?php
                        if($cat){
                            echo '<h2>' .ucwords($Country). ' Jobs' . '</h2>';
                        } else {

                            echo '<h2>'.'NGO Jobs In ' .ucwords($Country).  '</h2>';
                        }
                    ?>
                </div>
            </div>
            <div class="col-sm-6">
                <p class="search-short-t">Found <span> <?php echo $total_job; ?></span> Jobs for You</p>
            </div>
            <div class="col-sm-2 top-filter-box pull-right text-right">
                <select class="form-control"
                        name="sort_by_top"
                        id="sort_by_top"
                        onchange="shortByChange();">
                    <?php
                    echo selectOptions($sort_by, [
                        '' => 'Sort By',
                        'NewJobASC' => 'New Job ASC',
                        'NewJobDESC' => 'New Job DESC',
                        'DeadlineASC' => 'Deadline ASC',
                        'DeadlineDESC' => 'Deadline DESC'
                    ]);
                    ?>
                </select>
            </div>
        </div>

        <div class="search-list-all">
            <div class="col-sm-3">
                <div class="search-left">
                    <?php $this->load->view('frontend/job_filter'); ?>
                </div>
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- job listing page -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-7967136455598756"
                     data-ad-slot="1139736717"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <div class="col-sm-9">
                <?php $this->load->view('frontend/template/listing_list_newsletter_popup'); ?>
                <?php // $this->load->view('frontend/template/listing_newsletter'); ?>

                <div class="jobcontent">
                    <pre class="hidden"><?php echo $sql; ?></pre>

                    <?php
                    if ($jobs) {
                        foreach ($jobs as $job) {
                            $job_url = site_url("job-details/{$job->id}/" . slugify($job->title) . '.html');
                            ?>

                            <div class="shortview white <?php echo ($job->is_feature) ? 'featured' : ''; ?>">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h3>
                                            <a href="<?php echo $job_url; ?>">
                                                <?php echo $job->title; ?>
                                            </a>
                                        </h3>
                                    </div>
                                    <div class="col-md-2">
                                        <?php
                                        $jobg8 = json_decode($job->jobg8, true);
                                        if ($jobg8) { ?>
                                            <a href="<?php echo jobG8AppLink($jobg8); ?>" target="_blank" class="btn btn-lg btn-warning job-view-apply">Apply Now</a>
                                        <?php } else { ?>
                                            <?php if (Ngo::CheckAlreadyAppliedForThisJob($job->id, $candidate_id)) { ?>
                                                <!-- <a href="#" class="btn btn-lg btn-warning job-view-apply" disabled="disabled">You already applied for the job</a>-->
                                            <?php } else { ?>
                                                <a href="<?php echo site_url("myaccount/job-apply/{$job->id}/" . slugify($job->title) . '.html'); ?>"
                                                   class="btn btn-lg btn-warning job-view-apply">Apply Now</a>
                                                <?php if (empty($candidate_id)) { ?>
                                                    <a href="<?php echo site_url("login"); ?>"
                                                       class="btn btn-lg btn-warning job-view-apply">Apply Now</a>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <h4><?php echo $job->location; ?></h4>
                                <div class="text-justify">
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
                                        <div class="">
                                            <button onclick="return shortListJob(<?php echo "{$job->id}, {$candidate_id}"; ?>);"
                                                    id="<?php echo $job->id; ?>" class="btn btn-success js-add-to-fav"
                                                    type="button">
                                                ADD TO FAVOURITES
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 search-details-text">
                                        <ul>
                                            <li><b>Category: </b> <?php echo isSpecify($job->cat_name); ?></li>
                                            <li><b>Published on: </b> <?php echo globalDateFormat($job->created_at); ?>
                                            </li>
                                            <li><b>Deadline: </b> <?php echo globalDateFormat($job->deadline); ?></li>
                                        </ul>
                                        <div class="">
                                            <a class="btn btn-info viewdetailsjobsearch"
                                               href="<?php echo $job_url; ?>">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
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
    </div>
</div>
<!--<div class="add-left">-->
<!--    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7967136455598756" crossorigin="anonymous"></script>-->
<!--    <ins class="adsbygoogle"-->
<!--         style="display:block"-->
<!--         data-ad-client="ca-pub-7967136455598756"-->
<!--         data-ad-slot="6768580337"-->
<!--         data-ad-format="auto"-->
<!--         data-full-width-responsive="true"></ins>-->
<!--    <script>-->
<!--        (adsbygoogle = window.adsbygoogle || []).push({});-->
<!--    </script>-->
<!--</div>-->
<!--<div class="add-right">-->
<!--    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7967136455598756" crossorigin="anonymous"></script>-->
<!---->
<!--    <ins class="adsbygoogle"-->
<!--         style="display:block"-->
<!--         data-ad-client="ca-pub-7967136455598756"-->
<!--         data-ad-slot="6768580337"-->
<!--         data-ad-format="auto"-->
<!--         data-full-width-responsive="true"></ins>-->
<!--    <script>-->
<!--        (adsbygoogle = window.adsbygoogle || []).push({});-->
<!--    </script>-->
<!--</div>-->

<script type="text/javascript">
    function findJob() {
        var keyword_top = $('#keyword_top').val();
        $('#keyword').val(keyword_top);

        var location = $('#autocomplete').val();
        $('#location').val(location);

        var lat = $('#latitude').val();
        $('#lat').val(lat);

        var lng = $('#longitude').val();
        $('#lng').val(lng);

        $('#job-search-form').submit();
    }

    function shortByChange() {
        var sort_by_top = $('#sort_by_top').val();
        $('#sort_by').val(sort_by_top);

        $('#job-search-form').submit();
    }

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


    // Google Location
    $("#autocomplete").on('focus', function () {
        geolocate();
    });

    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initialize() {
        autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('autocomplete')), {
                types: ['geocode']
            });
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            fillInAddress();
        });
    }

    function fillInAddress() {
        var place = autocomplete.getPlace();

        document.getElementById("latitude").value = place.geometry.location.lat();
        document.getElementById("longitude").value = place.geometry.location.lng();

        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }

    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var geolocation = new google.maps.LatLng(
                    position.coords.latitude, position.coords.longitude);
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                document.getElementById("latitude").value = latitude;
                document.getElementById("longitude").value = longitude;
                autocomplete.setBounds(new google.maps.LatLngBounds(geolocation, geolocation));
            });
        }
    }

    initialize();
</script>