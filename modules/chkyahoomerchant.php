<?php
if (!defined('ABSPATH')) exit;
class chkyahoomerchant extends be_module{ 
public function process($ip,&$stats=array(),&$options=array(),&$post=array()) {
$yahoo=array(
'66.218.72.0/24',
'98.139.190.128/25',
'67.195.95.0/23',
'98.139.116.0/22',
'216.252.126.0/24',
'68.180.210.0/23',
'68.180.222.0/25',
'209.191.67.0/25',
'216.252.96.0/19',
'216.39.58.16/28',
'66.94.237.176/28',
'209.131.41.32/27',
'209.191.112.64/27',
'209.191.66.0/24',
'216.136.224.0/22',
'66.163.168.0/22',
'66.163.172.0/22'
);
$this->searchname='Yahoo Merchant Services';
return $this->searchList($ip,$yahoo);
return false;
}
}
?>