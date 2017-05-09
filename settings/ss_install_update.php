<?php
if (!defined('ABSPATH')) exit; // just in case
// this is a little function that will download a plugin and install or upgrade it
// just give it the slug and it will install from the blogseye website
if (!function_exists('ss_install_update')) { // could co-exist with the stop spammer version
function ss_install_update($plugin_slug,$site='https://www.blogseye.com/') {
// this function allows you to install from anywhere. - dangerous?
// make sure that you've checked for nonces and clean the text coming in to avoid installing bad stuff
if(!current_user_can('manage_options')) {
die('Access Denied');
}
// determine if the plugin is installed or not
$found=ss_get_plugin_prog($plugin_slug);
$ret="";
if ($found!==false) {
$ret=ss_install_upgrade($site,$plugin_slug);
} else {
ss_install_addon($site,$plugin_slug);
}
if (!is_wp_error($ret)) {
?>	
Plugin Upgraded Successfully.<br />
<?php
// now we need to activate the plugin
// stop-spammer-registrations-plugin/stop-spammer-registrations-new.php
$prog=ss_get_plugin_prog($plugin_slug);
$err=activate_plugin( $plugin_slug.'/'.$prog);
if (is_wp_error($err)) {
?>	
<br />
Plugin Activation Failed <?php echo $plugin_slug.'/'.$prog; print_r($err);?><br />
<?php
// print_r($err);
// $installed_plugins = get_plugins();
// print_r($installed_plugins);
return false;
} else {
?>	
<br />
The plugin installation and activation was successful.<br />
<?php
return true;
}
} else {
?>	
<br />
The plugin installation was not successful. The reason will be displayed above.<br />
<?php
return false;
}
}
function ss_get_plugin_prog($plugin_slug) {
$installed_plugins = get_plugins();
$found=false;
$prog="";
foreach($installed_plugins as $s=>$data) {
if (strrpos($s, $plugin_slug.'/', -strlen($s)) !== FALSE) {
$prog=substr($s,strlen($plugin_slug)+1);
$found=true;
break;
}
}
if ($found) return $prog;
return false;
}
function ss_install_addon($site,$plugin_slug) {
include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
class ss_upgrader_skin extends Plugin_Installer_Skin{ 
public function after() {
return;
}
}
$skin=new ss_upgrader_skin( compact('title', 'url', 'nonce', 'plugin', 'api') );
$upgrader = new Plugin_Upgrader( $skin );
$skin->set_upgrader($upgrader);
$ret=$upgrader->install($site.$plugin_slug.".zip");
// return success or failure
return $ret;
}
function ss_install_upgrade($site,$plugin_slug) {
include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
class ss_upgrader_skin extends Plugin_Installer_Skin{ 
public function after() {
return;
}
}
$skin=new ss_upgrader_skin( compact('title', 'url', 'nonce', 'plugin', 'api') );
$upgrader = new Plugin_Upgrader( $skin );
$skin->set_upgrader($upgrader);
$options = array(
'package' => $site.$plugin_slug.".zip", // zip file
'destination' => $plugin_slug, 
'destination_name' => $plugin_slug, 
'clear_destination' => true,  // do true to completely erase old stuff
'abort_if_destination_exists' => false, // abort if the destination directory exists, pass clear_destination as false please
'clear_working' => true,
'is_multi' => false, // means more than one plugin at a time
'hook_extra' => array() // pass any extra $hook_extra args here, this will be passed to any hooked filters
);
$ret=$upgrader->run($options);
// test with: stop-spammer-registrations-plugin
return $ret;
}
}
?>