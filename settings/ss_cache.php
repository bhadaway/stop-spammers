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
$trash=SS_PLUGIN_URL.'images/trash.png';
$tdown=SS_PLUGIN_URL.'images/tdown.png';
$tup=SS_PLUGIN_URL.'images/tup.png'; // fix this
$whois=SS_PLUGIN_URL.'images/whois.png'; // fix this
$nonce="";
$ajaxurl=admin_url('admin-ajax.php');
// update options
if (array_key_exists('ss_stop_spammers_control',$_POST)) $nonce=$_POST['ss_stop_spammers_control'];
if (!empty($nonce) && wp_verify_nonce($nonce,'ss_stopspam_update')) { 
if (array_key_exists('update_options',$_POST)) {
if (array_key_exists('ss_sp_cache',$_POST)) {
$ss_sp_cache=stripslashes($_POST['ss_sp_cache']);
$options['ss_sp_cache']=$ss_sp_cache;
}
if (array_key_exists('ss_sp_good',$_POST)) {
$ss_sp_good=stripslashes($_POST['ss_sp_good']);
$options['ss_sp_good']=$ss_sp_good;
}
ss_set_options($options);
}
}
// clear the cache
if (array_key_exists('ss_stop_spammers_control',$_POST)) $nonce=$_POST['ss_stop_spammers_control'];
if (wp_verify_nonce($nonce,'ss_stopspam_update')) { 
if (array_key_exists('ss_stop_clear_cache',$_POST)) {
// clear the cache
$badips=array();
$goodips=array();
$stats['badips']=$badips;
$stats['goodips']=$goodips;
ss_set_stats($stats);
echo "<div class='notice notice-success'><p>Cache Cleared</p></div>";
}
$msg='<div class="notice notice-success"><p>Options Updated</p></div>';
}
$nonce=wp_create_nonce('ss_stopspam_update');
?>
<div id="ss-plugin" class="wrap">
<h1>Stop Spammers — Cache</h1>
<?php if (!empty($msg)) echo "$msg"; ?>
<p>Whenever a user tries to leave a comment, register, or login, they are recorded in the Good Cache if they pass or the Bad Cache if they fail. If a user is blocked from access, they are added to the Bad Cache. You can see the caches here. The caches clear themselves over time, but if you are getting lots of spam it is a good idea to clear these out manually by pressing the "Clear Cache" button.</p>
<form method="post" action="">
<input type="hidden" name="update_options" value="update" />
<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>" />
<fieldset>
<legend><span style="font-weight:bold;font-size:1.2em">Bad Cache Size</span></legend>
<p>You can change the number of entries to keep in your history and cache. The size of these items is an issue and will cause problems with some WordPress installations. It is best to keep these small.</p>
Bad IP Cache Size: <select name="ss_sp_cache">
<option value="0" <?php if ($ss_sp_cache=='0') echo "selected=\"true\""; ?>>0</option>
<option value="10" <?php if ($ss_sp_cache=='10') echo "selected=\"true\""; ?>>10</option>
<option value="25" <?php if ($ss_sp_cache=='25') echo "selected=\"true\""; ?>>25</option>
<option value="50" <?php if ($ss_sp_cache=='50') echo "selected=\"true\""; ?>>50</option>
<option value="75" <?php if ($ss_sp_cache=='75') echo "selected=\"true\""; ?>>75</option>
<option value="100" <?php if ($ss_sp_cache=='100') echo "selected=\"true\""; ?>>100</option>
<option value="200" <?php if ($ss_sp_cache=='200') echo "selected=\"true\""; ?>>200</option>
</select>
<p>Select the number of items to save in the bad IP cache. Avoid making this too big as it can cause the plugin to run out of memory.</p>
</fieldset>
<br />
<fieldset>
<legend><span style="font-weight:bold;font-size:1.2em">Good Cache Size</span></legend>
<p>The good cache should be set to just a few entries. The first time a spammer hits your site he may not be well-known and once he gets in the Good Cache he can hit your site without being checked again. Increasing the size of the cache means a spammer has more opportunities to hit your site without a new check.</p>
Good Cache Size: 
<select name="ss_sp_good">
<option value="1" <?php if ($ss_sp_good=='1') echo "selected=\"true\""; ?>>1</option>
<option value="2" <?php if ($ss_sp_good=='2') echo "selected=\"true\""; ?>>2</option>
<option value="3" <?php if ($ss_sp_good=='3') echo "selected=\"true\""; ?>>3</option>
<option value="4" <?php if ($ss_sp_good=='4') echo "selected=\"true\""; ?>>4</option>
<option value="10" <?php if ($ss_sp_good=='10') echo "selected=\"true\""; ?>>10</option>
<option value="25" <?php if ($ss_sp_good=='25') echo "selected=\"true\""; ?>>25</option>
<option value="50" <?php if ($ss_sp_good=='50') echo "selected=\"true\""; ?>>50</option>
<option value="75" <?php if ($ss_sp_good=='75') echo "selected=\"true\""; ?>>75</option>
<option value="100" <?php if ($ss_sp_good=='100') echo "selected=\"true\""; ?>>100</option>
<option value="200" <?php if ($ss_sp_good=='200') echo "selected=\"true\""; ?>>200</option>
</select>
</fieldset>
<br />
<p class="submit"><input class="button-primary" value="Save Changes" type="submit" /></p>
</form>
<?php
if (count($badips)==0&&count($goodips)==0) echo "Nothing in the cache.";
else {
?>
<h2>Cached Values</h2>
<form method="post" action="">
<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce;?>" />
<input type="hidden" name="ss_stop_clear_cache" value="true" />
<p class="submit"><input class="button-primary" value="Clear the Cache" type="submit" /></p>
</form>  
<table>
<tr>
<?php
if (count($badips)>0) {
arsort($badips);
?>
<td width="30%">Rejected IPs</td>
<?php
}
?>
<?php
if (count($goodips)>0) {
?>
<td width="30%">Good IPs</td>
<?php
}
?>
</tr>
<tr>
<?php
if (count($badips)>0) {
?>
<td valign="top" id="badips"><?php
// use the be_load to get badips
$options=ss_get_options();
$stats=ss_get_stats();
$show=be_load('ss_get_bcache','x',$stats,$options);
/*
$show='';
$cont='badips';
foreach ($badips as $key => $value) {
$show.="<a href=\"https://www.stopforumspam.com/search?q=$key\" target=\"_stopspam\">$key: $value</a> ";
// try ajax on the delete from bad cache
$onclick="onclick=\"sfs_ajax_process('$key','$cont','delete_bcache','$ajaxurl');return false;\"";
$show.=" <a href=\"\" $onclick title=\"Delete $key from Cache\" alt=\"Delete $key from Cache\" ><img src=\"$trash\" height=\"16px\" /></a> ";			
$onclick="onclick=\"sfs_ajax_process('$key','$cont','add_black','$ajaxurl');return false;\"";
$show.=" <a href=\"\" $onclick title=\"Add to $key Deny List\" alt=\"Add to Deny List\" ><img src=\"$tdown\" height=\"16px\" /></a> ";
$onclick="onclick=\"sfs_ajax_process('$key','$cont','add_white','$ajaxurl');return false;\"";
$show.=" <a href=\"\" $onclick title=\"Add to $key Allow List\" alt=\"Add to Allow List\" ><img src=\"$tup\" height=\"16px\" /></a> ";
$who="<a title=\"Look Up WHOIS\" target=\"_stopspam\" href=\"http://lacnic.net/cgi-bin/lacnic/whois?lg=EN&query=$key\"><img src=\"$whois\" height=\"16px\" /></a> ";
$show.=$who;
$show.="<br />";
}
*/
echo $show;
?></td>
<?php
}
?>
<?php
if (count($goodips)>0) {
arsort($goodips);
?>
<td valign="top" id="goodips"><?php
// use the be_load to get badips
$options=ss_get_options();
$stats=ss_get_stats();
$show=be_load('ss_get_gcache','x',$stats,$options);
/*$show='';
$cont='goodips';
foreach ($goodips as $key => $value) {
$show.="<a href=\"https://www.stopforumspam.com/search?q=$key\" target=\"_stopspam\">$key: $value</a> ";
// try ajax on the delete from bad cache
$onclick="onclick=\"sfs_ajax_process('$key','$cont','delete_gcache','$ajaxurl');return false;\"";
$show.=" <a href=\"\" $onclick title=\"Delete $key from Cache\" alt=\"Delete $key from Cache\" ><img src=\"$trash\" height=\"16px\" /></a> ";			
$onclick="onclick=\"sfs_ajax_process('$key','$cont','add_black','$ajaxurl');return false;\"";
$show.=" <a href=\"\" $onclick title=\"Add to $key Deny List\" alt=\"Add to Deny List\" ><img src=\"$tdown\" height=\"16px\" /></a> ";
$onclick="onclick=\"sfs_ajax_process('$key','$cont','add_white','$ajaxurl');return false;\"";
$show.=" <a href=\"\" $onclick title=\"Add to $key Allow List\" alt=\"Add to Allow List\" ><img src=\"$tup\" height=\"16px\" /></a> ";
$show.="<br />";
}
*/
echo $show;
?></td>
<?php
}
?>
</tr>
</table>
<?php
} 
?>