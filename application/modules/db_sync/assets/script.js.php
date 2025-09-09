<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
    
    jQuery('#backup_full_db').on('click', function(e){
        e.preventDefault();
        var table = 'Full Tbl';
        jQuery.ajax({
            url: 'admin/db_sync/backup_full_db',
            type: "POST",
            dataType: 'json',
            data: { table : table},
            beforeSend: function () {
                jQuery('#ajax_respond')
                        .html('<p class="ajax_processing">Loading...</p>')
                        .css('display','block');
            },
            success: function (jsonRespond) {
                if(jsonRespond.Status === 'OK'){
                    jQuery('#ajax_respond').html( jsonRespond.Msg );    
                    jQuery('#history tbody').prepend( jsonRespond.TblRow );
                    
                     jQuery('html, body').animate({
                        scrollTop: jQuery("#js_ajax_scroll").offset().top
                    }, 1000);                    
                    setTimeout(function() {	jQuery('#ajax_respond').slideUp('slow'); }, 2000);
                    
                } else {
                    jQuery('#ajax_respond').html( jsonRespond.Msg );
                }                               
            }
        });
        return false;
        
    });
    
    jQuery('#upload_sql_file').on('click', function(e){
        e.preventDefault();
        var table = 'Full Tbl';
        jQuery.ajax({
            url: 'admin/db_sync/upload_sql_file',
            type: "POST",
            dataType: 'json',
            data: { table : table},
            beforeSend: function () {
                jQuery('#ajax_respond')
                        .html('<p class="ajax_processing">Loading...</p>')
                        .css('display','block');
            },
            success: function (jsonRespond) {
                if(jsonRespond.Status === 'OK'){
                    jQuery('#ajax_respond').html( jsonRespond.Msg );    
                    jQuery('#history tbody').prepend( jsonRespond.TblRow );
                    
                     jQuery('html, body').animate({
                        scrollTop: jQuery("#js_ajax_scroll").offset().top
                    }, 1000);                    
                    setTimeout(function() {	jQuery('#ajax_respond').slideUp('slow'); }, 2000);
                    
                } else {
                    jQuery('#ajax_respond').html( jsonRespond.Msg );
                }                               
            }
        });
        return false;
        
    });
    
    
    function exportTable(table) {                        
        jQuery.ajax({
            url: 'admin/db_sync/exportTable',
            type: "post",
            dataType: 'json',
            data: { table : table},
            beforeSend: function () {
                jQuery('#ajax_respond')
                        .html('<p class="ajax_processing">Loading...</p>')
                        .css('display','block');
            },
            success: function (jsonRespond) {
                if(jsonRespond.Status === 'OK'){
                    jQuery('#ajax_respond').html( jsonRespond.Msg );    
                    jQuery('#history tbody').prepend( jsonRespond.TblRow );
                    
                     jQuery('html, body').animate({
                        scrollTop: jQuery("#js_ajax_scroll").offset().top
                    }, 1000);                    
                    setTimeout(function() {	jQuery('#ajax_respond').slideUp('slow'); }, 5000);
                    
                } else {
                    jQuery('#ajax_respond').html( jsonRespond.Msg );
                }                               
            }
        });
        return false;
    }
    
    function truncateDialog( table ){
        //alert( table );
        jQuery("#jquery-dialog").html('Do you really want to empty '+ table +' record ');        
        jQuery("#jquery-dialog").dialog({
            resizable: false,
            title: 'Truncate a Table Record',
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
              Cancel: function() {
                jQuery( this ).dialog( "close" );
              },
              "Confirm Empty": function() {
                truncateTable( table );  
                //jQuery( this ).dialog( "close" );
              }
            }
        });    
    }
        
    function truncateTable( table ){        
        jQuery("#jquery-dialog").html('<p class="ajax_processing">Processing...</p>');
        
        jQuery.ajax({
            url: 'admin/db_sync/truncateTable',
            type: "post",
            dataType: 'json',
            data: { table : table},
            beforeSend: function () {
                jQuery('#jquery-dialog').html('<p class="ajax_processing">Loading...</p>');
            },
            success: function (jsonRespond) {
                jQuery('#jquery-dialog').html( jsonRespond.Msg );
                if(jsonRespond.Status === 'OK'){                                       
                    setTimeout(function() {	jQuery( "#jquery-dialog" ).dialog( "close" ); }, 2000);        
                }                               
            }
        });
        return false;                
    }
    
    function deleteTable(  id, file) {
        
        jQuery("#jquery-dialog").html('Do you really want to delete '+ file +' backup? ');        
        jQuery("#jquery-dialog").dialog({
            resizable: false,
            title: 'Delete a Backup',
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
              Cancel: function() {
                jQuery( this ).dialog( "close" );
              },
              "Confirm Empty": function() {
                deleteABackup( id, file );  
                //jQuery( this ).dialog( "close" );
              }
            }
        }); 
    }
    
    function deleteABackup( id, file ) {
        jQuery.ajax({
            url: 'admin/db_sync/delete',
            type: "post",
            dataType: 'json',
            data: { id : id, file : file },
            beforeSend: function () {
                jQuery('#jquery-dialog').html('<p class="ajax_processing">Loading...</p>');
            },
            success: function (jsonRespond) {
                jQuery('#jquery-dialog').html( jsonRespond.Msg );
                if(jsonRespond.Status === 'OK'){                                       
                    setTimeout(function() {  jQuery( "#jquery-dialog" ).dialog( "close" ); }, 1000);  
                    $('#row_' + id).fadeOut(2000);
                }                               
            }
        });
        return false;
    }
    
    function RestoreDB( file, table ){

        jQuery.ajax({
            url: 'admin/db_sync/restore',
            type: "POST",
            dataType: 'json',
            data: { file: file, table : table},
            beforeSend: function () {
                jQuery('#ajax_respond')
                        .html('<p class="ajax_processing">Loading...</p>')
                        .css('display','block');
            },
            success: function (jsonRespond) {
                if(jsonRespond.Status === 'OK'){
                    jQuery('#ajax_respond').html( jsonRespond.Msg );
                    jQuery('html, body').animate({
                        scrollTop: jQuery("#js_ajax_scroll").offset().top
                    }, 1000); 
                    setTimeout(function() {	jQuery('#ajax_respond').slideUp('slow'); }, 2000);                    
                } else {
                    jQuery('#ajax_respond').html( jsonRespond.Msg );
                }                               
            }
        });        
    }        
</script>