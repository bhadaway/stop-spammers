<?php
// Allow List - returns false if not found

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

// last updated from https://help.smallbusiness.yahoo.net/s/article/SLN19413 on 12/22/20
class chkyahoomerchant extends be_module {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		$yahoo = array(
			'52.89.44.13',
			'52.73.246.40',
			'98.139.190.48/28',
			'98.139.32.168',
			'98.139.32.169',
			'98.139.32.170'
		);
		$this->searchname = 'Yahoo Merchant Services';
		return $this->searchList( $ip, $yahoo );
		return false;
	}
}

?>