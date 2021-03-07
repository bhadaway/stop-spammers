<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkwlistemail extends be_module { // change name
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		if ( is_user_logged_in() ) {
			// checks the email from params which has the cache in it
			$current_user 	  = wp_get_current_user();
			$this->searchname = 'Allow List Email';
			$gcache		      = $options['wlist_email'];
			return $this->searchList( $current_user->user_email, $gcache );
		}
		return false;
	}
}

?>