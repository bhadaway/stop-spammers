<?php
// checks for invalid IPs
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class chkinvalidip {
	public function process(
		$ip, &$stats = array(), &$options = array(), &$post = array()
	) {
		if ( strpos( $ip, '.' ) === false && strpos( $ip, ':' ) === false ) {
			_e( 'Invalid IP: ', 'stop-spammer-registrations-plugin' ) . $ip;
		}
		if ( defined( 'AF_INET6' ) && strpos( $ip, ':' ) !== false ) {
			try {
				if ( ! @inet_pton( $ip ) ) {
					_e( 'Invalid IP: ', 'stop-spammer-registrations-plugin' ) . $ip;
				}
			} catch ( Exception $e ) {
				_e( 'Invalid IP: ', 'stop-spammer-registrations-plugin' ) . $ip;
			}
		}
		$ips = be_module::ip2numstr( $ip );
		if ( $ips >= '224000000000' && $ips <= '239255255255' ) {
			_e( 'IPv4 Multicast Address Space Registry', 'stop-spammer-registrations-plugin' );
		}
// reserved for future use >= 240.0.0.0
		if ( $ips >= '240000000000' && $ips <= '255255255255' ) {
			_e( 'Reserved for future use', 'stop-spammer-registrations-plugin' );
		}
		return false;
	}
}

?>