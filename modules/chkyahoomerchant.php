<?php
// Allow List - returns false if not found

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

// last updated from https://help.turbify.com/s/article/SLN19413 on 2/29/24
class chkyahoomerchant extends be_module {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		$yahoo = array(
			'52.0.50.252',
			'52.20.227.151',
			'52.21.142.28',
			'52.21.143.68',
			'52.73.246.40',
			'52.89.44.13'
		);
		$this->searchname = 'Yahoo Merchant Services';
		return $this->searchList( $ip, $yahoo );
		return false;
	}
}

?>