<?php
// this checks the generated Allow List cidrs that I have been collecting
// this list includes good hosting and ISPs

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chksession {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		// this uses cookies - it may break programs that need to get to cookies first
		// move this to main line
		if ( !isset( $_POST ) || empty( $_POST ) ) { // no post defined
			if ( !isset( $_COOKIE['ss_protection_time'] ) ) { // if previous set do not reset
				setcookie( 'ss_protection_time', strtotime( "now" ), strtotime( '+1 min' ) );
			}
			return false;
		}
		// post is set - check the timeout
		// need to get sname
		$sname = '';
		if ( array_key_exists( "REQUEST_URI", $_SERVER ) ) {
			$sname = $_SERVER["REQUEST_URI"];
		} else if ( array_key_exists( "SCRIPT_URI", $_SERVER ) ) {
			$sname = $_SERVER["SCRIPT_URI"];
			if ( strpos( $sname, '?' ) !== false ) {
				$sname = substr( $sname, 0, strpos( $sname, '?' ) );
			}
			$sname = $sname;
		} else if ( array_key_exists( "PHP_SELF", $_SERVER ) ) {
			$sname = substr( $_SERVER['PHP_SELF'], 1 );
		}
		// echo "Testing Session '$sname'<br>";
		if ( empty( $sname ) ) {
			return false;
		}
		$sesstime = 2; // nobody can do it in 3 seconds
		if ( !defined( "WP_CACHE" ) || ( !WP_CACHE ) ) {
			if ( strpos( $sname, 'wp-login.php' ) === false ) {  // don't check for logins - too many failures
				if ( isset( $_COOKIE['ss_stop_spammers_time'] ) ) {
					$stime = $_COOKIE['ss_stop_spammers_time'];
					$tm	   = strtotime( "now" ) - $stime;
					if ( $tm > 0 && $tm <= $sesstime ) { // zero seconds is wrong, too - it means that session was set somewhere
						// takes longer than 2 seconds to really type a comment
						return __( 'Session Speed — ' . $tm . ' seconds', 'stop-spammer-registrations-plugin' );
					}
				}
			}
		}
		return false;
	}
}

?>