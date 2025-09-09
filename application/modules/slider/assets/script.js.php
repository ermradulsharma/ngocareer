<script>
    $('.remove').on('click', function(){
        var id = parseInt($(this).attr('id')) || 0;
        
        var yes = confirm('Confirm Delete?');
        if(yes){
            $.ajax({
                url: 'admin/slider/delete',
                type: 'POST',
                dataType: "json",
                data: { id: id },
                beforeSend: function(){
                    $('#item-'+ id ).css('background-color','red');
                },
                success: function ( jsonRespond ) {                
                    if( jsonRespond.Status === 'OK'){
                        setTimeout(function() { $('#item-'+ id ).fadeOut( 1000 ); }, 2000);
                    }
                }
            });
        }
    });

    function photoPreview(input, target) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(target + ' img').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
        $(target).show();
    }
    
    $(document).ready(function(){
        $( "#list tbody" ).sortable({

        axis: "y",

        update: function (event, ui) {
            // sortable() - Creates an array of the elements based on the element's id. 
            // The element id must be a word separated by a hyphen, underscore, or equal sign. For example, <tr id='item-1'>
            var data = $(this).sortable('serialize');                 
            // AJAX POST to server
            $.ajax({
                data: data,
                type: 'POST',
                url: 'admin/slider/reorder',
                success: function(response) {
                    $('#respond').html( response ).css('display','block');
                    setTimeout(function(){ $('#respond').slideUp(); }, 2000);
                }
            });
        }
    });
    });


function setStatus(status, id) {

        jQuery.ajax({
            url: '<?php echo Backend_URL; ?>slider/setStatus',
            type: "POST",
            dataType: 'json',
            data: {status: status, id: id},
            beforeSend: function () {
                jQuery('#status_' + id ).html('<span class="ajax_processing">Loading...</span>');
            },
            success: function (jsonRespond) {                                
                jQuery('#status_' + id ).html(jsonRespond.Msg);                
            }
        });
        return false;

    }
</script>