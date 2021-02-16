<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkwluserid extends be_module { // change name
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		// checks the user - dangerous to allow a whitelisted user - spammers could use it
		$this->searchname = 'Allow List Email';
		$user			  = $post['author'];
		if ( empty( $user ) ) {
			return false;
		}
		$wlist = $options['wlist'];
		return $this->searchList( $user, $wlist );
	}
}

?>