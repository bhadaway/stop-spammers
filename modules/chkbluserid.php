<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkbluserid extends be_module { // change name
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		// checks the user author or login ID
		$this->searchname = 'Allow List Email';
		$user			  = $post['author'];
		if ( empty( $user ) ) {
			return false;
		}
		$blist = $options['blist'];
		return $this->searchList( $user, $blist );
	}
}

?>