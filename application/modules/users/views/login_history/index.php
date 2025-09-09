<?php defined('BASEPATH') OR exit('No direct script access allowed');
load_module_asset('users','css'); ?>


<section class="content-header">
    <h1> Login history  <small>Control panel</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url( Backend_URL )?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Login history</li>
    </ol>
</section>

<section class="content">    
    <ul class="tabsmenu">        
        <li><a class="<?php echo  ($this->input->get('most_login') != 'yes') ? 'active': '' ; ?>" href="<?php echo Backend_URL.'users/login_history' ?>"> All</a></li>
        <li><a class="<?php echo  ($this->input->get('most_login') == 'yes') ? 'active': '' ; ?>"  href="<?php echo Backend_URL.'users/login_history?most_login=yes' ?>"> Most Login Users</a></li>
    </ul>

    <div class="box no-border">            
        
        
        <?php if( $most != 'yes' ): ?>
        <div class="box-header with-border">
            <div class="row">
                <form method="get" name="report" action="">
                    <div class="col-md-7 no-padding">
                            <?php $ragne = $this->input->get('range'); ?>

                            <div class="col-md-3">
                                <select name="range" class="form-control" onchange="date_range(this.value)">
                                    <?php echo Users_helper::getRegistraionRange($ragne); ?>
                                </select>
                            </div>

                            <div id="custom" <?php echo ($ragne == 'Custom') ? '' : ' style="display: none;"'; ?>>
                                <div class="col-md-3">
                                    <input type="text" name="fd" placeholder="From Date" value="<?php echo $this->input->get('fd'); ?>"  class="form-control input-md dp_icon js_datepicker"> 
                                </div>
                                <div class="col-md-3">                 
                                    <input type="text" name="td"  placeholder="To Date" value="<?php echo $this->input->get('td'); ?>"   size="10" class="form-control dp_icon input-md js_datepicker">    
                                </div>                
                            </div>


                        </div>

                    <div class="col-md-5 pull-right">
                        <div class="row">
                            <div class="col-md-4">
                                    <select name="device" class="form-control">
                                        <?php echo getDeviceList( $this->input->get('device') ); ?>
                                    </select>
                                </div>
                            <div class="col-md-4">
                                <select name="browser" class="form-control">
                                    <?php echo getBrowserList( $this->input->get('browser') ); ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <input type="submit" class="btn btn-primary" value="Filter">
                                <input type="button" class="btn btn-default" value="Reset" onclick="location.href = 'admin/users/login_history';">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>        
        <?php endif; ?>
        
        
        <form method="POST" id="all_log_select" style="padding-bottom:  10px;">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                                <?php if( $most != 'yes' ): ?>
                                <th width="30">#</th>
                                <th width="40">ID</th>
                                <?php endif;  ?>

                                <th>User Name</th>
                                <?php if( $most == 'yes' ) : ?>
                                <th>Count</th>
                                <?php endif;  ?>
                                <th>Login Time</th>
                                <th>Logout Time</th>
                                <th>IP Address</th>                                        
                                <th>Browser</th>
                                <th>Device</th>
                                <th width="50" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php  foreach ($logins as $login) { ?>
                            <tr id="row_<?php echo $login->id; ?>">
                                <?php if( $most != 'yes' ): ?>
                                <td><input type="checkbox" name="log_id[]" value="<?php echo $login->id; ?>"></td>
                                <td><?php echo $login->id; ?></td>
                                <?php endif;  ?>

                                <td><a href="<?php echo Backend_URL . 'users/profile/' . $login->user_id; ?>">
                                    <?php echo $login->email; ?></a></td>
                                <?php if( $most == 'yes' ) : ?>
                                <td><span class="badge bg-light-blue"><?php echo $login->visit; ?></span></td>
                                <?php endif;  ?>
                                <td><?php echo globalDateFormat( $login->login_time ); ?></td>
                                <td><?php echo globalDateFormat($login->logout_time); ?></td>
                                <td><?php echo $login->ip; ?></td>                                            
                                <td><?php echo $login->browser; ?></td>
                                <td><?php echo $login->device; ?></td>
                                <td  class="text-center"><span class="btn btn-danger btn-xs delete" 
                                          data-most="<?php echo $most;?>"
                                          data-id="<?php echo $login->id; ?>"
                                          data-user="<?php echo $login->user_id; ?>">
                                        <i class="fa fa-times"></i>                                             
                                    </span>                                        
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        
            <div class="box-footer with-border">
                <div id="ajax_respond"> </div>
        
                <div class="row">                                      
                    <div class="col-md-5">

                        <?php if( $this->input->get('most_login') != 'yes') : ?>
                        <div class="row" style="">
                            <div class="col-md-12">
                             <div class="col-md-3 no-padding">
                                 <label class="btn btn-default"><input type="checkbox" name="checkall" onclick="checkedAll();"> Mark All</label>                                                             
                             </div>

                             <div class="col-md-4 no-padding">
                                  <select class="form-control" name="action" >
                                      <option value="0">--Bulk Action--</option>                                     
                                      <option value="Delete">Delete</option>                                                                        
                                  </select>

                              </div>                         
                             <div class="col-md-2 no-padding">
                                  <button type="button" id="open_dialog" class="btn btn-primary btn-flat">Action</button>
                             </div>
                            </div>
                        </div>

                        <?php endif;  ?>

                     </div>
                    <div class="col-md-7">
                       <div class="row">    
                            <div class="col-md-8 text-right">
                                 <?php echo $pagination ?>
                            </div> 
                            <div class="col-md-4 text-right">
                                 <span class="btn btn-primary">Total Record : <?php echo $total_rows; ?></span>
                            </div>                                           
                         </div>
                    </div>
                </div>        
            </div>        
        </form>        
   </div>       
</section>

<script>
    var checked = false;
    function checkedAll() {
        if (checked === false) {
            checked = true;
        } else {
            checked = false;
        }
        for (var i = 0; i < document.getElementById('all_log_select').elements.length; i++) {
            document.getElementById('all_log_select').elements[i].checked = checked;
        }
    }

    jQuery('#open_dialog').on('click', function(){
        var formData = jQuery('#all_log_select').serialize();
        jQuery.ajax({
            url: 'admin/users/login_history/bulk_action',
            type: "POST",
            dataType: "json",
            data: formData,
            beforeSend: function () {
                jQuery('#ajax_respond').html('<p class="ajax_processing">Loading....</p>');
            },
            success: function (jsonRepond ) {                     
                jQuery('#ajax_respond').html( jsonRepond.Msg );
                if(jsonRepond.Status === 'OK'){                   
                   setTimeout(function() {	
                       jQuery('#ajax_respond').fadeOut(); 
                       location.reload();},
                    2000);
                }
            }
        });            
    });

    function date_range(range){
        var range = range;
        if( range === 'Custom'){       
            $('#custom').css('display','block');
        } else {      
            $('#custom').css('display','none');
        }
    }  
    
    jQuery(document).on('click', '.delete', function(){
        var id = parseInt( $(this).data('id')) || 0;
        var user = parseInt( $(this).data('user')) || 0;
        var most = $(this).data('most');        
        
        var yes = confirm('Confirm Delete');
        if(yes){
            jQuery.ajax({
                url: 'admin/users/login_history/delete',
                type: "POST",
                dataType: "json",
                data: { id: id, most: most, user: user },
                beforeSend: function () {
                    jQuery('#row_'+id).css('background-color','red');
                },
                success: function (jsonRepond ){
                    if(jsonRepond.Status === 'OK'){                
                       jQuery('#row_'+id).fadeOut(1000);
                    } else {
                        jQuery('#row_'+id).css('background-color','none');
                    }
                }
            });   
        }
    });    
</script>