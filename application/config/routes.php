<?php defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller']    = 'frontend';
$route['admin']                 = 'dashboard';
$route['admin/login']           = 'auth/login_form';
$route['admin/logout']          = 'auth/logout';
$route['404_override']          = 'frontend';
$route['404']                   = 'frontend/not_found_page';
$route['cron_keywords']         = 'cron_keywords';
$route['revision/(:num)/(:num)'] = 'frontend/revision/$2/$1';
 

$route['admin/auth/facebook/callback']  = 'auth/facebook_callback';
$route['admin/auth/google/callback']  	= 'auth/google_callback';

//$route['logout']                        = 'auth_student/logout';
//$route['auth_candidate/forgot_pass']    = 'my_account/forgot_pass';
//$route['login']                         = 'my_account/login_form';

$route['login']                 	= 'auth_candidate/login_form/login';
$route['create-candidate-profile']  = 'auth_candidate/login_form/create-candidate-profile';
$route['auth_candidate/forgot_pass']    = 'auth_candidate/forgot_pass';
$route['reset_password']                = 'auth_candidate/reset_password';
//Facebook Callback URL
$route['auth/facebook/callback']  	= 'auth_candidate/facebook_callback';
$route['auth/google/callback']  	= 'auth_candidate/google_callback';
$route['logout']                	= 'auth_candidate/logout';

$route['myaccount']                 = 'my_account/alert';
$route['myaccount/profile']         = 'my_account/profile';
$route['post-your-cv']              = 'auth_candidate/login_form/post-your-cv';
$route['myaccount/cv']              = 'my_account/cv';
$route['myaccount/changepassword']  = 'my_account/change_password';
$route['myaccount/job-apply/(:num)/(:any)'] = 'my_account/job_apply/$1';
$route['myaccount/applied_job']      = 'my_account/applied_job';
$route['myaccount/resume']           = 'my_account/resume';
$route['myaccount/alert']            = 'my_account/alert';
$route['myaccount/alert_action']     = 'my_account/alert_action';

$route['myaccount/shortlisted']     = 'my_account/shortlisted_jobs';
$route['myaccount/apply']           = 'my_account/shortlisted_apply';
$route['myaccount/shortlist_job']   = 'my_account/shortlist_job_insert';
$route['myaccount/shortlisted_job_delete/(:num)'] = 'my_account/shortlisted_job_delete/$1';
$route['job_share_by_email']        = 'frontend/shareByEmail';
$route['translate_uri_dashes']      = TRUE;

$route['jobs/']  = 'frontend/jobSearch';
$route['jobs']                      = 'frontend/jobSearch';
$route['jobs/(:any)']               = 'frontend/jobSearch/$1';
$route['job-details/(:num)/(:any)'] = 'frontend/jobDetails/$1';

$route['Subscribe']  = 'frontend/alert_subscribe';

$route['events']                = 'frontend/events';
$route['event/(:num)/(:any)']   = 'frontend/event_details/$1';

$route['companies']                     = 'frontend/companySearch';
$route['company-details/(:num)/(:any)'] = 'frontend/companyDetails/$1';

$route['advertisers']               = 'frontend/advertisers';
$route['company/profile/(:any)']    = 'frontend/advertiser_details/$1';

$route['recruiter']                  = 'auth_candidate/employer/employer';
$route['create-recruiter-profile']  = 'auth_candidate/employer/create-recruiter-profile';
$route['post-ngo-jobs']             = 'auth_candidate/employer/post-ngo-jobs';
$route['employer/singup/action']    = 'auth_candidate/employer_singup_action';

$route['browse-job']                = 'frontend/browse_job';
$route['ngo-career-advice']                      = 'frontend/blog';
$route['ngo-career-advice/(:any)']               = 'frontend/blog/$1';
$route['ngo-career-advice/(:any)/(:any)']        = 'frontend/blog_post';

define('ModuleRoutePrefix', APPPATH . '/modules/');
define('ModuleRouteSuffix', '/config/routes.php');

require_once(ModuleRoutePrefix . 'cms' . ModuleRouteSuffix);
require_once(ModuleRoutePrefix . 'slider' . ModuleRouteSuffix);
require_once(ModuleRoutePrefix . 'settings' . ModuleRouteSuffix);
require_once(ModuleRoutePrefix . 'users' . ModuleRouteSuffix);
require_once(ModuleRoutePrefix . 'profile' . ModuleRouteSuffix);
require_once(ModuleRoutePrefix . 'module' . ModuleRouteSuffix);
require_once(ModuleRoutePrefix . 'db_sync' . ModuleRouteSuffix);
require_once(ModuleRoutePrefix . 'email_templates' . ModuleRouteSuffix);
require_once(ModuleRoutePrefix . 'mailbox' . ModuleRouteSuffix);

require_once(ModuleRoutePrefix . 'job' . ModuleRouteSuffix);
require_once(ModuleRoutePrefix . 'job_alert' . ModuleRouteSuffix);
require_once(ModuleRoutePrefix . 'candidate' . ModuleRouteSuffix);
require_once(ModuleRoutePrefix . 'newsletter_subscriber' . ModuleRouteSuffix);
require_once(ModuleRoutePrefix . 'payment' . ModuleRouteSuffix);
require_once(ModuleRoutePrefix . 'event' . ModuleRouteSuffix);
require_once(ModuleRoutePrefix . 'package' . ModuleRouteSuffix);