<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

if ( !current_user_can( 'manage_options' ) ) {
	die( __( 'Access Blocked', 'stop-spammer-registrations-plugin' ) );
}

ss_fix_post_vars();

?>

<div id="ss-plugin" class="wrap">
	<h1 class="ss_head">Stop Spammers — <?php _e( 'Multisite', 'stop-spammer-registrations-plugin' ); ?></h1>
	<?php
	$now	  = date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
	// $ip=ss_get_ip();
	$ip	      = $_SERVER['REMOTE_ADDR'];
	$nonce	  = '';
	$muswitch = get_option( 'ss_muswitch' );
	if ( empty( $muswitch ) ) {
		$muswitch = 'N';
	}
	if ( array_key_exists( 'ss_stop_spammers_control', $_POST ) ) {
		$nonce = $_POST['ss_stop_spammers_control'];
	}
	if ( wp_verify_nonce( $nonce, 'ss_stopspam_update' ) ) {
		if ( array_key_exists( 'action', $_POST ) ) {
			if ( array_key_exists( 'muswitch', $_POST ) ) {
				$muswitch = trim( stripslashes( sanitize_text_field( $_POST['muswitch'] ) ) );
			}
			if ( empty( $muswitch ) ) {
				$muswitch = 'N';
			}
			if ( $muswitch != 'Y' ) {
				$muswitch = 'N';
			}
			update_option( 'ss_muswitch', $muswitch );
			_e( '<h2>Options Updated</h2>', 'stop-spammer-registrations-plugin' );
		}
	} else {
	// echo "no nonce<br>";
	}
	$nonce = wp_create_nonce( 'ss_stopspam_update' );
	?>
	<form method="post" action="">
		<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>">
		<input type="hidden" name="action" value="update mu settings">
		<span style="font-weight:bold;font-size:1.2em"><?php _e( 'Network Blog Option', 'stop-spammer-registrations-plugin' ); ?></span>
		<p><?php _e( 'Networked ON:', 'stop-spammer-registrations-plugin' ); ?> <input name="muswitch" type="radio" value='Y' <?php if ( $muswitch == 'Y' ) { echo 'checked="true"'; } ?>>
		<br>
		<?php _e( 'Networked OFF:', 'stop-spammer-registrations-plugin' ); ?> <input name="muswitch" type="radio" value='N' <?php if ( $muswitch != 'Y' ) { echo 'checked="true"'; } ?>>
		<br>
		<?php _e( 'If you are running WPMU and want to control options and history through the main login admin panel, select ON. If you select OFF, each blog will have to configure the plugin separately, and each blog will have a separte history.', 'stop-spammer-registrations-plugin' ); ?></p>
		<p class="submit"><input class="button-primary" value="<?php _e( 'Save Changes', 'stop-spammer-registrations-plugin' ); ?>" type="submit"></p>
	</form>
</div>