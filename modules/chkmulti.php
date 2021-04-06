<?php
// this keeps a list of the hits and counts in the last 3 minutes - if someone has tried to leave 
// more than 5 comments in three minutes then they must be a spammer

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkmulti extends be_module {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		if ( function_exists( 'is_user_logged_in' ) ) {
			if ( is_user_logged_in() ) {
				return false; // don't want to do this if just testing - could lock out sysop
			}
		}
		if ( !array_key_exists( 'multi', $stats ) ) {
			return false;
		}
		$multi = $stats['multi'];
		if ( !is_array( $multi ) ) {
			$multi = array();
		}
		$multitime = 3;
		$multicnt  = 5;
		if ( array_key_exists( 'multitime', $options ) ) {
			$multitime = $options['multitime'];
		}
		if ( array_key_exists( 'multicnt', $options ) ) {
			$multicnt = $options['multicnt'];
		}
		// clean up multi 
		$now		= date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
		$nowtimeout = date( 'Y/m/d H:i:s', time() - ( 60 * $multitime ) + ( get_option( 'gmt_offset' ) * 3600 ) );
		foreach ( $multi as $key => $data ) { // key is IP, data is array of time and count
			if ( $data[0] < $nowtimeout ) {
				unset( $multi[$key] );
			}
		}
		$row = array( $now, 0 );
		if ( array_key_exists( $ip, $multi ) ) {
			$row = $multi[$ip];
		}
		$row[0] = $now;
		$row[1] ++;
		$multi[$ip]   = $row;
		$stats['multi'] = $multi;
		ss_set_stats( $stats );
		if ( $row[1] >= $multicnt ) {
			return __( '' . $row[1] . ' hits in last 3 minutes', 'stop-spammer-registrations-plugin' );
		}
		return false;
	}
}

?>