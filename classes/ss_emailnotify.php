<?php
if (!defined('ABSPATH')) exit;
class ss_emailnotify {
public function process($func_via_ip,&$emails_via_stats=array(),&$options=array(),&$post=array()) {
if (!is_array($emails_via_stats)) return false;
$email=$emails_via_stats[0];
switch ($func_via_ip) {
case 'add_white':
if (!is_email($email)) return false;
if (empty($email)) return false;
$subject='Allow List Request Accepted at '.get_bloginfo('name');
$message="
Hello,

Your Allow Request was accepted by site admin.

Best, ".get_bloginfo('name');
$message=wordwrap($message, 70, "\r\n");
$headers = 'From: '.get_option('admin_email'). "\r\n";
wp_mail( $email, $subject, $message,$headers );
return true;
break;
}
return false;
}
}