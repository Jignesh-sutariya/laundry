<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = 'home/error_404';
$route['translate_uri_dashes'] = FALSE;

$route[ADMIN.'/forgot-password'] = ADMIN.'/login/forgot_password';
$route[ADMIN.'/checkOtp'] = ADMIN.'/login/checkOtp';
$route[ADMIN.'/changePassword'] = ADMIN.'/login/changePassword';
$route[ADMIN.'/address']['post'] = ADMIN.'/address/get';
$route[ADMIN.'/banner']['post'] = ADMIN.'/banner/get';
$route[ADMIN.'/user']['post'] = ADMIN.'/user/get';
$route[ADMIN.'/deliveryBoy']['post'] = ADMIN.'/deliveryBoy/get';
$route[ADMIN.'/category']['post'] = ADMIN.'/category/get';
$route[ADMIN.'/subCategory']['post'] = ADMIN.'/subCategory/get';
$route[ADMIN.'/item']['post'] = ADMIN.'/item/get';
$route[ADMIN.'/order']['post'] = ADMIN.'/order/get';