<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // just in case

if ( ! current_user_can( 'manage_options' ) ) {
	die( __( 'Access Denied', 'stop-spammer-registrations-plugin' ) );
}
?>

<div id="ss-plugin" class="wrap">
    <h1 class="ss_head"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/stop-spammers-premium.png'; ?>" class="ss_icon">Stop Spammers — <?php __( 'Premium Options', 'stop-spammer-registrations-plugin' ); ?></h1>
    <br />
	    <span class="notice notice-warning" style="display:block">
        <p><?php __( 'Use coupon code <strong>SSP4ME</strong> to get $5 off <a href="https://stopspammers.io/downloads/stop-spammers-premium/">Stop Spammers Premium</a>.', 'stop-spammer-registrations-plugin' ); ?></p>
    </span>
    <br />
    <div class="ss_admin_info_boxes_3row">
        <div class="ss_admin_info_boxes_3col">
            <h3><?php __( 'Server Side Firewall', 'stop-spammer-registrations-plugin' ); ?></h3>
            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/firewall_stop-spammers-premium.png'; ?>" class="center_thumb">
            <?php __( 'Hands-free & lightweight blocking bad bots before they load a web page or reach a form on your site. Compatible with the WordFence firewall.', 'stop-spammer-registrations-plugin' ); ?>
        </div>
        <div class="ss_admin_info_boxes_3col">
            <h3><?php __( 'Honeypot Protection', 'stop-spammer-registrations-plugin' ); ?></h3>
            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/honeypot_stop-spammers-premium_trumani.png'; ?>" class="center_thumb">
            <?php __( 'Avoid the inconvenience of a captcha and thwart spam bots with a honeypot, which is enabled on our core Login and Contact Forms and on Contact Form 7.', 'stop-spammer-registrations-plugin' ); ?>
        </div>
        <div class="ss_admin_info_boxes_3col">
            <h3><?php __( 'Themed Login', 'stop-spammer-registrations-plugin' ); ?></h3>
            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/themed-login_stop-spammers-premium_trumani.png'; ?>" class="center_thumb">
            <?php __( 'Frontend login and registration forms that are protected by Stop Spammers and login/logout links you can add to any menu. Ability to disable wp-login.php.', 'stop-spammer-registrations-plugin' ); ?>
	</div>
	<div class="ss_admin_info_boxes_3row">
        <div class="ss_admin_info_boxes_3col">
            <h3><?php __( 'Contact Form', 'stop-spammer-registrations-plugin' ); ?></h3>
            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/contact-form_stop-spammers-premium_trumani.png'; ?>" class="center_thumb">
            <?php __( 'A super lightweight form protected by Stop Spammers that we can style for you to match your theme.', 'stop-spammer-registrations-plugin' ); ?>
        </div>
        <div class="ss_admin_info_boxes_3col">
            <h3><?php __( 'Restore Default Settings', 'stop-spammer-registrations-plugin' ); ?></h3>
            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/restore-settings_stop-spammers_trumani.png'; ?>" class="center_thumb">
            <?php __( 'Too fargone? Revert to the out-of-the box configurations.', 'stop-spammer-registrations-plugin' ); ?>
        </div>
        <div class="ss_admin_info_boxes_3col">
            <h3><?php __( 'Import/Export Settings', 'stop-spammer-registrations-plugin' ); ?></h3>
            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/import-export_stop-spammers_trumani.png'; ?>" class="center_thumb">
            <?php __( 'You can download your personalized configurations and upload them to other sites. You can also save the log report entries.', 'stop-spammer-registrations-plugin' ); ?>
        </div>
    </div>
	<div class="ss_admin_button">
        <a href="https://stopspammers.io/downloads/stop-spammers-premium/"><?php __( 'Get Premium', 'stop-spammer-registrations-plugin' ); ?></a>
	</div>
</div>
