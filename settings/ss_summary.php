<?php
if (!defined('ABSPATH')) exit; // just in case
if (!current_user_can('manage_options')) {
die('Access Denied');
}
if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'protect' ) ) {
echo "<div>Jetpack Protect has been detected. Stop Spammers has disabled itself.<br />
Please turn off Jetpack Protect or uninstall Stop Spammers.</div>";
return;
}
ss_fix_post_vars();
$stats=ss_get_stats();
extract($stats);
$now=date('Y/m/d H:i:s',time() + ( get_option( 'gmt_offset' ) * 3600 ));
// counter list - this should be copied from the get option utility
// counters should have the same name as the YN switch for the check
// I see lots of missing counters here
$counters=array(
'cntchkcloudflare'=>'Pass Cloudflare',
'cntchkgcache'=>'Pass Good Cache',
'cntchkakismet'=>'Reported by Akismet',
'cntchkgenallowlist'=>'Pass Generated Allow List',
'cntchkgoogle'=>'Pass Google',
'cntchkmiscallowlist'=>'Pass Allow List',
'cntchkpaypal'=>'Pass PayPal',
'cntchkscripts'=>'Pass Scripts',
'cntchkvalidip'=>'Pass Uncheckable IP',
'cntchkwlem'=>'Allow List Email',
'cntchkuserid'=>'Allow User ID/Author',
'cntchkwlist'=>'Pass Allow List IP',
'cntchkyahoomerchant'=>'Pass Yahoo merchant',
'cntchk404'=>'404 Exploit Attempt',
'cntchkaccept'=>'Bad or Missing Accept Header',
'cntchkadmin'=>'Admin Login Attempt',
'cntchkadminlog'=>'Passed Login OK',
'cntchkagent'=>'Bad or Missing User Agent',
'cntchkamazon'=>'Amazon AWS',
'cntchkaws'=>'Amazon AWS Allow',
'cntchkbcache'=>'Bad Cache',
'cntchkblem'=>'Deny List Email',
'cntchkuserid'=>'Deny User ID/Author',
'cntchkblip'=>'Deny List IP',
'cntchkbotscout'=>'BotScout',
'cntchkdisp'=>'Disposable Email',
'cntchkdnsbl'=>'DNSBL Hit',
'cntchkexploits'=>'Exploit Attempt',
'cntchkgooglesafe'=>'Google Safe Browsing',
'cntchkhoney'=>'Project Honeypot',
'cntchkhosting'=>'Known Spam Host',
'cntchkinvalidip'=>'Block Invalid IP',
'cntchklong'=>'Long Email',
'cntchkshort'=>'Short Email',
'cntchkbbcode'=>'BBCode in Request',
'cntchkreferer'=>'Bad HTTP_REFERER',
'cntchksession'=>'Session Speed',
'cntchksfs'=>'Stop Forum Spam',
'cntchkspamwords'=>'Spam Words',
'cntchktld'=>'Email TLD',
'cntchkubiquity'=>'Ubiquity Servers',
'cntchkmulti'=>'Repeated Hits',
'cntchkform'=>'Check for Standard Form',
'cntchkAD'=>'Andorra',
'cntchkAE'=>'United Arab Emirates',
'cntchkAF'=>'Afghanistan',
'cntchkAL'=>'Albania',
'cntchkAM'=>'Armenia',
'cntchkAR'=>'Argentina',
'cntchkAT'=>'Austria',
'cntchkAU'=>'Australia',
'cntchkAX'=>'Aland Islands',
'cntchkAZ'=>'Azerbaijan',
'cntchkBA'=>'Bosnia And Herzegovina',
'cntchkBB'=>'Barbados',
'cntchkBD'=>'Bangladesh',
'cntchkBE'=>'Belgium',
'cntchkBG'=>'Bulgaria',
'cntchkBH'=>'Bahrain',
'cntchkBN'=>'Brunei Darussalam',
'cntchkBO'=>'Bolivia',
'cntchkBR'=>'Brazil',
'cntchkBS'=>'Bahamas',
'cntchkBY'=>'Belarus',
'cntchkBZ'=>'Belize',
'cntchkCA'=>'Canada',
'cntchkCD'=>'Congo, Democratic Republic',
'cntchkCH'=>'Switzerland',
'cntchkCL'=>'Chile',
'cntchkCN'=>'China',
'cntchkCO'=>'Colombia',
'cntchkCR'=>'Costa Rica',
'cntchkCU'=>'Cuba',
'cntchkCW'=>'CuraÃ§ao',
'cntchkCY'=>'Cyprus',
'cntchkCZ'=>'Czech Republic',
'cntchkDE'=>'Germany',
'cntchkDK'=>'Denmark',
'cntchkDO'=>'Dominican Republic',
'cntchkDZ'=>'Algeria',
'cntchkEC'=>'Ecuador',
'cntchkEE'=>'Estonia',
'cntchkES'=>'Spain',
'cntchkEU'=>'European Union',
'cntchkFI'=>'Finland',
'cntchkFJ'=>'Fiji',
'cntchkFR'=>'France',
'cntchkGB'=>'Great Britain',
'cntchkGE'=>'Georgia',
'cntchkGF'=>'French Guiana',
'cntchkGI'=>'Gibraltar',
'cntchkGP'=>'Guadeloupe',
'cntchkGR'=>'Greece',
'cntchkGT'=>'Guatemala',
'cntchkGU'=>'Guam',
'cntchkGY'=>'Guyana',
'cntchkHK'=>'Hong Kong',
'cntchkHN'=>'Honduras',
'cntchkHR'=>'Croatia',
'cntchkHT'=>'Haiti',
'cntchkHU'=>'Hungary',
'cntchkID'=>'Indonesia',
'cntchkIE'=>'Ireland',
'cntchkIL'=>'Israel',
'cntchkIN'=>'India',
'cntchkIQ'=>'Iraq',
'cntchkIR'=>'Iran, Islamic Republic Of',
'cntchkIS'=>'Iceland',
'cntchkIT'=>'Italy',
'cntchkJM'=>'Jamaica',
'cntchkJO'=>'Jordan',
'cntchkJP'=>'Japan',
'cntchkKE'=>'Kenya',
'cntchkKG'=>'Kyrgyzstan',
'cntchkKH'=>'Cambodia',
'cntchkKR'=>'Korea',
'cntchkKW'=>'Kuwait',
'cntchkKY'=>'Cayman Islands',
'cntchkKZ'=>'Kazakhstan',
'cntchkLA'=>"Lao People's Democratic Republic",
'cntchkLB'=>'Lebanon',
'cntchkLK'=>'Sri Lanka',
'cntchkLT'=>'Lithuania',
'cntchkLU'=>'Luxembourg',
'cntchkLV'=>'Latvia',
'cntchkMD'=>'Moldova',
'cntchkME'=>'Montenegro',
'cntchkMK'=>'Macedonia',
'cntchkMM'=>'Myanmar',
'cntchkMN'=>'Mongolia',
'cntchkMO'=>'Macao',
'cntchkMP'=>'Northern Mariana Islands',
'cntchkMQ'=>'Martinique',
'cntchkMT'=>'Malta',
'cntchkMV'=>'Maldives',
'cntchkMX'=>'Mexico',
'cntchkMY'=>'Malaysia',
'cntchkNC'=>'New Caledonia',
'cntchkNI'=>'Nicaragua',
'cntchkNL'=>'Netherlands',
'cntchkNO'=>'Norway',
'cntchkNP'=>'Nepal',
'cntchkNZ'=>'New Zealand',
'cntchkOM'=>'Oman',
'cntchkPA'=>'Panama',
'cntchkPE'=>'Peru',
'cntchkPG'=>'Papua New Guinea',
'cntchkPH'=>'Philippines',
'cntchkPK'=>'Pakistan',
'cntchkPL'=>'Poland',
'cntchkPR'=>'Puerto Rico',
'cntchkPS'=>'Palestinian Territory, Occupied',
'cntchkPT'=>'Portugal',
'cntchkPW'=>'Palau',
'cntchkPY'=>'Paraguay',
'cntchkQA'=>'Qatar',
'cntchkRO'=>'Romania',
'cntchkRS'=>'Serbia',
'cntchkRU'=>'Russian Federation',
'cntchkSA'=>'Saudi Arabia',
'cntchkSC'=>'Seychelles',
'cntchkSE'=>'Sweden',
'cntchkSG'=>'Singapore',
'cntchkSI'=>'Slovenia',
'cntchkSK'=>'Slovakia',
'cntchkSV'=>'El Salvador',
'cntchkSX'=>'Sint Maarten',
'cntchkSY'=>'Syrian Arab Republic',
'cntchkTH'=>'Thailand',
'cntchkTJ'=>'Tajikistan',
'cntchkTM'=>'Turkmenistan',
'cntchkTR'=>'Turkey',
'cntchkTT'=>'Trinidad And Tobago',
'cntchkTW'=>'Taiwan',
'cntchkUA'=>'Ukraine',
'cntchkUK'=>'United Kingdom',
'cntchkUS'=>'United States',
'cntchkUY'=>'Uruguay',
'cntchkUZ'=>'Uzbekistan',
'cntchkVC'=>'Saint Vincent And Grenadines',
'cntchkVE'=>'Venezuela',
'cntchkVN'=>'Viet Nam',
'cntchkYE'=>'Yemen',
'cntcap'=>'Passed CAPTCHA', // captha success
'cntncap'=>'Failed CAPTCHA', // captha not success	
'cntpass'=>'Total Pass', // passed
);
$message="";
$nonce='';
if (array_key_exists('ss_stop_spammers_control',$_POST)) $nonce=$_POST['ss_stop_spammers_control'];
if (wp_verify_nonce($nonce,'ss_stopspam_update')) { 
if (array_key_exists('clear',$_POST)) {
foreach($counters as $v1=>$v2) {
$stats[$v1]=0;
}	
$addonstats=array();
$stats['addonstats']=$addonstats;
$msg='<div class="notice notice-success"><p>Summary Cleared</p></div>';
ss_set_stats($stats);
extract($stats); // extract again to get the new options
}
if (array_key_exists('update_total',$_POST)) {
$stats['spmcount']=$_POST['spmcount'];
$stats['spmdate']=$_POST['spmdate'];
ss_set_stats($stats);
extract($stats); // extract again to get the new options
}
}
$nonce=wp_create_nonce('ss_stopspam_update');
?>
<div id="ss-plugin" class="wrap">
<h1>Stop Spammers — Summary</h1>
<p>Version <span class="green"><?php echo SS_VERSION; ?></span></p>
<?php
if (!empty($msg)) echo "$msg";
$current_user_name=wp_get_current_user()->user_login;
if ($current_user_name=='admin') {
echo "<p style=\"color:red;font-style::italic;\">You are using the admin id \"admin\". This is 
an invitation to hackers to try and guess your password. Please change this.<br />
Here is discussion on WordPress.org:
<a href=\"https://wordpress.org/support/topic/how-to-change-admin-username?replies=4\" target=\"_blank\">How to Change Admin Username</a>
</p>";
}
$showcf=false; // hide this for now
if ($showcf && array_key_exists('HTTP_CF_CONNECTING_IP',$_SERVER)&& !function_exists( 'cloudflare_init' ) &&!defined('W3TC') ){
echo "<p style=\"color:red;font-style::italic;\">
Cloudflare Remote IP address detected. Please install the <a href=\"https://wordpress.org/plugins/cloudflare/\" target=\"_blank\">Cloudflare Plugin</a>.
This plugin works best with the Cloudflare plugin when yout website is using Cloudflare.
</p>";
}
if ($spmcount>0) {
?>
<script type="text/javascript">
function showcheat() {
var el=document.getElementById("cheater");
el.style.display="block";
return false;
}
</script>
<p>Stop Spammers in total has stopped <a href="" onclick="showcheat();return false;" class="green"><?php echo $spmcount; ?></a> spammers since <?php echo $spmdate; ?>.</p>
<div id="cheater" style="display:none">
This is cheating! Enter a new Total Spam Count:<br />
<form method="post" action="">
<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce;?>" />
<input type="hidden" name="update_total" value="Update Total" />
Count:<input type="text" name="spmcount" value="<?php echo $spmcount; ?>" /><br />
Date: <input type="text" name="spmdate" value="<?php echo $spmdate; ?>" /><br />
<p class="submit" style="clear:both"><input class="button-primary" value="Update Total Spam" type="submit" /></p>
</form>
</p>
</div>
<?php 
}
if ($spcount>0) {
?>
<p>Stop Spammers has stopped <span class="green"><?php echo $spcount; ?></span> spammers since <?php echo $spdate; ?>.</p>
<?php 
}
$num_comm = wp_count_comments( );
$num = number_format_i18n($num_comm->spam);
if ($num_comm->spam>0 && SS_MU!='Y') {	
?>
<p>There are <a href='edit-comments.php?comment_status=spam'><?php echo $num; ?></a> spam comments waiting for you to report them.</p>
<?php 
}
$num_comm = wp_count_comments( );
$num = number_format_i18n($num_comm->moderated);
if ($num_comm->moderated>0 && SS_MU!='Y') {	
?>
<p>There are <a href='edit-comments.php?comment_status=moderated'><?php echo $num; ?></a> comments waiting to be moderated.</p>
<?php 
}
$summry='';
foreach($counters as $v1=>$v2) {
if (!empty($stats[$v1])) {
$summry.= "<div class='stat-box'>$v2: ".$stats[$v1]."</div>";
} else {
// echo "  $v1 - $v2 , ";
}
}
$addonstats=$stats['addonstats'];
foreach($addonstats as $key=>$data) {
// count is in data[0] and use the plugin name
$summry.= "<div class='stat-box'>$key: ".$data[0]."</div>";
}
if (!empty($summry)) {
?>
<?php
}
$ip =ss_get_ip();
?>
<p>Your current IP address is: <span class="green"><?php echo $ip; ?></span><p>
<?php
// check the IP to see if we are local
$ansa=be_load('chkvalidip',ss_get_ip());
if ($ansa==false) {
$ansa=be_load('chkcloudflare',ss_get_ip());
}
if ($ansa!==false) {
?>
<p>This address is invalid for testing for the following reason: 
<span style="font-weight:bold;font-size:1.2em"><?php echo $ansa;?></span>.<br />
If you working on a local installation of WordPress, this might be OK. However, if the plugin reports that your IP is invalid it may be because you are using Cloudflare or a proxy server to access this page. This will make it impossible for the plugin to check IP addresses. You may want to go to the Stop Spammers Testing page in order to test all possible reasons that your IP is not appearing as the IP of the machine that your using to browse this site.<br />
It is possible to use the plugin if this problem appears, but most checking functions will be turned off. The plugin will still perform spam checks which do not require an IP.<br />
If the error says that this is a Cloudflare IP address, you can fix this by installing the Cloudflare plugin. If you use Cloudflare to protect and speed up your site then you MUST install the Cloudflare plugin. This plugin will be crippled until you install it.</p>
<?php
}
// need the current guy
$sname='';
if (isset($_SERVER['REQUEST_URI'])) $sname=$_SERVER["REQUEST_URI"];	
if (empty($sname)) {
$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
$sname=$_SERVER["SCRIPT_NAME"];	
}
if (strpos($sname,'?')!==false) $sname=substr($sname,0,strpos($sname,'?'));
?>
<fieldset>
<legend><span style="font-weight:bold;font-size:1.2em">Summary of Spam</span></legend>
<?php
echo $summry;
?>
<form method="post" action="">
<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>" />
<input type="hidden" name="clear" value="clear summary" />
<p class="submit" style="clear:both"><input class="button-primary" value="Clear Summary" type="submit" /></p>
</form>
</fieldset>
<h2>Get Support and Help Improve Stop Spammers</h2>
<p>First, <a href="https://github.com/bhadaway/stop-spammers/wiki/faqs" target="_blank">read the FAQs page</a>. Then, please post all issues, bugs, typos, questions, suggestions, requests, and complaints <a href="https://github.com/bhadaway/stop-spammers/issues" target="_blank">on GitHub</a>. Thank you.</p>
<h2>Plugin Options</h2>
<ul>
<li><a href="?page=stop_spammers">Summary</a>: This checks to see if there may be problems from your current incoming IP address and displays a summary of events.</li>
<li><a href="?page=ss_options">Protection Options</a>: This has all the options for checking for spam and logins. You can also block whole countries.</li>
<li><a href="?page=ss_allow_list">Allow Lists</a>: Here you can set up your Allow List to allow IP addresses to login and leave comments on your site, without being checked for spam. It also sets up the options which you can use to allow certain kinds of users into your site, even though they may trigger spam detection.</li>
<li><a href="?page=ss_deny_list">Block Lists</a>: This is where you set up your Deny List for IPs and email. It also allows you to enter spam words and phrases that trigger spam.</li>
<li><a href="?page=ss_challenge">Challenge &amp; Deny</a>: This sets up CAPTCHA and notification options. You can give users who trigger the plugin a second chance to use a CAPTCHA. Supports Google ReCaptcha and Solve Media CAPTCHA.</li>
<li><a href="?page=ss_allowrequests">Allow Requests</a>: Displays users who were denied and filled out the form requesting access to your site.</li>
<li><a href="?page=ss_webservices_settings">Web Services</a>: This is where you enter the API keys for StopForumSpam.com and other web checking services. You don't need to have these set for the plugin to work, but if you do, you will have better protection and the ability to report spam.</li>
<li><a href="?page=ss_cache">Cache</a>: Shows the cache of recently detected events.</li>
<li><a href="?page=ss_reports">Log Report</a>: Shows details of the most recent events detected by Stop Spammers.</li>
<li><a href="?page=ss_diagnostics">Diagnostics</a>: You can use this to test an IP, email or, comment against all of the options. This can tell you more about why an IP address might fail. It will also show you any options that might crash the plugin on your site due to system settings.</li>
</ul>
<h2>Beta Options</h2>
<span class="notice notice-warning" style="display:block">
<p>These features are to be considered experimental. Use with caution and at your own risk.</p>
</span>
<ul>
<li><a href="?page=ss_option_maint">DB Cleanup</a>: Delete leftover options from deleted plugins or anything that appears suspicious.</li>
<li><a href="?page=ss_threat_scan">Threat Scan</a>: A simple scan to find possibly malicious code.</li>
</ul>
</div>