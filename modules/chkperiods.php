<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkperiods extends be_module { 
	public function process( $ip, &$stats=array(), &$options=array(), &$post=array() ) {
		if ( array_key_exists( 'email', $post ) && $options['chkperiods'] == 'Y' ) {
			$email = $post['email'];
			if ( !empty( $email ) ) {
				list( $text, $domain ) = explode( '@', $email, 2 );
				$domain = $this->remove_tld( $domain );
				if ( substr_count( $domain, "." ) >= 1 ) {
					return __( 'Too many periods in: ' . $email . '', 'stop-spammer-registrations-plugin' );
					return true;
				} else if ( substr_count( $text, "." ) >= 2 ) {
					return __( 'Too many periods in: ' . $email . '', 'stop-spammer-registrations-plugin' );
					return true;
				}
			}
		}
		if ( array_key_exists( 'user_email', $post ) && $options['chkperiods'] == 'Y') {
			$email = $post['user_email'];
			if ( !empty( $email ) ) {
				list( $text, $domain ) = explode( '@', $email, 2 );
				$domain = $this->remove_tld( $domain );
				if ( substr_count( $domain, "." ) >= 2 ) {
					return __( 'Too many periods in: ' . $email . '', 'stop-spammer-registrations-plugin' );
					return true;
				} else if ( substr_count( $text, "." ) >= 2 ) {
					return __( 'Too many periods in: ' . $email . '', 'stop-spammer-registrations-plugin' );
					return true;
				}
			}
		}
		return false;
	}
	private function remove_tld( $domain ) {
		$domain_split = explode( '.', $domain );
		$domain_array = array_slice( $domain_split, -2, 2 );
		$tld_two = implode( '.', $domain_array );
		$tld_one = end( $domain_split );
		// downloaded from https://raw.githubusercontent.com/fbraz3/publicsuffix-json/master/public_suffix_list.json
		$tld_array = array_flip( json_decode( file_get_contents( __DIR__ . '/tlds/public_suffix_list.json' ) ) );
		if ( isset( $tld_array[$tld_two] ) ) {
			return str_replace( ".$tld_two", "", $domain );
		} else if ( isset( $tld_array[$tld_one] ) ) {
			return str_replace( ".$tld_one", "", $domain );
		}
	}
}

?>