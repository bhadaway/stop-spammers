<?php
if (!defined('ABSPATH')) exit;
class ss_check_site_get extends be_module{ 
public function process($ip,&$stats=array(),&$options=array(),&$post=array()) {
// not checking this anymore
return false;
}
}
?>