<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Mailbox  <small>Panel</small>    
    <?php 
        echo anchor(
            site_url(Backend_URL . 'mailbox/compose'), 
            ' Send Mail', 
            'class="btn btn-primary"'
        ); 
    ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Mailbox</li>
    </ol>
</section>

<section class="content">       
    <div class="box">            
        <div class="box-header with-border"> 
            <div class="col-md-3"></div>
            
            <div class="col-md-3 col-md-offset-9 text-right">
                <form action="<?php echo site_url(Backend_URL . 'mailbox'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php if ($q <> '') { ?>
                                <a href="<?php echo site_url(Backend_URL . 'mailbox'); ?>" class="btn btn-default">Reset</a>
                            <?php } ?>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="box-body"> 
            
            <?php echo $this->session->flashdata('message'); ?>
            
            <div class="table-responsive">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th width="40"><input type="checkbox" name="all" class="all"></th>
                            <th width="40">S/L</th>
                            <th>Mail Type</th>
                            <th>From => To</th>                            
                            <th>Subject</th>                            
                            <th>Status</th>                            
                            <th>Sent At</th>
                            <th width="80">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i= 0; foreach ($mails as $mail) { ?>
                            <tr>
                                <td><input type="checkbox" value="<?php echo $mail->id; ?>" name="mailbox[1]" class="singleMail"></td>
                                <td><?php echo ++$start ?></td> 
                                <td><?php echo $mail->mail_type ?></td>
                                <td><?php echo $mail->sender_id ?> | <?php echo $mail->mail_from ?>
                                    <br/><?php echo $mail->receiver_id ?> | <?php echo $mail->mail_to ?></td>                                
                                <td><?php echo $mail->subject ?></td>                                
                                <td><?php echo $mail->status ?></td>                                
                                <td><?php echo globalDateTimeFormat($mail->sent_at); ?></td>
                                <td>
                                    <?php
                                    echo anchor(
                                            site_url(Backend_URL . 'mailbox/read/' . $mail->id), '<i class="fa fa-fw fa-external-link"></i>', 'class="btn btn-xs btn-primary"');

                                    echo anchor(
                                            site_url(Backend_URL . 'mailbox/delete/' . $mail->id), '<i class="fa fa-fw fa-trash"></i> ', 'class="btn btn-xs btn-danger"
                                            onclick="return confirm(\'Confirm Delete?\');"');
                                    ?>
                                </td>
                            </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>
            </div>


            <div class="row">                
                <div class="col-md-6">
                    <span class="btn btn-primary">Total Record : <?php echo $total_rows ?></span>
                    <a href="<?php echo base_url('admin/mailbox/multi_delete'); ?>" id="multiDelete" class="btn btn-danger disabled">Multi Delete</a><br>
                    <div id="ajaxRespondID" class="alert alert-success" style="display:none; margin-top: 20px;">Delete Success</div>
                </div>
                <div class="col-md-6 text-right">
                    <?php echo $pagination ?>
                </div>                
            </div>
        </div>
    </div>
</section>


<script>
    $(function () {
        var tblChkBox = $(".singleMail");
        $('input:checkbox[name="all"]').change(function () {
            if ($(this).is(':checked')) {
                $(tblChkBox).prop("checked", true);
                $('#multiDelete').removeClass('disabled');
            }
            if (!$(this).is(':checked')) {
                $(tblChkBox).prop("checked", false);
                $('#multiDelete').addClass('disabled');
            }
        });
        
        $('.singleMail').change(function () {
            var len = $(".singleMail:checked").length;
            if(len>0){$('#multiDelete').removeClass('disabled');}else{$('#multiDelete').addClass('disabled');}
        });
        
        $('#multiDelete').click(function(e){
            e.preventDefault();
            var len = $(".singleMail:checked").length;
            var yourArray = [];
            if(len > 0){
                $(".singleMail:checked").each(function(){
                    yourArray.push($(this).val());
                });
                $.ajax({
                        type: 'POST',
                        url: $(this).attr('href'),
                        data: {mailbox:yourArray},
                        dataType: "html",
                        success: function(resultData) { 
                        $('#ajaxRespondID').show();
                        setTimeout(function(){location.reload();}, 2000);
                        }
                  });
            }else{
                alert('Plese select mail to delete!');
            }
          
        });
        
    });
</script>