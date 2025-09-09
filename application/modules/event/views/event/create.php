<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&key=AIzaSyCSuu_Ag9Z2CEMxzzXdCcPNIUtPm0-GIXs"></script>
<section class="content-header">
    <h1> Event <small><?php echo $button ?></small> <a href="<?php echo site_url(Backend_URL . 'event') ?>"
                                                       class="btn btn-default">Back</a></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>event">Event</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Add New Event</h3>
        </div>

        <div class="box-body">
            <form class="form-horizontal" action="<?php echo $action; ?>" enctype="multipart/form-data" role="form"
                  id="personalForm" method="post">
                
                <div class="box no-border">
                    <div class="row">

                        <div class="col-md-9">
                            <div class="box-body">
                                <?php if($login_role_id != 4): ?>
                                    <div class="form-group">
                                        <label for="user_id" class="col-sm-2 control-label">Select Company<sup>*</sup></label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="user_id" id="user_id">
                                                <option value="0">-- Select Company --</option>
                                                <?php echo Ngo::company($user_id); ?>
                                            </select>
                                            <?php echo form_error('user_id') ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <label for="event_category_id" class="col-sm-2 control-label">Event Category<sup>*</sup></label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="event_category_id">
                                            <?php echo getEventCategoryDropDown($event_category_id); ?>
                                        </select>
                                        <?php echo form_error('event_category_id') ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Title<sup>*</sup></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="title" id="title" placeholder="Title"
                                               value="<?php echo $title; ?>"/>
                                        <?php echo form_error('title') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="location" class="col-sm-2 control-label">Location<sup>*</sup></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="location" id="autocomplete" placeholder="Location"
                                               value="<?php echo $location; ?>" autocomplete="off"/>
                                        <input type="hidden" name="lat" id="latitude" value="<?php echo $lat; ?>"/>
                                        <input type="hidden" name="lng" id="longitude" value="<?php echo $lng; ?>"/>
                                        <?php echo form_error('location') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="physical_address" class="col-sm-2 control-label">Physical Address<sup>*</sup></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="physical_address" id="physical_address"
                                               placeholder="Physical Address" value="<?php echo $physical_address; ?>"/>
                                        <?php echo form_error('physical_address') ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="region" class="col-sm-2 control-label">Region<sup>*</sup></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="region" id="region" placeholder="Region"
                                               value="<?php echo $region; ?>"/>
                                        <?php echo form_error('region') ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="country_id" class="col-sm-2 control-label">Country<sup>*</sup></label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="country_id">
                                            <?php echo getDropDownCountries($country_id) ?>
                                        </select>
                                        <?php echo form_error('country_id') ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="event_link" class="col-sm-2 control-label">Event Link</label>
                                    <div class="col-sm-10">
                                        <input type="url" class="form-control" name="event_link" id="event_link"
                                               placeholder="Event Link" value="<?php echo $event_link; ?>"/>
                                        <?php echo form_error('event_link') ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="start_date" class="col-sm-2 control-label">Start Date<sup>*</sup></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control js_datepicker_limit date_picker_icon" name="start_date" id="start_date"
                                               placeholder="Start Date" value="<?php echo $start_date; ?>" autocomplete="off"/>
                                        <?php echo form_error('start_date') ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="end_date" class="col-sm-2 control-label">End Date<sup>*</sup></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control js_datepicker_limit date_picker_icon" name="end_date" id="end_date"
                                               placeholder="End Date" autocomplete="off"
                                               value="<?php echo $end_date; ?>"/>
                                        <?php echo form_error('end_date') ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="summary" class="col-sm-2 control-label">Summary</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="summary" id="summary"
                                               placeholder="Summary"
                                               value="<?php echo $summary; ?>"/>
                                        <?php echo form_error('summary') ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Description<sup>*</sup></label>
                                    <div class="col-sm-10">
                                <textarea class="form-control" rows="6" name="description" id="description"
                                          placeholder="Description"><?php echo $description; ?></textarea>
                                        <?php echo form_error('description') ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="full_description" class="col-sm-2 control-label">Full Description</label>
                                    <div class="col-sm-10">
                                <textarea class="form-control" rows="3" name="full_description" id="full_description"
                                          placeholder="Full Description"><?php echo $full_description; ?></textarea>
                                        <?php echo form_error('full_description') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="organizer_name" class="col-sm-2 control-label">Organizer Name<sup>*</sup></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="organizer_name" id="organizer_name"
                                               placeholder="Organizer Name" value="<?php echo $organizer_name; ?>"/>
                                        <?php echo form_error('organizer_name') ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="organization_type" class="col-sm-2 control-label">Organization Type</label>
                                    <div class="col-sm-10"
                                         style="padding-top:8px;">
                                        <?php echo htmlRadio('organization_type', $organization_type, array('Individual' => 'Individual', 'Public' => 'Public')); ?></div>
                                </div>
                                <div class="form-group hidden" id="organization_details_area">
                                    <label for="organization_details" class="col-sm-2 control-label">Organization Details</label>
                                    <div class="col-sm-10">
                                <textarea class="form-control" rows="6" name="organization_details" id="organization_details"
                                          placeholder="Organization Details"><?php echo $organization_details; ?></textarea>
                                        <?php echo form_error('organization_details') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="package_id" class="col-sm-2 control-label">Select Package<sup>*</sup></label>
                                    <div class="col-sm-10">
                                        <?php echo packageHtmlRadio('package_id', $package_id, 'Event'); ?>
                                        <?php echo form_error('package_id') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="status" class="col-sm-2 control-label">Status</label>
                                    <div class="col-sm-10"
                                         style="padding-top:8px;"><?php echo htmlRadio('status', $status, $status_option); ?></div>
                                </div>

                                <div class="form-group">
                                    <label for="remark" class="col-sm-2 control-label">Remark</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="remark" id="remark" placeholder="Remark"
                                               value="<?php echo $remark; ?>"/>
                                        <?php echo form_error('remark') ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="box-body">
                                <fieldset>
                                    <legend>Event Image</legend>
                                    <div class="thumbnail upload_image">
                                        <img src="<?php echo getPhoto($image); ?>" alt="Thumbnail">
                                    </div>
                                    <div class="btn btn-default btn-file">
                                        <i class="fa fa-picture-o"></i> Select Logo
                                        <input accept="image/*" type="file" name="image" class="file_select"
                                               onchange="photoPreview(this, '.upload_image')">
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer text-center">
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button ?></button>
                        <a href="<?php echo site_url(Backend_URL . 'event') ?>" class="btn btn-default">Cancel</a>
                    </div>


                </div>
            </form>
        </div>
    </div>
</section>


<script type="text/javascript">
    $(function() {
        organization_type_change();
    });

    $("input[name = 'organization_type']").click(function(){
        organization_type_change();
    });

    function organization_type_change(){
        var value = $("input[name = 'organization_type']:checked").val();
        if(value == 'Public'){
            $('#organization_details_area').removeClass('hidden');
        } else{
            $('#organization_details_area').addClass('hidden');
        }
    }


    //    google location  track
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
<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('full_description', {
        width: ['100%'],
        height: ['300px'],
        customConfig: '<?php echo site_url('assets/lib/plugins/ckeditor/config.js'); ?>'
    });
</script>