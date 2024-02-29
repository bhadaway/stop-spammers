<?php
// Allow List - returns false if not found

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

// last updated from https://docs.recurly.com/docs/ip-allowlist on 2/29/24
class chkrecurly extends be_module {
	public $searchname = 'Recurly';
	public $searchlist = array(
		// IP addresses
		'34.105.107.15',
		'34.107.35.64',
		'34.107.83.154',
		'34.141.92.246',
		'34.79.180.69',
		'34.79.238.20',
		'34.86.231.208',
		'34.86.76.227',
		'34.89.164.175',
		'35.185.253.62',
		'35.188.232.138',
		'35.194.77.56',
		'35.195.228.7',
		'35.197.126.78',
		'35.199.174.181',
		'35.230.60.156',
		'35.233.168.62',
		'35.236.210.191',
		'35.240.64.130',
		'35.245.149.42'
	);
}

?>