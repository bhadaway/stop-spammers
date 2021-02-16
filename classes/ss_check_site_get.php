<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class ss_check_site_get extends be_module {
	public function process(
		$ip, &$stats = array(), &$options = array(), &$post = array() ) {
		// not checking this anymore
		return false;
	}
}

?>