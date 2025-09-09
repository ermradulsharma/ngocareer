<script type="text/javascript">
    function countUserByRoleID(RoleID) {
        jQuery.ajax({
            url: "<?php echo Backend_URL; ?>users/countUser",
            type: "POST",
            dataType: "text",
            data: {RoleID: RoleID},
            beforeSend: function () {
                jQuery('#role_' + RoleID).html('Loading...');
            },
            success: function (jsonData) {
                jQuery('#role_' + RoleID).html(jsonData);
            }
        });
    }


    // Manage ACL 
    function manage_acl(id) {
        
        jQuery('.js_update_respond').empty();
        jQuery('#manageAcl').modal({
            show: 'false'
        });
        jQuery.ajax({
            url: "<?php echo Backend_URL; ?>users/roles/getAcl",
            type: "POST",
            dataType: "text",
            data: {id: id},
            beforeSend: function () {
                jQuery('.acl_respond').html('<p class="ajax_processing">Loading...</p>');
            },
            success: function (msg) {
                jQuery('.acl_respond').html(msg);
            }
        });
    }
    
    function add_new_role(e) {
        e.preventDefault();
        var role_name = jQuery('#role_name').val();

        jQuery.ajax({
            url: '<?php echo Backend_URL; ?>users/roles/create',
            type: "POST",
            dataType: "json",
            data: {role_name: role_name},
            beforeSend: function () {
                jQuery('#ajaxRespondID').css('display','block').html('<p class="ajax_processing">Loading...</p>');
            },
            success: function (jsonRespond) {
                jQuery('#ajaxRespondID').html(jsonRespond.Msg);
                
                setTimeout(function() {	
                    jQuery('#ajaxRespondID').fadeOut('slow');
                }, 2000);

                
            }
        });
        return false;
    }

    // Delete Role ID
    function delete_role(id) {
        var yes = confirm('Really Want to Delete?');
        if (yes) {
            jQuery.ajax({
                url: "<?php echo Backend_URL; ?>users/roles/delete",
                type: "POST",
                dataType: "json",
                data: {id: id},
                beforeSend: function () {
                    jQuery('.role_id_' + id).css('background-color', '#FF0000');
                },
                success: function (respond) {
                    jQuery('.role_id_' + id).fadeOut('slow');
                    jQuery('#ajaxRespond').html('<p class="alert alert-success">' + respond.Msg + '</p>');
                    setTimeout(function () {
                        jQuery('#ajaxRespond').slideUp('slow');
                    }, 1500);
                }
            });
        }
    }

    // Rename Role 
    function edit_role(id) {
        jQuery.ajax({
            url: '<?php echo Backend_URL; ?>users/roles/rename',
            type: 'POST',
            dataType: "text",
            data: {id: id},
            beforeSend: function () {
                jQuery('.edit_id_' + id).html('Loading...');
            },
            success: function (msg) {
                jQuery('.edit_id_' + id).html(msg);
            }
        });
    }

    // Update Role Value
    function update_role(id) {
        var update_form = jQuery('#update_form').serialize();
        jQuery.ajax({
            url: "<?php echo Backend_URL; ?>users/roles/update",
            type: "POST",
            dataType: "json",
            data: update_form,
            cache: false,
            beforeSend: function () {
                jQuery('.edit_id_' + id).html('Loading...');
            },
            success: function (jsonData) {
                jQuery('.edit_id_' + id).html(jsonData.Msg);
            }
        });

    }


    // Module Access 
    function module_manage() {
        var FormData = jQuery('#access_permission').serialize();

        jQuery.ajax({
            url: "<?php echo Backend_URL; ?>users/roles/update_acl",
            type: "POST",
            dataType: "json",
            data: FormData,
            beforeSend: function () {
                jQuery('.js_update_respond').html('<p class="ajax_processing">Please Wait...</p>');
            },
            success: function (jsonRespond) {                
                jQuery('.js_update_respond').html(jsonRespond.Msg);               
            }
        });
    }

    var checked = false;
    function checkedAll() {
        if (checked === false) {
            checked = true;
        } else {
            checked = false;
        }
        for (var i = 0; i < document.getElementById('access_permission').elements.length; i++) {
            document.getElementById('access_permission').elements[i].checked = checked;
        }
    }
     
    function checkUncheck( module ) {        
        var len = $("#"+module+" input[name='acl_id[]']:checked").length;        
        if(len){
            jQuery('.' + module).prop('checked', '');
        } else {
            jQuery('.' + module).prop('checked', 'checked');
        }        
    }

    
    
    
    // random password generator
    function make_password() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for (var i = 0; i < 12; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        $('#new_pass').val(text);
    }


    var $ = jQuery;
    $(document).ready(function (e) {
        $("#update_user_aliza").on('submit', (function (e) {                                                
            e.preventDefault();            
            var formData = new FormData(document.getElementById("update_user_aliza"));                                                          
             
            jQuery.ajax({
                url: "<?php echo Backend_URL; ?>users/update_action",  
                type: "POST", 
                data: formData,
                enctype: 'multipart/form-data',
                beforeSend: function () {
                    jQuery('#success_report')
                            .html('<p class="ajax_processing"> Updating...')
                            .css('display','block');
                },
                success: function (msg) {
                    jQuery('#success_report').html(msg);                     
                    setTimeout(function () { jQuery('#success_report').fadeOut('slow');  }, 2000);                       
                },
                processData: false, 
                contentType: false, 
                cache: false                    
            });            
        }));        
    });
    
    
    /*------------ Instant Show Preview Image to a targeted place ------------*/
    


 function date_range(range){
     var range = range;
     if( range === 'Custom'){       
      $('#custom').css('display','block');
     } else {      
      $('#custom').css('display','none');
     }
    }
    

    function  password_change() {
        var formData = jQuery('#update_password').serialize();
        var error = 0;
        
        

        var new_pass = jQuery('[name=new_pass]').val();
	if(!new_pass){
            jQuery('[name=new_pass]').addClass('required');
            error = 1;
	}else{
            jQuery('[name=new_pass]').removeClass('required').addClass('required_pass');
	}
        
        var con_pass = jQuery('[name=con_pass]').val();
	if(!con_pass){
            jQuery('[name=con_pass]').addClass('required');
            error = 1;
	}else{
            jQuery('[name=con_pass]').removeClass('required').addClass('required_pass');
	}
        
                                        
        if( !error ) {
            jQuery.ajax({
                url: '<?php echo Backend_URL; ?>users/reset_password',
                type: "post",
                dataType: 'json',
                data: formData,
                beforeSend: function () {
                    jQuery('#ajax_respond')
                            .html('<p class="ajax_processing">Please Wait...</p>')
                            .css('display', 'block');
                },
                success: function (jsonRespond) {
                    if(jsonRespond.Status === 'OK'){
                        jQuery('#ajax_respond').html(jsonRespond.Msg);
                        setTimeout(function() { 
                            jQuery('#ajax_respond').slideUp('slow');
                            document.getElementById("update_password").reset();
                            jQuery('[name=new_pass]').removeClass('required_pass');
                            jQuery('[name=con_pass]').removeClass('required_pass');
                        }, 2000);
                    } else {                    
                        jQuery('#ajax_respond').html(jsonRespond.Msg);                
                    }
                }
            });
        }
        
     
     return false;
    };
    
    function setStatus( status, id ){               
        
        jQuery.ajax({
            url: 'admin/users/setStatus',
            type: "POST",
            dataType: 'json',
            data: {status:status, id:id },
            beforeSend: function () {
                jQuery('#currentStatus').html('<p class="ajax_processing">Loading...</p>');                        
            },
            success: function ( jsonRespond ) {
                if(jsonRespond.Status === 'OK'){
                    jQuery('#currentStatus').html( jsonRespond.Msg );                    
                }  
            }
        });
        return false;
        
    }
    
    
    function assign_billing_area() {
        var FormData = jQuery('#assign_areas').serialize();

        jQuery.ajax({
            url: "users/area_action",
            type: "POST",
            dataType: "json",
            data: FormData,
            beforeSend: function () {
                jQuery('#ajax_respond')
                        .html('<p class="ajax_processing">Please Wait...</p>')
                        .css('display','block');
            },
            success: function (jsonRespond) {                
                jQuery('#ajax_respond').html(jsonRespond.Msg);                
                if(jsonRespond.Status === 'OK'){
                    setTimeout(function() { 
                        jQuery('#ajax_respond').slideUp('slow');
                    }, 2000);
                }                
            }
        });
    }
</script>
