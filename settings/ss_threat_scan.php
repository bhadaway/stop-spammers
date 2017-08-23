<?php
if (!defined('ABSPATH')) exit; // just in case
if (!current_user_can('manage_options')) {
die('Access Denied');
}
ss_fix_post_vars();
global $wpdb;
global $wp_query;
$pre=$wpdb->prefix;
$runscan=false;
$nonce='';
if (array_key_exists('ss_stop_spammers_control',$_POST)) $nonce=$_POST['ss_stop_spammers_control'];
if (!empty($nonce) && wp_verify_nonce($nonce,'ss_stopspam_update')) { 
if (array_key_exists('update_options',$_POST)) {
$runscan=true;
}
}
$nonce=wp_create_nonce('ss_stopspam_update');
?>
<div id="ss-plugin" class="wrap">
<h1>Stop Spammers — Threat Scan</h1>
<div class="notice notice-warning">
<p>This feature is to be considered experimental. Use with caution and at your own risk.</p>
</div>
<p>This is a very simple threat scan that looks for things out of place in the content directory as well as the database.</p>
<p>The process searches PHP files for the occurrence of the eval() function, which, although a valuable part of PHP is also the door that hackers use in order to infect systems. The eval() function is avoided by many programmers unless there is a real need. It is often used by hackers to hide their malicious code or to inject future threats into infected systems. If you find a theme or a plugin that uses the eval() function it is safer to delete it and ask the author to provide a new version that does not use this function.</p>
<p>The scan can take a few seconds and on larger or slower systems can time-out.</p>
<form method="post" action="">
<input type="hidden" name="update_options" value="update" />
<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce;?>" />
<p class="submit"><input class="button-primary" value="Run Scan" type="submit" /></p>
</form>
<?php 
if ($runscan) {
?>
<p>When you scan your system you undoubtedly see the eval used in Javascript because it is used in the Javascript AJAX and JSON functionality. The appearance of eval in these cases does not mean that there is a possible threat. It just means that you should inspect the code to make sure that it is in a Javascript section and not native PHP.</p>
<p>The process continues its scan by checking the database tables for Javascript or HTML where it should not be found.</p>
<p>Normally, Javascript can be found in the post body, but if the script tag is found in a title or a text field where it does not belong it is probably because the script is hiding something, such as a hidden admin user, so that the normal administration pages do not show bad records. The scan looks for this and displays the table and record number where it believes there is something hinky.</p>
<p>The scan continues looking in the database for certain HTML in places where it does not belong. Recent threats have been putting HTML into fields in the options table so that users will be sent to malicious sites. The presence of HTML in options values is suspect and should be checked.</p>
<p>The options table will have things placed there by plugins so it is difficult to tell if scripts, iframes, and other HTML tags are a threat. They will be reported, but they should be checked before deleting the entries.</p>
<p>This process is just a simple scan and does not try to fix any problems. It will show things that may not be threats, but should be checked. If anything shows up, you should try to repair the damage or hire someone to do it. I am not a security expert, but a programmer who discovered these types of things in a friend's blog. After many hours of checking I was able to fix the problem, but a professional could have done it faster and easier, although they would have charged for it.</p>
<p>You probably do not have a backup to your blog, so if this scan shows you are clean, your next step is to install one of the plugins that does regular backups of your system. Next, make sure you have the latest WordPress version.</p>
<p>If you think you have problems, the first thing to do is change your user id and password. Next make a backup of the infected system. Any repairs to WordPress might delete important data so you might lose posts, and the backup will help you recover missing posts.</p>
<p>The next step is to install the latest version of WordPress. The new versions usually have fixes for older threats.</p>
<p>You may want to export your WordPress posts, make a new clean installation of WordPress, and then import the old posts.</p>
<p>If this doesn't work it is time to get a pro involved.</p>
<h2>A clean scan does not mean you are safe. Please do backups and keep your installation up-to-date!</h2>
<hr />
<?php
$disp=false;
flush();
// lets try the posts - looking for script tags in data
echo "<br/><br/>Testing Posts<br/>";
$ptab=$pre.'posts';
$sql= "select ID,post_author,post_title,post_name,guid,post_content,post_mime_type
from $ptab where 
INSTR(LCASE(post_author), '<script') +
INSTR(LCASE(post_title), '<script') +
INSTR(LCASE(post_name), '<script') +
INSTR(LCASE(guid), '<script') +
INSTR(LCASE(post_author), 'eval(') +
INSTR(LCASE(post_title), 'eval(') +
INSTR(LCASE(post_name), 'eval(') +
INSTR(LCASE(guid), 'eval(') +
INSTR(LCASE(post_content), 'eval(') +
INSTR(LCASE(post_author), 'eval (') +
INSTR(LCASE(post_title), 'eval (') +
INSTR(LCASE(post_name), 'eval (') +
INSTR(LCASE(guid), 'eval (') +
INSTR(LCASE(post_content), 'eval (') +
INSTR(LCASE(post_content), 'document.write(unescape(') +
INSTR(LCASE(post_content), 'try{window.onload') +
INSTR(LCASE(post_content), 'setAttribute(\'src\'') +
INSTR(LCASE(post_mime_type), 'script') > 0
";
flush();
$myrows = $wpdb->get_results( $sql );
if ($myrows) {
foreach ($myrows as $myrow) {
$disp=true;
$reason='';
if (strpos(strtolower($myrow->post_author),'<script')!==false) $reason.="post_author:&lt;script "; 
if (strpos(strtolower($myrow->post_title),'<script')!==false) $reason.="post_title:&lt;script "; 
if (strpos(strtolower($myrow->post_name),'<script')!==false) $reason.="post_name:&lt;script "; 
if (strpos(strtolower($myrow->guid),'<script')!==false) $reason.="guid:&lt;script "; 
if (strpos(strtolower($myrow->post_author),'eval(')!==false) $reason.="post_author:eval() "; 
if (strpos(strtolower($myrow->post_title),'eval(')!==false) $reason.="post_title:eval() "; 
if (strpos(strtolower($myrow->post_name),'eval(')!==false) $reason.="post_name:eval() "; 
if (strpos(strtolower($myrow->guid),'eval(')!==false) $reason.="guid:eval() "; 
if (strpos(strtolower($myrow->post_content),'eval(')!==false) $reason.="post_content:eval() "; 
if (strpos(strtolower($myrow->post_author),'eval (')!==false) $reason.="post_author:eval() "; 
if (strpos(strtolower($myrow->post_title),'eval (')!==false) $reason.="post_title:eval() "; 
if (strpos(strtolower($myrow->post_name),'eval (')!==false) $reason.="post_name:eval() "; 
if (strpos(strtolower($myrow->guid),'eval (')!==false) $reason.="guid:eval() "; 
if (strpos(strtolower($myrow->post_content),'eval (')!==false) $reason.="post_content:eval() "; 
if (strpos(strtolower($myrow->post_content),'document.write(unescape(')!==false) $reason.="post_content:document.write(unescape( "; 
if (strpos(strtolower($myrow->post_content),'try{window.onload')!==false) $reason.="post_content:try{window.onload "; 
if (strpos(strtolower($myrow->post_content),"setAttribute('src'")!==false) $reason.="post_content:setAttribute('src' "; 
if (strpos(strtolower($myrow->post_mime_type),'script')!==false) $reason.="post_mime_type:script "; 
echo "found possible problems in post ($reason) ID: ". $myrow->ID.'<br/>';
}
} else {
echo "<br />Nothing found in posts.<br/>";
$disp=false;
}
echo "<hr />";
// comments: comment_ID: author_url, comment_agent, comment_author, comment_email
$ptab=$pre.'comments';
echo "<br /><br />Testing Comments<br />";
flush();
$sql="select comment_ID,comment_author_url,comment_agent,comment_author,comment_author_email,comment_content
from $ptab where 
INSTR(LCASE(comment_author_url), '<script') +
INSTR(LCASE(comment_agent), '<script') +
INSTR(LCASE(comment_author), '<script') +
INSTR(LCASE(comment_author_email), '<script') +
INSTR(LCASE(comment_author_url), 'eval(') +
INSTR(LCASE(comment_agent), 'eval(') +
INSTR(LCASE(comment_author), 'eval(') +
INSTR(LCASE(comment_author_email), 'eval(') +
INSTR(LCASE(comment_author_url), 'eval (') +
INSTR(LCASE(comment_agent), 'eval (') +
INSTR(LCASE(comment_author), 'eval (') +
INSTR(LCASE(comment_author_email), 'eval (') +
INSTR(LCASE(comment_content), '<script') +
INSTR(LCASE(comment_content), 'eval(') +
INSTR(LCASE(comment_content), 'eval (') +
INSTR(LCASE(comment_content), 'document.write(unescape(') +
INSTR(LCASE(comment_content), 'try{window.onload') +
INSTR(LCASE(comment_content), 'setAttribute(\'src\'') +
INSTR(LCASE(comment_author_url), 'javascript:') >0
";
$myrows = $wpdb->get_results( $sql );
if ($myrows) {
foreach ($myrows as $myrow) {
$disp=true;
$reason='';
if (strpos(strtolower($myrow->comment_author_url),'<script')!==false) $reason.="comment_author_url:&lt;script "; 
if (strpos(strtolower($myrow->comment_agent),'<script')!==false) $reason.="comment_agent:&lt;script "; 
if (strpos(strtolower($myrow->comment_author),'<script')!==false) $reason.="comment_author:&lt;script "; 
if (strpos(strtolower($myrow->comment_author_email),'<script')!==false) $reason.="comment_author_email:&lt;script ";
if (strpos(strtolower($myrow->comment_content),'<script')!==false) $reason.="comment_content:&lt;script ";
if (strpos(strtolower($myrow->comment_author_url),'eval(')!==false) $reason.="comment_author_url:eval() "; 
if (strpos(strtolower($myrow->comment_agent),'eval(')!==false) $reason.="comment_agent:eval() "; 
if (strpos(strtolower($myrow->comment_author),'eval(')!==false) $reason.="comment_author:eval() "; 
if (strpos(strtolower($myrow->comment_author_email),'eval(')!==false) $reason.="comment_author_email:eval() "; 
if (strpos(strtolower($myrow->comment_content),'eval(')!==false) $reason.="comment_content:eval() "; 
if (strpos(strtolower($myrow->comment_author_url),'eval (')!==false) $reason.="comment_author_url:eval() "; 
if (strpos(strtolower($myrow->comment_agent),'eval (')!==false) $reason.="comment_agent:eval() "; 
if (strpos(strtolower($myrow->comment_author),'eval (')!==false) $reason.="comment_author:eval() "; 
if (strpos(strtolower($myrow->comment_author_email),'eval (')!==false) $reason.="comment_author_email:eval() "; 
if (strpos(strtolower($myrow->comment_content),'eval (')!==false) $reason.="comment_content:eval() "; 
if (strpos(strtolower($myrow->comment_content),'document.write(unescape(')!==false) $reason.="comment_content:document.write(unescape( ";
if (strpos(strtolower($myrow->comment_content),'try{window.onload')!==false) $reason.="comment_content:try{window.onload ";
if (strpos(strtolower($myrow->comment_content),"setAttribute('src'")!==false) $reason.="comment_content:setAttribute('src' ";
if (strpos(strtolower($myrow->comment_content),'javascript:')!==false) $reason.="comment_content:javascript: ";
echo "found possible problems in comment ($reason) ID". $myrow->comment_ID.'<br />';
}
} else {
echo "<br />Nothing found in comments.<br />";
}
flush();
echo "<hr />";
// links: links_id: link_url, link_image, link_description, link_notes, link_rss,link_rss
$ptab=$pre.'links';
echo "<br /><br />Testing Links<br />";
flush();
$sql="select link_ID,link_url,link_image,link_description,link_notes
from $ptab where 
INSTR(LCASE(link_url), '<script') +
INSTR(LCASE(link_image), '<script') +
INSTR(LCASE(link_description), '<script') +
INSTR(LCASE(link_notes), '<script') +
INSTR(LCASE(link_rss), '<script') +
INSTR(LCASE(link_url), 'eval(') +
INSTR(LCASE(link_image), 'eval(') +
INSTR(LCASE(link_description), 'eval(') +
INSTR(LCASE(link_notes), 'eval(') +
INSTR(LCASE(link_rss), 'eval(') +
INSTR(LCASE(link_url), 'eval (') +
INSTR(LCASE(link_image), 'eval (') +
INSTR(LCASE(link_description), 'eval (') +
INSTR(LCASE(link_notes), 'eval (') +
INSTR(LCASE(link_rss), 'eval (') +
INSTR(LCASE(link_url), 'javascript:') >0
";
$myrows = $wpdb->get_results( $sql );
if ($myrows) {
foreach ($myrows as $myrow) {
$reason=''; 
if (strpos(strtolower($myrow->link_url),'<script')!==false) $reason.="link_url:&lt;script "; 
if (strpos(strtolower($myrow->link_image),'<script')!==false) $reason.="link_image:&lt;script "; 
if (strpos(strtolower($myrow->link_description),'<script')!==false) $reason.="link_description:&lt;script "; 
if (strpos(strtolower($myrow->link_notes),'<script')!==false) $reason.="link_notes:&lt;script "; 
if (strpos(strtolower($myrow->link_rss),'<script')!==false) $reason.="link_rss:&lt;script "; 
if (strpos(strtolower($myrow->link_url),'eval(')!==false) $reason.="link_url:eval() "; 
if (strpos(strtolower($myrow->link_image),'eval(')!==false) $reason.="link_image:eval() "; 
if (strpos(strtolower($myrow->link_description),'eval(')!==false) $reason.="link_description:eval() "; 
if (strpos(strtolower($myrow->link_notes),'eval(')!==false) $reason.="link_notes:eval() "; 
if (strpos(strtolower($myrow->link_rss),'eval(')!==false) $reason.="link_rss:eval() "; 
if (strpos(strtolower($myrow->link_url),'eval (')!==false) $reason.="link_url:eval() "; 
if (strpos(strtolower($myrow->link_image),'eval (')!==false) $reason.="link_image:eval() "; 
if (strpos(strtolower($myrow->link_description),'eval (')!==false) $reason.="link_description:eval() "; 
if (strpos(strtolower($myrow->link_notes),'eval (')!==false) $reason.="link_notes:eval() "; 
if (strpos(strtolower($myrow->link_rss),'eval (')!==false) $reason.="link_rss:eval() "; 
if (strpos(strtolower($myrow->link_url),'javascript:')!==false) $reason.="link_url:javascript: "; 
echo "found possible problems in links ($reason) ID:". $myrow->link_ID.'<br />';
}
} else {
echo "<br />Nothing found in links.<br />";
}
echo "<hr />";
// users: ID: user_login,user_nicename, user_email, user_url, display_name
$ptab=$pre.'users';
echo "<br /><br />Testing Users<br />";
flush();
$sql="select ID,user_login,user_nicename,user_email,user_url,display_name 
from $ptab where 
INSTR(LCASE(user_login), '<script') +
INSTR(LCASE(user_nicename), '<script') +
INSTR(LCASE(user_email), '<script') +
INSTR(LCASE(user_url), '<script') +
INSTR(LCASE(display_name), '<script') +
INSTR(user_login, 'eval(') +
INSTR(user_nicename, 'eval(') +
INSTR(user_email, 'eval(') +
INSTR(user_url, 'eval(') +
INSTR(display_name, 'eval(') +
INSTR(user_login, 'eval (') +
INSTR(user_nicename, 'eval (') +
INSTR(user_email, 'eval (') +
INSTR(user_url, 'eval (') +
INSTR(display_name, 'eval (') +
INSTR(LCASE(user_url), 'javascript:') +
INSTR(LCASE(user_email), 'javascript:')>0
";
$myrows = $wpdb->get_results( $sql );
if ($myrows) {
foreach ($myrows as $myrow) {
$disp=true;
$reason='';
if (strpos(strtolower($myrow->user_login),'<script')!==false) $reason.="user_login:&lt;script "; 
if (strpos(strtolower($myrow->user_nicename),'<script')!==false) $reason.="user_nicename:&lt;script "; 
if (strpos(strtolower($myrow->user_email),'<script')!==false) $reason.="user_email:&lt;script "; 
if (strpos(strtolower($myrow->user_url),'<script')!==false) $reason.="user_url:&lt;script "; 
if (strpos(strtolower($myrow->display_name),'<script')!==false) $reason.="display_name:&lt;script ";
if (strpos(strtolower($myrow->user_login),'eval(')!==false) $reason.="user_login:eval() "; 
if (strpos(strtolower($myrow->user_nicename),'eval(')!==false) $reason.="user_nicename:eval() "; 
if (strpos(strtolower($myrow->user_email),'eval(')!==false) $reason.="user_email:eval() "; 
if (strpos(strtolower($myrow->user_url),'eval(')!==false) $reason.="user_url:eval() "; 
if (strpos(strtolower($myrow->display_name),'eval(')!==false) $reason.="display_name:eval() "; 
if (strpos(strtolower($myrow->user_login),'eval (')!==false) $reason.="user_login:eval() "; 
if (strpos(strtolower($myrow->user_nicename),'eval (')!==false) $reason.="user_nicename:eval() "; 
if (strpos(strtolower($myrow->user_email),'eval (')!==false) $reason.="user_email:eval() "; 
if (strpos(strtolower($myrow->user_url),'eval (')!==false) $reason.="user_url:eval() "; 
if (strpos(strtolower($myrow->display_name),'eval (')!==false) $reason.="display_name:eval() "; 
if (strpos(strtolower($myrow->user_email),'javascript:')!==false) $reason.="user_email:javascript: "; 
if (strpos(strtolower($myrow->user_url),'javascript:')!==false) $reason.="user_url:javascript: "; 
echo "found possible problems in Users ($reason) ID:". $myrow->ID.'<br />';
}
} else {
echo "<br />Nothing found in users.<br />";
}
echo "<hr />";
// options: option_id option_value, option_name
// I may have to update this as new websites show up
$ptab=$pre.'options';
echo "<br /><br />Testing Options Table for HTML<br />";
flush();
$badguys=array(
'eval('=>'eval function found',
'eval ('=>'eval function found',
'networkads'=>'unexpected network ads reference',
'document.write(unescape('=>'javascript document write unescape',
'try{window.onload'=>'javascript onload event',
'escape(document['=>'javascript checking document array',
'escape(navigator['=>'javascript checking navigator',
'document.write(string.fromcharcode'=>'obsfucated javascript write',
'(base64'.'_decode'=>'base64 decode to hide code',
'(gz'.'inflate'=>'gzip inflate often used to hide code',
'UA-27917097-1'=>'Bogus Google Analytics code',
'w.wpquery.o'=>'Malicious jquery in bootleg plugin or theme',
'<scr\\\'+'=>'Obfuscated script tag, usually in bootleg plugin or theme'
);
$sql="select option_id,option_value,option_name
from $ptab where
";
foreach ($badguys as $baddie=>$reas) {
$sql.="INSTR(LCASE(option_value), '$baddie') +";
}
$sql=trim($sql,'+');
$myrows = $wpdb->get_results( $sql );
if ($myrows) {
foreach ($myrows as $myrow) {
// get the option and then red the string
$id=$myrow->option_id;
$name=$myrow->option_name;
$line=$myrow->option_value;
$line=htmlentities($line);
$line=strtolower($line);
$reason='';
if (strpos($name,'_transient_feed_')===false) {
$disp=true;
foreach ($badguys as $baddie=>$reas) {
if (!(strpos($line,$baddie)===false)) {
// bad boy
$line=ss_make_red($baddie,$line);
$reason.=$reas.' ';
} 
}
}				
echo "<strong>Found possible problems in Option $name ($reason)</strong> option_id:". $myrow->option_id.", value: $line<br /><br />";
}
} else {
echo "<br />Nothing found in options.<br />";
}
echo "<hr />";
echo "<h2>Scanning Themes and Plugins for eval</h2>";
flush();
if (ss_scan_for_eval()) $disp=true;;
if ($disp) {
?>
<h2>Possible Problems Found!</h2>
<p>These are warnings only. Some content and plugins might not be malicious, but still contain one or more of these indicators. Please investigate all indications of problems. The plugin may err on the side of caution.</p>
<p>Although there are legitimate reasons for using the eval function, and Javascript uses it frequently, finding eval in PHP code is in the very least bad practice, and the worst is used to hide malicious code. If eval() comes up in a scan, try to get rid of it.</p>
<p>Your code could contain 'eval', or 'document.write(unescape(' or 'try{window.onload' or setAttribute('src'. These are markers for problems such as SQL injection or cross-browser Javascript. &lt;script&gt; tags should occur in your posts, if you added them, but should not be found anywhere else, except options. Options often have scripts for displaying Facebook, Twitter, etc. Be careful, though, if one appears in an option. Most of the time it is OK, but make sure.</p>
<?php
} else {
?>
<h2>No Problems Found</h2>
<p>It appears that there are no eval or suspicious Javascript functions in the code in your wp-content directory. That does not mean that you are safe, only that a threat may be well-hidden.</p>
<?php	
}
flush();
} // end if runscan
function ss_scan_for_eval() {
// scan content completely
// WP_CONTENT_DIR is supposed to have the content dir
$phparray=array();
// use get_home_path()
// $phparray=ss_scan_for_eval_recurse(WP_CONTENT_DIR.'/..',$phparray);
$phparray=ss_scan_for_eval_recurse(realpath(get_home_path()),$phparray);
// phparray should have a list of all of the PHP files
$disp=false;
echo "Files: <ol>";
for ($j=0;$j<count($phparray);$j++) {
// ignore my work on this subject
if (strpos($phparray[$j],'threat_scan')===false&&strpos($phparray[$j],'threat-scan')===false) {
$ansa=ss_look_in_file($phparray[$j]);
if (count($ansa)>0) {
$disp=true;
// echo "Think we got something<br />";
echo "<li>".$phparray[$j]." <br /> ";
for ($k=0;$k<count($ansa);$k++) {
echo $ansa[$k]." <br />"; 
}
echo "</li>";
}
}
}  
echo "</ol>";
return $disp;
} // end of function
// recursive walk of directory structure.
function ss_scan_for_eval_recurse($dir,$phparray) {
if (!@is_dir($dir))  return $phparray;
// if (substr($dir,0,1)='.') return $phparray;
$dh=null;
// can't protect this - turn off the error capture for a moment.
sfs_errorsonoff('off');
try {
$dh=@opendir($dir);
} catch (Exception $e) {
sfs_errorsonoff();
return $phparray;
}
sfs_errorsonoff();
if ($dh!==null && $dh!==false) {
while (($file = readdir($dh)) !== false) {
if (@is_dir($dir .'/'. $file)) {
if ($file!='.' && $file!='..' && $file!=':' && strpos('/',$file)===false ) { // that last one does some symbolics?
$phparray=ss_scan_for_eval_recurse($dir .'/'. $file,$phparray);
}
} else if ( strpos($file,'.php')>0 ) {
$phparray[count($phparray)]=$dir .'/'. $file;
} else {
// echo "can't find .php in $file <br />";
}
}
closedir($dh);
}
return $phparray;
}	
function ss_look_in_file($file) {
if (!file_exists($file)) return false;
// don't look in this plugin because it finds too much stuff
// only look for .php files - no more javascript
if (strpos($file,'.php')===false) return false;
$handle=@fopen($file,'r');
if ($handle===false) return array();
$ansa=array();
$n=0;
$idx=0;
$badguys=array(
'eval(',
'eval (',
'document.write(unescape(',
'try{window.onload',
'escape(document[',
'escape(navigator[',
"setAttribute('src'",
'document.write(string.fromcharcode',
'base64'.'_decode',
'gzun'.'compress',
'gz'.'inflate',
'if(!isset($GLOBALS['."\\'\\a\\e\\0",
'passssword',
'Bruteforce protection',
'w.wpquery.o',
"<scr'+"
);
while (!@feof($handle)) {
$line=fgets($handle);
$line=htmlentities($line);
$n++;
foreach($badguys as $baddie) {		
if (!(strpos($line,$baddie)===false)) {
// bad boy
if (ss_ok_list($file,$n)) {
$line=ss_make_red($baddie,$line);
$ansa[$idx]=$n.': '.$line;
$idx++;
}
} 
}
// search line for $xxxxx() type things
$m=0;
$f=false;
$vchars='!@#$%^&*),.;:\"[]{}?/+=_- \t\\|~`<>'."'"; // not part of variable names
while ($m<strlen($line)-2) {
$m=strpos($line,'$',$m);
if ($m===false) break;
if (substr($line,$m,7)!='$class(') { // used often and correctly
$mi=$m;
$mi++;
for ($mm=$mi;($mm<$mi+8&&$mm<strlen($line));$mm++) {
$c=substr($line,$mm,1);
if ($c=='(' && $mm>$mi) { // need at least a character so as not to kill jQuery
$f=true;
break;
}
if (strpos($vchars,$c)!==false) {
break;
}
}
}
if ($f) break;
$m++;
}
if ($f) {
if (ss_ok_list($file,$n)) {
$ll=substr($line,$m,7);
$line=ss_make_red($ll,$line);
$ansa[$idx]=$n.': '.$line;
$idx++;
}
}
}
fclose($handle);
return $ansa;
}
function ss_make_red($needle,$haystack) {
// turns error red
$j=strpos($haystack,$needle);
$s=substr_replace($haystack, '</span>', $j+strlen($needle), 0);
$s=substr_replace($s, '<span style="color:red;">', $j, 0);
return $s;
}	
function ss_ok_list($file,$line) {
// more advanced excluder file=>array(start,end,start,end,start,end
// start and end are loose to allow for varuous versions - hope that they don't hide some bad code
$exclude=array(
'class-pclzip.php'=>array(3700,4300),
'wp-admin/includes/file.php'=>array(450,550),	
'wp-admin/press-this.php'=>array(200,250,400,450),
'jetpack/class.jetpack.php'=>array(5000,5100),
'jetpack/locales.php'=>array(25,75),
'custom-css/preprocessors/lessc.inc.php'=>array(25,75,1500,1600),
'preprocessors/scss.inc.php'=>array(800,900,1800,1900),
'ss_challenge.php'=>array(0,300),
'modules/chkexploits.php'=>array(10,30),	
'wp-includes/class-http.php'=>array(2000,2300),	
'class-IXR.php'=>array(300,350),	
'all-in-one-seo-pack/JSON.php'=>array(10,30),	
'all-in-one-seo-pack/OAuth.php'=>array(240,300),	
'all-in-one-seo-pack/aioseop_sitemap.php'=>array(500,600),	
'wp-includes/class-json.php'=>array(10,30),
'p-includes/class-smtp.php'=>array(300,400),
'wp-includes/class-snoopy.php'=>array(650,700),
'wp-includes/class-feed.php'=>array(100,150),
'wp-includes/class-wp-customize-widgets.php'=>array(1100,1250),
'wp-includes/compat.php'=>array(40,60),
'/jsonwrapper/JSON/JSON.php'=>array(10,30),
'wp-includes/functions.php'=>array(200,250),
'wp-includes/ID3/module.audio-video.quicktime.php'=>array(450,550),
'wp-includes/ID3/module.audio.ogg.php'=>array(550,650),
'wp-includes/ID3/module.tag.id3v2.php'=>array(550,650),
'wp-includes/pluggable.php'=>array(1750,1850),
'wp-includes/session.php'=>array(25,75),
'wp-includes/SimplePie/File.php'=>array(200,300),
'wp-includes/SimplePie/gzdecode.php'=>array(300,350),
'wp-includes/SimplePie/Sanitize.php'=>array(225,275,300,350),
'stop-spammer-registrations-new.php'=>array(250,400)
);
foreach($exclude as $f=>$ln) {
if (stripos($file,$f)!==false) {
// found a file
for ($j=0;$j<count($ln)/2;$j++) {
$t1=$ln[$j*2];
$t2=$ln[($j*2)+1];
// echo "checking $file, $f for $line and '$ln'<br />";
if($line>=$t1 && $line<=$t2) return false;
}
}
}
// if (strpos($file,'stop-spammers') !== false) return false;
return true;
}	
?>
</div>