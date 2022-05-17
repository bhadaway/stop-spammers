<?php
// adds to the Good Cache and log

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class ss_log_good extends be_module {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		// are we getting stats?
		$chk = "error";
		extract( $stats );
		extract( $post );
		// reason and chk are from the post array
		if ( array_key_exists( 'cnt' . $chk, $stats ) ) {
			$stats['cnt' . $chk] ++;
		} else {
			$stats['cnt' . $chk] = 1;
		}
		$sname = $this->getSname();
		$now   = date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
		// updates counters - adds to log list - adds to Good Cache - then updates stats when done
		// start with the counters - does some extra checks in case the stats file gets corrupted
		if ( array_key_exists( 'cntpass', $stats ) ) {
			$stats['cntpass'] ++;
		} else {
			$stats['cntpass'] = 1;
		}
		// now the cache - need to purge it for time and length
		$ss_sp_good	  = $options['ss_sp_good'];
		$goodips[$ip] = $now;
		asort( $goodips );
		while ( count( $goodips ) > $ss_sp_good ) {
			array_shift( $goodips );
		}
		$nowtimeout = date( 'Y/m/d H:i:s', time() - ( 4 * 3600 ) + ( get_option( 'gmt_offset' ) * 3600 ) );
		foreach ( $goodips as $key => $data ) {
			if ( $data < $nowtimeout ) {
				unset( $goodips[$key] );
			}
		}
		$stats['goodips'] = $goodips;
		// now we need to log the IP and reason
		$blog = '';
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			global $blog_id;
			if ( !isset( $blog_id ) || $blog_id != 1 ) {
				$blog = $blog_id;
			}
		}
		$ss_sp_hist = $options['ss_sp_hist'];
		while ( count( $hist ) > $ss_sp_hist ) {
			array_shift( $hist );
		}
		$hist[$now]  = array( $ip, $email, $author, $sname, $reason, $blog );
		$stats['hist'] = $hist;
		if ( array_key_exists( 'addon', $post ) ) {
			ss_set_stats( $stats, $post['addon'] ); // from a plugin
		} else {
			ss_set_stats( $stats );
		}
	}
}

?>