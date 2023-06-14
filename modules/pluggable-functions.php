<?php

if ( !function_exists( 'wp_new_user_notification' ) ) :
	function wp_new_user_notification( $user_id, $deprecated = null, $notify = '' ) {
		$options = ss_get_options();
		if ( $options['new_user_notification_to_admin'] == 'Y' ) {
			ss_new_user_notification_to_admin( $user_id, $deprecated, $notify );
		}
		if ( $options['ss_new_user_notification_to_user'] == 'Y' ) {
			ss_new_user_notification_to_user( $user_id, $deprecated, $notify );
		}
	}
endif;

function ss_new_user_notification_to_user( $user_id, $deprecated = null, $notify = '' ) {
	if ( $deprecated !== null ) {
		_deprecated_argument( __FUNCTION__, '4.3.1' );
	}
	if ( !in_array( $notify, array( 'user', 'admin', 'both', '' ), true ) ) {
		return;
	}
	global $wpdb, $wp_hasher;
	$user = get_userdata( $user_id );
	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text area of emails.
	$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	// `$deprecated was pre-4.3 `$plaintext_pass`. An empty `$plaintext_pass` didn't sent a user notification.
	if ( 'admin' === $notify || ( empty( $deprecated ) && empty( $notify ) ) ) {
		return;
	}
	// Generate something random for a password reset key.
	$key = wp_generate_password( 20, false );
	/** This action is documented in wp-login.php */
	do_action( 'retrieve_password_key', $user->user_login, $key );
	// Now insert the key, hashed, into the DB.
	if ( empty( $wp_hasher ) ) {
		require_once ABSPATH . WPINC . '/class-phpass.php';
		$wp_hasher = new PasswordHash( 8, true );
	}
	$hashed = time() . ':' . $wp_hasher->HashPassword( $key );
	$wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user->user_login ) );
	$switched_locale = switch_to_locale( get_user_locale( $user ) );
	/* translators: %s: user login */
	$message = sprintf( __( 'Username: %s' ), $user->user_login ) . "\r\n\r\n";
	$message.= __( 'To set your password, visit the following address:' ) . "\r\n\r\n";
	$message.= '<' . network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user->user_login ), 'login' ) . ">\r\n\r\n";
	$message.= wp_login_url() . "\r\n";
	$wp_new_user_notification_email = array( 'to' => $user->user_email,
	/* translators: Login details notification email subject. %s: Site title */
	'subject' => __( '[%s] Login Details' ), 'message' => $message, 'headers' => '', );
	$wp_new_user_notification_email = apply_filters( 'wp_new_user_notification_email', $wp_new_user_notification_email, $user, $blogname );
	wp_mail( $wp_new_user_notification_email['to'], wp_specialchars_decode( sprintf( $wp_new_user_notification_email['subject'], $blogname ) ), $wp_new_user_notification_email['message'], $wp_new_user_notification_email['headers'] );
	if ( $switched_locale ) {
		restore_previous_locale();
	}
}

function ss_new_user_notification_to_admin( $user_id, $deprecated, $notify = '' ) {
	if ( $deprecated !== null ) {
		_deprecated_argument( __FUNCTION__, '4.3.1' );
	}
	global $wpdb, $wp_hasher;
	$user = get_userdata( $user_id );
	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	if ( 'user' !== $notify ) {
		$switched_locale = switch_to_locale( get_locale() );
		/* translators: %s: site title */
		$message = sprintf( __( 'New user registration on your site %s:' ), $blogname ) . "\r\n\r\n";
		/* translators: %s: user login */
		$message.= sprintf( __( 'Username: %s' ), $user->user_login ) . "\r\n\r\n";
		/* translators: %s: user email address */
		$message.= sprintf( __( 'Email: %s' ), $user->user_email ) . "\r\n";
		$wp_new_user_notification_email_admin = array( 'to' => get_option( 'admin_email' ),
		/* translators: New user registration notification email subject. %s: Site title */
		'subject' => __( '[%s] New User Registration' ), 'message' => $message, 'headers' => '', );
		$wp_new_user_notification_email_admin = apply_filters( 'wp_new_user_notification_email_admin', $wp_new_user_notification_email_admin, $user, $blogname );
		@wp_mail( $wp_new_user_notification_email_admin['to'], wp_specialchars_decode( sprintf( $wp_new_user_notification_email_admin['subject'], $blogname ) ), $wp_new_user_notification_email_admin['message'], $wp_new_user_notification_email_admin['headers'] );
		if ( $switched_locale ) {
			restore_previous_locale();
		}
	}
}

$options = ss_get_options();
if ( $options['ss_password_change_notification_to_admin'] == 'N' && !function_exists( 'wp_password_change_notification' ) ):
	/**
	 * Notify the blog admin of a user changing password, normally via email.
	 */
	function wp_password_change_notification( $user ) {}
endif;

if ( !function_exists( 'dont_send_password_change_email' ) ):
	function dont_send_password_change_email( $send = false, $user = '', $userdata = '' ) {
		$options = ss_get_options();
		if ( is_array( $user ) ) $user = ( object )$user;
		if ( $options['ss_password_change_notification_to_admin'] == 'Y' ):
			// send a copy of password change notification to the admin
			// but check to see if it's the admin whose password we're changing, and skip this
			if ( 0 !== strcasecmp( $user->user_email, get_option( 'admin_email' ) ) ) {
				$message = sprintf( __( 'Password Lost and Changed for user: %s' ), $user->user_login ) . "\r\n";
				// The blogname option is escaped with esc_html on the way into the database in sanitize_option
				// we want to reverse this for the plain text arena of emails.
				$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
				wp_mail( get_option( 'admin_email' ), sprintf( __( '[%s] Password Lost/Changed' ), $blogname ), $message );
			}
		endif;
		if ( $options['ss_password_change_notification_to_user'] == 'N' ):
			return false;
		else:
			return true;
		endif;
	}
	add_filter( 'send_password_change_email', 'dont_send_password_change_email', 1, 3 );
endif;

$options = ss_get_options();
if ( $options['ss_wp_notify_post_author'] == 'N' && !function_exists( 'wp_notify_postauthor' ) ):
	/**
	 * Notify an author ( and/or others ) of a comment/trackback/pingback on a post.
	 */
	//echo "wp_notify_postauthor off";
	function wp_notify_postauthor( $comment_id, $deprecated = null ) {
	}
endif;

if ( $options['ss_wp_notify_moderator'] == 'N' && !function_exists( 'wp_notify_moderator' ) ):
	/**
	 * Notifies the moderator of the blog about a new comment that is awaiting approval.
	 */
	//echo "wp_notify_moderator off";
	function wp_notify_moderator( $comment_id ) {
	}
endif;

$options = ss_get_options();
if ( ( $options['ss_send_password_forgotten_email'] == 'N' ) && !function_exists( 'dont_send_password_forgotten_email' ) ):
	/**
	 * Email forgotten password notification to registered user.
	 *
	 */
	//echo "dont_send_password_forgotten_email off";exit;
	function ss_user_is_administrator( $user_id = 0 ) {
		$user = new WP_User( intval( $user_id ) );
		$is_administrator = false;
		if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
			foreach ( $user->roles as $role ) if ( strtolower( $role ) == 'administrator' ) $is_administrator = true;
		}
		return $is_administrator;
	}
	function dont_send_password_forgotten_email( $send = true, $user_id = 0 ) {
		$options = ss_get_options();
		$is_administrator = ss_user_is_administrator( $user_id );
		// if ( $is_administrator && empty( $famne_options['send_password_admin_forgotten_email'] ) ){
		//	 // stop sending admin forgot email
		//  return false;
		// }
		if ( !$is_administrator && $options['ss_send_password_forgotten_email'] == 'N' ) {
			// stop sending user forgot email
			return false;
		}
		// none of the above so give the default status back
		return $send;
	}
	add_filter( 'allow_password_reset', 'dont_send_password_forgotten_email', 1, 3 );
endif;

if ( $options['ss_auto_core_update_send_email'] == 'N' && !function_exists( 'ss_dont_sent_auto_core_update_emails' ) ):
	function ss_dont_sent_auto_core_update_emails( $send, $type, $core_update, $result ) {
		if ( !empty( $type ) && $type == 'success' ) {
			return false;
		}
		return true;
	}
	add_filter( 'auto_core_update_send_email', 'ss_dont_sent_auto_core_update_emails', 10, 4 );
endif;

if ( $options['ss_auto_plugin_update_send_email'] == 'N' ):
	function ss_auto_plugin_update_send_email( $notifications_enabled, $update_results_plugins ) {
		$notifications_enabled = false;
		foreach ( $update_results_plugins as $update_result ) {
			// do we have a failed update?
			if ( true !== $update_result->result ) $notifications_enabled = true;
		}
		return $notifications_enabled;
	}
	add_filter( 'auto_plugin_update_send_email', 'ss_auto_plugin_update_send_email', 10, 2 );
endif;

if ( $options['ss_auto_theme_update_send_email'] == 'N' ):
	function ss_auto_theme_update_send_email( $notifications_enabled, $update_results_theme ) {
		$notifications_enabled = false;
		foreach ( $update_results_theme as $update_result ) {
			// do we have a failed update?
			if ( true !== $update_result->result ) $notifications_enabled = true;
		}
		return $notifications_enabled;
	}
	add_filter( 'auto_theme_update_send_email', 'ss_auto_theme_update_send_email', 10, 2 );
endif;

if ( $options['ss_send_email_change_email'] == 'N' && !function_exists( 'dont_send_email_change_email' ) ):
	/**
	 * Email users e-mail change notification to registered user.
	 *
	 */
	//echo "dont_send_email_change_email off";
	function dont_send_email_change_email( $send = false, $user = '', $userdata = '' ) {
		return false;
	}
	add_filter( 'send_email_change_email', 'dont_send_email_change_email', 1, 3 );
endif;

?>