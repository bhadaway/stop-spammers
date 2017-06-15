<?php
if (!defined('ABSPATH')) exit; // just in case
if (!current_user_can('manage_options')) {
die('Access Denied');
}
ss_fix_post_vars();
$now=date('Y/m/d H:i:s',time() + ( get_option( 'gmt_offset' ) * 3600 ));
$options=ss_get_options();
extract($options);
$nonce='';
if (array_key_exists('ss_stop_spammers_control',$_POST)) $nonce=$_POST['ss_stop_spammers_control'];
if (!empty($nonce) && wp_verify_nonce($nonce,'ss_stopspam_update')) { 
if (array_key_exists('blist',$_POST)) {
$blist=$_POST['blist'];
if(empty($blist)) $blist=array(); else $blist=explode("\n",$blist);
$tblist=array();
foreach($blist as $bl) {
$bl=trim($bl);
if (!empty($bl)) $tblist[]=$bl;
}
$options['blist']=$tblist;				
$blist=$tblist;
}
if (array_key_exists('spamwords',$_POST)) {
$spamwords=$_POST['spamwords'];
if(empty($spamwords)) $spamwords=array(); else $spamwords=explode("\n",$spamwords);
$tblist=array();
foreach($spamwords as $bl) {
$bl=trim($bl);
if (!empty($bl)) $tblist[]=$bl;
}
$options['spamwords']=$tblist;				
$spamwords=$tblist;
}
if (array_key_exists('badTLDs',$_POST)) {
$badTLDs=$_POST['badTLDs'];
if(empty($badTLDs)) $badTLDs=array(); else $badTLDs=explode("\n",$badTLDs);
$tblist=array();
foreach($badTLDs as $bl) {
$bl=trim($bl);
if (!empty($bl)) $tblist[]=$bl;
}
$options['badTLDs']=$tblist;				
$badTLDs=$tblist;
}
if (array_key_exists('badagents',$_POST)) {
$badagents=$_POST['badagents'];
if(empty($badagents)) $badagents=array(); else $badagents=explode("\n",$badagents);
$tblist=array();
foreach($badagents as $bl) {
$bl=trim($bl);
if (!empty($bl)) $tblist[]=$bl;
}
$options['badagents']=$tblist;				
$badagents=$tblist;
}
// check box setting
$optionlist= array(
'chkspamwords',
'chkbluserid',
'chkagent'
);
foreach ($optionlist as $check) {
$v='N';
if(array_key_exists($check,$_POST)) {
$v=$_POST[$check];
if ($v!='Y') $v='N';
} 
$options[$check]=$v;
}
ss_set_options($options);
extract($options);
$msg='<div class="notice notice-success"><p>Options Updated</p></div>';
}
$nonce=wp_create_nonce('ss_stopspam_update');
?>
<div id="ss-plugin" class="wrap">
<h1>Stop Spammers — Block Lists</h1>
<?php if (!empty($msg)) echo "$msg"; ?>
<form method="post" action="">
<input type="hidden" name="action" value="update" />
<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>" />
<fieldset>
<legend><span style="font-weight:bold;font-size:1.2em">Block List</span></legend>
<p>Put IP addresses or emails here that you want blocked. One email or IP to a line.<br />
You can mix email addresses and IP numbers. You can use IPV4 or IPV6 numbers. You can use CIDR format to block a range (e.g. 1.2.3.4/16) or you can use wild cards (e.g. spammer@spam.* or 1.2.3.*).<br />
You can also use this to deny user ids. This is usually not useful as spammers can change the user id that they use.<br />
To block userids in this list, check this box. 
<input name="chkbluserid" type="checkbox" value="Y" <?php if ($chkbluserid=='Y') echo "checked=\"checked\""; ?> /></p>
<p>These are checked after the Allow List so the Allow List overrides any blocking.</p>
<textarea name="blist" cols="40" rows="8"><?php 
foreach($blist as $p) {
echo $p."\r\n";
}
?>
</textarea>
</fieldset>
<br />
<fieldset>
<legend><span style="font-weight:bold;font-size:1.2em">Spam Words List</span></legend>
<p>Use the spam words list to check comment body, email, and author fields. If a word here shows up in an email address or author field then block the comment. (wild cards do not work here)<br />
Check Spam Words: <input name="chkspamwords" type="checkbox" value="Y" <?php if ($chkspamwords=='Y') echo "checked=\"checked\""; ?> /><br />
Add or delete spam words (one word per line):</p>
<textarea name="spamwords" cols="40" rows="8"><?php
foreach($spamwords as $p) {
echo $p."\r\n";
}
?>
</textarea>
</fieldset>
<br />
<fieldset>
<legend><span style="font-weight:bold;font-size:1.2em">Bad User Agents List</span></legend>
<p>Browsers always include a user agent string when they access a site. A missing user agent is usually a spammer using poorly written software or a leech who is stealing the pages from your site. This option checks for a variety of user agents such as WGET and PHP, Java, or Ruby language standard agents. It also checks for known abusive robots that sometimes submit forms.<br />
Check Agents: <input name="chkagent" type="checkbox" value="Y" <?php if ($chkagent=='Y') echo "checked=\"checked\""; ?> /><br />
Add or delete agent strings (one word per line):</p>
<textarea name="badagents" cols="40" rows="8"><?php
foreach($badagents as $p) {
echo $p."\r\n";
}
?>
</textarea>
<br />
<p>This is a string search so that all you have to enter is enough of the agent to match. Telesoft matches Telesoft Spider or Telesoft 3.2.</p>
</fieldset>
<br />
<fieldset>
<legend><span style="font-weight:bold;font-size:1.2em">Blocked TLDs</span></legend>
<p>Enter the TLD name including the '.' e.g. .XXX<br />
<strong>This only works for email addresses entered by the user.</strong><br />
This will block all comments and registrations that use this TLD in domains for emails.<br />
If you have a problem with a more complex sub-domains you can also use this to check anything after the first period. 
This is not for stopping domains, though. Entering '.xxx.ru' will stop 'user@mail.xxx.ru',
but it will not stop 'user@xxx.ru'. 
Blocked TLDs (One TLD per line not case sensitive):</p>
<textarea name="badTLDs" cols="40" rows="8"><?php
foreach($badTLDs as $p) {
echo $p."\r\n";
}
?>
</textarea><br />
<p>A TLD is the last part of a domain like .COM or .NET. You can block emails from various countries this way by adding a TLD such as .CN or .RU (these will block Russia and China). It will not block the whole country.<br />
A list of TLDs can be found at <a href="https://wikipedia.org/wiki/List_of_Internet_top-level_domains" target="_blank">Wikipedia list of internet top-level domains</a>.</p>
</fieldset>
<br />
<p class="submit"><input class="button-primary" value="Save Changes" type="submit" /></p>
</form>
</div>