<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chklong { // change name
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		$this->searchname = 'Email/Username/Password Too Long';
		if ( array_key_exists( 'email', $post ) ) {
			$email = $post['email'];
			if ( !empty( $email ) ) {
				if ( strlen( $email ) > 64 ) {
					return __( 'Email Too Long: ' . $email . '', 'stop-spammer-registrations-plugin' );
				}
			}
		}
		if ( array_key_exists( 'author', $post ) ) {
			if ( !empty( $post['author'] ) ) {
				$author = $post['author'];
				if ( strlen( $post['author'] ) > 64 ) {
					return __( 'Username Too Long: ' . $author . '', 'stop-spammer-registrations-plugin' );
				}
			}
		}
		if ( array_key_exists( 'psw', $post ) ) {
			if ( !empty( $post['psw'] ) ) {
				$psw = $post['psw'];
				if ( strlen( $post['psw'] ) > 32 ) {
					return __( 'Password Too Long: ' . $psw . '', 'stop-spammer-registrations-plugin' );
				}
			}
		}
		return false;
	}
}

?>