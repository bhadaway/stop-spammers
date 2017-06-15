<?php
if (!defined('ABSPATH')) exit; // just in case
if (!current_user_can('manage_options')) {
die('Access Denied');
}
ss_fix_post_vars();
$stats=ss_get_stats();
extract($stats);
$now=date('Y/m/d H:i:s',time() + ( get_option( 'gmt_offset' ) * 3600 ));
$options=ss_get_options();
extract($options);
$stats=ss_get_stats();
extract($stats);
$trash=SS_PLUGIN_URL.'images/trash.png';
$tdown=SS_PLUGIN_URL.'images/tdown.png';
$tup=SS_PLUGIN_URL.'images/tup.png'; // fix this
$whois=SS_PLUGIN_URL.'images/whois.png'; // fix this
$nonce="";
$ajaxurl=admin_url('admin-ajax.php');
// update options
if (array_key_exists('ss_stop_spammers_control',$_POST)) $nonce=$_POST['ss_stop_spammers_control'];
if (!empty($nonce) && wp_verify_nonce($nonce,'ss_stopspam_update')) { 
if (array_key_exists('ss_stop_clear_wlreq',$_POST)) {
$wlrequests=array();
$stats['wlrequests']=$wlrequests;
ss_set_stats($stats);
}
$msg='<div class="notice notice-success"><p>Requests Cleared</p></div>';
}
$nonce=wp_create_nonce('ss_stopspam_update');
?>
<div id="ss-plugin" class="wrap">
<h1>Stop Spammers — Allow Requests</h1>
<?php if (!empty($msg)) echo "$msg"; ?>
<p>When users are blocked they can fill out a form asking to be added to the allow list. Any users that have filled out the form will appear below. Some spam robots fill in any form that they find so their may be some garbage here.</p>
<?php
if (count($wlrequests)==0) {
echo "<p>No requests.</p>";
}
else {
?>
<h2>Allow List Requests</h2>
<form method="post" action="">
<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>" />
<input type="hidden" name="ss_stop_clear_wlreq" value="true" />
<p class="submit"><input  class="button-primary" value="Clear the Requests" type="submit" /></p>
</form>  
<?php
?>
<table width="100%" style="background-color:#eee" cellspacing="2">
<thead>
<tr style="background-color:ivory;text-align:center"><th>Time</th><th>IP</th><th>Email</th><th>Reason</th><th>URL</th></tr>
</thead>
<tbody id="wlreq">	
<?php
$show='';
$cont='wlreqs';
// wlrequs has an array of arrays
// time,ip,email,author,reason,info,sname
// time,ip,email,author,reason,info,sname
// use the be_load to get badips
$options=ss_get_options();
$stats=ss_get_stats();
$show=be_load('ss_get_alreq','x',$stats,$options);
echo $show;
?>
</tbody>
</table>
<?php
} 
?>