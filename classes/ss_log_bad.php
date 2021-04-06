<?php
// adds to the Bad Cache

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class ss_log_bad extends be_module {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		$chk = 'error';
		extract( $stats );
		extract( $post );
		$sname = $this->getSname();
		$now   = date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
		// updates counters - adds to log list - adds to Bad Cache - then updates stats when done
		// start with the counters - does some extra checks in case the stats file gets corrupted
		if ( array_key_exists( 'spcount', $stats ) ) {
			$stats['spcount'] ++;
		} else {
			$stats['spcount'] = 1;
		}
		if ( array_key_exists( 'spmcount', $stats ) ) {
			$stats['spmcount'] ++;
		} else {
			$stats['spmcount'] = 1;
		}
		if ( array_key_exists( 'cnt' . $chk, $stats ) ) {
			$stats['cnt' . $chk] ++;
		} else {
			$stats['cnt' . $chk] = 1;
		}
		// now the cache - need to purge it for time and length
		$ss_sp_cache   = $options['ss_sp_cache'];
		$badips[$ip] = $now;
		asort( $badips );
		while ( count( $badips ) > $ss_sp_cache ) {
			array_shift( $badips );
		}
		$nowtimeout = date( 'Y/m/d H:i:s', time() - ( 4 * 3600 ) + ( get_option( 'gmt_offset' ) * 3600 ) );
		foreach ( $badips as $key => $data ) {
			if ( $data < $nowtimeout ) {
				unset( $badips[$key] );
			}
		}
		$stats['badips'] = $badips;
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
		// if ( !empty( $pwd ) ) $author = $author . '/' . $pwd; // show bad passwords?
		$hist[$now]  = array( $ip, $email, $author, $sname, $reason, $blog );
		$stats['hist'] = $hist;
		if ( array_key_exists( 'addon', $post ) ) {
			ss_set_stats( $stats, $post['addon'] );
		} else {
			ss_set_stats( $stats );
		}
		// we can report the spam to add-ons here
		do_action( 'ss_stop_spam_caught', $ip, $post ); // post has the chk and reason in the array plus all the other info
		be_load( 'ss_challenge', $ip, $stats, $options, $post );
		exit();
	}
}

?>