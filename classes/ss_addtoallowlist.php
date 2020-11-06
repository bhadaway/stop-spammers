<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ss_addtoallowlist {
	public function process(
		$ip, &$stats = array(), &$options = array(), &$post = array()
	) {
		// adds to Allow List - used to add admin to Allow List or to add a comment author to Allow List
		$now = date( 'Y/m/d H:i:s',
			time() + ( get_option( 'gmt_offset' ) * 3600 ) );
		$wlist = $options['wlist'];
		// $ip=ss_get_ip();
		// add this IP to your Allow List
		if ( ! in_array( $ip, $wlist ) ) {
			$wlist[] = $ip;
		}
		$options['wlist'] = $wlist;
		ss_set_options( $options );
		// need to remove from caches
		$badips = $stats['badips'];
		if ( array_key_exists( $ip, $badips ) ) {
			unset( $badips[ $ip ] );
			$stats['badips'] = $badips;
		}
		$goodips = $stats['goodips'];
		if ( array_key_exists( $ip, $goodips ) ) {
			unset( $goodips[ $ip ] );
			$stats['goodips'] = $goodips;
		}
		ss_set_stats( $stats );
		if ( isset( $_GET['func' ] ) and $_GET['func'] == 'add_white' )
			$this->ss_send_approval_email( $ip, $stats, $options, $post );
		return false;
	}

	public function ss_send_approval_email( $ip, $stats = array(), $options = array(), $post = array() ) {
		if ( ! array_key_exists( 'emailrequest', $options ) ) {
			return false;
		}
		if ( $options['emailrequest'] == 'N' ) {
			return false;
		}
		if ( ! isset( $_GET['ip'] ) ) {
			return false;
		}
		$wlrequests = $stats['wlrequests'];
		$request = array();
		foreach ( $wlrequests as $r ) {
			if ( $r[0] == $_GET['ip'] ) {
				$request = $r;
				break;
			}
		}
		if ( empty( $request ) or ! isset( $request[1] ) ) {
			return false;
		}
		$to = $request[1];
		if ( ! is_email( $to ) ) {
			return false;
		}
		$ke = sanitize_text_field( $to );
		$blog = get_bloginfo( 'name' );
		$subject = get_bloginfo( 'name' ) . ': Your Request has been approved';
		$subject = str_replace( '&', 'and', $subject );
		$message = "
Hi,

I apologize for the inconvenience. I have added your IP address to the allow list. Please let me know if I can be of further assistance.

$blog";
		$message = str_replace( '&', 'and', $message );
		$headers = 'From: ' . get_option( 'admin_email' ) . "\r\n";
		wp_mail( $to, $subject, $message, $headers );
		return true;
	}
}

?>