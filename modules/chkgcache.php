<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkgcache extends be_module { // change name
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		// checks the IP from params which has the cache in it
		$this->searchname = 'Good Cache';
		$gcache		      = $stats['goodips'];
		return $this->searchcache( $ip, $gcache );
	}
}

?>