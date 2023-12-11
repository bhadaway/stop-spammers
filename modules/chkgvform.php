<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkgvform extends be_module {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		if ( isset( $_POST["gform_submit"] ) ) {
			return false;
		}
	}
}

?>