<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>
<section class="content-header">
    <h1>Mailbox  <small>Compose & Send</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo site_url(Backend_URL . 'mailbox') ?>">Mailbox</a></li>
        <li class="active">Compose</li>
    </ol>
</section>

<style type="text/css">
    .select2 { width: 100% !important; }
</style>
<section class="content">    
    <div class="box">
        <form name="compose" id="compose" 
              action="<?php echo base_url('admin/mailbox/send_action'); ?>" 
              method="post" enctype="multipart/form-data">
            <div class="box-header with-border">
                <h3 class="box-title">Send New Mail</h3>            
            </div>
            <div class="box-body">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Select Group</span>
                        <div style="border: 1px solid #CCC;padding-top: 5px;padding-left: 25px;">
                            <?php echo htmlRadio('group', $group, [
                                'Recruiter' => 'Recruiter',
                                'Candidate' => 'Candidate',
                            ]);?>
                        </div>
                    </div>
                </div>
                
                <div id="candidate_id" class="form-group <?php echo $hidden_can; ?>">
                    <div class="input-group">
                        <span class="input-group-addon">Select Candidate</span>
                        <select name="candidate_id" class="form-control select2">                                
                            <?php echo getDropDownCandidate($candidate_id); ?>
                        </select>                             
                    </div>
                </div>
                
                <div id="recruiter_id" class="form-group <?php echo $hidden_rec; ?>">
                    <div class="input-group">
                        <span class="input-group-addon">Select Recruiter</span>
                        <select name="recruiter_id" class="form-control select2">                                
                            <?php echo getDropDownRecruiter($recruiter_id); ?>
                        </select>                             
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Subject</span>
                        <input id="Subject" class="form-control" name="subject" 
                               placeholder="Subject:" value="<?php echo $subject; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <textarea id="Message" name="message" class="form-control"><?php echo $message; ?></textarea>                        
                </div>            
            </div>
            <div class="box-footer text-center">
                <a href="<?php echo site_url(Backend_URL . 'mailbox') ?>" class="btn btn-default">
                    <i class="fa fa-long-arrow-left"></i> 
                    Back to Mailbox
                </a> 

                <button type="submit" id="Submit" class="btn btn-success">
                    <i class="fa fa-envelope-o"></i> 
                    Send
                </button>                        
            </div>
        </form>
    </div>
</section>

<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('message', {
        width: ['100%'],
        height: ['350px'],
        customConfig: '<?php echo site_url('assets/lib/plugins/ckeditor/config.js'); ?>'
    });
    
    $('input[name="group"]').on('change', function(){
        var show = $(this).val();
        
        if(show === 'Candidate'){
            $('#candidate_id').removeClass('hidden');
            $('#recruiter_id').addClass('hidden');
        }
        if(show === 'Recruiter'){
            $('#candidate_id').addClass('hidden');
            $('#recruiter_id').removeClass('hidden');
        }
    });
</script>