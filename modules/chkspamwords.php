<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkspamwords {
	// look on option list for spam words
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		// spam words can be in password, author, comment, etc. - anything in the post
		// 'email', 'author', 'pwd', 'comment', 'subject'
		$spamwords = $options['spamwords'];
		foreach ( $post as $key => $data ) {
			if ( !empty( $data ) ) {
				foreach ( $spamwords as $sw ) {
					if ( stripos( $data, $sw ) !== false ) {
						return __( 'Spam Word: ' . $sw . ' in ' . $key . '', 'stop-spammer-registrations-plugin' );
					}
				}
			}
		}
		return false;
	}
}

?>