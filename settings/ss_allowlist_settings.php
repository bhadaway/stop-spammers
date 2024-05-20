<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

if ( !current_user_can( 'manage_options' ) ) {
	die( __( 'Access Blocked', 'stop-spammer-registrations-plugin' ) );
}

ss_fix_post_vars();
$stats   = ss_get_stats();
extract( $stats );
$now	 = date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
$options = ss_get_options();
extract( $options );
$stats   = ss_get_stats();
extract( $stats );
$trash   = SS_PLUGIN_URL . 'images/trash.png';
$tdown   = SS_PLUGIN_URL . 'images/tdown.png';
$tup	 = SS_PLUGIN_URL . 'images/tup.png'; // fix this
$whois   = SS_PLUGIN_URL . 'images/whois.png'; // fix this
$chkcloudflare = 'Y'; // force back to on - always fix Cloudflare if the plugin is not present and Cloudflare detected
$nonce   = '';
$ajaxurl = admin_url( 'admin-ajax.php' );

// update options
if ( array_key_exists( 'ss_stop_spammers_control', $_POST ) ) {
	$nonce = $_POST['ss_stop_spammers_control'];
}

if ( !empty( $nonce ) && wp_verify_nonce( $nonce, 'ss_stopspam_update' ) ) {
	if ( array_key_exists( 'ss_stop_clear_wlreq', $_POST ) ) {
		$wlrequests			 = array();
		$stats['wlrequests'] = $wlrequests;
		ss_set_stats( $stats );
	}
	if ( array_key_exists( 'wlist', $_POST ) and !array_key_exists( 'ss_stop_clear_wlreq', $_POST ) ) {
		$wlist  = sanitize_textarea_field( $_POST['wlist'] );
		$wlist  = explode( "\n", $wlist );
		$tblist = array();
		foreach ( $wlist as $bl ) {
			$bl = trim( $bl );
			if ( !empty( $bl ) ) {
				$tblist[] = $bl;
			}
		}
		$options['wlist'] = $tblist;
		$wlist			  = $tblist;
	}
	if ( !array_key_exists( 'ss_stop_clear_wlreq', $_POST ) ) {
		$optionlist = array(
			'chkgoogle',
			'chkaws',
			'chkwluserid',
			'chkpaypal',
			'chkstripe',
			'chkauthorizenet',
			'chkbraintree',
			'chkrecurly',
			'chksquare',
			'chkgenallowlist',
			'chkmiscallowlist',
			'chkyahoomerchant'
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
	}
	extract( $options ); // extract again to get the new options
	$msg = __( '<div class="notice notice-success is-dismissible"><p>Options Updated</p></div>', 'stop-spammer-registrations-plugin' );
}

$nonce = wp_create_nonce( 'ss_stopspam_update' );

?>

<div id="ss-plugin" class="wrap">
	<h1 class="ss_head"><?php _e( 'Stop Spammers — Allow Requests & Lists', 'stop-spammer-registrations-plugin' ); ?></h1>
	<?php if ( !empty( $msg ) ) {
		echo $msg;
	} ?>
	<br>
	<br>
	<div class="mainsection"><?php _e( 'Allow List Requests', 'stop-spammer-registrations-plugin' ); ?>
		<sup class="ss_sup"><a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Allow-Requests-&-Lists#allow-requests" target="_blank">?</a></sup>
	</div>
	<?php
	if ( count( $wlrequests ) == 0 ) {
		_e( '<p><strong>There are currently no pending requests.</strong></p>', 'stop-spammer-registrations-plugin' );
	} else { ?>
	<form method="post" action="">
		<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>">
		<input type="hidden" name="ss_stop_clear_wlreq" value="true">
		<p class="submit"><input class="button-primary" value="<?php _e( 'Clear the Requests', 'stop-spammer-registrations-plugin' ); ?>" type="submit"></p>
	</form>
	<table id="sstable" name="sstable" cellspacing="2">
		<thead>
			<tr style="background-color:#675682;color:white;text-align:center;text-transform:uppercase;font-weight:600">
				<th><?php _e( 'Time', 'stop-spammer-registrations-plugin' ); ?></th>
				<th><?php _e( 'IP', 'stop-spammer-registrations-plugin' ); ?></th>
				<th><?php _e( 'Email', 'stop-spammer-registrations-plugin' ); ?></th>
				<th><?php _e( 'Reason', 'stop-spammer-registrations-plugin' ); ?></th>
				<th><?php _e( 'Message', 'stop-spammer-registrations-plugin' ); ?></th>
			</tr>
		</thead>
		<tbody id="wlreq">
			<?php
			$show = '';
			$cont = 'wlreqs';
			// wlrequs has an array of arrays
			// time, ip, email, author, reason, info, sname
			// time, ip, email, author, reason, info, sname
			// use the be_load to get badips
			$options = ss_get_options();
			$stats   = ss_get_stats();
			$show	 = be_load( 'ss_get_alreq', 'x', $stats, $options );
			echo $show;
			?>
		</tbody>
	</table>
	<?php } ?>
	<form method="post" action="">
		<input type="hidden" name="action" value="update">
		<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>">
		<div class="mainsection"><?php _e( 'Personalized Allow List', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Allow-Requests-&-Lists#personalized-allow-list" target="_blank">?</a></sup>
		</div>
		<?php _e( '
			<p>Put IP addresses or emails here that you don\'t want blocked.
			One email or IP to a line. You can use wild cards here for
			emails. These are checked first so they override any blocking.</p>
		', 'stop-spammer-registrations-plugin' ); ?>
		<div class="checkbox switcher">
	  		<label id="ss_subhead" for="chkwluserid">
				<input class="ss_toggle" type="checkbox" id="chkwluserid" name="chkwluserid" value="Y" <?php if ( $chkwluserid == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
		  		<small><span style="font-size:16px!important"><?php _e( 'Enable Allow by Username (not recommended)', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<textarea name="wlist" cols="40" rows="8" class="ipbox"><?php
			for ( $k = 0; $k < count( $wlist ); $k ++ ) {
				echo $wlist[$k] . "\r\n";
			}
		?></textarea>
		<br>
		<div class="mainsection"><?php _e( 'Allow Options', 'stop-spammer-registrations-plugin' ); ?>
			<sup class="ss_sup"><a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Allow-Requests-&-Lists#allow-options" target="_blank">?</a></sup>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkgoogle">
				<input class="ss_toggle" type="checkbox" id="chkgoogle" name="chkgoogle" value="Y" <?php if ( $chkgoogle == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Google (keep enabled under most circumstances)', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
	  		<label id="ss_subhead" for="chkgenallowlist">
				<input class="ss_toggle" type="checkbox" id="chkgenallowlist" name="chkgenallowlist" value="Y" <?php if ( $chkgenallowlist == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Generated Allow List', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
	  		<label id="ss_subhead" for="chkmiscallowlist">
				<input class="ss_toggle" type="checkbox" id="chkmiscallowlist" name="chkmiscallowlist" value="Y" <?php if ( $chkmiscallowlist == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Other Allow Lists', 'stop-spammer-registrations-plugin' ); ?></span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
	  		<label id="ss_subhead" for="chkpaypal">
				<input class="ss_toggle" type="checkbox" id="chkpaypal" name="chkpaypal" value="Y" <?php if ( $chkpaypal == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
		  		<small><span style="font-size:16px!important"><?php _e( 'Allow', 'stop-spammer-registrations-plugin' ); ?> PayPal</span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
	  		<label id="ss_subhead" for="chkstripe">
				<input class="ss_toggle" type="checkbox" id="chkstripe" name="chkstripe" value="Y" <?php if ( $chkstripe == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Allow', 'stop-spammer-registrations-plugin' ); ?> Stripe</span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
	  		<label id="ss_subhead" for="chkauthorizenet">
				<input class="ss_toggle" type="checkbox" id="chkauthorizenet" name="chkauthorizenet" value="Y" <?php if ( $chkauthorizenet == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Allow', 'stop-spammer-registrations-plugin' ); ?> Authorize.Net</span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
	  		<label id="ss_subhead" for="chkbraintree">
				<input class="ss_toggle" type="checkbox" id="chkbraintree" name="chkbraintree" value="Y" <?php if ( $chkbraintree == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Allow', 'stop-spammer-registrations-plugin' ); ?> Braintree</span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
	  		<label id="ss_subhead" for="chkrecurly">
				<input class="ss_toggle" type="checkbox" id="chkrecurly" name="chkrecurly" value="Y" <?php if ( $chkrecurly == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Allow', 'stop-spammer-registrations-plugin' ); ?> Recurly</span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
	  		<label id="ss_subhead" for="chksquare">
				<input class="ss_toggle" type="checkbox" id="chksquare" name="chksquare" value="Y" <?php if ( $chksquare == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
		  		<small><span style="font-size:16px!important"><?php _e( 'Allow', 'stop-spammer-registrations-plugin' ); ?> Square</span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
	  		<label id="ss_subhead" for="chkyahoomerchant">
				<input class="ss_toggle" type="checkbox" id="chkyahoomerchant" name="chkyahoomerchant" value="Y" <?php if ( $chkyahoomerchant == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Allow', 'stop-spammer-registrations-plugin' ); ?> Yahoo Merchant Services</span></small>
			</label>
		</div>
		<br>
		<div class="checkbox switcher">
			<label id="ss_subhead" for="chkaws">
				<input class="ss_toggle" type="checkbox" id="chkaws" name="chkaws" value="Y" <?php if ( $chkaws == 'Y' ) { echo 'checked="checked"'; } ?>><span><small></small></span>
				<small><span style="font-size:16px!important"><?php _e( 'Allow', 'stop-spammer-registrations-plugin' ); ?> Amazon Cloud</span></small>
			</label>
		</div>
		<br>
		<p class="submit"><input class="button-primary" value="<?php _e( 'Save Changes', 'stop-spammer-registrations-plugin' ); ?>" type="submit"></p>
	</form>
</div>