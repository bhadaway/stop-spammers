<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class ss_addtoblocklist {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		// adds to Block List
		$now = date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
		$blist = $options['blist'];
		// add this IP to your Allow List
		if ( !in_array( $ip, $blist ) ) {
			$blist[] = $ip;
		}
		$options['blist'] = $blist;
		ss_set_options( $options );
		// need to remove from caches
		$badips = $stats['badips'];
		if ( array_key_exists( $ip, $badips ) ) {
			unset( $badips[$ip] );
			$stats['badips'] = $badips;
		}
		$goodips = $stats['goodips'];
		if ( array_key_exists( $ip, $goodips ) ) {
			unset( $goodips[$ip] );
			$stats['goodips'] = $goodips;
		}
		ss_set_stats( $stats );
		return false;
	}
}

?>