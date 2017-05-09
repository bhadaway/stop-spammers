<?php
// this checks 404 entries for attacks
// loaded at theme if (!defined('ABSPATH')) exit;
if (!defined('ABSPATH')) exit;
class ss_check_404s { 
public function process($ip,&$stats=array(),&$options=array(),&$post=array()) {
// load the chk404 module
if ($options['chk404']!=='Y') return false;
$reason=be_load('chk404',$ip);
if ($reason===false) return;
// update log
ss_log_bad($ip,$reason,'chk404');
// need to deny access
$rejectmessage=$options['rejectmessage'];
wp_die("$rejectmessage","Login Access Denied",array('response' => 403));
exit();
}
}
?>