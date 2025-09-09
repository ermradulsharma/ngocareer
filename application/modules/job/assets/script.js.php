<script type="text/javascript">
    
    $("input[name='salary_type']").on('change', function () {
        var value = $(this).val();
        if(value === 'Range'){
            $('#salary_range_area').removeClass('hidden');
            $('#salary_period_area').removeClass('hidden');
            $('#salary_fixed_area').addClass('hidden');
        } else if(value === 'Fixed'){
            $('#salary_fixed_area').removeClass('hidden');
            $('#salary_period_area').removeClass('hidden');
            $('#salary_range_area').addClass('hidden');
        } else {
            $('#salary_range_area').addClass('hidden');
            $('#salary_period_area').addClass('hidden');
            $('#salary_fixed_area').addClass('hidden');
        }
    });

    $( document ).ready(function() {
        var value = $("input[name='salary_type']:checked").val();
        if(value === 'Range'){
            $('#salary_range_area').removeClass('hidden');
            $('#salary_period_area').removeClass('hidden');
            $('#salary_fixed_area').addClass('hidden');
        } else if(value === 'Fixed'){
            $('#salary_fixed_area').removeClass('hidden');
            $('#salary_period_area').removeClass('hidden');
            $('#salary_range_area').addClass('hidden');
        } else {
            $('#salary_range_area').addClass('hidden');
            $('#salary_period_area').addClass('hidden');
            $('#salary_fixed_area').addClass('hidden');
        }        
        
        $("#sub_cat_id").select2({tags: true, placeholder: 'Select an option'});
        $("#sub_cat_id").val($('#sub_cat_id').val()).trigger('change');
        $('#job_category_id').on('change', function () {
            var category_id = this.value;
            $.ajax({
                url: '<?php echo site_url('admin/job/get_sub_categoory/'); ?>' + category_id,
                type: "get",
                success: function (data) {
                    $('#sub_cat_id').html(data);
                    $("#sub_cat_id").select2({
                        tags: true
                    });                   
                }
            });
        });        
    });
    

//    $("#sub_cat_id").select2();
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