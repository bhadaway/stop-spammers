<?php
// dumped the utility functions into its own separate file
// I am trying to keep the plugin foorprint down as low as possible
// rename each function with an _l and then call after a load

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

function ss_append_file( $filename, &$content ) {
	// this writes content to a file in the uploads director in the 'stop-spammer-registrations' directory
	// changed to write to the current directory - content_dir is a bad place
	$file = SS_PLUGIN_DATA . $filename;
	$f	  = @fopen( $file, 'a' );
	if ( !$f ) {
		return false;
	}
	fwrite( $f, $content );
	fclose( $f );
	@chmod( $file, 0640 ); // read/write for owner and owner groups
	return true;
}

function ss_read_file( $f, $method = 'GET' ) {
	// try this using Wp_Http
	if ( !class_exists( 'WP_Http' ) ) {
		include_once( ABSPATH . WPINC . '/class-http.php' );
	}
	$request		  = new WP_Http;
	$parms			  = array();
	$parms['timeout'] = 10; // bump timeout a little we are timing out in Google
	$parms['method']  = $method;
	$result		      = $request->request( $f, $parms );
	// see if there is anything there
	if ( empty( $result ) ) {
		return '';
	}
	if ( is_array( $result ) ) {
		$ansa = $result['body'];
		return $ansa;
	}
	if ( is_object( $result ) ) {
		$ansa = 'ERR: ' . $result->get_error_message();
		return $ansa; // return $ansa when debugging
		// return '';
	}
	return '';
}

function ss_read_filex( $filename ) {
	// read file
	$file = SS_PLUGIN_DATA . $filename;
	if ( file_exists( $file ) ) {
		return file_get_contents( $file );
	}
	return __( 'File Not Found', 'stop-spammer-registrations-plugin' );
}

function ss_file_exists( $filename ) {
	$file = SS_PLUGIN_DATA . $filename;
	if ( !file_exists( $file ) ) {
		return false;
	}
	return filesize( $file );
}

function ss_file_delete( $filename ) {
	$file = SS_PLUGIN_DATA . $filename;
	return @unlink( $file );
}

// debug functions
// change the debug = false to debug = true to start debugging
// the plugin will drop a file sfs_debug_output.txt in the current directory (root, wp-admin, or network) 
// directory must be writeable or plugin will crash
function sfs_errorsonoff( $old = null ) {
	$debug = true; // change to true to debug, false to stop all debugging
	if ( !$debug ) {
		return;
	}
	if ( empty( $old ) ) {
		return set_error_handler( "sfs_ErrorHandler" );
	}
	restore_error_handler();
}

function sfs_debug_msg( $msg ) {
	// used to aid debugging - adds to debug file
	$debug = true;
	$ip	   = ss_get_ip();
	if ( !$debug ) {
		return;
	}
	$now = date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
	// get the program that is running
	$sname = ( !empty( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : $_SERVER['SCRIPT_NAME'] );
	@file_put_contents( SS_PLUGIN_DATA . ".sfs_debug_output.txt", "$now: $sname, $msg, $ip \r\n", FILE_APPEND );
}

function sfs_ErrorHandler( $errno, $errmsg, $filename, $linenum ) {
	// write the answers to the file
	// we are only concerned with the errors and warnings, not the notices
	// if ( $errno == E_NOTICE || $errno == E_WARNING ) return false;
	// if ( $errno == 2048 ) return; // WordPress throws deprecated all over the place
	$serrno = "";
	if ( ( strpos( $filename, 'ss' ) === false ) && ( strpos( $filename, 'admin-options' ) === false ) && ( strpos( $filename, 'mu-options' ) === false ) && ( strpos( $filename, 'stop-spam' ) === false ) && ( strpos( $filename, 'sfr_mu' ) === false ) && ( strpos( $filename, 'settings.php' ) === false ) && ( strpos( $filename, 'options-general.php' ) === false ) ) {
		return false;
	}
	switch ( $errno ) {
		case E_ERROR:
			$serrno = __( 'Fatal run-time errors. These indicate errors that can not be recovered from, such as a memory allocation problem. Execution of the script is halted. ', 'stop-spammer-registrations-plugin' );
			break;
		case E_WARNING:
			$serrno = __( 'Run-time warnings (non-fatal errors). Execution of the script is not halted. ', 'stop-spammer-registrations-plugin' );
			break;
		case E_NOTICE:
			$serrno = __( 'Run-time notices. Indicate that the script encountered something that could indicate an error, but could also happen in the normal course of running a script. ', 'stop-spammer-registrations-plugin' );
			break;
		default;
			$serrno = __( 'Unknown Error Type ' . $errno . '', 'stop-spammer-registrations-plugin' );
	}
	if ( strpos( $errmsg, __( 'modify header information', 'stop-spammer-registrations-plugin' ) ) ) {
		return false;
	}
	$now = date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
	$m1  = memory_get_usage( true );
	$m2  = memory_get_peak_usage( true );
	$ip  = ss_get_ip();
	$msg = __( '
		Time: ' . $now . '
		Error Number: ' . $errno . '
		Error Type: ' . $serrno . '
		Error Msg: ' . $errmsg . '
		IP Address: ' . $ip . '
		File Name: ' . $filename . '
		Line Number: ' . $linenum . '
		Memory Used: ' . $m1 . ' Peak: ' . $m2 . '
		---------------------
	', 'stop-spammer-registrations-plugin' );
	$msg = str_replace( "\t", '', $msg );
	// write out the error
	@file_put_contents( SS_PLUGIN_DATA . '.sfs_debug_output.txt', $msg, FILE_APPEND );
	return false;
}

?>