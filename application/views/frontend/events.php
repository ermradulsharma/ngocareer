<script src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&key=AIzaSyCSuu_Ag9Z2CEMxzzXdCcPNIUtPm0-GIXs"></script>
<div class="search-top">
    <div class="container">
        <div class="row">

            <div class="col-sm-12">
                <form method="get" action="" id="find-jobs-form-top">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="text" name="keyword" id="keyword" class="form-control"
                                       placeholder="Event Title" value="<?php echo $keyword; ?>"/>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="loc" id="autocomplete" placeholder="Location"
                                       value="<?php echo $location; ?>"/>
                                <input type="hidden" name="lat" id="latitude" value="<?php echo $lat; ?>"/>
                                <input type="hidden" name="lng" id="longitude" value="<?php echo $lng; ?>"/>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <select name="category" id="category" class="form-control">
                                    <?php echo Ngo::getEventCategoryDropDown($category, 'Any Category'); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <input type="submit" class="btnContactSubmit" value="Find Event"/>
                            <a href="<?php echo site_url('events'); ?>" class="btn btn-link">
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
        
        <div class="search-list-all">          
            <div class="col-sm-12">
                <div class="jobcontent">
                    <pre class="hidden"><?php //echo $sql; ?></pre>

                    <?php
                    if ($events) {
                        foreach ($events as $event) {
                            $event_url = site_url("event/{$event->id}/" . slugify($event->title) . '.html');
                            ?>
                            <div class="shortview event_box">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img class="img-responsive" src="<?php echo getPhoto($event->image); ?>" alt="Event"/>
                                    </div>
                                    <div class="col-md-9">
                                        <div style="padding-right: 15px;">
                                            <h1>
                                                <a href="<?php echo $event_url; ?>">
                                                    <?php echo $event->title; ?>
                                                </a>
                                            </h1>
                                            <p>
                                                Start Date: <?php echo globalDateFormat($event->start_date) ?>,
                                                End Date: <?php echo globalDateFormat($event->end_date) ?></p>
                                            <p>Category: <?php echo $event->cat_name; ?></p>
                                            <p class="text-justify">
                                                <?php echo getShortContent($event->description, 350); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                    <div class="no-result">
                        <p>No events found today. Search later...</p>
                        <a class="btn btn-primary" 
                           href="<?php echo site_url('admin/event/create'); ?>">
                            Post an Event Today
                            <i class="fa fa-caret-right"></i>
                        </a>
                    </div>
                    <?php } ?>

                    <div class="pagination-box">                        
                        <?php echo $pagination; ?>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
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