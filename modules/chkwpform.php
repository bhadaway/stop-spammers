<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkwpform extends be_module {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		if ( isset( $_POST["wpforms[submit]"] ) ) {
			return false;
		}
	}
}

?>