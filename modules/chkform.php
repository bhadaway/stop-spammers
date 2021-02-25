<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkform extends be_module {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		// checks to see if we are in 
		// wp-comments-post.php and wp-login.php
		$uri = $_SERVER['REQUEST_URI'];
		if ( strpos( $uri, 'wp-comments-post.php' ) !== false ) {
			// sfs_debug_msg( "continue check wp-comments-post.php $ip" );
			return false;
		}
		if ( strpos( $uri, 'wp-login.php' ) !== false ) {
			// sfs_debug_msg( "continue check wp-login.php $ip" );
			return false;
		}
		// sfs_debug_msg( "Allowed $uri $ip" );
		return __( 'Post request not in wp-comments-post.php or wp-login.php — ' . $uri . '', 'stop-spammer-registrations-plugin' );
	}
}

?>