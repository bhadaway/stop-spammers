<?php
// this is the new settings pages for Stop Spammers
// this is loaded only when users who can change settings are logged in
if (!defined('ABSPATH')) exit;
function ss_admin_menu_l() {
$icon2='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAAAAACo4kLRAAAA5UlEQVQY02P4DwS/251dwMC5/TeIzwASa4rcDAWRTb8hgkhiUFEGVDGIKAOaGFiUoR1NDCjazuC8uTusc2l6evrkNclJq9elZzRtdmZwWSPkxtNvxmlU76SqabWSw4Sz14XBZbb8qoIFm2WXreZfs15wttRmv2yg4CYVzpDNQMHpWps36zcLZEjXAwU3r8oRbgMKTlHZvFm7lcMoeBNQsNlks2sZUHAV97wlPAukgNYDBdeIKnAvBApuDucTCFgJEXTevKh89ubNEzZs3tzWvHlDP1DQGbvjsXoTa4BgDzrsgYwZHQBqzOv51ZaiYwAAAABJRU5ErkJggg==';
$iconpng=SS_PLUGIN_URL.'images/sticon.png';
add_menu_page( 
"Stop Spammers", // $page_title,
"Stop Spammers", // $menu_title,
'manage_options', // $capability,
'stop_spammers', // $menu_slug,
'ss_summary', // $function
$iconpng, // $icon_url,
78.92   // $position 
);
if (class_exists('Jetpack') && Jetpack::is_module_active('protect')) {
return;
}
add_submenu_page(
'stop_spammers', // plugins parent
"Summary — Stop Spammers", // $page_title,
"Summary", // $menu_title,
'manage_options', // $capability,
'stop_spammers', // $menu_slug,
'ss_summary' // $function
);
add_submenu_page(
'stop_spammers', // plugins parent
"Protection Options — Stop Spammers", // $page_title,
'Protection Options', // $menu_title,
'manage_options', // $capability,
'ss_options', // $menu_slug,
'ss_options' // function
);
add_submenu_page(
'stop_spammers', // plugins parent
"Allow Lists — Stop Spammers", // $page_title,
'Allow Lists', // $menu_title,
'manage_options', // $capability,
'ss_allow_list', // $menu_slug,
'ss_allowlist_settings' // function
);
add_submenu_page(
'stop_spammers', // plugins parent
"Block Lists — Stop Spammers", // $page_title,
'Block Lists', // $menu_title,
'manage_options', // $capability,
'ss_deny_list', // $menu_slug,
'ss_denylist_settings' // function
);
add_submenu_page(
'stop_spammers', // plugins parent
"Challenge and Deny — Stop Spammers", // $page_title,
'Challenge &amp; Deny', // $menu_title,
'manage_options', // $capability,
'ss_challenge', // $menu_slug,
'ss_challenges' // function
);
add_submenu_page(
'stop_spammers', // plugins parent
"Allow Requests — Stop Spammers", // $page_title,
"Allow Requests", // $menu_title,
'manage_options', // $capability,
'ss_allowrequests', // $menu_slug,
'ss_allowreq' // $function
);
add_submenu_page(
'stop_spammers', // plugins parent
"Web Services — Stop Spammers", // $page_title,
'Web Services', // $menu_title,
'manage_options', // $capability,
'ss_webservices_settings', // $menu_slug,
'ss_webservices_settings'
);
add_submenu_page(
'stop_spammers', // plugins parent
"Cache — Stop Spammers", // $page_title,
'Cache', // $menu_title,
'manage_options', // $capability,
'ss_cache', // $menu_slug,
'ss_cache' // function
);
add_submenu_page(
'stop_spammers', // plugins parent
"Log Report — Stop Spammers", // $page_title,
'Log Report', // $menu_title,
'manage_options', // $capability,
'ss_reports', // $menu_slug,
'ss_reports' // function
);
add_submenu_page(
'stop_spammers', // plugins parent
"Diagnostics — Stop Spammers", // $page_title,
'Diagnostics', // $menu_title,
'manage_options', // $capability,
'ss_diagnostics', // $menu_slug,
'ss_diagnostics' // function
);
add_submenu_page(
'stop_spammers', // plugins parent
"Beta: DB Cleanup — Stop Spammers", // $page_title,
'Beta: DB Cleanup', // $menu_title,
'manage_options', // $capability,
'ss_option_maint', // $menu_slug,
'ss_option_maint' // function
);
add_submenu_page(
'stop_spammers', // plugins parent
"Beta: Threat Scan — Stop Spammers", // $page_title,
'Beta: Threat Scan', // $menu_title,
'manage_options', // $capability,
'ss_threat_scan', // $menu_slug,
'ss_threat_scan' // function
);
if (function_exists('is_multisite') && is_multisite()) {
add_submenu_page(
'stop_spammers', // plugins parent
"Multisite — Stop Spammers", // $page_title,
'Network', // $menu_title,
'manage_options', // $capability,
'ss_network', // $menu_slug,
'ss_network'
);
}
}
function ss_summary() {
include_setting("ss_summary.php");
}
function ss_network() {
include_setting("ss_network.php");
}
function ss_webservices_settings() {
include_setting("ss_webservices_settings.php");
}
function ss_allowlist_settings() {
include_setting("ss_allowlist_settings.php");
}
function ss_denylist_settings() {
include_setting("ss_denylist_settings.php");
}
function ss_options() {
include_setting("ss_options.php");
}
function ss_access() {
include_setting("ss_access.php");
}
function ss_reports() {
include_setting("ss_reports.php");
}
function ss_cache() {
include_setting("ss_cache.php");
}
function ss_threat_scan() {
include_setting("ss_threat_scan.php");
}
function ss_option_maint() {
include_setting("ss_option_maint.php");
}
function ss_change_admin() {
include_setting("ss_change_admin.php");
}
function ss_challenges() {
include_setting("ss_challenge.php");
}
function ss_contribute() {
include_setting("ss_contribute.php");
}
function ss_diagnostics() {
include_setting("ss_diagnostics.php");
}
function ss_allowreq() {
include_setting("ss_allowreq.php");
}
function include_setting($file) {
sfs_errorsonoff();
$ppath=plugin_dir_path( __FILE__ );
if (file_exists($ppath.$file)) {
require_once($ppath.$file);
} else {
echo "<br />Missing file:$ppath $file <br />";
}
sfs_errorsonoff('off');	
}
function ss_fix_post_vars() {
// sanitize post
$p=$_POST;
$keys=array_keys($_POST);
foreach ($keys as $var) {
try {
$val=$_POST[$var];
if (is_string($val)) {
if (strpos($val,"\n")!==false) {
$val2 = esc_textarea($val);
} else {
$val2 = sanitize_text_field($val);
}
$_POST[$var]=$val2;
}
} catch (Exception $e) {}
}
}
?>