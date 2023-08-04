<?php
/*
ss-mu-options.php
provides mu support to the Stop Spammers plugin
this hooks the options functions of WP in order to update one option from blog #1`
*/

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

// now we need to get a ask the user for a list of options that he wants to get
// call the setup from the plugin proper
// ssp_global_setup(); // when plugin is loaded this get's done
$ssp_semaphore = 0;
// add the options - since the add action is already implied at the load_plugins level we don't need to add_action 
// get a list of option names and values from the site config
// user must be able to 'manage_network_plugins' to see the plugin
// user must be able to 'manage_network_options' to change the plugin
/***********************************************
 * ss_mu_options
 * this installs the global hooks and redirects
 * all plugin options to blog #1
 ***********************************************/
function ssp_global_setup() {
	global $blog_id;
	if ( $blog_id == 1 ) {
		return;
	}
	$ops = array( 'ss_stop_sp_reg_stats', 'ss_stop_sp_reg_options' );
	foreach ( $ops as $value ) {
		add_filter( 'pre_update_option_' . $value, 'ssp_global_set', 10, 2 );
		add_filter( 'add_option_' . $value, 'ssp_global_add', 1, 2 );
		add_filter( 'delete_option_' . $value, 'ssp_global_delete' );
		add_filter( 'pre_option_' . $value, 'ssp_global_get', 1 );
	}
}

function ssp_global_set( $newvalue, $oldvalue ) {
	if ( !function_exists( 'switch_to_blog' ) ) {
		return $newvalue;
	}
	global $ssp_semaphore;
	if ( $ssp_semaphore ) {
		return $newvalue;
	}
	$ssp_semaphore ++;
	$filt = current_filter();
	$f	= substr( $filt, strlen( 'pre_update_option_' ) );
	// now add to list of options we are hooking
	switch_to_blog( 1 );
	$ansa = update_option( $f, $newvalue );
	restore_current_blog();
	$ssp_semaphore --;
	return $oldvalue; // returning the old value keeps the add from updating the current
}

function ssp_global_add( $option, $value ) {
	if ( !function_exists( 'switch_to_blog' ) ) {
		return false;
	}
	global $ssp_semaphore;
	if ( $ssp_semaphore ) {
		return false;
	}
	$ssp_semaphore ++;
	$filt = current_filter();
	$f	  = substr( $filt, strlen( 'add_option_' ) );
	// now add to list of options we are hooking
	switch_to_blog( 1 );
	// echo '<br>Updating $f, $value <br>';
	$ansa = update_option( $f, $value );
	restore_current_blog();
	$ssp_semaphore --;
	return true; // functions.php ignores result anyway
}

function ssp_global_get( $option ) {
	if ( !function_exists( 'switch_to_blog' ) ) {
		return false;
	}
	global $ssp_semaphore;
	if ( $ssp_semaphore ) {
		return false;
	}
	$ssp_semaphore ++;
	$filt = current_filter();
	$f	= substr( $filt, strlen( 'pre_option_' ) );
	// switch to main blog
	// undo the filter to prevent deadly recursion
	switch_to_blog( 1 );
	$ansa = get_option( $f );
	restore_current_blog();
	// restore the filter
	$ssp_semaphore --;
	return $ansa;
}

function ssp_global_Delete( $ops ) {
	if ( !function_exists( 'switch_to_blog' ) ) {
		return false;
	}
	global $ssp_semaphore;
	if ( $ssp_semaphore ) {
		return false;
	}
	$ssp_semaphore ++;
	$filt = current_filter();
	$f	  = substr( $filt, strlen( 'delete_option_' ) );
	switch_to_blog( 1 );
	$ansa = delete_option( $ops );
	restore_current_blog();
	$ssp_semaphore --;
	return $ansa;
}

function ssp_global_unsetup() {
	// if someone set the mu global options flag to 'N' then we have to unset the global setup
	$ops = array( 'ss_stop_sp_reg_stats', 'ss_stop_sp_reg_options' );
	foreach ( $ops as $value ) {
		remove_filter( 'pre_update_option_' . $value, 'ss_pf_global_set', 10, 2 );
		remove_filter( 'add_option_' . $value, 'ss_pf_global_add', 1, 2 );
		remove_filter( 'delete_option_' . $value, 'ss_pf_global_delete' );
		remove_filter( 'pre_option_' . $value, 'ss_pf_global_get', 1 );
	}
	return;
}

?>