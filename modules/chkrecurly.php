<?php
// Allow List - returns false if not found

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkrecurly extends be_module {
	public $searchname = 'Recurly';
	public $searchlist = array(
		// IP addresses
		'35.233.168.62',
		'35.185.253.62',
		'35.188.232.138',
		'35.236.210.191',
		'50.18.192.88',
		'52.8.32.100',
		'52.9.209.233',
		'50.0.172.150',
		'52.203.102.94',
		'52.203.192.184'

	);
}

?>