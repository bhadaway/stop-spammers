<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chktemplate extends be_module {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		return false;
	}
}

?>