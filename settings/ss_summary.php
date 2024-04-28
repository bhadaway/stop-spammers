<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

if ( !current_user_can( 'manage_options' ) ) {
	die( __( 'Access Blocked', 'stop-spammer-registrations-plugin' ) );
}

if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'protect' ) ) {
	_e( '<div>Jetpack Protect has been detected. Because of a conflict, Stop Spammers has disabled itself.<br>You do not need to disable Jetpack, just the Protect feature.</div>', 'stop-spammer-registrations-plugin' );
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
	'cntchkcloudflare'	  => __( 'Pass Cloudflare', 'stop-spammer-registrations-plugin' ),
	'cntchkgcache'		  => __( 'Pass Good Cache', 'stop-spammer-registrations-plugin' ),
	'cntchkakismet'	      => __( 'Reported by Akismet', 'stop-spammer-registrations-plugin' ),
	'cntchkgenallowlist'  => __( 'Pass Generated Allow List', 'stop-spammer-registrations-plugin' ),
	'cntchkgoogle'		  => __( 'Pass Google', 'stop-spammer-registrations-plugin' ),
	'cntchkmiscallowlist' => __( 'Pass Allow List', 'stop-spammer-registrations-plugin' ),
	'cntchkpaypal'		  => __( 'Pass PayPal', 'stop-spammer-registrations-plugin' ),
	'cntchkscripts'	      => __( 'Pass Scripts', 'stop-spammer-registrations-plugin' ),
	'cntchkvalidip'	      => __( 'Pass Uncheckable IP', 'stop-spammer-registrations-plugin' ),
	'cntchkwlem'		  => __( 'Allow List Email', 'stop-spammer-registrations-plugin' ),
	'cntchkuserid'		  => __( 'Allow Username', 'stop-spammer-registrations-plugin' ),
	'cntchkwlist'		  => __( 'Pass Allow List IP', 'stop-spammer-registrations-plugin' ),
	'cntchkyahoomerchant' => __( 'Pass Yahoo Merchant', 'stop-spammer-registrations-plugin' ),
	'cntchk404'		      => __( '404 Exploit Attempt', 'stop-spammer-registrations-plugin' ),
	'cntchkaccept'		  => __( 'Bad or Missing Accept Header', 'stop-spammer-registrations-plugin' ),
	'cntchkadmin'		  => __( 'Admin Login Attempt', 'stop-spammer-registrations-plugin' ),
	'cntchkadminlog'	  => __( 'Passed Login OK', 'stop-spammer-registrations-plugin' ),
	'cntchkagent'		  => __( 'Bad or Missing User Agent', 'stop-spammer-registrations-plugin' ),
	'cntchkamazon'		  => __( 'Amazon AWS', 'stop-spammer-registrations-plugin' ),
	'cntchkaws'		      => __( 'Amazon AWS Allow', 'stop-spammer-registrations-plugin' ),
	'cntchkbcache'		  => __( 'Bad Cache', 'stop-spammer-registrations-plugin' ),
	'cntchkblem'		  => __( 'Block List Email', 'stop-spammer-registrations-plugin' ),
	'cntchkuserid'		  => __( 'Block Username', 'stop-spammer-registrations-plugin' ),
	'cntchkblip'		  => __( 'Block List IP', 'stop-spammer-registrations-plugin' ),
	'cntchkbotscout'	  => __( 'BotScout', 'stop-spammer-registrations-plugin' ),
	'cntchkdisp'		  => __( 'Disposable Email', 'stop-spammer-registrations-plugin' ),
	'cntchkdnsbl'		  => __( 'DNSBL Hit', 'stop-spammer-registrations-plugin' ),
	'cntchkexploits'	  => __( 'Exploit Attempt', 'stop-spammer-registrations-plugin' ),
	'cntchkgooglesafe'	  => __( 'Google Safe Browsing', 'stop-spammer-registrations-plugin' ),
	'cntchkhoney'		  => __( 'Project Honeypot', 'stop-spammer-registrations-plugin' ),
	'cntchkhosting'	      => __( 'Known Spam Host', 'stop-spammer-registrations-plugin' ),
	'cntchkinvalidip'	  => __( 'Block Invalid IP', 'stop-spammer-registrations-plugin' ),
	'cntchklong'		  => __( 'Long Email', 'stop-spammer-registrations-plugin' ),
	'cntchkshort'		  => __( 'Short Email', 'stop-spammer-registrations-plugin' ),
	'cntchkbbcode'		  => __( 'BBCode in Request', 'stop-spammer-registrations-plugin' ),
	'cntchkreferer'	      => __( 'Bad HTTP_REFERER', 'stop-spammer-registrations-plugin' ),
	'cntchksession'	      => __( 'Session Speed', 'stop-spammer-registrations-plugin' ),
	'cntchksfs'		      => __( 'Stop Forum Spam', 'stop-spammer-registrations-plugin' ),
	'cntchkspamwords'	  => __( 'Spam Words', 'stop-spammer-registrations-plugin' ),
	'cntchkurlshort'	  => __( 'Short URLs', 'stop-spammer-registrations-plugin' ),
	'cntchktld'		      => __( 'Email TLD', 'stop-spammer-registrations-plugin' ),
	'cntchkubiquity'	  => __( 'Ubiquity Servers', 'stop-spammer-registrations-plugin' ),
	'cntchkmulti'		  => __( 'Repeated Hits', 'stop-spammer-registrations-plugin' ),
	'cntchkform'		  => __( 'Check for Standard Form', 'stop-spammer-registrations-plugin' ),
	'cntchkAD'			  => __( 'Andorra', 'stop-spammer-registrations-plugin' ),
	'cntchkAE'			  => __( 'United Arab Emirates', 'stop-spammer-registrations-plugin' ),
	'cntchkAF'			  => __( 'Afghanistan', 'stop-spammer-registrations-plugin' ),
	'cntchkAL'			  => __( 'Albania', 'stop-spammer-registrations-plugin' ),
	'cntchkAM'			  => __( 'Armenia', 'stop-spammer-registrations-plugin' ),
	'cntchkAR'			  => __( 'Argentina', 'stop-spammer-registrations-plugin' ),
	'cntchkAT'			  => __( 'Austria', 'stop-spammer-registrations-plugin' ),
	'cntchkAU'			  => __( 'Australia', 'stop-spammer-registrations-plugin' ),
	'cntchkAX'			  => __( 'Aland Islands', 'stop-spammer-registrations-plugin' ),
	'cntchkAZ'			  => __( 'Azerbaijan', 'stop-spammer-registrations-plugin' ),
	'cntchkBA'			  => __( 'Bosnia And Herzegovina', 'stop-spammer-registrations-plugin' ),
	'cntchkBB'			  => __( 'Barbados', 'stop-spammer-registrations-plugin' ),
	'cntchkBD'			  => __( 'Bangladesh', 'stop-spammer-registrations-plugin' ),
	'cntchkBE'			  => __( 'Belgium', 'stop-spammer-registrations-plugin' ),
	'cntchkBG'			  => __( 'Bulgaria', 'stop-spammer-registrations-plugin' ),
	'cntchkBH'			  => __( 'Bahrain', 'stop-spammer-registrations-plugin' ),
	'cntchkBN'			  => __( 'Brunei Darussalam', 'stop-spammer-registrations-plugin' ),
	'cntchkBO'			  => __( 'Bolivia', 'stop-spammer-registrations-plugin' ),
	'cntchkBR'			  => __( 'Brazil', 'stop-spammer-registrations-plugin' ),
	'cntchkBS'			  => __( 'Bahamas', 'stop-spammer-registrations-plugin' ),
	'cntchkBY'			  => __( 'Belarus', 'stop-spammer-registrations-plugin' ),
	'cntchkBZ'			  => __( 'Belize', 'stop-spammer-registrations-plugin' ),
	'cntchkCA'			  => __( 'Canada', 'stop-spammer-registrations-plugin' ),
	'cntchkCD'			  => __( 'Congo, Democratic Republic', 'stop-spammer-registrations-plugin' ),
	'cntchkCH'			  => __( 'Switzerland', 'stop-spammer-registrations-plugin' ),
	'cntchkCL'			  => __( 'Chile', 'stop-spammer-registrations-plugin' ),
	'cntchkCN'			  => __( 'China', 'stop-spammer-registrations-plugin' ),
	'cntchkCO'			  => __( 'Colombia', 'stop-spammer-registrations-plugin' ),
	'cntchkCR'			  => __( 'Costa Rica', 'stop-spammer-registrations-plugin' ),
	'cntchkCU'			  => __( 'Cuba', 'stop-spammer-registrations-plugin' ),
	'cntchkCW'			  => __( 'CuraÃ§ao', 'stop-spammer-registrations-plugin' ),
	'cntchkCY'			  => __( 'Cyprus', 'stop-spammer-registrations-plugin' ),
	'cntchkCZ'			  => __( 'Czech Republic', 'stop-spammer-registrations-plugin' ),
	'cntchkDE'			  => __( 'Germany', 'stop-spammer-registrations-plugin' ),
	'cntchkDK'			  => __( 'Denmark', 'stop-spammer-registrations-plugin' ),
	'cntchkDO'			  => __( 'Dominican Republic', 'stop-spammer-registrations-plugin' ),
	'cntchkDZ'			  => __( 'Algeria', 'stop-spammer-registrations-plugin' ),
	'cntchkEC'			  => __( 'Ecuador', 'stop-spammer-registrations-plugin' ),
	'cntchkEE'			  => __( 'Estonia', 'stop-spammer-registrations-plugin' ),
	'cntchkES'			  => __( 'Spain', 'stop-spammer-registrations-plugin' ),
	'cntchkEU'			  => __( 'European Union', 'stop-spammer-registrations-plugin' ),
	'cntchkFI'			  => __( 'Finland', 'stop-spammer-registrations-plugin' ),
	'cntchkFJ'			  => __( 'Fiji', 'stop-spammer-registrations-plugin' ),
	'cntchkFR'			  => __( 'France', 'stop-spammer-registrations-plugin' ),
	'cntchkGB'			  => __( 'Great Britain', 'stop-spammer-registrations-plugin' ),
	'cntchkGE'			  => __( 'Georgia', 'stop-spammer-registrations-plugin' ),
	'cntchkGF'			  => __( 'French Guiana', 'stop-spammer-registrations-plugin' ),
	'cntchkGI'			  => __( 'Gibraltar', 'stop-spammer-registrations-plugin' ),
	'cntchkGP'			  => __( 'Guadeloupe', 'stop-spammer-registrations-plugin' ),
	'cntchkGR'			  => __( 'Greece', 'stop-spammer-registrations-plugin' ),
	'cntchkGT'			  => __( 'Guatemala', 'stop-spammer-registrations-plugin' ),
	'cntchkGU'			  => __( 'Guam', 'stop-spammer-registrations-plugin' ),
	'cntchkGY'			  => __( 'Guyana', 'stop-spammer-registrations-plugin' ),
	'cntchkHK'			  => __( 'Hong Kong', 'stop-spammer-registrations-plugin' ),
	'cntchkHN'			  => __( 'Honduras', 'stop-spammer-registrations-plugin' ),
	'cntchkHR'			  => __( 'Croatia', 'stop-spammer-registrations-plugin' ),
	'cntchkHT'			  => __( 'Haiti', 'stop-spammer-registrations-plugin' ),
	'cntchkHU'			  => __( 'Hungary', 'stop-spammer-registrations-plugin' ),
	'cntchkID'			  => __( 'Indonesia', 'stop-spammer-registrations-plugin' ),
	'cntchkIE'			  => __( 'Ireland', 'stop-spammer-registrations-plugin' ),
	'cntchkIL'			  => __( 'Israel', 'stop-spammer-registrations-plugin' ),
	'cntchkIN'			  => __( 'India', 'stop-spammer-registrations-plugin' ),
	'cntchkIQ'			  => __( 'Iraq', 'stop-spammer-registrations-plugin' ),
	'cntchkIR'			  => __( 'Iran, Islamic Republic Of', 'stop-spammer-registrations-plugin' ),
	'cntchkIS'			  => __( 'Iceland', 'stop-spammer-registrations-plugin' ),
	'cntchkIT'			  => __( 'Italy', 'stop-spammer-registrations-plugin' ),
	'cntchkJM'			  => __( 'Jamaica', 'stop-spammer-registrations-plugin' ),
	'cntchkJO'			  => __( 'Jordan', 'stop-spammer-registrations-plugin' ),
	'cntchkJP'			  => __( 'Japan', 'stop-spammer-registrations-plugin' ),
	'cntchkKE'			  => __( 'Kenya', 'stop-spammer-registrations-plugin' ),
	'cntchkKG'			  => __( 'Kyrgyzstan', 'stop-spammer-registrations-plugin' ),
	'cntchkKH'			  => __( 'Cambodia', 'stop-spammer-registrations-plugin' ),
	'cntchkKR'			  => __( 'Korea', 'stop-spammer-registrations-plugin' ),
	'cntchkKW'			  => __( 'Kuwait', 'stop-spammer-registrations-plugin' ),
	'cntchkKY'			  => __( 'Cayman Islands', 'stop-spammer-registrations-plugin' ),
	'cntchkKZ'			  => __( 'Kazakhstan', 'stop-spammer-registrations-plugin' ),
	'cntchkLA'			  => __( 'Lao People\'s Democratic Republic', 'stop-spammer-registrations-plugin' ),
	'cntchkLB'			  => __( 'Lebanon', 'stop-spammer-registrations-plugin' ),
	'cntchkLK'			  => __( 'Sri Lanka', 'stop-spammer-registrations-plugin' ),
	'cntchkLT'			  => __( 'Lithuania', 'stop-spammer-registrations-plugin' ),
	'cntchkLU'			  => __( 'Luxembourg', 'stop-spammer-registrations-plugin' ),
	'cntchkLV'			  => __( 'Latvia', 'stop-spammer-registrations-plugin' ),
	'cntchkMD'			  => __( 'Moldova', 'stop-spammer-registrations-plugin' ),
	'cntchkME'			  => __( 'Montenegro', 'stop-spammer-registrations-plugin' ),
	'cntchkMK'			  => __( 'Macedonia', 'stop-spammer-registrations-plugin' ),
	'cntchkMM'			  => __( 'Myanmar', 'stop-spammer-registrations-plugin' ),
	'cntchkMN'			  => __( 'Mongolia', 'stop-spammer-registrations-plugin' ),
	'cntchkMO'			  => __( 'Macao', 'stop-spammer-registrations-plugin' ),
	'cntchkMP'			  => __( 'Northern Mariana Islands', 'stop-spammer-registrations-plugin' ),
	'cntchkMQ'			  => __( 'Martinique', 'stop-spammer-registrations-plugin' ),
	'cntchkMT'			  => __( 'Malta', 'stop-spammer-registrations-plugin' ),
	'cntchkMV'			  => __( 'Maldives', 'stop-spammer-registrations-plugin' ),
	'cntchkMX'			  => __( 'Mexico', 'stop-spammer-registrations-plugin' ),
	'cntchkMY'			  => __( 'Malaysia', 'stop-spammer-registrations-plugin' ),
	'cntchkNC'			  => __( 'New Caledonia', 'stop-spammer-registrations-plugin' ),
	'cntchkNI'			  => __( 'Nicaragua', 'stop-spammer-registrations-plugin' ),
	'cntchkNL'			  => __( 'Netherlands', 'stop-spammer-registrations-plugin' ),
	'cntchkNO'			  => __( 'Norway', 'stop-spammer-registrations-plugin' ),
	'cntchkNP'			  => __( 'Nepal', 'stop-spammer-registrations-plugin' ),
	'cntchkNZ'			  => __( 'New Zealand', 'stop-spammer-registrations-plugin' ),
	'cntchkOM'			  => __( 'Oman', 'stop-spammer-registrations-plugin' ),
	'cntchkPA'			  => __( 'Panama', 'stop-spammer-registrations-plugin' ),
	'cntchkPE'			  => __( 'Peru', 'stop-spammer-registrations-plugin' ),
	'cntchkPG'			  => __( 'Papua New Guinea', 'stop-spammer-registrations-plugin' ),
	'cntchkPH'			  => __( 'Philippines', 'stop-spammer-registrations-plugin' ),
	'cntchkPK'			  => __( 'Pakistan', 'stop-spammer-registrations-plugin' ),
	'cntchkPL'			  => __( 'Poland', 'stop-spammer-registrations-plugin' ),
	'cntchkPR'			  => __( 'Puerto Rico', 'stop-spammer-registrations-plugin' ),
	'cntchkPS'			  => __( 'Palestinian Territory, Occupied', 'stop-spammer-registrations-plugin' ),
	'cntchkPT'			  => __( 'Portugal', 'stop-spammer-registrations-plugin' ),
	'cntchkPW'			  => __( 'Palau', 'stop-spammer-registrations-plugin' ),
	'cntchkPY'			  => __( 'Paraguay', 'stop-spammer-registrations-plugin' ),
	'cntchkQA'			  => __( 'Qatar', 'stop-spammer-registrations-plugin' ),
	'cntchkRO'			  => __( 'Romania', 'stop-spammer-registrations-plugin' ),
	'cntchkRS'			  => __( 'Serbia', 'stop-spammer-registrations-plugin' ),
	'cntchkRU'			  => __( 'Russian Federation', 'stop-spammer-registrations-plugin' ),
	'cntchkSA'			  => __( 'Saudi Arabia', 'stop-spammer-registrations-plugin' ),
	'cntchkSC'			  => __( 'Seychelles', 'stop-spammer-registrations-plugin' ),
	'cntchkSE'			  => __( 'Sweden', 'stop-spammer-registrations-plugin' ),
	'cntchkSG'			  => __( 'Singapore', 'stop-spammer-registrations-plugin' ),
	'cntchkSI'			  => __( 'Slovenia', 'stop-spammer-registrations-plugin' ),
	'cntchkSK'			  => __( 'Slovakia', 'stop-spammer-registrations-plugin' ),
	'cntchkSV'			  => __( 'El Salvador', 'stop-spammer-registrations-plugin' ),
	'cntchkSX'			  => __( 'Sint Maarten', 'stop-spammer-registrations-plugin' ),
	'cntchkSY'			  => __( 'Syrian Arab Republic', 'stop-spammer-registrations-plugin' ),
	'cntchkTH'			  => __( 'Thailand', 'stop-spammer-registrations-plugin' ),
	'cntchkTJ'			  => __( 'Tajikistan', 'stop-spammer-registrations-plugin' ),
	'cntchkTM'			  => __( 'Turkmenistan', 'stop-spammer-registrations-plugin' ),
	'cntchkTR'			  => __( 'Turkey', 'stop-spammer-registrations-plugin' ),
	'cntchkTT'			  => __( 'Trinidad And Tobago', 'stop-spammer-registrations-plugin' ),
	'cntchkTW'			  => __( 'Taiwan', 'stop-spammer-registrations-plugin' ),
	'cntchkUA'			  => __( 'Ukraine', 'stop-spammer-registrations-plugin' ),
	'cntchkUK'			  => __( 'United Kingdom', 'stop-spammer-registrations-plugin' ),
	'cntchkUS'			  => __( 'United States', 'stop-spammer-registrations-plugin' ),
	'cntchkUY'			  => __( 'Uruguay', 'stop-spammer-registrations-plugin' ),
	'cntchkUZ'			  => __( 'Uzbekistan', 'stop-spammer-registrations-plugin' ),
	'cntchkVC'			  => __( 'Saint Vincent And Grenadines', 'stop-spammer-registrations-plugin' ),
	'cntchkVE'			  => __( 'Venezuela', 'stop-spammer-registrations-plugin' ),
	'cntchkVN'			  => __( 'Viet Nam', 'stop-spammer-registrations-plugin' ),
	'cntchkYE'			  => __( 'Yemen', 'stop-spammer-registrations-plugin' ),
	'cntcap'			  => __( 'Passed CAPTCHA', 'stop-spammer-registrations-plugin' ), // captha success
	'cntncap'			  => __( 'Failed CAPTCHA', 'stop-spammer-registrations-plugin' ), // captha not success
	'cntpass'			  => __( 'Total Pass', 'stop-spammer-registrations-plugin' ), // passed
);

$message  = '';
$nonce	  = '';

if ( array_key_exists( 'ss_stop_spammers_control', $_POST ) ) {
	$nonce = $_POST['ss_stop_spammers_control'];
}

if ( wp_verify_nonce( $nonce, 'ss_stopspam_update' ) ) {
	if ( array_key_exists( 'clear', $_POST ) ) {
		foreach ( $counters as $v1 => $v2 ) {
			$stats[$v1] = 0;
		}
		$addonstats		     = array();
		$stats['addonstats'] = $addonstats;
		$msg			  	 = '<div class="notice notice-success is-dismissible"><p>' . __( 'Summary Cleared', 'stop-spammer-registrations-plugin' ) . '</p></div>';
		ss_set_stats( $stats );
		extract( $stats ); // extract again to get the new options
	}
	if ( array_key_exists( 'update_total', $_POST ) ) {
		$stats['spmcount'] = sanitize_text_field( $_POST['spmcount'] );
		$stats['spmdate']  = sanitize_text_field( $_POST['spmdate'] );
		ss_set_stats( $stats );
		extract( $stats ); // extract again to get the new options
	}
}

$nonce = wp_create_nonce( 'ss_stopspam_update' );

?>

<div id="ss-plugin" class="wrap">
	<h1 class="ss_head"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/stop-spammers-icon.png'; ?>" class="ss_icon" ><?php _e( 'Stop Spammers — Summary', 'stop-spammers' ); ?></h1><br>
	<?php _e( 'Version', 'stop-spammer-registrations-plugin' ); ?> <strong><?php echo SS_VERSION; ?></strong>
	<?php if ( !empty( $summary ) ) { ?>
	<?php }
	$ip = ss_get_ip();
	?>
	| <?php _e( 'Your current IP address is', 'stop-spammer-registrations-plugin' ); ?>: <strong><?php echo $ip; ?></strong>
	<?php
	// check the IP to see if we are local
	$ansa = be_load( 'chkvalidip', ss_get_ip() );
	if ( $ansa == false ) {
		$ansa = be_load( 'chkcloudflare', ss_get_ip() );
	}
	if ( $ansa !== false ) { ?>
		<p><?php _e( 'This address is invalid for testing for the following reason:
			  <span style="font-weight:bold;font-size:1.2em">' . $ansa . '</span>.<br>
			  If you working on a local installation of WordPress, this might be
			  OK. However, if the plugin reports that your
			  IP is invalid it may be because you are using Cloudflare or a proxy
			  server to access this page. This will make
			  it impossible for the plugin to check IP addresses. You may want to
			  go to the Stop Spammers Testing page in
			  order to test all possible reasons that your IP is not appearing as
			  the IP of the machine that your using to
			  browse this site.<br>
			  It is possible to use the plugin if this problem appears, but most
			  checking functions will be turned off. The
			  plugin will still perform spam checks which do not require an
			  IP.<br>
			  If the error says that this is a Cloudflare IP address, you can fix
			  this by installing the Cloudflare plugin. If
			  you use Cloudflare to protect and speed up your site then you MUST
			  install the Cloudflare plugin. This plugin
			  will be crippled until you install it.', 'stop-spammer-registrations-plugin' ); ?></p>
	<?php }
	// need the current guy
	$sname = '';
	if ( isset( $_SERVER['REQUEST_URI'] ) ) {
		$sname = $_SERVER["REQUEST_URI"];
	}
	if ( empty( $sname ) ) {
		$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
		$sname			  	    = $_SERVER["SCRIPT_NAME"];
	}
	if ( strpos( $sname, '?' ) !== false ) {
		$sname = substr( $sname, 0, strpos( $sname, '?' ) );
	}
	if ( !empty( $msg ) ) {
		echo $msg;
	}
	$current_user_name = wp_get_current_user()->user_login;
	if ( $current_user_name == 'admin' ) {
		_e( '<span class="notice notice-warning" style="display:block">SECURITY RISK: You are using the username "admin." This is an invitation to hackers to try and guess your password. Please change this.</span>', 'stop-spammer-registrations-plugin' );
	}
	$showcf = false; // hide this for now
	if ( $showcf && array_key_exists( 'HTTP_CF_CONNECTING_IP', $_SERVER ) && !function_exists( 'cloudflare_init' ) && !defined( 'W3TC' ) ) {
		_e( '<span class="notice notice-warning" style="display:block">WARNING: Cloudflare Remote IP address detected. Please make sure to <a href="https://support.cloudflare.com/hc/sections/200805497-Restoring-Visitor-IPs" target="_blank">restore visitor IPs</a>.</span>', 'stop-spammer-registrations-plugin' );
	}
	?>
	<h2><?php _e( 'Summary of Spam', 'stop-spammer-registrations-plugin' ); ?></h2>
	<div class="main-stats">
	<?php if ( $spcount > 0 ) { ?>
		<p><?php _e( 'Stop Spammers has stopped <strong>' . $spcount . '</strong> spammers since ' . $spdate . '.', 'stop-spammer-registrations-plugin' ); ?></p>
	<?php }
	$num_comm = wp_count_comments();
	$num	  = number_format_i18n( $num_comm->spam );
	if ( $num_comm->spam > 0 && SS_MU != 'Y' ) { ?>
		<p><?php _e( 'There are <a href="edit-comments.php?comment_status=spam">' . $num . '</a> spam comments waiting for you to report.', 'stop-spammer-registrations-plugin' ); ?></p>
	<?php }
	$num_comm = wp_count_comments();
	$num	  = number_format_i18n( $num_comm->moderated );
	if ( $num_comm->moderated > 0 && SS_MU != 'Y' ) { ?>
		<p><?php _e( 'There are <a href="edit-comments.php?comment_status=moderated">' . $num . '</a> comments waiting to be moderated.', 'stop-spammer-registrations-plugin' ); ?></p></div>
	<?php }
	$summary = '';
	foreach ( $counters as $v1 => $v2 ) {
		if ( !empty( $stats[$v1] ) ) {
			  $summary .= "<div class='stat-box'>$v2: " . $stats[$v1] . "</div>";
		} else {
		// echo "  $v1 - $v2 , ";
		}
	}
	$addonstats = $stats['addonstats'];
	foreach ( $addonstats as $key => $data ) {
	// count is in data[0] and use the plugin name
		$summary .= "<div class='stat-box'>$key: " . $data[0] . "</div>";
	} ?>
	<?php
		echo $summary;
	?>
	<form method="post" action="">
		<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>">
		<input type="hidden" name="clear" value="clear summary">
		<p class="submit" style="clear:both"><input class="button-primary" value="<?php _e( 'Clear Summary', 'stop-spammer-registrations-plugin' ); ?>" type="submit"></p>
	</form>
	<?php
	function ss_control()  {
		// this is the display of information about the page.
		if ( array_key_exists( 'resetOptions', $_POST ) ) {
			ss_force_reset_options();
		}
		$ip 	 = ss_get_ip();
		$nonce   = wp_create_nonce( 'ss_options' );
		$options = ss_get_options();
		extract( $options );
	}
	function ss_force_reset_options() {
		$ss_opt = sanitize_text_field( $_POST['ss_opt'] );
		if ( !wp_verify_nonce( $ss_opt, 'ss_options' ) ) {	
			_e( 'Session Timeout — Please Refresh the Page', 'stop-spammer-registrations-plugin' );
			exit;
		}
		if ( !function_exists( 'ss_reset_options' ) ) {
			ss_require( 'includes/ss-init-options.php' );
		}
		ss_reset_options();
		// clear the cache
		delete_option( 'ss_cache' );
	} ?>
	<h2><?php _e( 'Options', 'stop-spammer-registrations-plugin' ); ?></h2>
	<div class="ss_admin_info_boxes_3row">
		<div class="ss_admin_info_boxes_3col">
			<h3><?php _e( 'PROTECTION OPTIONS', 'stop-spammer-registrations-plugin' ); ?></h3>
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/protection.png'; ?>" class="center_thumb"><?php _e( 'All options related to checking spam and logins. You can also block whole countries.', 'stop-spammer-registrations-plugin' ); ?>
			<div>
				<br>
				<a class="button-primary" href="?page=ss_options"><?php _e( 'Protection', 'stop-spammer-registrations-plugin' ); ?></a>
			</div>
		</div>
		<div class="ss_admin_info_boxes_3col">
			<h3><?php _e( 'ALLOW LISTS', 'stop-spammer-registrations-plugin' ); ?></h3>
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/allow-list.png'; ?>" class="center_thumb"><?php _e( 'Specify IP addresses always allowed without being checked and whitelist gateways such as PayPal.', 'stop-spammer-registrations-plugin' ); ?>
			<div>
				<br>
				<a class="button-primary" href="?page=ss_allow_list"><?php _e( 'Allow', 'stop-spammer-registrations-plugin' ); ?></a>
			</div>
		</div>
		<div class="ss_admin_info_boxes_3col">
			<h3><?php _e( 'BLOCK LISTS', 'stop-spammer-registrations-plugin' ); ?></h3>
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/block-list.png'; ?>" class="center_thumb"><?php _e( 'Block specified IPs and emails and block comments with certain words and phrases that are often used by spammers.', 'stop-spammer-registrations-plugin' ); ?>
			<div>
				<br>
				<a class="button-primary" href="?page=ss_block_list"><?php _e( 'Block', 'stop-spammer-registrations-plugin' ); ?></a>
			</div>
		</div>
	</div>
	<div class="ss_admin_info_boxes_3row">
		<div class="ss_admin_info_boxes_3col">
			<h3><?php _e( 'CHALLENGE &amp; BLOCK', 'stop-spammer-registrations-plugin' ); ?></h3>
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/challenge.png'; ?>" class="center_thumb"><?php _e( 'Enable reCAPTCHA and notification options. You can give real users who trigger the spam defender a second chance.', 'stop-spammer-registrations-plugin' ); ?>
			<div>
				<br>
				<a class="button-primary" href="?page=ss_challenge"><?php _e( 'Challenges', 'stop-spammer-registrations-plugin' ); ?></a>
			</div>
		</div>
		<div class="ss_admin_info_boxes_3col">
			<h3><?php _e( 'APPROVE REQUESTS', 'stop-spammer-registrations-plugin' ); ?></h3>
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/approve-requests.png'; ?>" class="center_thumb"><?php _e( 'Review and approve or block users who were blocked and filled out the form requesting access to your site.', 'stop-spammer-registrations-plugin' ); ?>
			<div>
				<br>
				<a class="button-primary" href="?page=ss_allow_list"><?php _e( 'Approve', 'stop-spammer-registrations-plugin' ); ?></a>
			</div>
		</div>
		<div class="ss_admin_info_boxes_3col">
			<h3><?php _e( 'WEB SERVICES', 'stop-spammer-registrations-plugin' ); ?></h3>
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/web-services.png'; ?>" class="center_thumb"><?php _e( 'Connect to StopForumSpam.com and other services for more sophisticated protection and the ability to report spam.', 'stop-spammer-registrations-plugin' ); ?>
			<div>
				<br>
				<a class="button-primary" href="?page=ss_webservices_settings"><?php _e( 'Web Services', 'stop-spammer-registrations-plugin' ); ?></a>
			</div>
		</div>
	</div>
	<div class="ss_admin_info_boxes_3row">
		<div class="ss_admin_info_boxes_3col">
			<h3><?php _e( 'CACHE', 'stop-spammer-registrations-plugin' ); ?></h3>
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/cache.png'; ?>" class="center_thumb"><?php _e( 'Shows the cache of recently detected events.', 'stop-spammer-registrations-plugin' ); ?>
			<div>
				<br>
				<a class="button-primary" href="?page=ss_cache"><?php _e( 'Cache', 'stop-spammer-registrations-plugin' ); ?></a>
			</div>
		</div>
		<div class="ss_admin_info_boxes_3col">
			<h3><?php _e( 'LOG REPORT', 'stop-spammer-registrations-plugin' ); ?></h3>
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/log-report.png'; ?>" class="center_thumb"><?php _e( 'Details the most recent events detected by Stop Spammers.', 'stop-spammer-registrations-plugin' ); ?>
			<div>
				<br>
				<a class="button-primary" href="?page=ss_reports"><?php _e( 'Log Report', 'stop-spammer-registrations-plugin' ); ?></a>
			</div>
		</div>
		<div class="ss_admin_info_boxes_3col">
			<h3><?php _e( 'DIAGNOSTICS', 'stop-spammer-registrations-plugin' ); ?></h3>
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/diagnostics.png'; ?>" class="center_thumb"><?php _e( 'Test an IP, email, or comment against all of the options to shed light about why an IP address might fail.', 'stop-spammer-registrations-plugin' ); ?>
			<div>
				<br>
				<a class="button-primary" href="?page=ss_diagnostics"><?php _e( 'Diagnostics', 'stop-spammer-registrations-plugin' ); ?></a>
			</div>
		</div>
	</div>
	<br style="clear:both">
 	<div class="ss_admin_info_boxes_3row">	
		<div class="ss_admin_info_boxes_3col">
			<h3><?php _e( 'CLEANUP', 'stop-spammer-registrations-plugin' ); ?></h3>			
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/database-cleanup.png'; ?>" class="center_thumb" ><?php _e( 'Delete leftover crumbs from bygone plugins or anything that appears suspicious. Lookup/disable spammy users. Mass delete pending comments.', 'stop-spammer-registrations-plugin' ); ?>
			<div>
				<br>
				<a class="button-primary" href="?page=ss_option_maint"><?php _e( 'Cleanup', 'stop-spammer-registrations-plugin' ); ?></a>
			</div>
		</div>	     		
		<div class="ss_admin_info_boxes_3col">			
			<h3><?php _e( 'THREAT SCAN', 'stop-spammer-registrations-plugin' ); ?></h3>			
			<img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/threat-scan.png'; ?>" class="center_thumb" ><?php _e( 'A simple scan to find possibly malicious code.', 'stop-spammer-registrations-plugin' ); ?> 
			<div>
				<br>
				<a class="button-primary" href="?page=ss_diagnostics"><?php _e( 'Scan', 'stop-spammer-registrations-plugin' ); ?></a></input>
			</div>
		</div>
	</div>
</div>