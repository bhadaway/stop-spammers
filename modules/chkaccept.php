<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkaccept {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		if ( array_key_exists( 'HTTP_ACCEPT', $_SERVER ) ) {
			return false;
		} // real browsers send HTTP_ACCEPT
		return __( 'No Accept Header: ', 'stop-spammer-registrations-plugin' );
	}
}

?>