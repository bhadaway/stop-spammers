<?php
if (!defined('ABSPATH')) exit;
class chkwlist extends be_module { // change name
public function process($ip,&$stats=array(),&$options=array(),&$post=array()) {
// checks the IP from params which has the cache in it
$this->searchname='Allow List IP';
$gcache=$options['wlist'];
return $this->searchList($ip,$gcache);
}
}
?>