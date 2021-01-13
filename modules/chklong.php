<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class chklong { // change name
	public function process(
		$ip, &$stats = array(), &$options = array(), &$post = array()
	) {
		$this->searchname = 'Email/Author/Password Too Long';
		if ( array_key_exists( 'email', $post ) ) {
			$email = $post['email'];
			if ( ! empty( $email ) ) {
				if ( strlen( $email ) > 64 ) {
					_e( 'Email Too Long: ' . $email . '', 'stop-spammer-registrations-plugin' );
				}
			}
		}
		if ( array_key_exists( 'author', $post ) ) {
			if ( ! empty( $post['author'] ) ) {
				$author = $post['author'];
				if ( strlen( $post['author'] ) > 64 ) {
					_e( 'Author Too Long: ' . $author . '', 'stop-spammer-registrations-plugin' );
				}
			}
		}
		if ( array_key_exists( 'psw', $post ) ) {
			if ( ! empty( $post['psw'] ) ) {
				$psw = $post['psw'];
				if ( strlen( $post['psw'] ) > 32 ) {
					_e( 'Password Too Long: ' . $psw . '', 'stop-spammer-registrations-plugin' );
				}
			}
		}

		return false;
	}
}

?>