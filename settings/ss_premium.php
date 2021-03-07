<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

if ( !current_user_can( 'manage_options' ) ) {
	die( __( 'Access Blocked', 'stop-spammer-registrations-plugin' ) );
}

?>

<div id="ss-plugin" class="wrap">
	<h1 class="ss_head"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/stop-spammers-premium.png'; ?>" class="ss_icon">Stop Spammers — <?php _e( 'Premium Options', 'stop-spammer-registrations-plugin' ); ?></h1>
	<br />
	<span class="notice notice-warning" style="display:block">
		<p><?php _e( 'Use coupon code <strong>SSP4ME</strong> to get $5 off <a href="https://stopspammers.io/downloads/stop-spammers-premium/">Stop Spammers Premium</a>.', 'stop-spammer-registrations-plugin' ); ?></p>
	</span>
	<br />
	<div class="ss_admin_info_boxes_3row">
		<div class="ss_admin_info_boxes_3col">
			<h3><?php _e( 'Server Side Firewall', 'stop-spammer-registrations-plugin' ); ?></h3>
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/firewall_stop-spammers-premium.png'; ?>" class="center_thumb">
			<?php _e( 'Hands-free & lightweight blocking bad bots before they load a web page or reach a form on your site. Compatible with the WordFence firewall.', 'stop-spammer-registrations-plugin' ); ?>
		</div>
		<div class="ss_admin_info_boxes_3col">
			<h3><?php _e( 'Honeypot Protection', 'stop-spammer-registrations-plugin' ); ?></h3>
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/honeypot_stop-spammers-premium_trumani.png'; ?>" class="center_thumb">
			<?php _e( 'Avoid the inconvenience of a captcha and thwart spam bots with a honeypot, which is enabled on our core Login and Contact Forms and on Contact Form 7.', 'stop-spammer-registrations-plugin' ); ?>
		</div>
		<div class="ss_admin_info_boxes_3col">
			<h3><?php _e( 'Themed Login', 'stop-spammer-registrations-plugin' ); ?></h3>
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/themed-login_stop-spammers-premium_trumani.png'; ?>" class="center_thumb">
			<?php _e( 'Frontend login and registration forms that are protected by Stop Spammers and login/logout links you can add to any menu. Ability to disable wp-login.php.', 'stop-spammer-registrations-plugin' ); ?>
		</div>
	</div>
	<div class="ss_admin_info_boxes_3row">
		<div class="ss_admin_info_boxes_3col">
			<h3><?php _e( 'Contact Form', 'stop-spammer-registrations-plugin' ); ?></h3>
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/contact-form_stop-spammers-premium_trumani.png'; ?>" class="center_thumb">
			<?php _e( 'A super lightweight form protected by Stop Spammers that we can style for you to match your theme.', 'stop-spammer-registrations-plugin' ); ?>
		</div>
		<div class="ss_admin_info_boxes_3col">
			<h3><?php _e( 'Restore Default Settings', 'stop-spammer-registrations-plugin' ); ?></h3>
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/restore-settings_stop-spammers_trumani.png'; ?>" class="center_thumb">
			<?php _e( 'Too fargone? Revert to the out-of-the box configurations.', 'stop-spammer-registrations-plugin' ); ?>
		</div>
		<div class="ss_admin_info_boxes_3col">
			<h3><?php _e( 'Import/Export Settings', 'stop-spammer-registrations-plugin' ); ?></h3>
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/import-export_stop-spammers_trumani.png'; ?>" class="center_thumb">
			<?php _e( 'You can download your personalized configurations and upload them to other sites. You can also save the log report entries.', 'stop-spammer-registrations-plugin' ); ?>
		</div>
	</div>
	<div class="ss_admin_button">
		<a href="https://stopspammers.io/downloads/stop-spammers-premium/"><?php _e( 'Get Premium', 'stop-spammer-registrations-plugin' ); ?></a>
	</div>
</div>