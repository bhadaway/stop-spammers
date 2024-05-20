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

// checks
$nonce = '';

if ( array_key_exists( 'ss_stop_spammers_control', $_POST ) ) {
	$nonce = $_POST['ss_stop_spammers_control'];
}

if ( !empty( $nonce ) && wp_verify_nonce( $nonce, 'ss_stopspam_update' ) ) {
	// update
	// check box items - keep track of these
	$optionlist = array(
		'chkamazon',
		'addtoallowlist',
		'chkadmin',
		'chkaccept',
		'chkbbcode',
		'chkperiods',
		'chkhyphens',
		'chkreferer',
		'chkdisp',
		'chklong',
		'chkshort',
		'chkmulti',
		'chksession',
		'chk404',
		'chkexploits',
		'chkadminlog',
		'chkhosting',
		'chktor',
		'chkakismet',
		'filterregistrations',
		'chkform',
		'ss_private_mode',
		'ss_keep_hidden_btn',
		'ss_hide_all_btn',
		'chkubiquity',
		'enable_custom_password'
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
	// countries
	$optionlist = array(
		'chkAD',
		'chkAE',
		'chkAF',
		'chkAL',
		'chkAM',
		'chkAR',
		'chkAT',
		'chkAU',
		'chkAX',
		'chkAZ',
		'chkBA',
		'chkBB',
		'chkBD',
		'chkBE',
		'chkBG',
		'chkBH',
		'chkBN',
		'chkBO',
		'chkBR',
		'chkBS',
		'chkBY',
		'chkBZ',
		'chkCA',
		'chkCD',
		'chkCH',
		'chkCL',
		'chkCN',
		'chkCO',
		'chkCR',
		'chkCU',
		'chkCW',
		'chkCY',
		'chkCZ',
		'chkDE',
		'chkDK',
		'chkDO',
		'chkDZ',
		'chkEC',
		'chkEE',
		'chkES',
		'chkEU',
		'chkFI',
		'chkFJ',
		'chkFR',
		'chkGB',
		'chkGE',
		'chkGF',
		'chkGI',
		'chkGP',
		'chkGR',
		'chkGT',
		'chkGU',
		'chkGY',
		'chkHK',
		'chkHN',
		'chkHR',
		'chkHT',
		'chkHU',
		'chkID',
		'chkIE',
		'chkIL',
		'chkIN',
		'chkIQ',
		'chkIR',
		'chkIS',
		'chkIT',
		'chkJM',
		'chkJO',
		'chkJP',
		'chkKE',
		'chkKG',
		'chkKH',
		'chkKR',
		'chkKW',
		'chkKY',
		'chkKZ',
		'chkLA',
		'chkLB',
		'chkLK',
		'chkLT',
		'chkLU',
		'chkLV',
		'chkMD',
		'chkME',
		'chkMK',
		'chkMM',
		'chkMN',
		'chkMO',
		'chkMP',
		'chkMQ',
		'chkMT',
		'chkMV',
		'chkMX',
		'chkMY',
		'chkNC',
		'chkNI',
		'chkNL',
		'chkNO',
		'chkNP',
		'chkNZ',
		'chkOM',
		'chkPA',
		'chkPE',
		'chkPG',
		'chkPH',
		'chkPK',
		'chkPL',
		'chkPR',
		'chkPS',
		'chkPT',
		'chkPW',
		'chkPY',
		'chkQA',
		'chkRO',
		'chkRS',
		'chkRU',
		'chkSA',
		'chkSC',
		'chkSE',
		'chkSG',
		'chkSI',
		'chkSK',
		'chkSV',
		'chkSX',
		'chkSY',
		'chkTH',
		'chkTJ',
		'chkTM',
		'chkTR',
		'chkTT',
		'chkTW',
		'chkUA',
		'chkUK',
		'chkUS',
		'chkUY',
		'chkUZ',
		'chkVC',
		'chkVE',
		'chkVN',
		'chkYE'
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
	// text options
	if ( array_key_exists( 'sesstime', $_POST ) ) {
		$sesstime			 = stripslashes( sanitize_text_field( $_POST['sesstime'] ) );
		$options['sesstime'] = $sesstime;
	}
	if ( array_key_exists( 'multitime', $_POST ) ) {
		$multitime			  = stripslashes( sanitize_text_field( $_POST['multitime'] ) );
		$options['multitime'] = $multitime;
	}
	if ( array_key_exists( 'multicnt', $_POST ) ) {
		$multicnt			 = stripslashes( sanitize_text_field( $_POST['multicnt'] ) );
		$options['multicnt'] = $multicnt;
	}
	ss_set_options( $options );
	extract( $options ); // extract again to get the new options
	$msg = '<div class="notice notice-success is-dismissible"><p>' . __( 'Options Updated', 'stop-spammer-registrations-plugin' ) . '</p></div>';
}

$nonce = wp_create_nonce( 'ss_stopspam_update' );

?>

<!-- <sup class="ss_sup"><?php _e( 'NEW!', 'stop-spammer-registrations-plugin' ); ?></sup> -->
<div id="ss-plugin" class="wrap">
	<h1 class="ss_head">Stop Spammers — <?php _e( 'Protection Options', 'stop-spammer-registrations-plugin' ); ?></h1>
	<br>
	<?php if ( !empty( $msg ) ) {
		echo $msg;
	} ?>
	<br>
	<form method="post" action="" name="ss">
		<input type="hidden" name="action" value="update">
		<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>">
		<div id="formchecking" class="mainsection"><?php _e( 'Form Checking', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Protection-Options#form-checking" target="_blank">?</a></sup>
		</div>
		<?php if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			_e( '<p><span style="color:purple">WooCommerce detected. If you experience any issues using WooCommerce and Stop Spammers together, you may need to adjust these settings.</span></p>', 'stop-spammer-registrations-plugin' );
		} ?>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkform">
				<input class="ss_toggle" type="checkbox" id="chkform" name="chkform" value="Y" <?php if ( $chkform == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Only Use the Plugin for Standard WordPress Forms', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div id="membersonly" class="mainsection"><?php _e( 'Members-only Mode', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Protection-Options#members-only-mode" target="_blank">?</a></sup>
		</div>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="ss_private_mode">
				<input class="ss_toggle" type="checkbox" id="ss_private_mode" name="ss_private_mode" value="Y" <?php if ( $ss_private_mode == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Require Users to Be Logged in to View Site', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div id="preventlockouts" class="mainsection"><?php _e( 'Prevent Lockouts', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Protection-Options#prevent-lockouts" target="_blank">?</a></sup>
		</div>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="addtoallowlist">
				<input class="ss_toggle" type="checkbox" id="addtoallowlist" name="addtoallowlist" value="Y" <?php if ( $addtoallowlist == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Automatically Add Admins to Allow List', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkadminlog">
				<input class="ss_toggle" type="checkbox" id="chkadminlog" name="chkadminlog" value="Y" <?php if ( $chkadminlog == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Check Credentials on All Login Attempts', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div id="notificationcontrol" class="mainsection">
			<?php _e( 'Notification Control', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Protection-Options#notification-control" target="_blank">?</a></sup>
		</div>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="ss_keep_hidden_btn">
				<input class="ss_toggle" type="checkbox" id="ss_keep_hidden_btn" name="ss_keep_hidden_btn" value="Y" <?php if ( $ss_keep_hidden_btn == 'Y' ) { echo 'checked="checked"'; } ?> onChange="(this.checked? '': jQuery('#ss_hide_all_btn').prop('checked', false) );"><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Show Keep Hidden Button', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="ss_hide_all_btn">
				<input class="ss_toggle" type="checkbox" id="ss_hide_all_btn" name="ss_hide_all_btn" value="Y" <?php if ( $ss_hide_all_btn == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Show Hide All Notices Button', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div id="validaterequests" class="mainsection"><?php _e( 'Validate Requests', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Protection-Options#validate-requests" target="_blank">?</a></sup>
		</div>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkaccept">
				<input class="ss_toggle" type="checkbox" id="chkaccept" name="chkaccept" value="Y" <?php if ( $chkaccept == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Block Spam Missing the HTTP_ACCEPT Header', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkreferer">
				<input class="ss_toggle" type="checkbox" id="chkreferer" name="chkreferer" value="Y" <?php if ( $chkreferer == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Block Invalid HTTP_REFERER', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkdisp">
				<input class="ss_toggle" type="checkbox" id="chkdisp" name="chkdisp" value="Y" <?php if ( $chkdisp == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Block Disposable Email Addresses', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chklong">
				<input class="ss_toggle" type="checkbox" id="chklong" name="chklong" value="Y" <?php if ( $chklong == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Check for Long Emails, Author Name, or Password', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkshort">
				<input class="ss_toggle" type="checkbox" id="chkshort" name="chkshort" value="Y" <?php if ( $chkshort == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Check for Short Emails or Author Name', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkbbcode">
				<input class="ss_toggle" type="checkbox" id="chkbbcode" name="chkbbcode" value="Y" <?php if ( $chkbbcode == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Check for BBCodes', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkperiods">
				<input class="ss_toggle" type="checkbox" id="chkperiods" name="chkperiods" value="Y" <?php if ( $chkperiods == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Check for Periods', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkhyphens">
				<input class="ss_toggle" type="checkbox" id="chkhyphens" name="chkhyphens" value="Y" <?php if ( $chkhyphens == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Check for Hyphens', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chksession">
				<input class="ss_toggle" type="checkbox" id="chksession" name="chksession" value="Y" onclick="ss_show_quick()" <?php if ( $chksession == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Check for Quick Responses', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<span id="ss_show_quick" style="margin-left:30px;margin-bottom:15px;display:none">
			<p style="margin-left:30px"><?php _e( 'Response Timeout Value: ', 'stop-spammer-registrations-plugin' ); ?>
			<input name="sesstime" type="text" value="<?php echo esc_attr( $sesstime ); ?>" size="2"><br></p>
		</span>
		<script>
		function ss_show_quick() {
			var checkBox = document.getElementById("chksession");
			var text = document.getElementById("ss_show_quick");
			if (checkBox.checked == true) {
				text.style.display = "block";
			} else {
				text.style.display = "none";
			}
		}
		ss_show_quick();
		</script>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chk404">
				<input class="ss_toggle" type="checkbox" id="chk404" name="chk404" value="Y" <?php if ( $chk404 == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Block 404 Exploit Probing', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkakismet">
				<input class="ss_toggle" type="checkbox" id="chkakismet" name="chkakismet" value="Y" <?php if ( $chkakismet == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Block IPs Detected by Akismet', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkexploits">
				<input class="ss_toggle" type="checkbox" id="chkexploits" name="chkexploits" value="Y" <?php if ( $chkexploits == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Check for Exploits', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkadmin">
				<input class="ss_toggle" type="checkbox" id="chkadmin" name="chkadmin" value="Y" <?php if ( $chkadmin == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Block Login Attempts Using "admin" in Username', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkubiquity">
				<input class="ss_toggle" type="checkbox" id="chkubiquity" name="chkubiquity" value="Y" <?php if ( $chkubiquity == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Check Against List of Ubiquity-Nobis and Other Spam Server IPs', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkhosting">
				<input class="ss_toggle" type="checkbox" id="chkhosting" name="chkhosting" value="Y" <?php if ( $chkhosting == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Check for Major Hosting Companies and Cloud Services', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chktor">
				<input class="ss_toggle" type="checkbox" id="chktor" name="chktor" value="Y" <?php if ( $chktor == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Check for Tor Exit Nodes', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkmulti">
				<input class="ss_toggle" type="checkbox" id="chkmulti" name="chkmulti" value="Y" onclick="ss_show_chkmulti()" <?php if ( $chkmulti == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Check for Many Hits in a Short Time', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<span id="ss_show_chkmulti" style="margin-left:30px;margin-bottom:15px;display:none">
			<p style="margin-left:30px"><?php _e( 'Block access when there are', 'stop-spammer-registrations-plugin' ); ?>
				<select name="multicnt">
					<option val="4" <?php if ( $multicnt <= 4 ) { echo 'selected="selected"'; } ?>>4</option>
					<option val="5" <?php if ( $multicnt == 5 ) { echo 'selected="selected"'; } ?>>5</option>
					<option val="6" <?php if ( $multicnt == 6 ) { echo 'selected="selected"'; } ?>>6</option>
					<option val="7" <?php if ( $multicnt == 7 ) { echo 'selected="selected"'; } ?>>7</option>
					<option val="8" <?php if ( $multicnt == 8 ) { echo 'selected="selected"'; } ?>>8</option>
					<option val="9" <?php if ( $multicnt == 9 ) { echo 'selected="selected"'; } ?>>9</option>
					<option val="10" <?php if ( $multicnt >= 10 ) { echo 'selected="selected"'; } ?>>10</option>
				</select>
				<?php _e( 'comments or logins in less than', 'stop-spammer-registrations-plugin' ); ?>
				<select name="multitime">
					<option val="1" <?php if ( $multitime <= 1 ) { echo 'selected="selected"'; } ?>>1</option>
					<option val="2" <?php if ( $multitime == 2 ) { echo 'selected="selected"'; } ?>>2</option>
					<option val="3" <?php if ( $multitime == 3 ) { echo 'selected="selected"'; } ?>>3</option>
					<option val="4" <?php if ( $multitime == 4 ) { echo 'selected="selected"'; } ?>>4</option>
					<option val="5" <?php if ( $multitime == 5 ) { echo 'selected="selected"'; } ?>>5</option>
					<option val="6" <?php if ( $multitime == 6 ) { echo 'selected="selected"'; } ?>>6</option>
					<option val="7" <?php if ( $multitime == 7 ) { echo 'selected="selected"'; } ?>>7</option>
					<option val="8" <?php if ( $multitime == 8 ) { echo 'selected="selected"'; } ?>>8</option>
					<option val="9" <?php if ( $multitime == 9 ) { echo 'selected="selected"'; } ?>>9</option>
					<option val="10" <?php if ( $multitime >= 10 ) { echo 'selected="selected"'; } ?>>10</option>
				</select>
				<?php _e( 'minutes.', 'stop-spammer-registrations-plugin' ); ?><br>
			</p>
		</span>
		<script>
		function ss_show_chkmulti() {
			var checkBox = document.getElementById("chkmulti");
			var text = document.getElementById("ss_show_chkmulti");
			if (checkBox.checked == true) {
				text.style.display = "block";
			} else {
				text.style.display = "none";
			}
		}
		jQuery(function() {
			ss_show_chkmulti();
		});
		</script>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkamazon">
				<input class="ss_toggle" type="checkbox" id="chkamazon" name="chkamazon" value="Y" <?php if ( $chkamazon == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Check for Amazon Cloud', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="filterregistrations">
				<input class="ss_toggle" type="checkbox" id="filterregistrations" name="filterregistrations" value="Y" <?php if ( $filterregistrations == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Filter Login Requests', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<br>
		<div id="blockcountries" class="mainsection"><?php _e( 'Block Countries', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Protection-Options#block-countries" target="_blank">?</a></sup>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="countries">
				<input class="ss_toggle" type="checkbox" id="countries" name="ss_set" value="1" onclick='var t=ss.ss_set.checked;var els=document.getElementsByTagName("INPUT");for (index = 0; index < els.length; ++index){if (els[index].type=="checkbox"){if (els[index].name.length==5){els[index].checked=t;}}}'/>
				<small><span class="button-primary" style="font-size:16px!important"><?php _e( 'Check All', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="stat-box">
			<input name="chkAD" type="checkbox" value="Y" <?php if ( $chkAD == "Y" ) { echo 'checked="checked"'; } ?>>Andorra
		</div>
		<div class="stat-box">
			<input name="chkAE" type="checkbox" value="Y" <?php if ( $chkAE == "Y" ) { echo 'checked="checked"'; } ?>>United Arab Emirates
		</div>
		<div class="stat-box">
			<input name="chkAF" type="checkbox" value="Y" <?php if ( $chkAF == "Y" ) { echo 'checked="checked"'; } ?>>Afghanistan
		</div>
		<div class="stat-box">
			<input name="chkAL" type="checkbox" value="Y" <?php if ( $chkAL == "Y" ) { echo 'checked="checked"'; } ?>>Albania
		</div>
		<div class="stat-box">
			<input name="chkAM" type="checkbox" value="Y" <?php if ( $chkAM == "Y" ) { echo 'checked="checked"'; } ?>>Armenia
		</div>
		<div class="stat-box">
			<input name="chkAR" type="checkbox" value="Y" <?php if ( $chkAR == "Y" ) { echo 'checked="checked"'; } ?>>Argentina
		</div>
		<div class="stat-box">
			<input name="chkAT" type="checkbox" value="Y" <?php if ( $chkAT == "Y" ) { echo 'checked="checked"'; } ?>>Austria
		</div>
		<div class="stat-box">
			<input name="chkAU" type="checkbox" value="Y" <?php if ( $chkAU == "Y" ) { echo 'checked="checked"'; } ?>>Australia
		</div>
		<div class="stat-box">
			<input name="chkAX" type="checkbox" value="Y" <?php if ( $chkAX == "Y" ) { echo 'checked="checked"'; } ?>>Aland Islands
		</div>
		<div class="stat-box">
			<input name="chkAZ" type="checkbox" value="Y" <?php if ( $chkAZ == "Y" ) { echo 'checked="checked"'; } ?>>Azerbaijan
		</div>
		<div class="stat-box">
			<input name="chkBA" type="checkbox" value="Y" <?php if ( $chkBA == "Y" ) { echo 'checked="checked"'; } ?>>Bosnia And Herzegovina
		</div>
		<div class="stat-box">
			<input name="chkBB" type="checkbox" value="Y" <?php if ( $chkBB == "Y" ) { echo 'checked="checked"'; } ?>>Barbados
		</div>
		<div class="stat-box">
			<input name="chkBD" type="checkbox" value="Y" <?php if ( $chkBD == "Y" ) { echo 'checked="checked"'; } ?>>Bangladesh
		</div>
		<div class="stat-box">
			<input name="chkBE" type="checkbox" value="Y" <?php if ( $chkBE == "Y" ) { echo 'checked="checked"'; } ?>>Belgium
		</div>
		<div class="stat-box">
			<input name="chkBG" type="checkbox" value="Y" <?php if ( $chkBG == "Y" ) { echo 'checked="checked"'; } ?>>Bulgaria
		</div>
		<div class="stat-box">
			<input name="chkBH" type="checkbox" value="Y" <?php if ( $chkBH == "Y" ) { echo 'checked="checked"'; } ?>>Bahrain
		</div>
		<div class="stat-box">
			<input name="chkBN" type="checkbox" value="Y" <?php if ( $chkBN == "Y" ) { echo 'checked="checked"'; } ?>>Brunei Darussalam
		</div>
		<div class="stat-box">
			<input name="chkBO" type="checkbox" value="Y" <?php if ( $chkBO == "Y" ) { echo 'checked="checked"'; } ?>>Bolivia
		</div>
		<div class="stat-box">
			<input name="chkBR" type="checkbox" value="Y" <?php if ( $chkBR == "Y" ) { echo 'checked="checked"'; } ?>>Brazil
		</div>
		<div class="stat-box">
			<input name="chkBS" type="checkbox" value="Y" <?php if ( $chkBS == "Y" ) { echo 'checked="checked"'; } ?>>Bahamas
		</div>
		<div class="stat-box">
			<input name="chkBY" type="checkbox" value="Y" <?php if ( $chkBY == "Y" ) { echo 'checked="checked"'; } ?>>Belarus
		</div>
		<div class="stat-box">
			<input name="chkBZ" type="checkbox" value="Y" <?php if ( $chkBZ == "Y" ) { echo 'checked="checked"'; } ?>>Belize
		</div>
		<div class="stat-box">
			<input name="chkCA" type="checkbox" value="Y" <?php if ( $chkCA == "Y" ) { echo 'checked="checked"'; } ?>>Canada
		</div>
		<div class="stat-box">
			<input name="chkCD" type="checkbox" value="Y" <?php if ( $chkCD == "Y" ) { echo 'checked="checked"'; } ?>>Congo, Democratic Republic
		</div>
		<div class="stat-box">
			<input name="chkCH" type="checkbox" value="Y" <?php if ( $chkCH == "Y" ) { echo 'checked="checked"'; } ?>>Switzerland
		</div>
		<div class="stat-box">
			<input name="chkCL" type="checkbox" value="Y" <?php if ( $chkCL == "Y" ) { echo 'checked="checked"'; } ?>>Chile
		</div>
		<div class="stat-box">
			<input name="chkCN" type="checkbox" value="Y" <?php if ( $chkCN == "Y" ) { echo 'checked="checked"'; } ?>>China
		</div>
		<div class="stat-box">
			<input name="chkCO" type="checkbox" value="Y" <?php if ( $chkCO == "Y" ) { echo 'checked="checked"'; } ?>>Colombia
		</div>
		<div class="stat-box">
			<input name="chkCR" type="checkbox" value="Y" <?php if ( $chkCR == "Y" ) { echo 'checked="checked"'; } ?>>Costa Rica
		</div>
		<div class="stat-box">
			<input name="chkCU" type="checkbox" value="Y" <?php if ( $chkCU == "Y" ) { echo 'checked="checked"'; } ?>>Cuba
		</div>
		<div class="stat-box">
			<input name="chkCW" type="checkbox" value="Y" <?php if ( $chkCW == "Y" ) { echo 'checked="checked"'; } ?>>CuraÃ§ao
		</div>
		<div class="stat-box">
			<input name="chkCY" type="checkbox" value="Y" <?php if ( $chkCY == "Y" ) { echo 'checked="checked"'; } ?>>Cyprus
		</div>
		<div class="stat-box">
			<input name="chkCZ" type="checkbox" value="Y" <?php if ( $chkCZ == "Y" ) { echo 'checked="checked"'; } ?>>Czech Republic
		</div>
		<div class="stat-box">
			<input name="chkDE" type="checkbox" value="Y" <?php if ( $chkDE == "Y" ) { echo 'checked="checked"'; } ?>>Germany
		</div>
		<div class="stat-box">
			<input name="chkDK" type="checkbox" value="Y" <?php if ( $chkDK == "Y" ) { echo 'checked="checked"'; } ?>>Denmark
		</div>
		<div class="stat-box">
			<input name="chkDO" type="checkbox" value="Y" <?php if ( $chkDO == "Y" ) { echo 'checked="checked"'; } ?>>Dominican Republic
		</div>
		<div class="stat-box">
			<input name="chkDZ" type="checkbox" value="Y" <?php if ( $chkDZ == "Y" ) { echo 'checked="checked"'; } ?>>Algeria
		</div>
		<div class="stat-box">
			<input name="chkEC" type="checkbox" value="Y" <?php if ( $chkEC == "Y" ) { echo 'checked="checked"'; } ?>>Ecuador
		</div>
		<div class="stat-box">
			<input name="chkEE" type="checkbox" value="Y" <?php if ( $chkEE == "Y" ) { echo 'checked="checked"'; } ?>>Estonia
		</div>
		<div class="stat-box">
			<input name="chkES" type="checkbox" value="Y" <?php if ( $chkES == "Y" ) { echo 'checked="checked"'; } ?>>Spain
		</div>
		<div class="stat-box">
			<input name="chkEU" type="checkbox" value="Y" <?php if ( $chkEU == "Y" ) { echo 'checked="checked"'; } ?>>European Union
		</div>
		<div class="stat-box">
			<input name="chkFI" type="checkbox" value="Y" <?php if ( $chkFI == "Y" ) { echo 'checked="checked"'; } ?>>Finland
		</div>
		<div class="stat-box">
			<input name="chkFJ" type="checkbox" value="Y" <?php if ( $chkFJ == "Y" ) { echo 'checked="checked"'; } ?>>Fiji
		</div>
		<div class="stat-box">
			<input name="chkFR" type="checkbox" value="Y" <?php if ( $chkFR == "Y" ) { echo 'checked="checked"'; } ?>>France
		</div>
		<div class="stat-box">
			<input name="chkGB" type="checkbox" value="Y" <?php if ( $chkGB == "Y" ) { echo 'checked="checked"'; } ?>>Great Britain
		</div>
		<div class="stat-box">
			<input name="chkGE" type="checkbox" value="Y" <?php if ( $chkGE == "Y" ) { echo 'checked="checked"'; } ?>>Georgia
		</div>
		<div class="stat-box">
			<input name="chkGF" type="checkbox" value="Y" <?php if ( $chkGF == "Y" ) { echo 'checked="checked"'; } ?>>French Guiana
		</div>
		<div class="stat-box">
			<input name="chkGI" type="checkbox" value="Y" <?php if ( $chkGI == "Y" ) { echo 'checked="checked"'; } ?>>Gibraltar
		</div>
		<div class="stat-box">
			<input name="chkGP" type="checkbox" value="Y" <?php if ( $chkGP == "Y" ) { echo 'checked="checked"'; } ?>>Guadeloupe
		</div>
		<div class="stat-box">
			<input name="chkGR" type="checkbox" value="Y" <?php if ( $chkGR == "Y" ) { echo 'checked="checked"'; } ?>>Greece
		</div>
		<div class="stat-box">
			<input name="chkGT" type="checkbox" value="Y" <?php if ( $chkGT == "Y" ) { echo 'checked="checked"'; } ?>>Guatemala
		</div>
		<div class="stat-box">
			<input name="chkGU" type="checkbox" value="Y" <?php if ( $chkGU == "Y" ) { echo 'checked="checked"'; } ?>>Guam
		</div>
		<div class="stat-box">
			<input name="chkGY" type="checkbox" value="Y" <?php if ( $chkGY == "Y" ) { echo 'checked="checked"'; } ?>>Guyana
		</div>
		<div class="stat-box">
			<input name="chkHK" type="checkbox" value="Y" <?php if ( $chkHK == "Y" ) { echo 'checked="checked"'; } ?>>Hong Kong
		</div>
		<div class="stat-box">
			<input name="chkHN" type="checkbox" value="Y" <?php if ( $chkHN == "Y" ) { echo 'checked="checked"'; } ?>>Honduras
		</div>
		<div class="stat-box">
			<input name="chkHR" type="checkbox" value="Y" <?php if ( $chkHR == "Y" ) { echo 'checked="checked"'; } ?>>Croatia
		</div>
		<div class="stat-box">
			<input name="chkHT" type="checkbox" value="Y" <?php if ( $chkHT == "Y" ) { echo 'checked="checked"'; } ?>>Haiti
		</div>
		<div class="stat-box">
			<input name="chkHU" type="checkbox" value="Y" <?php if ( $chkHU == "Y" ) { echo 'checked="checked"'; } ?>>Hungary
		</div>
		<div class="stat-box">
			<input name="chkID" type="checkbox" value="Y" <?php if ( $chkID == "Y" ) { echo 'checked="checked"'; } ?>>Indonesia
		</div>
		<div class="stat-box">
			<input name="chkIE" type="checkbox" value="Y" <?php if ( $chkIE == "Y" ) { echo 'checked="checked"'; } ?>>Ireland
		</div>
		<div class="stat-box">
			<input name="chkIL" type="checkbox" value="Y" <?php if ( $chkIL == "Y" ) { echo 'checked="checked"'; } ?>>Israel
		</div>
		<div class="stat-box">
			<input name="chkIN" type="checkbox" value="Y" <?php if ( $chkIN == "Y" ) { echo 'checked="checked"'; } ?>>India
		</div>
		<div class="stat-box">
			<input name="chkIQ" type="checkbox" value="Y" <?php if ( $chkIQ == "Y" ) { echo 'checked="checked"'; } ?>>Iraq
		</div>
		<div class="stat-box">
			<input name="chkIR" type="checkbox" value="Y" <?php if ( $chkIR == "Y" ) { echo 'checked="checked"'; } ?>>Iran, Islamic Republic Of
		</div>
		<div class="stat-box">
			<input name="chkIS" type="checkbox" value="Y" <?php if ( $chkIS == "Y" ) { echo 'checked="checked"'; } ?>>Iceland
		</div>
		<div class="stat-box">
			<input name="chkIT" type="checkbox" value="Y" <?php if ( $chkIT == "Y" ) { echo 'checked="checked"'; } ?>>Italy
		</div>
		<div class="stat-box">
			<input name="chkJM" type="checkbox" value="Y" <?php if ( $chkJM == "Y" ) { echo 'checked="checked"'; } ?>>Jamaica
		</div>
		<div class="stat-box">
			<input name="chkJO" type="checkbox" value="Y" <?php if ( $chkJO == "Y" ) { echo 'checked="checked"'; } ?>>Jordan
		</div>
		<div class="stat-box">
			<input name="chkJP" type="checkbox" value="Y" <?php if ( $chkJP == "Y" ) { echo 'checked="checked"'; } ?>>Japan
		</div>
		<div class="stat-box">
			<input name="chkKE" type="checkbox" value="Y" <?php if ( $chkKE == "Y" ) { echo 'checked="checked"'; } ?>>Kenya
		</div>
		<div class="stat-box">
			<input name="chkKG" type="checkbox" value="Y" <?php if ( $chkKG == "Y" ) { echo 'checked="checked"'; } ?>>Kyrgyzstan
		</div>
		<div class="stat-box">
			<input name="chkKH" type="checkbox" value="Y" <?php if ( $chkKH == "Y" ) { echo 'checked="checked"'; } ?>>Cambodia
		</div>
		<div class="stat-box">
			<input name="chkKR" type="checkbox" value="Y" <?php if ( $chkKR == "Y" ) { echo 'checked="checked"'; } ?>>Korea
		</div>
		<div class="stat-box">
			<input name="chkKW" type="checkbox" value="Y" <?php if ( $chkKW == "Y" ) { echo 'checked="checked"'; } ?>>Kuwait
		</div>
		<div class="stat-box">
			<input name="chkKY" type="checkbox" value="Y" <?php if ( $chkKY == "Y" ) { echo 'checked="checked"'; } ?>>Cayman Islands
		</div>
		<div class="stat-box">
			<input name="chkKZ" type="checkbox" value="Y" <?php if ( $chkKZ == "Y" ) { echo 'checked="checked"'; } ?>>Kazakhstan
		</div>
		<div class="stat-box">
			<input name="chkLA" type="checkbox" value="Y" <?php if ( $chkLA == "Y" ) { echo 'checked="checked"'; } ?>>Lao People's Democratic Republic
		</div>
		<div class="stat-box">
			<input name="chkLB" type="checkbox" value="Y" <?php if ( $chkLB == "Y" ) { echo 'checked="checked"'; } ?>>Lebanon
		</div>
		<div class="stat-box">
			<input name="chkLK" type="checkbox" value="Y" <?php if ( $chkLK == "Y" ) { echo 'checked="checked"'; } ?>>Sri Lanka
		</div>
		<div class="stat-box">
			<input name="chkLT" type="checkbox" value="Y" <?php if ( $chkLT == "Y" ) { echo 'checked="checked"'; } ?>>Lithuania
		</div>
		<div class="stat-box">
			<input name="chkLU" type="checkbox" value="Y" <?php if ( $chkLU == "Y" ) { echo 'checked="checked"'; } ?>>Luxembourg
		</div>
		<div class="stat-box">
			<input name="chkLV" type="checkbox" value="Y" <?php if ( $chkLV == "Y" ) { echo 'checked="checked"'; } ?>>Latvia
		</div>
		<div class="stat-box">
			<input name="chkMD" type="checkbox" value="Y" <?php if ( $chkMD == "Y" ) { echo 'checked="checked"'; } ?>>Moldova
		</div>
		<div class="stat-box">
			<input name="chkME" type="checkbox" value="Y" <?php if ( $chkME == "Y" ) { echo 'checked="checked"'; } ?>>Montenegro
		</div>
		<div class="stat-box">
			<input name="chkMK" type="checkbox" value="Y" <?php if ( $chkMK == "Y" ) { echo 'checked="checked"'; } ?>>Macedonia
		</div>
		<div class="stat-box">
			<input name="chkMM" type="checkbox" value="Y" <?php if ( $chkMM == "Y" ) { echo 'checked="checked"'; } ?>>Myanmar
		</div>
		<div class="stat-box">
			<input name="chkMN" type="checkbox" value="Y" <?php if ( $chkMN == "Y" ) { echo 'checked="checked"'; } ?>>Mongolia
		</div>
		<div class="stat-box">
			<input name="chkMO" type="checkbox" value="Y" <?php if ( $chkMO == "Y" ) { echo 'checked="checked"'; } ?>>Macao
		</div>
		<div class="stat-box">
			<input name="chkMP" type="checkbox" value="Y" <?php if ( $chkMP == "Y" ) { echo 'checked="checked"'; } ?>>Northern Mariana Islands
		</div>
		<div class="stat-box">
			<input name="chkMQ" type="checkbox" value="Y" <?php if ( $chkMQ == "Y" ) { echo 'checked="checked"'; } ?>>Martinique
		</div>
		<div class="stat-box">
			<input name="chkMT" type="checkbox" value="Y" <?php if ( $chkMT == "Y" ) { echo 'checked="checked"'; } ?>>Malta
		</div>
		<div class="stat-box">
			<input name="chkMV" type="checkbox" value="Y" <?php if ( $chkMV == "Y" ) { echo 'checked="checked"'; } ?>>Maldives
		</div>
		<div class="stat-box">
			<input name="chkMX" type="checkbox" value="Y" <?php if ( $chkMX == "Y" ) { echo 'checked="checked"'; } ?>>Mexico
		</div>
		<div class="stat-box">
			<input name="chkMY" type="checkbox" value="Y" <?php if ( $chkMY == "Y" ) { echo 'checked="checked"'; } ?>>Malaysia
		</div>
		<div class="stat-box">
			<input name="chkNC" type="checkbox" value="Y" <?php if ( $chkNC == "Y" ) { echo 'checked="checked"'; } ?>>New Caledonia
		</div>
		<div class="stat-box">
			<input name="chkNI" type="checkbox" value="Y" <?php if ( $chkNI == "Y" ) { echo 'checked="checked"'; } ?>>Nicaragua
		</div>
		<div class="stat-box">
			<input name="chkNL" type="checkbox" value="Y" <?php if ( $chkNL == "Y" ) { echo 'checked="checked"'; } ?>>Netherlands
		</div>
		<div class="stat-box">
			<input name="chkNO" type="checkbox" value="Y" <?php if ( $chkNO == "Y" ) { echo 'checked="checked"'; } ?>>Norway
		</div>
		<div class="stat-box">
			<input name="chkNP" type="checkbox" value="Y" <?php if ( $chkNP == "Y" ) { echo 'checked="checked"'; } ?>>Nepal
		</div>
		<div class="stat-box">
			<input name="chkNZ" type="checkbox" value="Y" <?php if ( $chkNZ == "Y" ) { echo 'checked="checked"'; } ?>>New Zealand
		</div>
		<div class="stat-box">
			<input name="chkOM" type="checkbox" value="Y" <?php if ( $chkOM == "Y" ) { echo 'checked="checked"'; } ?>>Oman
		</div>
		<div class="stat-box">
			<input name="chkPA" type="checkbox" value="Y" <?php if ( $chkPA == "Y" ) { echo 'checked="checked"'; } ?>>Panama
		</div>
		<div class="stat-box">
			<input name="chkPE" type="checkbox" value="Y" <?php if ( $chkPE == "Y" ) { echo 'checked="checked"'; } ?>>Peru
		</div>
		<div class="stat-box">
			<input name="chkPG" type="checkbox" value="Y" <?php if ( $chkPG == "Y" ) { echo 'checked="checked"'; } ?>>Papua New Guinea
		</div>
		<div class="stat-box">
			<input name="chkPH" type="checkbox" value="Y" <?php if ( $chkPH == "Y" ) { echo 'checked="checked"'; } ?>>Philippines
		</div>
		<div class="stat-box">
			<input name="chkPK" type="checkbox" value="Y" <?php if ( $chkPK == "Y" ) { echo 'checked="checked"'; } ?>>Pakistan
		</div>
		<div class="stat-box">
			<input name="chkPL" type="checkbox" value="Y" <?php if ( $chkPL == "Y" ) { echo 'checked="checked"'; } ?>>Poland
		</div>
		<div class="stat-box">
			<input name="chkPR" type="checkbox" value="Y" <?php if ( $chkPR == "Y" ) { echo 'checked="checked"'; } ?>>Puerto Rico
		</div>
		<div class="stat-box">
			<input name="chkPS" type="checkbox" value="Y" <?php if ( $chkPS == "Y" ) { echo 'checked="checked"'; } ?>>Palestinian Territory, Occupied
		</div>
		<div class="stat-box">
			<input name="chkPT" type="checkbox" value="Y" <?php if ( $chkPT == "Y" ) { echo 'checked="checked"'; } ?>>Portugal
		</div>
		<div class="stat-box">
			<input name="chkPW" type="checkbox" value="Y" <?php if ( $chkPW == "Y" ) { echo 'checked="checked"'; } ?>>Palau
		</div>
		<div class="stat-box">
			<input name="chkPY" type="checkbox" value="Y" <?php if ( $chkPY == "Y" ) { echo 'checked="checked"'; } ?>>Paraguay
		</div>
		<div class="stat-box">
			<input name="chkQA" type="checkbox" value="Y" <?php if ( $chkQA == "Y" ) { echo 'checked="checked"'; } ?>>Qatar
		</div>
		<div class="stat-box">
			<input name="chkRO" type="checkbox" value="Y" <?php if ( $chkRO == "Y" ) { echo 'checked="checked"'; } ?>>Romania
		</div>
		<div class="stat-box">
			<input name="chkRS" type="checkbox" value="Y" <?php if ( $chkRS == "Y" ) { echo 'checked="checked"'; } ?>>Serbia
		</div>
		<div class="stat-box">
			<input name="chkRU" type="checkbox" value="Y" <?php if ( $chkRU == "Y" ) { echo 'checked="checked"'; } ?>>Russian Federation
		</div>
		<div class="stat-box">
			<input name="chkSA" type="checkbox" value="Y" <?php if ( $chkSA == "Y" ) { echo 'checked="checked"'; } ?>>Saudi Arabia
		</div>
		<div class="stat-box">
			<input name="chkSC" type="checkbox" value="Y" <?php if ( $chkSC == "Y" ) { echo 'checked="checked"'; } ?>>Seychelles
		</div>
		<div class="stat-box">
			<input name="chkSE" type="checkbox" value="Y" <?php if ( $chkSE == "Y" ) { echo 'checked="checked"'; } ?>>Sweden
		</div>
		<div class="stat-box">
			<input name="chkSG" type="checkbox" value="Y" <?php if ( $chkSG == "Y" ) { echo 'checked="checked"'; } ?>>Singapore
		</div>
		<div class="stat-box">
			<input name="chkSI" type="checkbox" value="Y" <?php if ( $chkSI == "Y" ) { echo 'checked="checked"'; } ?>>Slovenia
		</div>
		<div class="stat-box">
			<input name="chkSK" type="checkbox" value="Y" <?php if ( $chkSK == "Y" ) { echo 'checked="checked"'; } ?>>Slovakia
		</div>
		<div class="stat-box">
			<input name="chkSV" type="checkbox" value="Y" <?php if ( $chkSV == "Y" ) { echo 'checked="checked"'; } ?>>El Salvador
		</div>
		<div class="stat-box">
			<input name="chkSX" type="checkbox" value="Y" <?php if ( $chkSX == "Y" ) { echo 'checked="checked"'; } ?>>Sint Maarten
		</div>
		<div class="stat-box">
			<input name="chkSY" type="checkbox" value="Y" <?php if ( $chkSY == "Y" ) { echo 'checked="checked"'; } ?>>Syrian Arab Republic
		</div>
		<div class="stat-box">
			<input name="chkTH" type="checkbox" value="Y" <?php if ( $chkTH == "Y" ) { echo 'checked="checked"'; } ?>>Thailand
		</div>
		<div class="stat-box">
			<input name="chkTJ" type="checkbox" value="Y" <?php if ( $chkTJ == "Y" ) { echo 'checked="checked"'; } ?>>Tajikistan
		</div>
		<div class="stat-box">
			<input name="chkTM" type="checkbox" value="Y" <?php if ( $chkTM == "Y" ) { echo 'checked="checked"'; } ?>>Turkmenistan
		</div>
		<div class="stat-box">
			<input name="chkTR" type="checkbox" value="Y" <?php if ( $chkTR == "Y" ) { echo 'checked="checked"'; } ?>>Turkey
		</div>
		<div class="stat-box">
			<input name="chkTT" type="checkbox" value="Y" <?php if ( $chkTT == "Y" ) { echo 'checked="checked"'; } ?>>Trinidad And Tobago
		</div>
		<div class="stat-box">
			<input name="chkTW" type="checkbox" value="Y" <?php if ( $chkTW == "Y" ) { echo 'checked="checked"'; } ?>>Taiwan
		</div>
		<div class="stat-box">
			<input name="chkUA" type="checkbox" value="Y" <?php if ( $chkUA == "Y" ) { echo 'checked="checked"'; } ?>>Ukraine
		</div>
		<div class="stat-box">
			<input name="chkUK" type="checkbox" value="Y" <?php if ( $chkUK == "Y" ) { echo 'checked="checked"'; } ?>>United Kingdom
		</div>
		<div class="stat-box">
			<input name="chkUS" type="checkbox" value="Y" <?php if ( $chkUS == "Y" ) { echo 'checked="checked"'; } ?>>United States
		</div>
		<div class="stat-box">
			<input name="chkUY" type="checkbox" value="Y" <?php if ( $chkUY == "Y" ) { echo 'checked="checked"'; } ?>>Uruguay
		</div>
		<div class="stat-box">
			<input name="chkUZ" type="checkbox" value="Y" <?php if ( $chkUZ == "Y" ) { echo 'checked="checked"'; } ?>>Uzbekistan
		</div>
		<div class="stat-box">
			<input name="chkVC" type="checkbox" value="Y" <?php if ( $chkVC == "Y" ) { echo 'checked="checked"'; } ?>>Saint Vincent And Grenadines
		</div>
		<div class="stat-box">
			<input name="chkVE" type="checkbox" value="Y" <?php if ( $chkVE == "Y" ) { echo 'checked="checked"'; } ?>>Venezuela
		</div>
		<div class="stat-box">
			<input name="chkVN" type="checkbox" value="Y" <?php if ( $chkVN == "Y" ) { echo 'checked="checked"'; } ?>>Viet Nam
		</div>
		<div class="stat-box">
			<input name="chkYE" type="checkbox" value="Y" <?php if ( $chkYE == "Y" ) { echo 'checked="checked"'; } ?>>Yemen
		</div>
		<br style="clear:both">
		<p class="submit"><input class="button-primary" value="<?php _e( 'Save Changes', 'stop-spammer-registrations-plugin' ); ?>" type="submit"></p>
	</form>
</div>
