<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chksfs extends be_module {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		// only do this with posts that have an email or login
		$query = "https://www.stopforumspam.com/api?ip=$ip";
		$check = '';
		$check = $this->getafile( $query, 'GET' );
		if ( empty( $check ) ) {
			return false;
		}
		if ( strpos( $check, 'ERR:' ) !== false ) {
			return $check;
		}
		$lastseen  = '';
		$frequency = '';
		$n		   = strpos( $check, '<appears>yes</appears>' );
		if ( $n !== false ) {
			if ( strpos( $check, '<lastseen>', $n ) !== false ) {
				$k		  = strpos( $check, '<lastseen>', $n );
				$k		 += 10;
				$j		  = strpos( $check, '</lastseen>', $k );
				$lastseen = date( 'Y-m-d', time() );
				if ( ( $j - $k ) > 12 && ( $j - $k ) < 24 ) {
					$lastseen = substr( $check, $k, $j - $k );
				} // should be about 20 characters
				if ( strpos( $lastseen, ' ' ) ) {
					$lastseen = substr( $lastseen, 0, strpos( $lastseen, ' ' ) );
				} // trim out the time to save room
				if ( strpos( $check, '<frequency>', $n ) !== false ) {
					$k		 = strpos( $check, '<frequency>', $n );
					$k		+= 11;
					$j		 = strpos( $check, '</frequency', $k );
					$frequency = '9999';
					if ( ( $j - $k ) && ( $j - $k ) < 7 ) {
						$frequency = substr( $check, $k, $j - $k );
					} // should be a number greater than 0 and probably no more than a few thousand
				}
			}
			// check freq and age - min freq=2 max age = 99
			$freq	 = 2;
			$maxtime = 99;
			$sfsfreq = $options['sfsfreq'];
			$sfsage  = $options['sfsage'];
			// if ( !empty( $frequency ) && !empty( $lastseen ) && ( $frequency != 255 ) && ( $frequency >= $freq ) && ( strtotime( $lastseen ) > ( time() - ( 60*60*24*$maxtime ) ) ) ) { 
			if ( ( $frequency >= $sfsfreq ) && ( strtotime( $lastseen ) > ( time() - ( 60 * 60 * 24 * $sfsage ) ) ) ) {
				// frequency we got from the db, sfsfreq is the min we'll accept (default 0)
				// sfsage is the age in days - we get lastscene from
				return __( 'SFS Last Seen = ' . $lastseen . ', Frequency = ' . $frequency . '', 'stop-spammer-registrations-plugin' );
			}
		}
		return false;
	}
}

?>