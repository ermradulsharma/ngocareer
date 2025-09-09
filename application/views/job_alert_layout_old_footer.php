<!DOCTYPE html>
<html>
<head>
    <title>NOG Career</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {font-family: "Arial", sans-serif;padding: 0;margin: 0;}
        a {text-decoration: none;}
        p { font-size: 18px;margin-top: 0;margin-bottom: 5px;}
        .footer p {font-size: 15px;margin-top: 20px;}
    </style>
</head>
<body>
<div style="padding-top: 50px;">
    <div style="max-width: 700px; margin: 0 auto;">
        <div style="text-align: center;border-bottom: 3px solid #F74E05">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <a href="<?php echo site_url(); ?>" style="text-align: center;">
                            <img src="<?php echo site_url('assets/theme/images/logo.png'); ?>" alt="NGO Career" style="width: 150px;margin: 0 auto;">
                        </a>
                    </td>
<!--                    <td style="text-align: right;"><a style="font-size: 18px;color: #1F8C49;text-decoration: none;" href="mailto:--><?php //echo getSettingItem('IncomingEmail'); ?><!--">--><?php //echo getSettingItem('IncomingEmail'); ?><!--</a></td>-->
                </tr>
            </table>
        </div>

        <h1 style="font-size: 18pt;color: #F74E05;text-align: center;margin: 50px 0;padding-bottom: 15px;">Your matching jobs on NGO Career - NGO Job Search</h1>

        <?php
        if ($jobs) {
            foreach ($jobs as $job) {
                $job_url = site_url("job-details/{$job->id}/" . slugify($job->title) . '.html');
                ?>
                    <table width="100%" cellspacing="0" cellpadding="0" style="border: 3px solid #4DA56E;">
                        <tr>
                            <td colspan="2">
                                <h2 style="font-size: 15pt;background-color: #4DA56E;padding: 10px;margin: 0;"><a style="color: #FFFFFF;text-decoration: none;" href="<?php echo $job_url; ?>" target="_blank"><?php echo getShortContent($job->title, 100); ?></a></h2>
                            </td>
                        </tr>
                        <tr>
                            <td width="150">
                                <img src="<?php echo base_url(); ?><?php echo getPhoto($job->logo); ?>" width="120" alt="">
                            </td>
                            <td>
                                <p><strong>Company:</strong> <?php echo $job->company; ?></p>
                                <p><strong>Location:</strong> <?php echo isSpecify($job->location); ?></p>
                                <p><strong>Deadline:</strong> <?php echo globalDateFormat($job->deadline); ?></p>
                                <p><a href="<?php echo $job_url; ?>" style="background: #F74E05; padding: 5px 10px; line-height: 40px; color: #FFFFFF;text-decoration: none;" target="_blank">Apply Now</a></p>
                            </td>
                        </tr>
                    </table>

                <?php
            }//foreach
        }//if
        ?>
        <p style="text-align: center"><a href="<?php echo site_url('job-search'); ?>" style="background: #1F8C49; padding: 10px 15px; line-height: 40px; color: #FFFFFF; font-weight: 700; text-transform: uppercase;text-decoration: none;">View more jobs</a></p>

        <table class="footer" width="100%" cellspacing="0" cellpadding="0" style="background-color: #222E39;color: #FFFFFF;text-align: center;padding: 30px; font-size: 15px;font-size: 15px;">
            <tr>
                <td>
                    <p>Web: <a style="color: #FFFFFF;text-decoration: none;" target="_blank" href="//www.ngocareer.com">www.ngocareer.com</a> &nbsp;&nbsp;&nbsp; Email: <a style="color: #FFFFFF;text-decoration: none;" href="mailto:info@ngocareer.com">info@ngocareer.com</a></p>
                    <p>NGO Career by Qualified Place Limited.<br>(The Market Square, London, N9 0TZ.)</p>
                    <p>Copyright © NGO Career. All Rights Reserved.<br>
                        To unsubscribe <a style="color: #FFFFFF; font-size: 15px; text-decoration: none;" href="<?php echo $unsubscribe_url; ?>" target="_blank">click here</a></p>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
