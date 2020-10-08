<?php

if ( !defined( 'ABSPATH' ) ) exit;

class chkperiods  extends be_module { 
	public function process( $ip, &$stats=array(), &$options=array(), &$post=array() ) {
		if ( array_key_exists( 'email', $post ) ) {
			$email = $post['email'];
			if ( !empty( $email ) ) {
				list( $text, $domain ) = explode( '@', $email, 2 );
				if ( substr_count( $domain, "." ) >= 2 ) {
					return "too many periods in: $email";
				}
			}
		}
		if ( array_key_exists( 'user_email', $post ) ) {
			$email = $post['user_email'];
			if ( !empty( $email ) ) {
				list( $text, $domain ) = explode( '@', $email, 2 );
				if ( substr_count( $domain, "." ) >= 2 ) {
					return "too many periods in: $email";
				}
			}
		}
		return false;
	}
}

?>