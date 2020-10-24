<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // just in case

if ( ! current_user_can( 'manage_options' ) ) {
	die( 'Access Denied' );
}
?>

<div id="ss-plugin" class="wrap">
    <h1 class="ss_head"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/stop-spammers-premium.png'; ?>" class="ss_icon">Stop Spammers — Premium Options</h1>
    <br />
	    <span class="notice notice-warning" style="display:block">
        <p>Use coupon code <strong>SSP4ME</strong> to get $5 off <a href="https://trumani.com/downloads/stop-spammers-premium/">Stop Spammers Premium</a>.</p>
    </span>
    <br />
    <div class="ss_admin_info_boxes_3row">
        <div class="ss_admin_info_boxes_3col">
            <h3>Server Side Firewall</h3>
            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/firewall_stop-spammers-premium.png'; ?>" class="center_thumb">
            Hands-free & lightweight blocking bad bots before they 
			load a web page or reach a form on your site.
			Compatible with the WordFence firewall
        </div>
        <div class="ss_admin_info_boxes_3col">
            <h3>Honeypot Protection</h3>
            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/honeypot_stop-spammers-premium_trumani.png'; ?>" class="center_thumb">
            Avoid the inconvenience of a captcha and thwart spam bots with a honeypot, which is enabled on our core Login and Contact Forms and on Contact Form 7
        </div>
        <div class="ss_admin_info_boxes_3col">
            <h3>Themed Login</h3>
            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/themed-login_stop-spammers-premium_trumani.png'; ?>" class="center_thumb">
            Frontend login and registration forms that are protected by Stop Spammers and login/logout links you can add to any menu. Ability to disable wp-login.php
	</div>
	<div class="ss_admin_info_boxes_3row">
        <div class="ss_admin_info_boxes_3col">
            <h3>Contact Form</h3>
            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/contact-form_stop-spammers-premium_trumani.png'; ?>" class="center_thumb">
            A super lightweight form protected by Stop Spammers that we can style for you to match your theme
        </div>
        <div class="ss_admin_info_boxes_3col">
            <h3>Restore Default Settings</h3>
            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/restore-settings_stop-spammers_trumani.png'; ?>" class="center_thumb">
            Too fargone? Revert to the out-of-the box configurations.
        </div>
        <div class="ss_admin_info_boxes_3col">
            <h3>Import/Export Settings</h3>
            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/import-export_stop-spammers_trumani.png'; ?>" class="center_thumb">
            You can download your personalized configurations and upload them to
            other sites. You can also save the log report entries
        </div>
    </div>
	            <div class="ss_admin_button">
                <a href="https://trumani.com/downloads/stop-spammers-premium/">Get Premium</a>
            </div>
</div>
