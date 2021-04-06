<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkgooglesafe extends be_module {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		if ( empty( $stats ) ) {
			return false;
		}
		if ( !array_key_exists( 'googleapi', $stats ) ) {
			return false;
		}
		if ( !array_key_exists( 'content', $stats ) ) {
			return false;
		}
		$googleapi = $stats['googleapi'];
		$content   = $stats['content'];
		$post	   = array();
		preg_match_all( '@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)*)@', $content, $post, PREG_PATTERN_ORDER );
		$urls1 = array();
		$urls2 = array();
		$urls3 = array();
		if ( is_array( $post ) && is_array( $post[1] ) ) {
			$urls1 = array_unique( $post[1] );
		} else {
			$urls1 = array();
		}
		// BBCode
		preg_match_all( '/\[url=(.+)\]/iU', $content, $post, PREG_PATTERN_ORDER );
		if ( is_array( $post ) && is_array( $post[0] ) ) {
			$urls2 = array_unique( $post[0] );
		} else {
			$urls2 = array();
		}
		$urls3 = array_merge( $urls1, $urls2 );
		if ( !is_array( $urls3 ) ) {
			return false;
		}
		if ( empty( $urls3 ) ) {
			return false;
		}
		for ( $j = 0; $j < count( $urls3 ); $j ++ ) {
			$urls3[$j] = urlencode( $urls3[$j] );
		}
		// $urls3 has the list of URLs found in content
		for ( $j = 0; $j < count( $urls3 ) && $j < 4; $j ++ ) {
			// check Google
			$url = $urls3[$j];
			if ( !empty( $url ) ) {
				$query = "https://sb-ssl.google.com/safebrowsing/api/lookup?client=stop-spammer-plugin&apikey=$googleapi&appver=9.3&pver=3.0&url=$url";
				// using file get contents or get using the https lookup?
				$r	   = $this->getafile( $query );
				if ( !empty( $r ) ) {
					if ( strpos( $r, 'phishing' ) !== false || strpos( $r, 'malware' ) !== false ) {
						return __( 'Google Safe: ', 'stop-spammer-registrations-plugin' ) . $r;
					}
				}
			}
		}
		return false;
	}
}

?>