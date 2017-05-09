<?php
if (!defined('ABSPATH')) exit;
class chkshort { // change name
public function process($ip,&$stats=array(),&$options=array(),&$post=array()) {
$this->searchname='Email/Author too short';
if (array_key_exists('email',$post)) {
$email=$post['email'];
if (!empty($email)) {
if (strlen($email)<5) {
return "Email too short:$email";
}
}
}
if (array_key_exists('author',$post)) {
if (!empty($post['author'])) {
$author=$post['author'];
// short author is OK?
if (strlen($post['author'])<3) {
return "Author too short:$author";
}
}
}
return false;
}
}
?>