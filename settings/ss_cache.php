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
// temp: not used in file
$nonce   = "";
$ajaxurl = admin_url( 'admin-ajax.php' );

// update options
if ( array_key_exists( 'ss_stop_spammers_control', $_POST ) ) {
	$nonce = $_POST['ss_stop_spammers_control'];
}

if ( !empty( $nonce ) && wp_verify_nonce( $nonce, 'ss_stopspam_update' ) ) {
	if ( array_key_exists( 'update_options', $_POST ) ) {
		if ( array_key_exists( 'ss_sp_cache', $_POST ) ) {
			$ss_sp_cache			= stripslashes( sanitize_text_field( $_POST['ss_sp_cache'] ) );
			$options['ss_sp_cache'] = $ss_sp_cache;
		}
		if ( array_key_exists( 'ss_sp_good', $_POST ) ) {
			$ss_sp_good			   = stripslashes( sanitize_text_field( $_POST['ss_sp_good'] ) );
			$options['ss_sp_good'] = $ss_sp_good;
		}
		ss_set_options( $options );
	}
}

// clear the cache
if ( array_key_exists( 'ss_stop_spammers_control', $_POST ) ) {
	$nonce = $_POST['ss_stop_spammers_control'];
}

if ( wp_verify_nonce( $nonce, 'ss_stopspam_update' ) ) {
	if ( array_key_exists( 'ss_stop_clear_cache', $_POST ) ) {
		// clear the cache
		$badips		      = array();
		$goodips		  = array();
		$stats['badips']  = $badips;
		$stats['goodips'] = $goodips;
		ss_set_stats( $stats );
		echo '<div class="notice notice-success"><p>' . __( 'Cache Cleared', 'stop-spammer-registrations-plugin' ) . '</p></div>';
	}
	$msg = '<div class="notice notice-success is-dismissible"><p>' . __( 'Options Updated', 'stop-spammer-registrations-plugin' ) . '</p></div>';
}

$nonce = wp_create_nonce( 'ss_stopspam_update' );

?>

<div id="ss-plugin" class="wrap">
	<h1 class="ss_head">Stop Spammers — <?php _e( 'Cache', 'stop-spammer-registrations-plugin' ); ?></h1>
	<?php
	if ( !empty( $msg ) ) {
		echo $msg;
	} ?>
	<br>
	<div class="ss_info_box">
	<?php _e( '
		<p>Whenever a user tries to leave a comment, register, or login, they are
		recorded in the Good Cache if they pass or the Bad Cache if they fail.
		If a user is blocked from access, they are added to the Bad Cache. You
		can see the caches here. To learn more about caching, 
		please <a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-IP-Cache" target="_blank">review our documentation</a>.</p>
	', 'stop-spammer-registrations-plugin' ); ?>
	<form method="post" action="">
		<input type="hidden" name="update_options" value="update">
		<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>">
		<label class="keyhead">
			<?php _e( 'Bad IP Cache Size', 'stop-spammer-registrations-plugin' ); ?>
			<br>
			<select name="ss_sp_cache">
				<option value="0" <?php if ( $ss_sp_cache == '0' ) { echo 'selected="true"'; } ?>>0</option>
				<option value="10" <?php if ( $ss_sp_cache == '10' ) { echo 'selected="true"'; } ?>>10</option>
				<option value="25" <?php if ( $ss_sp_cache == '25' ) { echo 'selected="true"'; } ?>>25</option>
				<option value="50" <?php if ( $ss_sp_cache == '50' ) { echo 'selected="true"'; } ?>>50</option>
				<option value="75" <?php if ( $ss_sp_cache == '75' ) { echo 'selected="true"'; } ?>>75</option>
				<option value="100" <?php if ( $ss_sp_cache == '100' ) { echo 'selected="true"'; } ?>>100</option>
				<option value="200" <?php if ( $ss_sp_cache == '200' ) { echo 'selected="true"'; } ?>>200</option>
			</select>
		</label>
		<br>
		<br>
		<label class="keyhead">
			<?php _e( 'Good IP Cache Size', 'stop-spammer-registrations-plugin' ); ?>
			<br>
			<select name="ss_sp_good">
				<option value="1" <?php if ( $ss_sp_good == '1' ) { echo 'selected="true"'; } ?>>1</option>
				<option value="2" <?php if ( $ss_sp_good == '2' ) { echo 'selected="true"'; } ?>>2</option>
				<option value="3" <?php if ( $ss_sp_good == '3' ) { echo 'selected="true"'; } ?>>3</option>
				<option value="4" <?php if ( $ss_sp_good == '4' ) { echo 'selected="true"'; } ?>>4</option>
				<option value="10" <?php if ( $ss_sp_good == '10' ) { echo 'selected="true"'; } ?>>10</option>
				<option value="25" <?php if ( $ss_sp_good == '25' ) { echo 'selected="true"'; } ?>>25</option>
				<option value="50" <?php if ( $ss_sp_good == '50' ) { echo 'selected="true"'; } ?>>50</option>
				<option value="75" <?php if ( $ss_sp_good == '75' ) { echo 'selected="true"'; } ?>>75</option>
				<option value="100" <?php if ( $ss_sp_good == '100' ) { echo 'selected="true"'; } ?>>100</option>
				<option value="200" <?php if ( $ss_sp_good == '200' ) { echo 'selected="true"'; } ?>>200</option>
			</select>
		</label>
		<br>
		<p class="submit"><input class="button-primary" value="<?php _e( 'Save Changes', 'stop-spammer-registrations-plugin' ); ?>" type="submit"></p>
	</form>
	<?php
	if ( count( $badips ) == 0 && count( $goodips ) == 0 ) {
		_e( 'Nothing in the cache.', 'stop-spammer-registrations-plugin' );
	} else {
		?>
		<h2><?php _e( 'Cached Values', 'stop-spammer-registrations-plugin' ); ?></h2>
		<form method="post" action="">
			<input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>">
			<input type="hidden" name="ss_stop_clear_cache" value="true">
			<p class="submit"><input class="button-primary" value="<?php _e( 'Clear the Cache', 'stop-spammer-registrations-plugin' ); ?>" type="submit"></p>
		</form>
		<table>
			<tr>
				<?php
				if ( count( $badips ) > 0 ) {
					arsort( $badips );
					?>
					<td width="30%"><?php _e( 'Bad IPs', 'stop-spammer-registrations-plugin' ); ?></td>
					<?php
				}
				?>
				<?php
				if ( count( $goodips ) > 0 ) {
					?>
					<td width="30%"><?php _e( 'Good IPs', 'stop-spammer-registrations-plugin' ); ?></td>
					<?php
				}
				?>
			</tr>
			<tr>
				<?php
				if ( count( $badips ) > 0 ) {
					?>
					<td valign="top" id="badips"><?php
						// use the be_load to get badips
						$show = be_load( 'ss_get_bcache', 'x', $stats,
							$options );
						echo $show;
						?></td>
					<?php
				}
				?>
				<?php
				if ( count( $goodips ) > 0 ) {
					arsort( $goodips );
					?>
					<td valign="top" id="goodips"><?php
						// use the be_load to get badips
						$show = be_load( 'ss_get_gcache', 'x', $stats,
							$options );
						echo $show;
						?></td>
					<?php
				}
				?>
			</tr>
		</table>
		<?php
	}
?>
