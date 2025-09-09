<script>
    
function  update_profile() {
    var formData = jQuery('#update_profile_info').serialize();
    jQuery.ajax({
        url: 'admin/profile/update',
        type: "POST",
        dataType: 'json',
        data: formData,
        beforeSend: function () {
            jQuery('#ajax_respond')
                    .html('<p class="ajax_processing">Loading...</p>')
                    .css('display','block');
        },
        success: function ( jsonRespond ) {
            if(jsonRespond.Status === 'OK'){
                jQuery('#ajax_respond').html( jsonRespond.Msg );                
                setTimeout(function () {
                    jQuery('#ajax_respond').slideUp( );                    
                }, 2000);
            } else {
                
            }
            
           
            
        


        }
    });
    return false;
}
</script>

