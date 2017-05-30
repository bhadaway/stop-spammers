<?php
if (!defined('ABSPATH')) exit;
function ss_notify_admin_action($user_login, $user) {
// notify admin when someone logs in
if(!current_user_can('manage_options')){
return;
}
sfs_errorsonoff();
$website =  get_bloginfo("wpurl");
$logintime = date('l jS F Y');
$ip=$_SERVER['REMOTE_ADDR'];
$subject = sprintf('An administrator of your website %s has just logged in', $website);
$message = "Stop Spammers Message - An admin logged into your WordPress website $website on $logintime from IP: $ip ";
wp_mail(
get_option("admin_email")
, $subject
, $message
);
sfs_errorsonoff('off');
}
?>