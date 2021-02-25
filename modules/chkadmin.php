<?php
// this is specific to my website - needs to be made generic
// originally designed to block admin login attempts

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkadmin extends be_module {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		$login = $post['author']; // sticks login name into author
		$pwd   = $post['pwd'];
		if ( stripos( $login, 'admin' ) === false ) {
			return false;
		}
		// no users or authors named admin 
		// do a look up to see if there is an author named admin
		if ( !function_exists( 'get_users' ) ) {
			return false;
		} // non-WP?
		if ( get_user_by( 'login', $login ) ) {
			return false;
		} // false alarm - really is a person admin
		// this may cause problems when a legitimate new user wants to include the string admin in their username
		return __( 'Admin Login or Registration Attempt: ' . $login . '', 'stop-spammer-registrations-plugin' );
	}
}

?>