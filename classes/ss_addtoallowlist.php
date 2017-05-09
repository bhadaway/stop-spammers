<?php
if (!defined('ABSPATH')) exit;
class ss_addtoallowlist { 
public function process($ip,&$stats=array(),&$options=array(),&$post=array()) {
// adds to Allow List - used to add admin to Allow List or to add a comment author to Allow List
$now=date('Y/m/d H:i:s',time() + ( get_option( 'gmt_offset' ) * 3600 ));
$wlist=$options['wlist'];
// $ip=ss_get_ip();
// add this IP to your Allow List
if (!in_array($ip,$wlist)) $wlist[]=$ip;
$options['wlist']=$wlist;
ss_set_options($options);
// need to remove from caches
$badips=$stats['badips'];
if (array_key_exists($ip,$badips)) {
unset($badips[$ip]);
$stats['badips']=$badips;
}
$goodips=$stats['goodips'];
if (array_key_exists($ip,$goodips)) {
unset($goodips[$ip]);
$stats['goodips']=$goodips;
}
ss_set_stats($stats);
return false;
}
}
?>