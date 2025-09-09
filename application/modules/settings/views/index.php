<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Global Site Setting  <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Settings</li>
    </ol>
</section>

<section class="content">                   
    <div class="box">
        <div class="box-body">
            <p class="text-red">
                <b>Note:</b> <u>Outgoing Email</u> address must be this domain email address. 
                E.g. if your domain name is "www.example.com" email should "xxx@example.com".
            </p>
            <div id="ajaxRespond"></div>
                 
            <form method="post" id="settings" action="<?php echo Backend_URL; ?>settings/update" name="settings">
                <table class="table  table-bordered table-striped" style="margin-bottom: 10px">
                    <?php foreach ($settings as $setting){ ?>
                        <tr>
                            <td width="220"><?php echo Setting_helper::splitSettings($setting->label); ?></td>
                            <td><?php echo Setting_helper::switchFormFiled($setting->field_type, $setting->label, $setting->value); ?></td>
                        </tr>
                    <?php } ?>
                        <tr>
                            <td></td>
                            <td><button class="btn btn-primary" id="submit" type="button" name="save"><i class="fa fa-save"></i> Update Setting </button></td>
                        </tr>
                </table> 
                
            </form>                  
        </div>
    </div>              
</section>

<script type="text/javascript">
    $('#submit').on('click', function(e){
        e.preventDefault();
        var settings = $('#settings').serialize();                    
        $.ajax({
            url: 'admin/settings/update',
            type: 'POST',
            dataType: "json",
            data: settings,
            beforeSend: function(){
                $('#ajaxRespond')
                        .html('<p class="ajax_processing">Loading...</p>')
                        .css('display','block');
            },
            success: function ( respond ) {
                $('#ajaxRespond').html(respond.Msg);
                if( respond.Status === 'OK'){
                    setTimeout(function() { $('#ajaxRespond').slideUp(); }, 2000);
                }
            }
        });
    });
</script>      