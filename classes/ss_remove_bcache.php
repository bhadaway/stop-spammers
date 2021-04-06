<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class ss_remove_bcache {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		extract( $stats );
		extract( $options );
		while ( count( $badips ) > $ss_sp_cache ) {
			array_shift( $badips );
		}
		$nowtimeout = date( 'Y/m/d H:i:s', time() - ( 4 * 3600 ) + ( get_option( 'gmt_offset' ) * 3600 ) );
		foreach ( $badips as $key => $data ) {
			if ( $data < $nowtimeout ) {
				unset( $badips[$key] );
			}
			if ( $key == $ip ) {
				unset( $badips[$key] );
			}
		}
		$stats['badips'] = $badips;
		ss_set_stats( $stats );
		return $badips; // return the array so AJAX can show it
	}
}

?>