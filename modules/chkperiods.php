<?php

if ( !defined( 'ABSPATH' ) ) exit;

class chkperiods extends be_module { 
	public function process( $ip, &$stats=array(), &$options=array(), &$post=array() ) {
		if ( array_key_exists( 'email', $post ) ) {
			$email = $post['email'];
			if ( !empty( $email ) ) {
				list( $text, $domain ) = explode( '@', $email, 2 );
				$domain = $this->remove_tld( $domain );
				if ( substr_count( $domain, "." ) >= 1 ) {
					_e( 'Too many periods in: ' . $email . '', 'stop-spammer-registrations-plugin' );
				} else if ( substr_count( $text, "." ) >= 2 ) {
					_e( 'Too many periods in: ' . $email . '', 'stop-spammer-registrations-plugin' );
				}
			}
		}
		if ( array_key_exists( 'user_email', $post ) ) {
			$email = $post['user_email'];
			if ( !empty( $email ) ) {
				list( $text, $domain ) = explode( '@', $email, 2 );
				$domain = $this->remove_tld( $domain );
				if ( substr_count( $domain, "." ) >= 2 ) {
					_e( 'Too many periods in: ' . $email . '', 'stop-spammer-registrations-plugin' );
				} else if ( substr_count( $text, "." ) >= 2 ) {
					_e( 'Too many periods in: ' . $email . '', 'stop-spammer-registrations-plugin' );
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
		if ( isset( $tld_array[ $tld_two ] ) ) {
			return str_replace( ".$tld_two", "", $domain );
		} else if ( isset( $tld_array[ $tld_one ] ) ) {
			return str_replace( ".$tld_one", "", $domain );
		}
	}
}

?>