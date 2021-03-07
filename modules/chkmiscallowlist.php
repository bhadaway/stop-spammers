<?php
// Allow List various services - returns name if found, false if not found

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkmiscallowlist extends be_module {
	public $searchname = 'VaultPress';
	public $searchlist = array(
		'VaultPress', // testing out checks for AWS
		array( '207.198.112.0', '207.198.113.255' ),
		'RssGrafitti', // testing out checks for AWS
		array( '23.21.82.184', '23.21.82.184' ),
		array( '54.235.100.22', '54.235.100.22' ),
		array( '54.235.94.95', '54.235.94.95' ),
		array( '54.235.97.10', '54.235.97.10' ),
		array( '54.235.98.169', '54.235.98.169' ),
		'WorldPay',
		'207.242.204.32/29',
		'12.220.48.112/28',
		'193.41.220.0/23',
		'208.74.164.0/22',
		'199.254.202.0/24',
		'216.137.161.128/26',
		'70.35.172.128/25',
		'62.6.167.128/25',
		'84.45.252.0/25',
		'195.35.90.0/23',
		'Clickbank',
		'74.63.153.66',
		'74.63.153.67',
		'96.47.69.66',
		'96.47.69.67'
	);
}

?>