<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkurls {
	// look on option list for URLs
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		$comment = explode( " ", $post['comment'] );
		for ( $i = 0 ; $i < count( $comment ) ; $i++ ) {
			if ( preg_match( '/^[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}+'.'((:[0-9]{1,5})?\\/.*)?$/i', $comment[$i] ) OR strpos( $comment[$i], 'http://' ) !== false OR strpos( $comment[$i], 'https://' ) !== false ) {
				return __( 'URL Detected', 'stop-spammer-registrations-plugin' );
			}
		}
		return false;
	}
}