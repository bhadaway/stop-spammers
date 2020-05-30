<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // just in case
if ( ! current_user_can( 'manage_options' ) ) {
	die( 'Access Denied' );
}
if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'protect' ) ) {
	echo "<div>Jetpack Protect has been detected. Stop Spammers has disabled itself.<br />Please turn off Jetpack Protect or uninstall Stop Spammers.</div>";

	return;
}
ss_fix_post_vars();
$stats = ss_get_stats();
extract( $stats );
$now = date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
// counter list - this should be copied from the get option utility
// counters should have the same name as the YN switch for the check
// I see lots of missing counters here
$counters = array(
	'cntchkcloudflare'    => 'Pass Cloudflare',
	'cntchkgcache'        => 'Pass Good Cache',
	'cntchkakismet'       => 'Reported by Akismet',
	'cntchkgenallowlist'  => 'Pass Generated Allow List',
	'cntchkgoogle'        => 'Pass Google',
	'cntchkmiscallowlist' => 'Pass Allow List',
	'cntchkpaypal'        => 'Pass PayPal',
	'cntchkscripts'       => 'Pass Scripts',
	'cntchkvalidip'       => 'Pass Uncheckable IP',
	'cntchkwlem'          => 'Allow List Email',
	'cntchkuserid'        => 'Allow User ID/Author',
	'cntchkwlist'         => 'Pass Allow List IP',
	'cntchkyahoomerchant' => 'Pass Yahoo merchant',
	'cntchk404'           => '404 Exploit Attempt',
	'cntchkaccept'        => 'Bad or Missing Accept Header',
	'cntchkadmin'         => 'Admin Login Attempt',
	'cntchkadminlog'      => 'Passed Login OK',
	'cntchkagent'         => 'Bad or Missing User Agent',
	'cntchkamazon'        => 'Amazon AWS',
	'cntchkaws'           => 'Amazon AWS Allow',
	'cntchkbcache'        => 'Bad Cache',
	'cntchkblem'          => 'Deny List Email',
	'cntchkuserid'        => 'Deny User ID/Author',
	'cntchkblip'          => 'Deny List IP',
	'cntchkbotscout'      => 'BotScout',
	'cntchkdisp'          => 'Disposable Email',
	'cntchkdnsbl'         => 'DNSBL Hit',
	'cntchkexploits'      => 'Exploit Attempt',
	'cntchkgooglesafe'    => 'Google Safe Browsing',
	'cntchkhoney'         => 'Project Honeypot',
	'cntchkhosting'       => 'Known Spam Host',
	'cntchkinvalidip'     => 'Block Invalid IP',
	'cntchklong'          => 'Long Email',
	'cntchkshort'         => 'Short Email',
	'cntchkbbcode'        => 'BBCode in Request',
	'cntchkreferer'       => 'Bad HTTP_REFERER',
	'cntchksession'       => 'Session Speed',
	'cntchksfs'           => 'Stop Forum Spam',
	'cntchkspamwords'     => 'Spam Words',
	'cntchktld'           => 'Email TLD',
	'cntchkubiquity'      => 'Ubiquity Servers',
	'cntchkmulti'         => 'Repeated Hits',
	'cntchkform'          => 'Check for Standard Form',
	'cntchkAD'            => 'Andorra',
	'cntchkAE'            => 'United Arab Emirates',
	'cntchkAF'            => 'Afghanistan',
	'cntchkAL'            => 'Albania',
	'cntchkAM'            => 'Armenia',
	'cntchkAR'            => 'Argentina',
	'cntchkAT'            => 'Austria',
	'cntchkAU'            => 'Australia',
	'cntchkAX'            => 'Aland Islands',
	'cntchkAZ'            => 'Azerbaijan',
	'cntchkBA'            => 'Bosnia And Herzegovina',
	'cntchkBB'            => 'Barbados',
	'cntchkBD'            => 'Bangladesh',
	'cntchkBE'            => 'Belgium',
	'cntchkBG'            => 'Bulgaria',
	'cntchkBH'            => 'Bahrain',
	'cntchkBN'            => 'Brunei Darussalam',
	'cntchkBO'            => 'Bolivia',
	'cntchkBR'            => 'Brazil',
	'cntchkBS'            => 'Bahamas',
	'cntchkBY'            => 'Belarus',
	'cntchkBZ'            => 'Belize',
	'cntchkCA'            => 'Canada',
	'cntchkCD'            => 'Congo, Democratic Republic',
	'cntchkCH'            => 'Switzerland',
	'cntchkCL'            => 'Chile',
	'cntchkCN'            => 'China',
	'cntchkCO'            => 'Colombia',
	'cntchkCR'            => 'Costa Rica',
	'cntchkCU'            => 'Cuba',
	'cntchkCW'            => 'CuraÃ§ao',
	'cntchkCY'            => 'Cyprus',
	'cntchkCZ'            => 'Czech Republic',
	'cntchkDE'            => 'Germany',
	'cntchkDK'            => 'Denmark',
	'cntchkDO'            => 'Dominican Republic',
	'cntchkDZ'            => 'Algeria',
	'cntchkEC'            => 'Ecuador',
	'cntchkEE'            => 'Estonia',
	'cntchkES'            => 'Spain',
	'cntchkEU'            => 'European Union',
	'cntchkFI'            => 'Finland',
	'cntchkFJ'            => 'Fiji',
	'cntchkFR'            => 'France',
	'cntchkGB'            => 'Great Britain',
	'cntchkGE'            => 'Georgia',
	'cntchkGF'            => 'French Guiana',
	'cntchkGI'            => 'Gibraltar',
	'cntchkGP'            => 'Guadeloupe',
	'cntchkGR'            => 'Greece',
	'cntchkGT'            => 'Guatemala',
	'cntchkGU'            => 'Guam',
	'cntchkGY'            => 'Guyana',
	'cntchkHK'            => 'Hong Kong',
	'cntchkHN'            => 'Honduras',
	'cntchkHR'            => 'Croatia',
	'cntchkHT'            => 'Haiti',
	'cntchkHU'            => 'Hungary',
	'cntchkID'            => 'Indonesia',
	'cntchkIE'            => 'Ireland',
	'cntchkIL'            => 'Israel',
	'cntchkIN'            => 'India',
	'cntchkIQ'            => 'Iraq',
	'cntchkIR'            => 'Iran, Islamic Republic Of',
	'cntchkIS'            => 'Iceland',
	'cntchkIT'            => 'Italy',
	'cntchkJM'            => 'Jamaica',
	'cntchkJO'            => 'Jordan',
	'cntchkJP'            => 'Japan',
	'cntchkKE'            => 'Kenya',
	'cntchkKG'            => 'Kyrgyzstan',
	'cntchkKH'            => 'Cambodia',
	'cntchkKR'            => 'Korea',
	'cntchkKW'            => 'Kuwait',
	'cntchkKY'            => 'Cayman Islands',
	'cntchkKZ'            => 'Kazakhstan',
	'cntchkLA'            => "Lao People's Democratic Republic",
	'cntchkLB'            => 'Lebanon',
	'cntchkLK'            => 'Sri Lanka',
	'cntchkLT'            => 'Lithuania',
	'cntchkLU'            => 'Luxembourg',
	'cntchkLV'            => 'Latvia',
	'cntchkMD'            => 'Moldova',
	'cntchkME'            => 'Montenegro',
	'cntchkMK'            => 'Macedonia',
	'cntchkMM'            => 'Myanmar',
	'cntchkMN'            => 'Mongolia',
	'cntchkMO'            => 'Macao',
	'cntchkMP'            => 'Northern Mariana Islands',
	'cntchkMQ'            => 'Martinique',
	'cntchkMT'            => 'Malta',
	'cntchkMV'            => 'Maldives',
	'cntchkMX'            => 'Mexico',
	'cntchkMY'            => 'Malaysia',
	'cntchkNC'            => 'New Caledonia',
	'cntchkNI'            => 'Nicaragua',
	'cntchkNL'            => 'Netherlands',
	'cntchkNO'            => 'Norway',
	'cntchkNP'            => 'Nepal',
	'cntchkNZ'            => 'New Zealand',
	'cntchkOM'            => 'Oman',
	'cntchkPA'            => 'Panama',
	'cntchkPE'            => 'Peru',
	'cntchkPG'            => 'Papua New Guinea',
	'cntchkPH'            => 'Philippines',
	'cntchkPK'            => 'Pakistan',
	'cntchkPL'            => 'Poland',
	'cntchkPR'            => 'Puerto Rico',
	'cntchkPS'            => 'Palestinian Territory, Occupied',
	'cntchkPT'            => 'Portugal',
	'cntchkPW'            => 'Palau',
	'cntchkPY'            => 'Paraguay',
	'cntchkQA'            => 'Qatar',
	'cntchkRO'            => 'Romania',
	'cntchkRS'            => 'Serbia',
	'cntchkRU'            => 'Russian Federation',
	'cntchkSA'            => 'Saudi Arabia',
	'cntchkSC'            => 'Seychelles',
	'cntchkSE'            => 'Sweden',
	'cntchkSG'            => 'Singapore',
	'cntchkSI'            => 'Slovenia',
	'cntchkSK'            => 'Slovakia',
	'cntchkSV'            => 'El Salvador',
	'cntchkSX'            => 'Sint Maarten',
	'cntchkSY'            => 'Syrian Arab Republic',
	'cntchkTH'            => 'Thailand',
	'cntchkTJ'            => 'Tajikistan',
	'cntchkTM'            => 'Turkmenistan',
	'cntchkTR'            => 'Turkey',
	'cntchkTT'            => 'Trinidad And Tobago',
	'cntchkTW'            => 'Taiwan',
	'cntchkUA'            => 'Ukraine',
	'cntchkUK'            => 'United Kingdom',
	'cntchkUS'            => 'United States',
	'cntchkUY'            => 'Uruguay',
	'cntchkUZ'            => 'Uzbekistan',
	'cntchkVC'            => 'Saint Vincent And Grenadines',
	'cntchkVE'            => 'Venezuela',
	'cntchkVN'            => 'Viet Nam',
	'cntchkYE'            => 'Yemen',
	'cntcap'              => 'Passed CAPTCHA', // captha success
	'cntncap'             => 'Failed CAPTCHA', // captha not success
	'cntpass'             => 'Total Pass', // passed
);
$message  = "";
$nonce    = '';
if ( array_key_exists( 'ss_stop_spammers_control', $_POST ) ) {
	$nonce = $_POST['ss_stop_spammers_control'];
}
if ( wp_verify_nonce( $nonce, 'ss_stopspam_update' ) ) {
	if ( array_key_exists( 'clear', $_POST ) ) {
		foreach ( $counters as $v1 => $v2 ) {
			$stats[ $v1 ] = 0;
		}
		$addonstats          = array();
		$stats['addonstats'] = $addonstats;
		$msg                 = '<div class="notice notice-success is-dismissible"><p>Summary Cleared</p></div>';
		ss_set_stats( $stats );
		extract( $stats ); // extract again to get the new options
	}
	if ( array_key_exists( 'update_total', $_POST ) ) {
		$stats['spmcount'] = $_POST['spmcount'];
		$stats['spmdate']  = $_POST['spmdate'];
		ss_set_stats( $stats );
		extract( $stats ); // extract again to get the new options
	}
}
$nonce = wp_create_nonce( 'ss_stopspam_update' );
?>
<div id="ss-plugin" class="wrap">
    <h1 class="ss_head"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/stop-spammers-icon.png'; ?>" class="ss_icon" ><?php _e( 'Stop Spammers — Summary', 'stop-spammers' ); ?></h1><br />
    <?php _e( 'Version', 'stop-spammers' ); ?> <strong><?php echo SS_VERSION; ?></strong>
		<?php
	if ( ! empty( $summry ) ) {
		?>
		<?php
	}
	$ip = ss_get_ip();
	?>
	| Your current IP address is: <strong><?php echo $ip; ?></strong>
	<?php
	if ( ! is_plugin_active( 'stop-spammers-premium/stop-spammers-premium.php' ) ) {
		echo ' | <strong>USE CODE SSP4ME FOR $5 OFF THE <a href="https://trumani.com/downloads/stop-spammers-premium/" target="_blank" style="color:#67aeca;text-decoration:none">PREMIUM PLUGIN</a></strong>';
	}
	?>
	<?php
	// check the IP to see if we are local
	$ansa = be_load( 'chkvalidip', ss_get_ip() );
	if ( $ansa == false ) {
		$ansa = be_load( 'chkcloudflare', ss_get_ip() );
	}
	if ( $ansa !== false ) {
		?>
        <p>This address is invalid for testing for the following reason:
            <span style="font-weight:bold;font-size:1.2em"><?php echo $ansa; ?></span>.<br />
            If you working on a local installation of WordPress, this might be
            OK. However, if the plugin reports that your
            IP is invalid it may be because you are using Cloudflare or a proxy
            server to access this page. This will make
            it impossible for the plugin to check IP addresses. You may want to
            go to the Stop Spammers Testing page in
            order to test all possible reasons that your IP is not appearing as
            the IP of the machine that your using to
            browse this site.<br />
            It is possible to use the plugin if this problem appears, but most
            checking functions will be turned off. The
            plugin will still perform spam checks which do not require an
            IP.<br />
            If the error says that this is a Cloudflare IP address, you can fix
            this by installing the Cloudflare plugin. If
            you use Cloudflare to protect and speed up your site then you MUST
            install the Cloudflare plugin. This plugin
            will be crippled until you install it.</p>
	<?php
	}
	// need the current guy
	$sname = '';
	if ( isset( $_SERVER['REQUEST_URI'] ) ) {
		$sname = $_SERVER["REQUEST_URI"];
	}
	if ( empty( $sname ) ) {
		$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
		$sname                  = $_SERVER["SCRIPT_NAME"];
	}
	if ( strpos( $sname, '?' ) !== false ) {
		$sname = substr( $sname, 0, strpos( $sname, '?' ) );
	}
	
	if ( ! empty( $msg ) ) {
		echo "$msg";
	}
	$current_user_name = wp_get_current_user()->user_login;
	
	if ( $current_user_name == 'admin' ) {
		echo "<span class=\"notice notice-warning\" style=\"display:block\">SECURITY RISK: You are using the admin ID \"admin\". This is 
an invitation to hackers to try and guess your password. Please change this.<br />
Here is discussion on WordPress.org:
<a href=\"https://wordpress.org/support/topic/how-to-change-admin-username?replies=4\" target=\"_blank\">How to Change Admin Username</a>
</span>";
	}
	$showcf = false; // hide this for now
	if ( $showcf && array_key_exists( 'HTTP_CF_CONNECTING_IP', $_SERVER )
	     && ! function_exists( 'cloudflare_init' )
	     && ! defined( 'W3TC' )
	) {
		echo "<span class=\"notice notice-warning\" style=\"display:block\">
WARNING: Cloudflare Remote IP address detected. Please install the <a href=\"https://wordpress.org/plugins/cloudflare/\" target=\"_blank\">Cloudflare Plugin</a>.
This plugin works best with the Cloudflare plugin when yout website is using Cloudflare.
</span>";
	}
	?>

<?php	
	/* if ( $spmcount > 0 ) {
		?>
        <script>
            function showcheat() {
                var el = document.getElementById("cheater");
                el.style.display = "block";
                return false;
            }
        </script>
        <p>Stop Spammers in total has stopped <a href="" onclick="showcheat();return false;" class="green"><?php echo $spmcount; ?></a> spammers since <?php echo $spmdate; ?>.</p>
        <div id="cheater" style="display:none">
            Enter a new Total Spam Count:<br />
            <form method="post" action="">
                <input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>" />
                <input type="hidden" name="update_total" value="Update Total" />
                Count: <input type="text" name="spmcount" value="<?php echo $spmcount; ?>" /><br />
                Date: <input type="text" name="spmdate" value="<?php echo $spmdate; ?>" /><br />
                <p class="submit" style="clear:both"><input class="button-primary" value="Update Total Spam" type="submit" /></p>
            </form>
        </div>
		<?php
	} */
?>	

			<h2>Summary of Spam</h2>
        
<div class="main-stats" style="width:95%">
<?php
	 if ( $spcount > 0 ) {
		?>
        <p>Stop Spammers has stopped <strong><?php echo $spcount; ?></strong> spammers since <?php echo $spdate; ?>.</p>
		<?php
	}
	$num_comm = wp_count_comments();
	$num      = number_format_i18n( $num_comm->spam );
	if ( $num_comm->spam > 0 && SS_MU != 'Y' ) {
		?>
        <p>There are <a href='edit-comments.php?comment_status=spam'><?php echo $num; ?></a> spam comments waiting for you to report them.</p>
		<?php
	}
	$num_comm = wp_count_comments();
	$num      = number_format_i18n( $num_comm->moderated );
	if ( $num_comm->moderated > 0 && SS_MU != 'Y' ) {
		?>
        <p>There are <a href='edit-comments.php?comment_status=moderated'><?php echo $num; ?></a> comments waiting to be moderated.</p></div>
		<?php
	}
	$summry = '';
	foreach ( $counters as $v1 => $v2 ) {
		if ( ! empty( $stats[ $v1 ] ) ) {
			$summry .= "<div class='stat-box'>$v2: " . $stats[ $v1 ] . "</div>";
		} else {
// echo "  $v1 - $v2 , ";
		}
	}
	$addonstats = $stats['addonstats'];
	foreach ( $addonstats as $key => $data ) {
// count is in data[0] and use the plugin name
		$summry .= "<div class='stat-box'>$key: " . $data[0] . "</div>";
	} ?>


		<?php
		echo $summry;
		?>
        <form method="post" action="">
            <input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>" />
            <input type="hidden" name="clear" value="clear summary" />
            <p class="submit" style="clear:both"><input class="button-primary" value="Clear Summary" type="submit" /></p>
        </form>
<?php

function ss_control()  {
	// this is the display of information about the page.

	if (array_key_exists('resetOptions',$_POST)) {
		ss_force_reset_options();
	}
	$ip=astound_get_ip();
	$nonce=wp_create_nonce('ss_options');

	$options=ss_get_options();
	extract($options);
}
	
function ss_force_reset_options() {
	$ss_opt=$_POST['ss_opt'];
	$ss_opt=sanitize_text_field($ss_opt);
	if (!wp_verify_nonce($ss_opt,'ss_options')) {	
		echo "Session timeout, please refresh the page";
		exit;
	}
	if (!function_exists('ss_reset_options')) {
		ss_require('includes/ss-init-options.php');
	}

	ss_reset_options();
	// clear the cache
	delete_option('ss_cache');
} ?>
</div>
    <h2><?php if ( ! is_plugin_active( 'stop-spammers-premium/stop-spammers-premium.php' ) ) { echo 'Free '; } ?>Options</h2>

<div class="ss_admin_info_boxes_3row" >
  <div class="ss_admin_info_boxes_3col" >		
<h3>PROTECTION OPTIONS</h3>
<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/protection.png'; ?>" class="center_thumb" >

All options related to checking spam and logins. You can also block whole countries.
<div class="ss_admin_button">
    <a href="?page=ss_options">Protection</a>
</div>
		</div>
		<div class="ss_admin_info_boxes_3col" >
		<h3>ALLOW LISTS</h3>
<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/allow-list.png'; ?>" class="center_thumb" >
        Specify IP addresses always allowed without being checked and whitelist gateways such as PayPal.
		<div class="ss_admin_button">
    <a href="?page=ss_allow_list">Allow</a>
</div>
		</div>
		<div class="ss_admin_info_boxes_3col" >
		<h3>BLOCK LISTS</h3>
<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/block-list.png'; ?>" class="center_thumb" >
        Block specified IPs and emails and deny comments with certain words and phrases that are often used by spammers.
		<div class="ss_admin_button">
    <a href="?page=ss_deny_list">Block</a>
</div>
		</div>
	</div>
<div class="ss_admin_info_boxes_3row" >
  <div class="ss_admin_info_boxes_3col" >		
<h3>CHALLENGE &amp; DENY</h3>
<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/challenge.png'; ?>" class="center_thumb" >
        Enable reCAPTCHA and notification options. You can give real users who trigger the spam defender a second chance.
<div class="ss_admin_button">
    <a href="?page=ss_challenge">Challenges</a>
</div>
		</div>        
<div class="ss_admin_info_boxes_3col" >		
<h3>APPROVE REQUESTS</h3>
<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/approve-requests.png'; ?>" class="center_thumb" >
		Review and approve or deny users who were blocked and filled out the form requesting access to your site.
<div class="ss_admin_button">
    <a href="?page=ss_allow_list">Approve</a>
</div>
</div> 

<div class="ss_admin_info_boxes_3col" >		
<h3>WEB SERVICES</h3>
<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/web-services.png'; ?>" class="center_thumb" >
        Connect to StopForumSpam.com and other services for more sophisticated protection and the ability to report spam.
<div class="ss_admin_button">
    <a href="?page=ss_webservices_settings">Web Services</a>
</div>
</div>   
</div>
<div class="ss_admin_info_boxes_3row" >
  <div class="ss_admin_info_boxes_3col" >		
<h3>CACHE</h3>
<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/cache.png'; ?>" class="center_thumb" >      
        Shows the cache of recently detected events.
<div class="ss_admin_button">
    <a href="?page=ss_cache">Cache</a>
</div>
</div>
<div class="ss_admin_info_boxes_3col" >		
<h3>LOG REPORT</h3>
<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/log-report.png'; ?>" class="center_thumb" >          
        Details the most recent events detected by Stop Spammers.
<div class="ss_admin_button">
    <a href="?page=ss_reports">Log Report</a>
</div>
</div> 
<div class="ss_admin_info_boxes_3col" >		
<h3>DIAGNOSTICS</h3>
<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/diagnostics.png'; ?>" class="center_thumb" >     
    Test an IP, email, or comment against all of the options to shed light about why an IP address might fail.
<div class="ss_admin_button">
    <a href="?page=ss_diagnostics">Diagnostics</a>
</div>
</div>
</div>

<?php if ( ! is_plugin_active( 'stop-spammers-premium/stop-spammers-premium.php' ) ) {
	echo '
		<h2>Premium Options</h2>
		<div class="ss_admin_info_boxes_1row" >
  			<div class="ss_admin_info_boxes_1col" >
    		<h3>Add a server-side firewall and options like export log to excel, restore options, and transfer settings.</h3>
				<div class="ss_admin_button">
    				<a href="https://trumani.com/downloads/stop-spammers-premium/">Go Premium</a>
				</div>
			</div>
		</div>
	';
} else {
	echo '
		<div class="ss_admin_info_boxes_3row">
			<div class="ss_admin_info_boxes_3col">
				<h3>Restore Default Settings</h3>
				<img src="' . plugin_dir_url( dirname( __FILE__ ) ) . 'images/restore-settings_stop-spammers_trumani.png" class="center_thumb" />
				Too fargone? Revert to the out-of-the box configurations.
				<div class="ss_admin_button">
					<a href="admin.php?page=ssp_premium">RESTORE</a>
				</div>
			</div>
			<div class="ss_admin_info_boxes_3col">
				<h3>Import/Export Settings</h3>
				<img src="' . plugin_dir_url( dirname( __FILE__ ) ) . 'images/import-export_stop-spammers_trumani.png" class="center_thumb" />
				You can download your personalized configurations and upload them to all of your other sites.
				<div class="ss_admin_button">
					<a href="admin.php?page=ssp_premium">IMPORT/EXPORT</a>
				</div>
			</div>
			<div class="ss_admin_info_boxes_3col">
				<h3>Export Log to Excel</h3>
				<img src="' . plugin_dir_url( dirname( __FILE__ ) ) . 'images/export-to-excel_stop-spammers_trumani.png" class="center_thumb" />
				Save the log report returns for future reference.
				<div class="ss_admin_button">
					<a href="admin.php?page=ssp_premium">EXPORT LOG</a>
			</div>
		</div>
	</div>
	';
}
?>

<br style="clear:both" />
<br />
<h2>Beta Options</h2>
    <span class="notice notice-warning" style="display:block">
        <p>These features are to be considered experimental. Use with caution and at your own risk.</p>
    </span>
<div class="ss_admin_info_boxes_2row" >
  <div class="ss_admin_info_boxes_2col" >
    <h3>Database Cleanup</h3>
    <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/database-cleanup.png'; ?>" class="center_thumb" >    
        Delete leftover options from deleted plugins or anything that appears suspicious.
 <div class="ss_admin_button">
    <a href="?page=ss_option_maint">Cleanup</a>
</div>
</div>       
  <div class="ss_admin_info_boxes_2col" >
    <h3>Threat Scan</h3>
    <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/threat-scan.png'; ?>" class="center_thumb" >           
		A simple scan to find possibly malicious code.
 <div class="ss_admin_button">
    <a href="?page=ss_diagnostics">Scan</a>
</div>
</div>   
</div>
</div>
