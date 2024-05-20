<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

if ( !current_user_can( 'manage_options' ) ) {
	die( __( 'Access Blocked', 'stop-spammer-registrations-plugin' ) );
}

ss_fix_post_vars();
$now	 = date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
$options = ss_get_options();
extract( $options );
$nonce   = '';

if ( array_key_exists( 'ss_stop_spammers_control', $_POST ) ) {
	$nonce = $_POST['ss_stop_spammers_control'];
}

if ( !empty( $nonce ) && wp_verify_nonce( $nonce, 'ss_stopspam_update' ) ) {
	if ( array_key_exists( 'action', $_POST ) ) {
		// other API keys
		if ( array_key_exists( 'apikey', $_POST ) ) {
			$apikey			   = stripslashes( sanitize_text_field( $_POST['apikey'] ) );
			$options['apikey'] = $apikey;
		}
		if ( array_key_exists( 'googleapi', $_POST ) ) {
			$googleapi			  = stripslashes( sanitize_text_field( $_POST['googleapi'] ) );
			$options['googleapi'] = $googleapi;
		}
		if ( array_key_exists( 'honeyapi', $_POST ) ) {
			$honeyapi			 = stripslashes( sanitize_text_field( $_POST['honeyapi'] ) );
			$options['honeyapi'] = $honeyapi;
		}
		if ( array_key_exists( 'botscoutapi', $_POST ) ) {
			$botscoutapi			= stripslashes( sanitize_text_field( $_POST['botscoutapi'] ) );
			$options['botscoutapi'] = $botscoutapi;
		}
		if ( array_key_exists( 'sfsfreq', $_POST ) ) {
			$sfsfreq			= stripslashes( sanitize_text_field( $_POST['sfsfreq'] ) );
			$options['sfsfreq'] = $sfsfreq;
		}
		if ( array_key_exists( 'sfsage', $_POST ) ) {
			$sfsage			   = stripslashes( sanitize_text_field( $_POST['sfsage'] ) );
			$options['sfsage'] = $sfsage;
		}
		if ( array_key_exists( 'hnyage', $_POST ) ) {
			$hnyage			   = stripslashes( sanitize_text_field( $_POST['hnyage'] ) );
			$options['hnyage'] = $hnyage;
		}
		if ( array_key_exists( 'hnylevel', $_POST ) ) {
			$hnylevel			 = stripslashes( sanitize_text_field( $_POST['hnylevel'] ) );
			$options['hnylevel'] = $hnylevel;
		}
		if ( array_key_exists( 'botfreq', $_POST ) ) {
			$botfreq			= stripslashes( sanitize_text_field( $_POST['botfreq'] ) );
			$options['botfreq'] = $botfreq;
		}
		$optionlist = array( 'chksfs', 'chkdnsbl' );
		foreach ( $optionlist as $check ) {
			$v = 'N';
			if ( array_key_exists( $check, $_POST ) ) {
				$v = $_POST[$check];
				if ( $v != 'Y' ) {
					$v = 'N';
				}
			}
			$options[$check] = $v;
		}
		ss_set_options( $options );
		extract( $options ); // extract again to get the new options
	}
	$msg = '<div class="notice notice-success is-dismissible"><p>' . __( 'Options Updated', 'stop-spammer-registrations-plugin' ) . '</p></div>';
}
$nonce = wp_create_nonce( 'ss_stopspam_update' );

?>

<div id="ss-plugin" class="wrap">
	<h1 class="ss_head">Stop Spammers — <?php _e( 'Web Services', 'stop-spammer-registrations-plugin' ); ?></h1>
	<?php if ( !empty( $msg ) ) {
		echo $msg;
	} ?>
	<br>
	<div class="ss_info_box">
		<p><?php _e( 'Below are several services that can be enabled to check for spam or protect your website against spammers. To learn more about each service and find links to create keys, please <a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Web-Services" target="_blank">review our documentation</a>.', 'stop-spammer-registrations-plugin' ); ?></p>
	</div>
	<br>
	<form method="post" action="">
		<input type="hidden" name="action" value="update">
		<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>">
		<div class="checkbox switcher">
	  		<label id="ss_subhead" for="chkdnsbl">
				<input class="ss_toggle" type="checkbox" id="chkdnsbl" name="chkdnsbl" value="Y" <?php if ( $chkdnsbl == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
		  		<small><span style="font-size:16px!important;"><?php _e( 'Check Against DNSBL Lists Such as Spamhaus.org', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>	  
		<br>		
		<div class="checkbox switcher">
	  		<label id="ss_subhead" for="chksfs">
				<input class="ss_toggle" type="checkbox" id="chksfs" name="chksfs" value="Y" <?php if ( $chksfs == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
		  		<small><span style="font-size:16px!important;"><?php _e( 'Enable Stop Forum Spam Lookups', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<label class="keyhead">
			<?php _e( 'StopForumSpam.com API Key', 'stop-spammer-registrations-plugin' ); ?>
			<br>
			<input size="32" name="apikey" type="text" value="<?php echo esc_attr( $apikey ); ?>">
		</label>
		<br>
		<table cellspacing="1" style="background-color:#ccc;font-size:0.9em;margin-left:30px">
			<tr bgcolor="white">
				<td valign="top"><?php _e( 'Block spammers found on Stop Forum Spam with more than
					<input size="3" name="sfsfreq" type="text" class="small-text" value="' . esc_attr( $sfsfreq ) . '">
					incidents, and occurring less than
					<input size="4" name="sfsage" type="text" class="small-text" value="' . esc_attr( $sfsage ) . '">
					days ago.', 'stop-spammer-registrations-plugin' ); ?>
				</td>
			</tr>
		</table>
		<br>
		<br>
		<label class="keyhead">
			<?php _e( 'Project Honeypot API Key', 'stop-spammer-registrations-plugin' ); ?>
			<br>
			<input size="32" name="honeyapi" type="text" value="<?php echo esc_attr( $honeyapi ); ?>">
		</label>
		<br>
		<table cellspacing="1" style="background-color:#ccc;font-size:0.9em;margin-left:30px">
			<tr bgcolor="white">
				<td valign="top"><?php _e( 'Block spammers found on Project HoneyPot with incidents less than
					<input size="3" name="hnyage" type="text" class="small-text" value="' . esc_attr( $hnyage ) . '">
					days ago, and with more than
					<input size="4" name="hnylevel" type="text" class="small-text" value="' . esc_attr( $hnylevel ) . '">
					threat level. (25 threat level is average, threat level
					5 is fairly low.)', 'stop-spammer-registrations-plugin' ); ?>
				</td>
			</tr>
		</table>
		<br>
		<br>
		<label class="keyhead">
			<?php _e( 'BotScout API Key', 'stop-spammer-registrations-plugin' ); ?>
			<br>
			<input size="32" name="botscoutapi" type="text" value="<?php echo esc_attr( $botscoutapi ); ?>">
		</label>
		<br>
		<table cellspacing="1" style="background-color:#ccc;font-size:0.9em;margin-left:30px">
			<tr bgcolor="white">
				<td valign="top"><?php _e( 'Block spammers found on BotScout with more than
					<input size="3" name="botfreq" type="text" class="small-text" value="' . esc_attr( $botfreq ) . '">
					incidents.', 'stop-spammer-registrations-plugin' ); ?>
				</td>
			</tr>
		</table>
		<br>
		<br>
		<label class="keyhead">
			<?php _e( 'Google Safe Browsing API Key', 'stop-spammer-registrations-plugin' ); ?>
			<br>
			<input size="32" name="googleapi" type="text" value="<?php echo esc_attr( $googleapi ); ?>">
		</label>
		<br>
		<br>
		<p class="submit"><input class="button-primary" value="<?php _e( 'Save Changes', 'stop-spammer-registrations-plugin' ); ?>" type="submit"></p>
	</form>
</div>