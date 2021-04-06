<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class ss_remove_gcache {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		extract( $stats );
		extract( $options );
		while ( count( $goodips ) > $ss_sp_good ) {
			array_shift( $goodips );
		}
		$nowtimeout = date( 'Y/m/d H:i:s', time() - ( 4 * 3600 ) + ( get_option( 'gmt_offset' ) * 3600 ) );
		foreach ( $goodips as $key => $data ) {
			if ( $data < $nowtimeout ) {
				unset( $goodips[$key] );
			}
			if ( $key == $ip ) {
				unset( $goodips[$key] );
			}
		}
		$stats['goodips'] = $goodips;
		ss_set_stats( $stats );
		return $goodips; // return the array so AJAX can show it
	}
}

?>