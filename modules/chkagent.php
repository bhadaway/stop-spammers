<?php
if (!defined('ABSPATH')) exit;
class chkagent extends be_module {
public function process($ip,&$stats=array(),&$options=array(),&$post=array()) {
if (!array_key_exists('badagents',$options)) return false;
$badagents=$options['badagents'];
if (empty($badagents)||!is_array($badagents)) return false;
$agent="";
if (array_key_exists('HTTP_USER_AGENT',$_SERVER)) $agent=$_SERVER['HTTP_USER_AGENT'];
if (empty($agent)) {
return 'Missing User Agent';
}		
// user agent can be spoofed - move these exclusions to a better test when finished
if (stripos($agent,'docs.google.com/viewer')!==false) return false; // fix this?
if (stripos($agent,'//www.google.com/bot.html)')!==false) return false; // fix this?
if (stripos($agent,'bingbot)')!==false) return false; // fix this?
foreach ($badagents as $a) {
if (stripos($agent,$a)!==false) {
return 'Deny List User Agent: '.$a;
}
}
return false;
}
}
?>