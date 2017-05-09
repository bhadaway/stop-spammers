<?php
if (!defined('ABSPATH')) exit;
class chkbcache extends be_module { // change name
public function process($ip,&$stats=array(),&$options=array(),&$post=array()) {
// checks the IP from params which has the cache in it
$this->searchname='Bad Cache';
$gcache=$stats['badips'];
return $this->searchcache($ip,$gcache);
}
}
?>