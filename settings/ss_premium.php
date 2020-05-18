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

    <div class="ss_admin_info_boxes_2row">

        <div class="ss_admin_info_boxes_2col">

            <h3>Server Side Firewall</h3>

            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/firewall_stop-spammers-premium.png'; ?>" class="center_thumb">

            Hands-free & lightweight blocking bad bots before they 
			
			load a web page or reach a form on your site.

            <div class="ss_admin_button">

                <a href="https://trumani.com/downloads/stop-spammers-premium/">Get Premium</a>

            </div>

        </div>

        <div class="ss_admin_info_boxes_2col">

            <h3>Restore Default Settings</h3>

            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/restore-settings_stop-spammers_trumani.png'; ?>" class="center_thumb">

            Too fargone? Revert to the out-of-the box configurations.

            <div class="ss_admin_button">

                <a href="https://trumani.com/downloads/stop-spammers-premium/">Get Premium</a>

            </div>

        </div>

        <div class="ss_admin_info_boxes_2col">

            <h3>Import/Export Settings</h3>

            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/import-export_stop-spammers_trumani.png'; ?>" class="center_thumb">

            You can download your personalized configurations and upload them to

            all of your other sites.

            <div class="ss_admin_button">

                <a href="https://trumani.com/downloads/stop-spammers-premium/">Get Premium</a>

            </div>

        </div>

        <div class="ss_admin_info_boxes_2col">

            <h3>Export Log to Excel</h3>

            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/export-to-excel_stop-spammers_trumani.png'; ?>" class="center_thumb">

            Save the log report returns for future reference.

            <div class="ss_admin_button">

                <a href="https://trumani.com/downloads/stop-spammers-premium/">Get Premium</a>

            </div>

        </div>

    </div>

</div>
