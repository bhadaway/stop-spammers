<?php
if (!defined('ABSPATH')) exit; // just in case
if (!current_user_can('manage_options')) {
die ('Access Denied');
$msg='<div class="notice notice-success"><p>Options Updated</p></div>';
}
ss_fix_post_vars();
?>
<div id="ss-plugin" class="wrap">
<h1>Stop Spammers — DB Cleanup</h1>
<?php if (!empty($msg)) echo "$msg"; ?>
<div class="notice notice-warning">
<p>This feature is to be considered experimental. Use with caution and at your own risk.</p>
</div>
<p>Plugins often don't clean up their mess when they are uninstalled. Some malicious themes and plugins use WordPress options to store some information.</p>
<p>This function allows you inspect and delete orphan or suspicious options and to change plugin options so that they don&acute;t autoload. </p>
<p>In WordPress, some options are loaded whenever WordPress loads a page. These are marked as autoload options. This is done to speed up WordPress and prevent the programs from hitting the database every time some plugin needs to look up an option. Automatic loading of options at startup makes WordPress fast, but it can also use up memory for options that will seldom or never be used.</p>
<p>You can safely switch options so that they don&acute;t load automatically. Probably the worst thing that will happen is that the page will paint a little slower because the option is retrieved separately from other options. The best thing that can happen is there is a lower demand on memory because the unused options are not loaded when WordPress starts loading a page.</p>
<p>When plugins are uninstalled they are supposed to clean up their options. Many options do not do any clean-up during uninstall. It is quite possible that you have many orphan options from plugins that you deleted long ago. These are autoloaded on every page, slowing down your pages and eating up memory. These options can be safely marked so that they will not autoload. If you are sure they are not needed you can delete them.</p>
<p>The change autoload column shows current autoload state. Yes means it is autoloading. No means that it is not.</p>
<p>You can change the autoload settings or delete an option on the form below. Be aware that you can break some plugins by deleting their options. I do not show most of the built-in options used by WordPress. The list below should be just plugin options.</p>
<p>It is far safer to change the autoload option value to &quot;no&quot; than to delete an option. Only delete an option if you are sure that it is from an uninstalled plugin. If you find your pages slowing down, turn the autoload option back to &quot;yes&quot;.</p>
<p>Option names are determined by the plugin author. Some are obvious, but some make no sense. You may have to do a little detective work to figure out where an option came from.</p>
<?php
global $wpdb;
$ptab=$wpdb->options;
$nonce='';	
// echo "<!--\r\n\r\n";
// print_r($_POST);
// echo "\r\n\r\n-->";
if (array_key_exists('ss_opt_control',$_POST)) $nonce=$_POST['ss_opt_control'];
if (!empty($nonce)&&wp_verify_nonce($nonce,'ss_update')) {
if (array_key_exists('view',$_POST)) {
$op=$_POST['view'];
$v=get_option($op);
if (is_serialized($v) && @unserialize($v)!==false) {
$v=@unserialize($v);
}
$v=print_r($v,true);
$v=htmlentities($v);
echo "<h2>contents of $op</h2><pre>$v</pre>";
}
if (array_key_exists('autol',$_POST)) {
$autol=$_POST['autol'];
foreach($autol as $name) {
$au=substr($name,0,strpos($name,'_'));
if(strtolower($au)=='no') $au='yes'; else $au='no';
$name=substr($name,strpos($name,'_')+1);
echo "changing $name autoload to $au<br />";
$sql="update $ptab set autoload='$au' where option_name='$name'";
$wpdb->query($sql);
}
}
if (array_key_exists('delo',$_POST)) {
$delo=$_POST['delo'];
foreach($delo as $name) {
echo "deleting $name <br/>";
$sql="delete from $ptab where option_name='$name'";
$wpdb->query($sql);
}
}
}
$sysops=array('_transient_',
'active_plugins','admin_email','advanced_edit','avatar_default','avatar_rating','denylist_keys','blog_charset','blog_public','blogdescription','blogname','can_compress_scripts','category_base','close_comments_days_old','close_comments_for_old_posts','comment_max_links','comment_moderation','comment_order','comment_registration','comment_allowlist','comments_notify','comments_per_page','cron','current_theme','dashboard_widget_options','date_format','db_version','default_category','default_comment_status','default_comments_page','default_email_category','default_link_category','default_ping_status','default_pingback_flag','default_post_edit_rows','default_post_format','default_role','embed_autourls','embed_size_h','embed_size_w','enable_app','enable_xmlrpc','fileupload_url','ftp_credentials','gmt_offset','gzipcompression','hack_file','home','ht_user_roles','html_type','image_default_align','image_default_link_type','image_default_size','initial_db_version','large_size_h','large_size_w','links_recently_updated_append','links_recently_updated_prepend','links_recently_updated_time','links_updated_date_format','mailserver_login','mailserver_pass','mailserver_port','mailserver_url','medium_size_h','medium_size_w','moderation_keys','moderation_notify','page_comments','page_for_posts','page_on_front','permalink_structure','ping_sites','posts_per_page','posts_per_rss','recently_edited','require_name_email','rss_use_excerpt','show_avatars','show_on_front','sidebars_widgets','siteurl','start_of_week','sticky_posts','stylesheet','tag_base','template','theme_mods_harptab','theme_mods_twentyeleven','theme_switched','thread_comments','thread_comments_depth','thumbnail_crop','thumbnail_size_h','thumbnail_size_w','time_format','timezone_string','uninstall_plugins','upload_path','upload_url_path','uploads_use_yearmonth_folders','use_balanceTags','use_smilies','use_trackback','users_can_register','widget_archives','widget_categories','widget_meta','widget_recent-comments','widget_recent-posts','widget_rss','widget_search','widget_text',
// some that I added because changing caused problems
'akismet_available_servers',
'auth_key',
'auth_salt',
'akismet_connectivity_time',
'akismet_discard_month',
'akismet_spam_count',
'akismet_show_user_comments_approved',
'akismet_strictness',
'category_children',
'db_upgraded',
'recently_activated',
'rewrite_rules',
'wordpress_api_key',
'theme_mods_',
'widget_',
'_user_roles',
'logged_in_key',
'logged_in_salt',
'nonce_key',
'nonce_salt',
'nav_menu_options',
'auto_core_update_notified','link_manager_enabled','WPLANG'
);
global $wpdb;
// global $wp_query;
$ptab=$wpdb->options;
// option_id, option_name, option_value, autoload
$sql= "SELECT * from $ptab order by autoload,option_name"; 
$arows=$wpdb->get_results($sql,ARRAY_A);
// filter out the ones we don't like
// echo "<br /> $sql : size of options array ".$ptab ." = ".count($arows)."<br />";
$rows=array();
foreach ($arows as $row) {
$uop=true;
$name=$row['option_name'];
if (!in_array($name,$sysops)) {
// check for name like for transients
// _transient_ , _site_transient_
foreach($sysops as $op) {
if (strpos($name,$op)!==false) {
// hit a name like
$uop=false;
break;
}
}
} else {
$uop=false;
}
if ($uop) {
$rows[]=$row;
}
}
// $rows has the allowed options - all default and system options have been excluded	
$nonce=wp_create_nonce('ss_update');
?>
<form method="POST" name="DOIT2" action="">
<input type="hidden" name="ss_opt_control" value="<?php echo $nonce; ?>" />
<table width="100%" bgcolor="#b0b0b0" cellspacing='1' cellpadding="4">
<thead>
<tr bgcolor="#fff">
<th>Option</th>
<th>Autoload</th>
<th>Size</th>
<th>Change Autoload</th>
<th>Delete</th>
<th>View Contents</th>
</tr>
</thead>
<?php
foreach ( $rows as $row ) {
extract($row);
$sz=strlen($option_value);
$au=$autoload;
$sz=number_format($sz);
//if ($autoload=='no') $au='No';
?>
<tr bgcolor="#fff">
<td align="center"><?php echo $option_name; ?></td>
<td align="center"><?php echo $autoload; ?></td>
<td align="center"><?php echo $sz; ?></td>
<td align="center"><input type="checkbox" value="<?php echo $autoload.'_'.$option_name; ?>" name="autol[]">
&nbsp;<?php echo $autoload;?></td>
<td align="center"><input type="checkbox" value="<?php echo $option_name; ?>" name="delo[]">
</td>
<td><button type="submit" name="view" value="<?php echo $option_name; ?>">view</button></td>
</tr>
<?php
}	
?>
</table>
<p class="submit"><input class="button-primary" value="Update" type="submit" onclick="return confirm('Are you sure? There is not undo for this.');"></p>
</form>
<?php
$m1=memory_get_usage();
$m3=memory_get_peak_usage();
$m1=number_format($m1);
$m3=number_format($m3);
echo "<p>Memory Usage Currently: $m1, Peak: $m3</p>";
$nonce=wp_create_nonce('ss_update2');
$showtransients=false; // change to true to clean up transients
if ($showtransients && countTransients()>0  ) { // personal use - probably too dangerous for casual users.
?>
<hr />
<p>WordPress creates temporary objects in the database called transients.<br />
WordPress is not good about cleaning them up afterwards. You can clean these up safely and it might speed things up.</p>
<form method="POST" name="DOIT2" action="">
<input type="hidden" name="ss_opt_tdel" value="<?php echo $nonce; ?>" />
<p class="submit"><input class="button-primary" value="Delete Transients" type="submit" /></p>
</form>
<?php
$nonce='';
if (array_key_exists('ss_opt_tdel',$_POST)) $nonce=$_POST['ss_opt_tdel'];
if (!empty($nonce)&&wp_verify_nonce($nonce,'ss_update2')) {
// doit!
deleteTransients();		
}
?>
<p>Currently there are <?php echo countTransients(); ?> found.</p>
<?php
}
?>
</div>
<?php
function countTransients() {
$blog_id=get_current_blog_id();
global $wpdb;
$optimeout = time() - 60;
$table = $wpdb->get_blog_prefix($blog_id) . 'options';
$count=0;
$sql = "
select count(*) from $table 
where
option_name like '\_transient\_timeout\_%'
or option_name like '\_site\_transient\_timeout\_%'
or option_name like 'displayed\_galleries\_%'
or option_name like 'displayed\_gallery\_rendering\_%'
or t1.option_name like '\_transient\_feed\_mod_%' 
or t1.option_name like '\_transient\__bbp\_%' 
and option_value < '$optimeout'
";
$sql = "
select count(*) from $table 
where instr(t1.option_name,'SS_SECRET_WORD')>0
";
$count += $wpdb->get_var($sql);
if (empty($count)) $count="0";
return $count;
}
/**
* clear expired transients for current blog
* @param int $blog_id
*/
function deleteTransients() {
$blog_id=get_current_blog_id();
global $wpdb;
$optimeout = time() - 60;
$table = $wpdb->get_blog_prefix($blog_id) . 'options';
$sql = "
delete from $table
where 
option_name like '\_transient\_timeout\_%'
or option_name like '\_site\_transient\_timeout\_%'
or option_name like 'displayed\_galleries\_%'
or option_name like 'displayed\_gallery\_rendering\_%'
or t1.option_name like '\_transient\_feed\_mod_%' 
or t1.option_name like '\_transient\__bbp\_%' 
or instr(t1.option_name,'SS_SECRET_WORD')>0
and option_value < '$optimeout'
";
$wpdb->query($sql);
$sql = "
select count(*) from $table 
where instr(t1.option_name,'SS_SECRET_WORD')>0
";
$wpdb->query($sql);
}
?>