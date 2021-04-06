<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class ss_addto_bcache {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		extract( $stats );
		extract( $options );
		$now = date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
		while ( count( $badips ) > $ss_sp_cache ) {
			array_shift( $badips );
		}
		$nowtimeout = date( 'Y/m/d H:i:s', time() - ( 4 * 3600 ) + ( get_option( 'gmt_offset' ) * 3600 ) );
		$badips[$ip] = $now;
		foreach ( $badips as $key => $data ) {
			if ( $data < $nowtimeout ) {
				unset( $badips[$key] );
			}
		}
		$stats['badips'] = $badips;
		ss_set_stats( $stats );
		return $badips;
	}
}

?>