<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkbotscout extends be_module {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		$disabled = true;
		if ( $disabled ) {
			return false;
		}
		if ( strpos( $ip, '.' ) === false ) {
			return false;
		}
		if ( empty( $stats ) ) {
			return false;
		}
		if ( !array_key_exists( 'botscoutapi', $options ) ) {
			return false;
		}
		$apikey = $options['botscoutapi'];
		if ( empty( $apikey ) ) {
			return false;
		}
		$botfreq = $options['botfreq'];
		$query   = "https://botscout.com/test/?ip=$ip&key=$apikey";
		$check   = $this->getafile( $query, 'GET' );
		if ( !empty( $check ) ) {
			if ( substr( $check, 0, 4 ) == "ERR:" ) {
				return $check . __( 'BotScout Error, ', 'stop-spammer-registrations-plugin' );
			}
			if ( strpos( $check, '|' ) ) {
				$result = explode( '|', $check );
				if ( count( $result ) > 2 ) {
					// Y|IP|3 - found, type, database occurrences
					if ( $result[0] == 'Y' && $result[2] > $botfreq ) {
						return 'BotScout, ' . $result[2];
					}
				}
			}
		}
		return false;
	}
}

?>