<?php
if (!defined('ABSPATH')) exit; // just in case
if (!current_user_can('manage_options')) {
die('Access Denied');
}
ss_fix_post_vars();
$now=date('Y/m/d H:i:s',time() + ( get_option( 'gmt_offset' ) * 3600 ));
$options=ss_get_options();
extract($options);
$chkcloudflare='Y'; // force back to on - always fix Cloudflare if the plugin is not present and Cloudflare detected
$nonce='';
if (array_key_exists('ss_stop_spammers_control',$_POST)) $nonce=$_POST['ss_stop_spammers_control'];
if (!empty($nonce) && wp_verify_nonce($nonce,'ss_stopspam_update')) { 
if (array_key_exists('wlist',$_POST)) {
$wlist=$_POST['wlist'];
$wlist=explode("\n",$wlist);
$tblist=array();
foreach($wlist as $bl) {
$bl=trim($bl);
if (!empty($bl)) $tblist[]=$bl;
}
$options['wlist']=$tblist;				
$wlist=$tblist;
}
$optionlist= array(
'chkgoogle',
'chkaws',
'chkwluserid',
'chkpaypal',
'chkgenallowlist',
'chkmiscallowlist',
'chkyahoomerchant'
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
extract($options); // extract again to get the new options
$msg='<div class="notice notice-success"><p>Options Updated</p></div>';
}
$nonce=wp_create_nonce('ss_stopspam_update');
?>
<div id="ss-plugin" class="wrap">
<h1>Stop Spammers — Allow Lists</h1>
<?php if (!empty($msg)) echo "$msg"; ?>
<form method="post" action="">
<input type="hidden" name="action" value="update" />
<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>" />
<fieldset>
<legend><span style="font-weight:bold;font-size:1.2em">Allow List</span></legend>
<p>Put IP addresses or emails here that you don't want blocked. 
One email or IP to a line. You can use wild cards here for emails.</p>
<p>You may put user ids here, but this is dangerous because spammers can easily find a user's id from previous comments, and add comments using it.
I don't recommend using this. Normally user id checking is turned off so you must check this box to use it.
<input name="chkwluserid" type="checkbox" value="Y" <?php if ($chkwluserid=='Y') echo "checked=\"checked\""; ?> /></p>
<p>These are checked first so they override any blocking.</p>
<textarea name="wlist" cols="40" rows="8"><?php 
for ($k=0;$k<count($wlist);$k++) {
echo $wlist[$k]."\r\n";
}
?>
</textarea>
</fieldset>
<br/>
<h2>Allow Options</h2>
<p>These options will be checked first and will allow some users to continue without being checked further.<br />
You can prevent Google, PayPal and other services from ever being blocked.</p>
<fieldset>
<legend><span style="font-weight:bold;font-size:1.2em">Google</span></legend>
<p><input name="chkgoogle" type="checkbox" value="Y" <?php if ($chkgoogle=='Y') echo  "checked=\"checked\""; ?> />
<strong>DON'T TOUCH.</strong> Google is very important to most websites. This prevents Google from being blocked.</p>
</fieldset>
<br />
<fieldset>
<legend><span style="font-weight:bold;font-size:1.2em">Generated Allow List</span></legend>
<p><input name="chkgenallowlist" type="checkbox" value="Y" <?php if ($chkgenallowlist=='Y') echo "checked=\"checked\""; ?> />
I generate an Allow List of well-behaved and responsible IP blocks in North America, Western Europe, and Australia. 
These are a major source of spam, but also a major source of paying customers. 
Checking this will let in some spam, but will not block residential ISP customers from 
industrialized countries. I don't use this feature.</p>
</fieldset>
<br />
<fieldset>
<legend><span style="font-weight:bold;font-size:1.2em">Other Allow Lists</span></legend>
<p><input name="chkmiscallowlist" type="checkbox" value="Y" <?php if ($chkmiscallowlist=='Y') echo "checked=\"checked\""; ?> />
I am trying to get a list of small web services providers that can be accidentally blocked as bad actors. 
This includes RssGrafitti and VaultPress for now. If you need to white-list another service please let me know.</p>
</fieldset>
<br />
<fieldset>
<legend><span style="font-weight:bold;font-size:1.2em">Allow PayPal</span></legend>
<p><input name="chkpaypal" type="checkbox" value="Y" <?php if ($chkpaypal=='Y') echo "checked=\"checked\""; ?> />
If you accept payment through PayPal, keep this box checked.</p>
</fieldset>
<br />
<fieldset>
<legend><span style="font-weight:bold;font-size:1.2em">Allow Yahoo Merchant Services</span></legend>
<p><input name="chkyahoomerchant" type="checkbox" value="Y" <?php if ($chkyahoomerchant=='Y') echo "checked=\"checked\""; ?> />
If you use Yahoo Merchant Services, keep this box checked.</p>
</fieldset>
<br />
<fieldset>
<legend><span style="font-weight:bold;font-size:1.2em">Allow Amazon Cloud</span></legend>
<p><input name="chkaws" type="checkbox" value="Y" <?php if ($chkaws=='Y') echo "checked=\"checked\""; ?> />
The Amazon Cloud is the source of occasional spam, but they shut it down right away. Lots of startup web services use
Amazon Cloud Servers to host their services. If you use a service to check your site, share on Facebook, or cross post from Twitter,
it may be using Amazon's cloud services. Check this if you want to always allow Amazon AWS.</p>
</fieldset>
<br />
<p class="submit"><input class="button-primary" value="Save Changes" type="submit" /></p>
</form>
</div>