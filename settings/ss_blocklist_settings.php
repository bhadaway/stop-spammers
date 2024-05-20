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
	if ( array_key_exists( 'blist', $_POST ) ) {
		$blist = sanitize_textarea_field( $_POST['blist'] );
		if ( empty( $blist ) ) {
			$blist = array();
		} else {
			$blist = explode( "\n", $blist );
		}
		$tblist = array();
		foreach ( $blist as $bl ) {
			$bl = trim( $bl );
			if ( !empty( $bl ) ) {
				$tblist[] = $bl;
			}
		}
		$options['blist'] = $tblist;
		$blist			  = $tblist;
	}
	if ( array_key_exists( 'spamwords', $_POST ) ) {
		$spamwords = sanitize_textarea_field( $_POST['spamwords'] );
		if ( empty( $spamwords ) ) {
			$spamwords = array();
		} else {
			$spamwords = explode( "\n", $spamwords );
		}
		$tblist = array();
		foreach ( $spamwords as $bl ) {
			$bl = trim( $bl );
			if ( !empty( $bl ) ) {
				$tblist[] = $bl;
			}
		}
		$options['spamwords'] = $tblist;
		$spamwords			  = $tblist;
	}
	if ( array_key_exists( 'blockurlshortners', $_POST ) ) {
		$blockurlshortners = sanitize_textarea_field( $_POST['blockurlshortners'] );
		if ( empty( $blockurlshortners ) ) {
			$blockurlshortners = array();
		} else {
			$blockurlshortners = explode( "\n", $blockurlshortners );
		}
		$tblist = array();
		foreach ( $blockurlshortners as $bl ) {
			$bl = trim( $bl );
			if ( !empty( $bl ) ) {
				$tblist[] = $bl;
			}
		}
		$options['blockurlshortners'] = $tblist;
		$blockurlshortners			  = $tblist;
	}
	if ( array_key_exists( 'badTLDs', $_POST ) ) {
		$badTLDs = sanitize_textarea_field( $_POST['badTLDs'] );
		if ( empty( $badTLDs ) ) {
			$badTLDs = array();
		} else {
			$badTLDs = explode( "\n", $badTLDs );
		}
		$tblist = array();
		foreach ( $badTLDs as $bl ) {
			$bl = trim( $bl );
			if ( !empty( $bl ) ) {
				$tblist[] = $bl;
			}
		}
		$options['badTLDs'] = $tblist;
		$badTLDs			= $tblist;
	}
	if ( array_key_exists( 'badagents', $_POST ) ) {
		$badagents = sanitize_textarea_field( $_POST['badagents'] );
		if ( empty( $badagents ) ) {
			$badagents = array();
		} else {
			$badagents = explode( "\n", $badagents );
		}
		$tblist = array();
		foreach ( $badagents as $bl ) {
			$bl = trim( $bl );
			if ( !empty( $bl ) ) {
				$tblist[] = $bl;
			}
		}
		$options['badagents'] = $tblist;
		$badagents			  = $tblist;
	}
	// check box setting
	$optionlist = array(
		'chkspamwords',
		'chkbluserid',
		'chkagent',
		'chkipsync',
		'chkurls'
	);
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
	extract( $options );
	$msg = '<div class="notice notice-success is-dismissible"><p>' . __( 'Options Updated', 'stop-spammer-registrations-plugin' ) . '</p></div>';
}

$nonce = wp_create_nonce( 'ss_stopspam_update' );

?>

<div id="ss-plugin" class="wrap">
	<h1 class="ss_head">Stop Spammers — <?php _e( 'Block Lists', 'stop-spammer-registrations-plugin' ); ?></h1>
	<br>
	<br>
	<?php if ( !empty( $msg ) ) {
		echo $msg;
	} ?>
	<form method="post" action="">
		<input type="hidden" name="action" value="update">
		<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>">
		<div class="mainsection"><?php _e( 'Personalized Block List', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Block-Lists#personalized-block-list" target="_blank">?</a></sup>
		</div>
		<p><?php _e( 'Add IP addresses or emails here that you want blocked.', 'stop-spammer-registrations-plugin' ); ?></p>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkbluserid">
				<input class="ss_toggle" type="checkbox" id="chkbluserid" name="chkbluserid" value="Y" <?php if ( $chkbluserid == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
		  		<small><span style="font-size:16px!important"><?php _e( 'Enable Block by Username', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<textarea name="blist" cols="40" rows="8"><?php
			foreach ( $blist as $p ) {
				echo $p . "\r\n";
			}
		?></textarea>
		<br>
		<br>
		<div class="mainsection"><?php _e( 'Spam Words List', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Block-Lists#spam-words-list" target="_blank">?</a></sup>
		</div>				
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkspamwords">
				<input class="ss_toggle" type="checkbox" id="chkspamwords" name="chkspamwords" value="Y" <?php if ( $chkspamwords == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Check Spam Words', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<textarea name="spamwords" cols="40" rows="8"><?php
			foreach ( $spamwords as $p ) {
				echo $p . "\r\n";
			}
		?></textarea>
		<br>
		<div class="mainsection"><?php _e( 'URL Shortening Services List', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Block-Lists#check-url-shorteners" target="_blank">?</a></sup>
		</div>			
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkurlshort">
				<input class="ss_toggle" type="checkbox" id="chkurlshort" name="chkurlshort" value="Y" <?php if ( $chkurlshort == 'Y' ) { echo 'checked="checked"'; } ?>>
				<span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Check URL Shorteners', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<textarea name="blockurlshortners" cols="40" rows="8"><?php
			foreach ( $blockurlshortners as $p ) {
				echo $p . "\r\n";
			}
		?></textarea>
		<div class="mainsection"><?php _e( 'Check for URLs', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Block-Lists#check-for-urls-in-comments" target="_blank">?</a></sup>
		</div>	
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkurls">
				<input class="ss_toggle" type="checkbox" id="chkurls" name="chkurls" value="Y" <?php if ( $chkurls == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
		  		<small><span style="font-size:16px!important"><?php _e( 'Check for any URL', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="mainsection"><?php _e( 'Bad User Agents List', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Block-Lists#check-agents" target="_blank">?</a></sup>
		</div>	
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkagent">
				<input class="ss_toggle" type="checkbox" id="chkagent" name="chkagent" value="Y" <?php if ( $chkagent == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
		  		<small><span style="font-size:16px!important"><?php _e( 'Check Agents', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<textarea name="badagents" cols="40" rows="8"><?php
			foreach ( $badagents as $p ) {
				echo $p . "\r\n";
			}
		?></textarea>
		<br>
		<br>
		<div class="mainsection"><?php _e( 'Blocked TLDs', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Block-Lists#blocked-tlds" target="_blank">?</a></sup>
		</div>					
		<?php _e( '<p>Enter the TLD name including the period (for example .xxx). A TLD is the last part of a domain like .com or .net.</p>', 'stop-spammer-registrations-plugin' ); ?>
		<textarea name="badTLDs" cols="40" rows="8"><?php
			foreach ( $badTLDs as $p ) {
				echo $p . "\r\n";
			}
		?></textarea>
		<br>
		<br>
		<p class="submit"><input class="button-primary" value="<?php _e( 'Save Changes', 'stop-spammer-registrations-plugin' ); ?>" type="submit"></p>
	</form>
</div>
