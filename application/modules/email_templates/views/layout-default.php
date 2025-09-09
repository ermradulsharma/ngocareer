<div style="background-color: #F9F9F9; padding: 50px 0;">
    <div style="width: 90%; border: 1px solid #EEE; background: #fff; margin: 0 auto;">
        <div style="background-color:#f3f3f3; height:105px; padding:15px; border-bottom: 10px solid #1f8c49;">
            <div style="float:left">
                <img src="<?php echo site_url('assets/theme/images/logo.png');?>" />              
            </div>

            <div style="float:right; text-align:right; color:#FFF;  font-size:12pt;">
                Phone: <?php echo getSettingItem('PhoneNumber'); ?><br />
                Email: <?php echo getSettingItem('OutgoingEmail'); ?>
            </div>
        </div>

        <div class="mail_body" style="min-height: 120px; padding:20px; font-size:11pt; font-family:Arial, Helvetica, sans-serif;">
            %MailBody%
        </div>

        <div style="background-color:#CCC;">
            <p style="color:#222; text-align:center; padding:10px 0; margin: 0">
                Copyright &copy; <?php echo date('Y');?> <?php echo getSettingItem('SiteTitle'); ?>. All rights reserved.
            </p>
        </div>
    </div>
</div>
