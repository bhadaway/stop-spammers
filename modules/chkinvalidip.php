<?php
// checks for invalid IPs
if (!defined('ABSPATH')) exit;
class chkinvalidip {
public function process($ip,&$stats=array(),&$options=array(),&$post=array()) {
if (strpos($ip,'.')===false&&strpos($ip,':')===false) return 'Invalid IP: '.$ip;
if (defined('AF_INET6')&&strpos($ip,':')!==false) {
try {
if (!@inet_pton($ip)) return 'Invalid IP: '.$ip;
} catch ( Exception $e) {
return 'Invalid IP: '.$ip;
}
}
$ips=be_module::ip2numstr($ip);
if($ips>='224000000000'&&$ips<='239255255255') return 'IPv4 Multicast Address Space Registry';
// reserved for future use >=240.0.0.0
if($ips>='240000000000'&&$ips<='255255255255') return 'Reserved for future use';
return false;
}
}
?>