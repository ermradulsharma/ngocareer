<script>
function statusUpdate(post_id, status){
    $.ajax({
        url: 'admin/cms/update_status',
        type: 'POST',
        dataType: "json",
        data: { status: status, post_id: post_id  },
        beforeSend: function(){
            $('#active_status_'+ post_id ).html('Updating...');
        },
        success: function ( jsonRespond ) {
            $('#active_status_'+post_id)
                    .html(jsonRespond.Status)
                    .removeClass( 'btn-default btn-danger btn-success')
                    .addClass( jsonRespond.Class );

        }
    });   
}

function removeFeaturedImage(id){
        if(confirm('Are you sure?')){
            $.ajax({
                url: "admin/cms/remove_featured_image",
                type: "POST",
                dataType: "json",
                data: {id: id},
                beforeSend: function () {
                    $('#ajax_respond').html('<p class="ajax_processing">Processing..</p>');
                },
                success: function (respond) {
                    if(respond.Status == 'OK'){
                        $('#ajax_respond').html(respond.Msg);
                        $('.upload_image img').attr('src', 'uploads/no-photo.jpg');
                        setTimeout(function(){ 
                            $('#ajax_respond').html('');
                            $('#remove_featured_image_btn').html('');
                        }, 2000);
                    } else {
                        $('#ajax_respond').html(respond.Msg);
                    }
                }
            });
        }
    }
</script>    