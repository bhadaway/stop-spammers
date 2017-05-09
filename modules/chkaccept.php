<?php
if (!defined('ABSPATH')) exit;
class chkaccept {
public function process($ip,&$stats=array(),&$options=array(),&$post=array()) {
if (array_key_exists('HTTP_ACCEPT',$_SERVER)) return false; // real browsers send HTTP_ACCEPT
return 'No Accept Header;';
}
}
?>