<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller']              = "welcome";
$route['404_override']                    = 'error';



/*********** USER DEFINED ROUTES *******************/

$route['admin']                           = 'admin/login';
$route['loginMe']   			          = 'admin/login/loginMe';
$route['admin/dashboard'] 	  		      = 'admin/dashboard';
$route['admin/loadChangePass']            = "admin/dashboard/loadChangePass";
$route['admin/changePassword']            = "admin/dashboard/changePassword";
$route['admin/forgotPassword']            = "admin/login/forgotPassword";
$route['admin/resetPasswordUser']         = "admin/login/resetPasswordUser";
$route['admin/pageNotFound']              = "admin/dashboard/pageNotFound";
$route['admin/logout']                    = 'admin/dashboard/logout';

$route['admin/companies']                 = 'admin/companies';
$route['admin/projects']                  = 'admin/projects';
$route['admin/enquiry']                   = 'admin/enquiry';
$route['admin/enq_projects/(:num)']       = 'admin/enq_projects/index/$1';
$route['admin/enq_leads/(:num)']          = 'admin/enq_leads/index/$1';


/*$route['admin/national_main_member_category'] = 'admin/national_main_category';
$route['admin/national_exe_member_category']  = 'admin/national_exe_category';
$route['admin/nmm_members/(:num)']            = 'admin/national_main_members/index/$1';
$route['admin/nem_members/(:num)']            = 'admin/national_exe_members/index/$1';
$route['admin/nsm_members/(:num)']            = 'admin/national_state_body_members/index/$1';
$route['admin/pages']                     = 'admin/pages';
$route['admin/gallery']                   = 'admin/gallery';
$route['admin/gallery_titles/(:num)']     = 'admin/gallery_titles/index/$1';
$route['admin/gallery_images/(:num)']     = 'admin/gallery_images/index/$1';
$route['admin/video']                     = 'admin/video';
$route['admin/video_titles/(:num)']       = 'admin/video_titles/index/$1';
$route['admin/video_images/(:num)']       = 'admin/video_images/index/$1';
$route['admin/news']                      = 'admin/news';
$route['admin/events']                    = 'admin/events';*/