<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // just in case
if ( ! current_user_can( 'manage_options' ) ) {
	die( 'Access Denied' );
}
ss_fix_post_vars();
$now     = date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
$options = ss_get_options();
extract( $options );
$nonce = '';
if ( array_key_exists( 'ss_stop_spammers_control', $_POST ) ) {
	$nonce = $_POST['ss_stop_spammers_control'];
}
if ( ! empty( $nonce ) && wp_verify_nonce( $nonce, 'ss_stopspam_update' ) ) {
	if ( array_key_exists( 'action', $_POST ) ) {
// other API keys
		if ( array_key_exists( 'apikey', $_POST ) ) {
			$apikey            = stripslashes( $_POST['apikey'] );
			$options['apikey'] = $apikey;
		}
		if ( array_key_exists( 'googleapi', $_POST ) ) {
			$googleapi            = stripslashes( $_POST['googleapi'] );
			$options['googleapi'] = $googleapi;
		}
		if ( array_key_exists( 'honeyapi', $_POST ) ) {
			$honeyapi            = stripslashes( $_POST['honeyapi'] );
			$options['honeyapi'] = $honeyapi;
		}
		if ( array_key_exists( 'botscoutapi', $_POST ) ) {
			$botscoutapi            = stripslashes( $_POST['botscoutapi'] );
			$options['botscoutapi'] = $botscoutapi;
		}
		if ( array_key_exists( 'sfsfreq', $_POST ) ) {
			$sfsfreq            = stripslashes( $_POST['sfsfreq'] );
			$options['sfsfreq'] = $sfsfreq;
		}
		if ( array_key_exists( 'sfsage', $_POST ) ) {
			$sfsage            = stripslashes( $_POST['sfsage'] );
			$options['sfsage'] = $sfsage;
		}
		if ( array_key_exists( 'hnyage', $_POST ) ) {
			$hnyage            = stripslashes( $_POST['hnyage'] );
			$options['hnyage'] = $hnyage;
		}
		if ( array_key_exists( 'hnylevel', $_POST ) ) {
			$hnylevel            = stripslashes( $_POST['hnylevel'] );
			$options['hnylevel'] = $hnylevel;
		}
		if ( array_key_exists( 'botfreq', $_POST ) ) {
			$botfreq            = stripslashes( $_POST['botfreq'] );
			$options['botfreq'] = $botfreq;
		}
		$optionlist = array( 'chksfs', 'chkdnsbl' );
		foreach ( $optionlist as $check ) {
			$v = 'N';
			if ( array_key_exists( $check, $_POST ) ) {
				$v = $_POST[ $check ];
				if ( $v != 'Y' ) {
					$v = 'N';
				}
			}
			$options[ $check ] = $v;
		}
		ss_set_options( $options );
		extract( $options ); // extract again to get the new options
	}
	if ( ! is_plugin_active( 'stop-spammers-premium/stop-spammers-premium.php' ) ) {
		$msg = '<div class="notice notice-success is-dismissible"><p>Options Updated! Need a firewall, themable login, honeypot for Divi / Elementor / CF7 / bbPress? — <strong><a href="https://stopspammers.io/downloads/stop-spammers-premium/" target="_blank">Try Premium</a></strong></p></div>';
	} else {
		$msg = '<div class="notice notice-success is-dismissible"><p>Options Updated!</p></div>';
	}
}
$nonce = wp_create_nonce( 'ss_stopspam_update' );
?>
<div id="ss-plugin" class="wrap">
    <h1 class="ss_head">Stop Spammers — Web Services</h1>
	<?php if ( ! empty( $msg ) ) {
		echo "$msg";
	} ?>
<br />
	<div class="ss_info_box">
    <p>Below are several services that can be enabled to check for spam or protect
        your website against spammers. To learn more about each service and find links to create keys, please <a href="https://stopspammers.io/web-services" target="_blank">review our documentation</a>.</p></div>
<br />
    <form method="post" action="">
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>" />
        <div class="checkbox switcher">
      <label id="ss_subhead" for="chkdnsbl">
            <input class"ss_toggle" type="checkbox" id="chkdnsbl" name="chkdnsbl" value="Y" <?php if ( $chkdnsbl == 'Y' ) {
					echo "checked=\"checked\"";
} ?> /><span><small></small></span>
		  <small><span style="font-size:16px!important;">Check Against DNSBL Lists Such as Spamhaus.org</span></small></label></div>      
        <br />		

			<div class="checkbox switcher">
      <label id="ss_subhead" for="chksfs">
            <input class"ss_toggle" type="checkbox" id="chksfs" name="chksfs" value="Y" <?php if ( $chksfs == 'Y' ) {
					echo "checked=\"checked\"";
} ?> /><span><small></small></span>
		  <small><span style="font-size:16px!important;">Enable Stop Forum Spam Lookups</span></small></label></div>
				<br />
            <table cellspacing="1" style="background-color:#ccc;font-size:0.9em;margin-left:30px;">
                <tr bgcolor="white">
                    <td valign="top">Deny spammers found on Stop Forum Spam with
                        more than
                        <input size="3" name="sfsfreq" type="text" class="small-text" value="<?php echo $sfsfreq; ?>" />
                        incidents, and occurring less than
                        <input size="4" name="sfsage" type="text" class="small-text" value="<?php echo $sfsage; ?>" />
                        days ago.
                    </td>
                </tr>
            </table>
			<br />
        <br />
				<span class="keyhead">StopForumSpam.com API Key</span>
            <input size="32" name="apikey" type="text" value="<?php echo $apikey; ?>" /><br />
			<br />
				<span class="keyhead">Project Honeypot API Key</span>
            <input size="32" name="honeyapi" type="text" value="<?php echo $honeyapi; ?>" /><br />
			<br />
            <table cellspacing="1" style="background-color:#ccc;font-size:0.9em;margin-left:30px;">
                <tr bgcolor="white">
                    <td valign="top">Deny spammers found on Project HoneyPot
                        with incidents less than
                        <input size="3" name="hnyage" type="text" class="small-text" value="<?php echo $hnyage; ?>" />
                        days ago, and with more than
                        <input size="4" name="hnylevel" type="text" class="small-text" value="<?php echo $hnylevel; ?>" />
                        threat level. (25 threat level is average, threat level
                        5 is fairly low.)
                    </td>
                </tr>
            </table>
        <br />
	<br />
			<span class="keyhead">BotScout API Key</span>
            <input size="32" name="botscoutapi" type="text" value="<?php echo $botscoutapi; ?>" /><br />
		<br />
            <table cellspacing="1" style="background-color:#ccc;font-size:0.9em;margin-left:30px;">
                <tr bgcolor="white">
                    <td valign="top">Deny spammers found on BotScout with more
                        than
                        <input size="3" name="botfreq" type="text" class="small-text" value="<?php echo $botfreq; ?>" />
                        incidents.
                    </td>
                </tr>
            </table>
        <br />
	<br />
			<span class="keyhead">Google Safe Browsing API Key</span>
            <input size="32" name="googleapi" type="text" value="<?php echo $googleapi; ?>" /><br />
        <br />
        <p class="submit"><input class="button-primary" value="Save Changes" type="submit" /></p>
    </form>
</div>
