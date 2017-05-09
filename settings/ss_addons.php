<?php
if (!defined('ABSPATH')) exit; // just in case
if (!current_user_can('manage_options')) {
die('Access Denied');
}
ss_fix_post_vars();
$updateable=array("beta-updater","RedHerring","multicheck","LogReport","TorList","SFSToxicList");
if (array_key_exists("ss_nonce",$_POST)&&wp_verify_nonce($_POST['ss_nonce'],'ss') ) {
if (!function_exists('ss_install_update')) { // adding update function to main plugin?
include("ss_install_update.php");
}
// go through the possible updates
foreach($updateable as $key) {
if (array_key_exists($key,$_POST)) {
ss_install_update($key);
break;
}
}
}
?>
<div id="ss-plugin" class="wrap">
<h1>Stop Spammers — Add-ons</h1>
<p>These add-ons will soon come packaged with Stop Spammers, but disabled by default.</p>
<form method="post" action="#">
<?php wp_nonce_field( 'ss', 'ss_nonce' ) ?>
<table width="80%" align="center" bgcolor="#d0d0d0" cellspacing="2px">
<tr bgcolor="#f0f0f0">
<td>Beta Updater</td>
<td><input type="submit" name="beta-updater" value="Install/Update Beta Updater" class="button-primary" /></td>
<td>Update Stop Spammers from the beta version. The plugin goes through frequent changes. I update the WordPress repository infrequently. The latest stable version is always available for download.<br />
Install the add-on so that you can update Stop Spammers whenever you like.
<p>
This allows your to update Stop Spammers directly from my website. 
</p></td>
</tr>
<tr bgcolor="#f0f0f0">
<td>Red Herring</td>
<td><input type="submit" name="RedHerring" value="Install/Update Red Herring" class="button-primary" /></td>
<td>The Red Herring plugin places a dummy form on your web pages. Spammers see the Red Herring Form and try to leave spam, login or register using the dummy form. Their request is ignored by WordPress and their IP address is added to the bad cache so they will be blocked in the future.<br />
This is an effective way to stop spam.</td>
</tr>
<tr bgcolor="#f0f0f0">
<td>Check system.multicall</td>
<td><input type="submit" name="multicheck" value="Install/Update system.multicall checker" class="button-primary" /></td>
<td>Spammers use the system.multicall option of xmlrpc.php to check thousands of login ids and passwords at a time. This protects against this.</td>
</tr>
<tr bgcolor="#f0f0f0">
<td>Log Reporter</td>
<td><input type="submit" name="LogReport" value="Install/Update Log Reporter" class="button-primary" /></td>
<td>Saves spammers in a CVS file and provides a download link in Excel format. Useful for seeing all log events and not just the last few.</td>
</tr>
<tr bgcolor="#f0f0f0">
<td>Tor Check</td>
<td><input type="submit" name="TorList" value="Install/Update Tor List Checker" class="button-primary" /></td>
<td>Check users IP against a list of Tor exit nodes. Rejects comments and login attempts from users coming from Tor.</td>
</tr>
<tr bgcolor="#f0f0f0">
<td>SFS Toxic List</td>
<td><input type="submit" name="SFSToxicList" value="Install/Update SFS Toxic List" class="button-primary" /></td>
<td>Stop Forum Spam keeps a master list of toxic IP addesses. These can be downloaded once a day and Stop Spammers will use the list to check for spam. This will let you check for spammers before hitting the SFS site.</td>
</tr>
</table>
</form>
<hr />
<?php
// get a list of all the addons using the filter
$addons=array();
$a1=apply_filters('ss_addons_allow',$addons);
$a3=apply_filters('ss_addons_deny',$addons);
$a5=apply_filters('ss_addons_get',$addons);
$addons=array_merge($a1,$a3,$a5);
if (empty($addons)) {
echo "<p>No add-ons installed.</p>";
} else {
?>
<fieldset>
<legend><span style="font-weight:bold;font-size:1.2em">Installed Addons</span></legend>
<ol>
<?php
foreach($addons as $add) {
$ad0=$add[0];
$ad1=$add[1];
$ad2=$add[2];
$ad3=$add[3];
$reason=be_load($add,$ad1);
echo "<li>$ad1: by $ad2, $ad3</li>";
}
?>
</ol>
</fieldset>
<?php
}
?>
</div>