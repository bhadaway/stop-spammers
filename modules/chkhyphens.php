<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkhyphens  extends be_module { 
	public function process( $ip, &$stats=array(), &$options=array(), &$post=array() ) {
		if ( array_key_exists( 'email', $post ) ) {
			$email = $post['email'];
			if ( !empty( $email ) ) {
				$email = substr( $email, 0, strpos( $email, '@' ) );
				if ( substr_count( $email, "-" ) > 1 ) {
					return __( 'Too many hyphens in: ' . $email . '', 'stop-spammer-registrations-plugin' );
				}
			}
		}
		if ( array_key_exists( 'user_email', $post ) ) {
			$email = $post['user_email'];
			if ( !empty( $email ) ) {
				$email = substr( $email, 0, strpos( $email, '@' ) );
				if ( substr_count( $email, "-" ) > 1 ) {
					return __( 'Too many hyphens in: ' . $email . '', 'stop-spammer-registrations-plugin' );
				}
			}
		}
		return false;
	}
}

?>