<script src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&key=AIzaSyCSuu_Ag9Z2CEMxzzXdCcPNIUtPm0-GIXs"></script>

<!--<div class="hidden-xs">-->
<!--    <div class="homebanner">-->
<!--        <div class="container">-->
<!--            --><?php ////echo view_slideshow(19); ?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<div class="banner hidden-xs">
    <a href="#"><img src="assets/theme/images/banner-new.jpg" class="img-responsive"></a>
</div>

<div class="mobile-banner hidden-lg hidden-md hidden-sm">
    <img src="assets/theme/images/banner-new.jpg" class="img-responsive">
</div>


<div class="container-fluid">
    <div class="col-md-2">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7967136455598756" crossorigin="anonymous"></script>
        <!-- vertic -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-7967136455598756"
             data-ad-slot="6768580337"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
    <div class="col-md-10">
        <div class="col-sm-12 newdesignhomesearch">
            <h2 class="">Search for NGO Jobs </h2>
            <form method="get" action="<?php echo site_url('job-search'); ?>">
                <div class="clearfix">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <input type="text" name="keyword" class="form-control"
                                   placeholder="Job Title, Job Sector, Occupation or Employer"/>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <input type="text" name="location" id="autocomplete" autocomplete="off"
                                   class="form-control" placeholder="Location"/>
                            <input type="hidden" name="lat" id="latitude"/>
                            <input type="hidden" name="lng" id="longitude"/>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <input type="submit" class="btnContactSubmit" value="Find Job"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-2">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7967136455598756" crossorigin="anonymous"></script>
        <!-- vertic -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-7967136455598756"
             data-ad-slot="6768580337"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
</div>

<div class="search-top homesearch">
    <div class="col-sm-2 adsleft pull-left" style="margin-top: 30px;">

            </div>
            <div class="clearfix"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 newdesignhomesearch">
                <h2 class="">Search for NGO Jobs </h2>
                <form method="get" action="<?php echo site_url('job-search'); ?>">
                    <div class="clearfix">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <input type="text" name="keyword" class="form-control"
                                       placeholder="Job Title, Job Sector, Occupation or Employer"/>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <input type="text" name="location" id="autocomplete" autocomplete="off"
                                       class="form-control" placeholder="Location"/>
                                <input type="hidden" name="lat" id="latitude"/>
                                <input type="hidden" name="lng" id="longitude"/>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="submit" class="btnContactSubmit" value="Find Job"/>
                            </div>
                        </div>
                    </div>
                </form>
        <!--        <div class="col-md-12">-->
        <!--    <?php //$this->load->view('frontend/template/job_alert_short'); ?>-->
        <!--</div>-->
                <!-- div class="home-search-bottom">
                    <h4 style="color: #fff;" class="text-left"><?php // echo Ngo::jobAdsSummery(); ?></h4>
                </div> -->
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-2 adsright pull-right" style="margin-top: 30px;">

</div>

</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php  $this->load->view('frontend/template/job_alert_short'); ?>
        </div>
    </div>
</div>

<?php
$featuredJobs = Ngo::getFeaturedJobs(6);
if ($featuredJobs) {
    ?>

    <div class="featurd-job">
        <div class="container">
            <div class="row">
                <h2 class="text-center">Featured Jobs</h2>
                <?php

                foreach ($featuredJobs as $featuredJob) {
                    $featured_job_url = site_url("job-details/{$featuredJob->id}/" . slugify($featuredJob->title) . '.html');
                    ?>
                    <div class="col-sm-4">
                        <div class="home-featured-box clearfix">
                            <div class="featurd-image">
                                <img src="assets/theme/images/featured-image.jpg" class="img-responsive">
                            </div>
                            <div class="home-featured-box-content">
                                <h3>
                                    <a href="<?php echo $featured_job_url; ?>"><?php echo getShortContent($featuredJob->title, 20); ?></a>
                                </h3>
                                <p class="group"><?php echo !empty($featuredJob->company_name) ? $featuredJob->company_name : 'N/A'; ?></p>
                                <p class="address-feature"><?php echo !empty($featuredJob->location) ? $featuredJob->location : 'N/A'; ?></p>
                                <p class="featurd-salary"><b>Salary</b>
                                    : <?php echo Ngo::getSalary($featuredJob->salary_type, $featuredJob->salary_min, $featuredJob->salary_max, $featuredJob->salary_period, $featuredJob->salary_currency); ?>
                                </p>
                                <p><?php echo getShortContent($featuredJob->description, 70); ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="col-sm-12 view-all-job">
                    <a class="jobseeker btn-primary btn" href="job-search">view all jobs</a>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

<?php

$featuredRecruiters = Ngo::getFeaturedRecruiters(4);
//dd($featuredRecruiters);
if ($featuredRecruiters) {
    ?>
    <div class="featurd-recruiters">
        <div class="container">
            <div class="row">
                <h2 class="text-center">Featured Recruiters</h2>
                <?php foreach ($featuredRecruiters as $featuredRecruiter) { ?>
                    <div class="col-sm-3">
                        <div class="recruiters-box">
                            <a href="<?php echo site_url("company-details/{$featuredRecruiter->company_id}/" . slugify($featuredRecruiter->company_name) . '.html'); ?>">
                                <div class="thumb">
                                    <img src="<?php echo getPhoto($featuredRecruiter->company_logo); ?>"
                                         class="img-responsive"/>
                                </div>
                                <h3><?php echo !empty($featuredRecruiter->company_name) ? $featuredRecruiter->company_name : 'N/A'; ?></h3>
                            </a>
                            <!--<p>NGO Jobs</p>-->
                        </div>
                    </div>
                <?php }//foreach
                ?>

                <div class="col-sm-12 view-all-job">
                    <a class="jobseeker btn-primary btn" href="companies">view all companies</a>
                </div>
            </div>
        </div>
    </div>

<?php } ?>



<?php
$recentJobs = Ngo::getRecentJobs(4);
if ($recentJobs) {
    ?>
    <div class="recent-jobs">
        <div class="container">
            <div class="row">
                <h2 class="text-center">Recent Jobs <small>(in last 30 days)</small></h2>
                <?php
                foreach ($recentJobs as $recentJob) {
                    $resunt_job_url = site_url("job-details/{$recentJob->id}/" . slugify($recentJob->title) . '.html');
                    ?>
                    <div class="col-sm-6">
                        <div class="job-box">
                            <h3>
                                <a href="<?php echo $resunt_job_url; ?>"><?php echo getShortContent($recentJob->title, 25); ?></a>
                            </h3>
                            <h4><?php echo getShortContent($recentJob->company_name,50); ?></h4>
                            <p class="home-loc"><?php echo isSpecify($recentJob->location); ?></p>
                            <p class="home-salary"><strong>Salary</strong>
                                : <?php echo isSpecify($recentJob->salary_type); ?></p>
                            <p><?php echo getShortContent($recentJob->description, 80); ?></p>
                        </div>
                    </div>
                    <?php
                }//foreach
                ?>
            </div>
            <p class="text-center"><a href="job-search" class="btn btn-primary">View all recent jobs</a></p>
        </div>
    </div>
<?php } ?>
<div style="margin-bottom: 40px;" class="container">

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7967136455598756"
     crossorigin="anonymous"></script>
<!-- horizont -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7967136455598756"
     data-ad-slot="7685064424"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>



<div class="job-category">
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item active">
                <a href="#categories" class="nav-link active" data-toggle="tab">
                    All Jobs by categories
                </a>
            </li>
            <li class="nav-item">
                <a href="#employers" class="nav-link" data-toggle="tab">
                    All Jobs by Employers
                </a>
            </li>
            <li class="nav-item">
                <a href="#country" class="nav-link" data-toggle="tab">
                    All Jobs by Country
                </a>
            </li>
            <!--            <li class="nav-item">-->
            <!--                <a href="#organization" class="nav-link" data-toggle="tab">-->
            <!--                    Organization Type-->
            <!--                </a>-->
            <!--            </li>-->
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="categories">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo Ngo::getAllJobsByCategories(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="employers">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php //echo Ngo::getAllJobsByEmployers(); ?>
                        <?php echo Ngo::getAllJobsByAdvertiser(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="country">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo Ngo::getAllJobsByCountry(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!--        <div class="tab-pane fade" id="organization">-->
        <!--            <div class="container">-->
        <!--                <div class="row">-->
        <!--                    <div class="col-md-12">-->
        <!--                        --><?php //echo Ngo::getAllJobsByOrganizationTypes(); ?>
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
    </div>
</div>


<?php
$recentEvents = Ngo::RecentNGOEvents(4);
if ($recentEvents):
    ?>

    <div class="recent-event">
        <div class="container">
            <h1 class="text-center">Recent NGO Events</h1>
            <div class="row">
                <?php foreach ($recentEvents as $r): ?>
                    <div class="col-md-6">
                        <div class="event-image">
                            <img class="img-responsive" src="<?php echo getPhoto($r->image); ?>">
                        </div>
                        <div class="event-content">
                            <p><span class="date"><?php echo GDF($r->start_date); ?></span> <span
                                        class="location"><?php echo $r->location ?></span></p>
                            <h3><?php echo getShortContent($r->title, 50); ?></h3>
                            <p><a class="more"
                                  href="<?php echo site_url("event/{$r->id}/" . slugify($r->title) . '.html'); ?>">READ
                                    MORE</a></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

<?php endif; ?>
<div class="home-bottom">
<div class="container text-left">
    <div class="col-md-8">
    <h2>About Us</h2>
    <p>NGO Career is a UK based employment search service offering a helping hand to individuals seeking jobs in the NGO (Non-governmental organization) sector. Our vision is to help NGOs in the amazing work they do by matching them up with ideal recruits to come and work for them. Simultaneously, we also aim to improve the experience of those looking for a job in the NGO sector by providing a platform to enable them to find their perfect match within the sector or NGO that they are interested in joining.</p>
    <p>NGO Career is an international NGO job board focused on matching the full spectrum of NGO roles with suitably skilled and experienced job seekers. We care that this is a sector in need of careful recruitment practices in order to empower NGOs, as well as empower the individual aid worker. As resources for recruitment can be scarce, and positions often have an international target job market, it’s vital to use a dedicated digital platform like NGO Careers to ensure the recruitment process is successful for candidate and NGO alike.</p>
    <p>At NGO Career, we have a vast number of NGO jobs for you to browse, and a broad and experienced talent pool of candidates. We focus on careers as connected employment opportunities, progression, learning and experiences to meet your life goals. NGOcareer.com is the ideal employment search and recruitment service for both Job seekers and employers worldwide.</p>
    <p>As job seeker, you can search and apply for your dream NGO Job in Non-government Organizations, Charities and Not-For-Profit Organisations. As a recruiter or employer, our job portal allow you post job vacancies and hire the right candidates for your organization’s cause and mission.</p>
    <p><a href="about-us" class="btn btn-primary">Read More</a></p>
</div>
    <div class="col-md-4">
            <img src="assets/theme/images/common-job.jpg" class="img-responsive">
        </div>
</div>

<!-- <div class="container">
    <h2 class="text-center">Most Common NGO Jobs</h2>
    <div class="row">
        <div class="col-md-8">
            <p>For anyone seeking a career that makes a difference in the world and improves the lives of other people, animals or the environment, a role with an NGO can be extremely rewarding.</p>
            <p>Featured here is a selection of job descriptions for some of the most common roles available with NGOs, but this list is not exhaustive.</p>
            <p>Depending on where and how they operate, NGOs may also recruit:</p>
            <ul>
                <li>Medical staff (doctors, nurses, midwives, nutritionists, physiotherapists, pharmacists) to train local medics or run emergency response clinics</li>
                <li>Mental health support staff (psychologists, psychiatrists, play therapists, counsellors) to help people overcome trauma in conflict zones or refugee camps</li>
                <li>Engineering staff (water engineers, civil engineers, mechanical engineers) to build local capacity, oversee large infrastructure projects and provide technical expertise</li>
                <li>Logisticians – to source and maintain project vehicles, telecommunications equipment, electricity supply and warehousing</li>
                <li>Volunteer managers – organising inductions, training and support for volunteers is a common aspect of many NGO roles</li>
                <li>Teaching staff (teachers, teaching assistants, youth workers) to support local schools in improving their education provision</li>
            </ul>
            <p><a href="most-common-ngo-jobs" class="btn btn-primary">Read More</a></p>
        </div>
        <div class="col-md-4">
            <img src="assets/theme/images/common-job.jpg" class="img-responsive">
        </div>
    </div>

</div> -->
</div>
<div class="news-slide">
    <div class="container">
        <h2 class="text-center">Recent Blog</h2>
        <?php echo getPostWidgetByCategoryIDNews('50'); ?>
        <p class="text-center"><a href="blog" class="btn btn-primary">View All</a></p>
    </div>
</div>




<script>
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
