<?php
if (!defined('ABSPATH')) exit;
class chkblip  extends be_module { // change name
public function process($ip,&$stats=array(),&$options=array(),&$post=array()) {
// checks the IP from params which has the cache in it
$this->searchname='Deny List IP';
$gcache=$options['blist'];
return $this->searchList($ip,$gcache);
}
}
?>