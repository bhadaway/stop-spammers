<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkwlem extends be_module { // change name
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		// checks the email - not sure I want to allow an Allow List on email - maybe won't include
		$this->searchname = 'Allow List Email';
		$email			  = $post['email'];
		if ( empty( $email ) ) {
			return false;
		}
		$wlist = $options['wlist'];
		return $this->searchList( $email, $wlist );
	}
}

?>