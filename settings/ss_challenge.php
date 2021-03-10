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
// $ip = ss_get_ip();
$nonce   = '';
$msg	 = '';

if ( array_key_exists( 'ss_stop_spammers_control', $_POST ) ) {
	$nonce = $_POST['ss_stop_spammers_control'];
}

if ( wp_verify_nonce( $nonce, 'ss_stopspam_update' ) ) {
	if ( array_key_exists( 'action', $_POST ) ) {
		$optionlist = array( 'redir', 'notify', 'emailrequest', 'wlreq' );
		foreach ( $optionlist as $check ) {
			$v = 'N';
			if ( array_key_exists( $check, $_POST ) ) {
				$v = sanitize_text_field( $_POST[$check] );
				if ( $v != 'Y' ) {
					$v = 'N';
				}
			}
			$options[$check] = $v;
		}
		// other options
		if ( array_key_exists( 'redirurl', $_POST ) ) {
			$redirurl			 = esc_url( trim( $_POST['redirurl'] ) );
			$options['redirurl'] = $redirurl;
		}
		if ( array_key_exists( 'wlreqmail', $_POST ) ) {
			$wlreqmail			  = sanitize_email( trim( $_POST['wlreqmail'] ) );
			$options['wlreqmail'] = $wlreqmail;
		}
		if ( array_key_exists( 'rejectmessage', $_POST ) ) {
			$rejectmessage			  = sanitize_textarea_field( trim( $_POST['rejectmessage'] ) );
			$options['rejectmessage'] = $rejectmessage;
		}
		if ( array_key_exists( 'chkcaptcha', $_POST ) ) {
			$chkcaptcha			   = sanitize_text_field( trim( $_POST['chkcaptcha'] ) );
			$options['chkcaptcha'] = $chkcaptcha;
		}
		// added the API key stiff for Captchas
		if ( array_key_exists( 'recaptchaapisecret', $_POST ) ) {
			$recaptchaapisecret			   = sanitize_text_field( $_POST['recaptchaapisecret'] );
			$options['recaptchaapisecret'] = $recaptchaapisecret;
		}
		if ( array_key_exists( 'recaptchaapisite', $_POST ) ) {
			$recaptchaapisite			 = sanitize_text_field( $_POST['recaptchaapisite'] );
			$options['recaptchaapisite'] = $recaptchaapisite;
		}
		if ( array_key_exists( 'solvmediaapivchallenge', $_POST ) ) {
			$solvmediaapivchallenge			   = sanitize_text_field( $_POST['solvmediaapivchallenge'] );
			$options['solvmediaapivchallenge'] = $solvmediaapivchallenge;
		}
		if ( array_key_exists( 'solvmediaapiverify', $_POST ) ) {
			$solvmediaapiverify			   = sanitize_text_field( $_POST['solvmediaapiverify'] );
			$options['solvmediaapiverify'] = $solvmediaapiverify;
		}
		// validate the chkcaptcha variable
		if ( $chkcaptcha == 'G' && ( $recaptchaapisecret == '' || $recaptchaapisite == '' ) ) {
			$chkcaptcha			   = 'Y';
			$options['chkcaptcha'] = $chkcaptcha;
			$msg				   = __( 'You cannot use Google reCAPTCHA unless you have entered an API key.', 'stop-spammer-registrations-plugin' );
		}
		if ( $chkcaptcha == 'S' && ( $solvmediaapivchallenge == '' || $solvmediaapiverify == '' ) ) {
			$chkcaptcha			   = 'Y';
			$options['chkcaptcha'] = $chkcaptcha;
			$msg				   = __( 'You cannot use Solve Media CAPTCHA unless you have entered an API key.', 'stop-spammer-registrations-plugin' );
		}
		ss_set_options( $options );
		extract( $options ); // extract again to get the new options
	}
	$update = '<div class="notice notice-success is-dismissible"><p>' . __( 'Options Updated', 'stop-spammer-registrations-plugin' ) . '</p></div>';
}

$nonce = wp_create_nonce( 'ss_stopspam_update' );

?>

<div id="ss-plugin" class="wrap">
	<h1 class="ss_head">Stop Spammers — <?php _e( 'Challenge & Block', 'stop-spammer-registrations-plugin' ); ?></h1>
	<?php if ( !empty( $update ) ) {
		echo "$update";
	} ?>
	<?php if ( !empty( $msg ) ) {
		echo '<span style="color:red;font-size:1.2em">' . $msg . '</span>';
	} ?>
	<form method="post" action="">
		<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>" />
		<input type="hidden" name="action" value="update challenge" />
		<br />
		<div class="mainsection"><?php _e( 'Access Blocked Message', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://stopspammers.io/documentation/challenge-and-block/#accessblocked" target="_blank"><i class="fa fa-question-circle fa-2x tooltip"></i></a></sup>
		</div>
		<textarea id="rejectmessage" name="rejectmessage" cols="40" rows="5"><?php echo $rejectmessage; ?></textarea>
		<br />
		<div class="mainsection"><?php _e( 'Routing and Notifications', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://stopspammers.io/documentation/challenge-and-block/#visitorexp" target="_blank"><i class="fa fa-question-circle fa-2x tooltip"></i></a></sup>
		</div>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="redir">
				<input class="ss_toggle" type="checkbox" id="redir" name="redir" value="Y" onclick="ss_show_option()" <?php if ( $redir == 'Y' ) { echo 'checked="checked"'; } ?> /><span><small></small></span>
		  		<small><span style="font-size:16px!important"><?php _e( 'Send Visitor to Another Web Page', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br />
		<span id="ss_show_option" style="margin-left:30px;margin-bottom:15px;display:none"><?php _e( 'Redirect URL:', 'stop-spammer-registrations-plugin' ); ?>
		<input size="77" name="redirurl" type="text" placeholder="e.g. https://example.com/privacy-policy/" value="<?php echo $redirurl; ?>" /></span>
		<script>
		function ss_show_option() {
			var checkBox = document.getElementById("redir");
			var text = document.getElementById("ss_show_option");
			if (checkBox.checked == true) {
				text.style.display = "block";
			} else {
				text.style.display = "none";
			}
		}
		ss_show_option();
		</script>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="wlreq">
				<input class="ss_toggle" type="checkbox" id="wlreq" name="wlreq" value="Y" <?php if ( $wlreq == 'Y' ) { echo 'checked="checked"'; } ?> /><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Blocked users see the Allow Request form', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br />
		<div class="checkbox switcher">
			<label id="ss_subhead" for="notify">
				<input class="ss_toggle" type="checkbox" id="notify" name="notify" value="Y" onclick="ss_show_notify()" <?php if ( $notify == 'Y' ) { echo 'checked="checked"'; } ?> /><span><small></small></span>
		  		<small><span style="font-size:16px!important;"><?php _e( 'Notify Web Admin when a user requests to be added to the Allow List', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br />
		<span id="ss_show_notify" style="margin-left:30px;margin-bottom:15px;display:none"><?php _e( '(Optional) Specify where email requests are sent:', 'stop-spammer-registrations-plugin' ); ?>
		<input id="ssinput" size="48" name="wlreqmail" type="text" value="<?php echo $wlreqmail; ?>" /></span>
		<script>
		function ss_show_notify() {
			var checkBox = document.getElementById("notify");
			var text = document.getElementById("ss_show_notify");
			if (checkBox.checked == true){
				text.style.display = "block";
			} else {
				text.style.display = "none";
			}
		}
		ss_show_notify();
		</script>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="emailrequest">
				<input class="ss_toggle" type="checkbox" id="emailrequest" name="emailrequest" value="Y" <?php if ( $emailrequest == 'Y' ) { echo 'checked="checked"'; } ?> /><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Notify Requester when a Web Admin has approved their request to be added to the Allow List', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br />
		<br />
		<div class="mainsection"><?php _e( 'CAPTCHA', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://stopspammers.io/documentation/challenge-and-block/#captcha" target="_blank"><i class="fa fa-question-circle fa-2x tooltip"></i></a></sup>
		</div>
		<div style="margin-left:30px">
			<small><span style="font-size:16px!important;"><?php _e( 'Second Chance CAPTCHA Challenge', 'stop-spammer-registrations-plugin' ); ?></span></small>
			<?php
			if ( !empty( $msg ) ) {
				echo '<span style="color:red;font-size:1.2em">' . $msg . '</span>';
			}
			?>
			<br />
			<input type="radio" value="N" name="chkcaptcha" <?php if ( $chkcaptcha == 'N' ) { echo 'checked="checked"'; } ?> />
			<?php _e( 'No CAPTCHA (default)', 'stop-spammer-registrations-plugin' ); ?><br />
			<input type="radio" value="G" name="chkcaptcha" <?php if ( $chkcaptcha == 'G' ) { echo 'checked="checked"'; } ?> />
			<?php _e( 'Google reCAPTCHA', 'stop-spammer-registrations-plugin' ); ?><br />
			<input type="radio" value="S" name="chkcaptcha" <?php if ( $chkcaptcha == 'S' ) { echo 'checked="checked"'; } ?> />
			<?php _e( 'Solve Media CAPTCHA', 'stop-spammer-registrations-plugin' ); ?><br />
			<input type="radio" value="A" name="chkcaptcha" <?php if ( $chkcaptcha == 'A' ) { echo 'checked="checked"'; } ?> />
			<?php _e( 'Arithmetic Question', 'stop-spammer-registrations-plugin' ); ?>
			<p><?php _e( 'To use either the Solve Media or Google reCAPTCHA, you will need an API key.', 'stop-spammer-registrations-plugin' ); ?></p>
		</div>
		<br />
		<div style="margin-left:30px">
			<small><span style="font-size:16px!important;"><?php _e( 'Google reCAPTCHA API Key', 'stop-spammer-registrations-plugin' ); ?></span></small><br />
			<input size="64" name="recaptchaapisite" type="text" placeholder="<?php _e( 'Site Key', 'stop-spammer-registrations-plugin' ); ?>" value="<?php echo $recaptchaapisite; ?>" />
			<br />
			<input size="64" name="recaptchaapisecret" type="text" placeholder="<?php _e( 'Secret Key', 'stop-spammer-registrations-plugin' ); ?>" value="<?php echo $recaptchaapisecret; ?>" />
			<br />
			<?php if ( !empty( $recaptchaapisite ) ) { ?>
				<script src="https://www.google.com/recaptcha/api.js" async defer></script>
				<div class="g-recaptcha" data-sitekey="<?php echo $recaptchaapisite; ?>"></div>
				<?php _e( 'If the reCAPTCHA form looks good, you need to enable the reCAPTCHA on the Challenge &amp; Block options page. (see left)', 'stop-spammer-registrations-plugin' ); ?>
			<?php } ?>
			<br />
			<small><span style="font-size:16px!important"><?php _e( 'Solve Media CAPTCHA API Key', 'stop-spammer-registrations-plugin' ); ?></span></small><br />
			<input size="64" name="solvmediaapivchallenge" type="text" placeholder="<?php _e( 'Challenge Key', 'stop-spammer-registrations-plugin' ); ?>" value="<?php echo $solvmediaapivchallenge; ?>" />
			<br />
			<input size="64" name="solvmediaapiverify" type="text" placeholder="<?php _e( 'Verification Key', 'stop-spammer-registrations-plugin' ); ?>" value="<?php echo $solvmediaapiverify; ?>" />
			<br />
			<?php if ( !empty( $solvmediaapivchallenge ) ) { ?>
				<script src="https://api-secure.solvemedia.com/papi/challenge.script?k=<?php echo $solvmediaapivchallenge; ?>"></script>
				<?php _e( '<p>If the CAPTCHA form looks good, you need to enable the CAPTCHA on the Challenge &amp; Block options page. (see left)</p>', 'stop-spammer-registrations-plugin' ); ?>
			<?php } ?>
		</div>
		<br />
		<br />
		<p class="submit"><input class="button-primary" value="<?php _e( 'Save Changes', 'stop-spammer-registrations-plugin' ); ?>" type="submit" /></p>
	</form>
</div>