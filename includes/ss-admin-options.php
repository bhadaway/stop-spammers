<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

$options = ss_get_options();

if ( $options['addtoallowlist'] == 'Y' ) {
	ss_sfs_check_admin(); // adds user to Allow List
}

// admin vs mu admin
if ( get_option( 'ss_muswitch', 'N' ) == 'Y' ) {
	add_action( 'mu_rightnow_end', 'ss_sp_rightnow' );
	add_filter( 'network_admin_plugin_action_links_' . plugin_basename( __FILE__ ), 'ss_sp_plugin_action_links' );
	add_filter( 'plugin_row_meta', 'ss_sp_plugin_action_links', 10, 2 );
	add_filter( 'wpmu_users_columns', 'ss_sfs_ip_column_head' );
} else {
	add_action( 'admin_menu', 'ss_admin_menu' );
	add_action( 'rightnow_end', 'ss_sp_rightnow' );
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'ss_sp_plugin_action_links' );
	add_filter( 'manage_users_columns', 'ss_sfs_ip_column_head' );
}

add_action( 'network_admin_menu', 'ss_admin_menu' );

add_filter( 'comment_row_actions', 'ss_row', 1, 2 );

// add_action( 'wp_ajax_nopriv_sfs_sub', 'sfs_handle_ajax_sub' );
add_action( 'wp_ajax_sfs_sub', 'sfs_handle_ajax_sub' );

// new replacement for multiple AJAX hooks
// add_action( 'wp_ajax_nopriv_sfs_process', 'sfs_handle_ajax_sfs_process' );
add_action( 'wp_ajax_sfs_process', 'sfs_handle_ajax_sfs_process' );
add_action( 'manage_users_custom_column', 'ss_sfs_ip_column', 10, 3 );
// the uninstall hook only gets set if user is logged in and can manage options (plugins)
if ( function_exists( 'register_uninstall_hook' ) ) {
// uncomment this or when we go to beta
// register_uninstall_hook( __FILE__, 'ss_sfs_reg_uninstall' );
}

// do this only if a valid IP and not Cloudflare
add_action( 'admin_enqueue_scripts', 'sfs_handle_ajax' );
function sfs_handle_ajax() {
	$version = ss_assets_version();
	wp_enqueue_script(
		'stop-spammers',
		SS_PLUGIN_URL . 'js/sfs_handle_ajax.js',
		array( 'jquery' ),
		$version
	);
	wp_enqueue_script(
		'stop-spammers-modal',
		SS_PLUGIN_URL . 'js/modal.js',
		array(),
		$version,
		true
	);
	wp_add_inline_script(
		'stop-spammers',
		'const StopSpammersAjaxConfig = ' . json_encode( array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'actions' => array(
				'sfs_process' => wp_create_nonce( 'sfs_process_nonce' ),
				'sfs_sub' => wp_create_nonce( 'sfs_sub_nonce' ),
				'ss_update_notice_preference' => wp_create_nonce( 'ss_update_notice_preference_nonce' ),
				'ss_allow_block_ip' => wp_create_nonce( 'ss_allow_block_ip_nonce' ),
			),
		) ),
		'before'
	);
}

function ss_ajax_action_allowed_for_user( $user = null ) {
	if ( !is_a( $user, 'WP_User' ) ) {
		$user = wp_get_current_user();
	}
	return $user->exists() && user_can( $user, 'manage_options' );
}

function ss_sp_plugin_action_links( $links, $file ) {
	// get the links
	if ( strpos( $file, 'stop-spammer' ) === false ) {
		return $links;
	}
	if ( SS_MU == 'Y' ) {
		$link = '<a href="' . admin_url( 'network/admin.php?page=stop_spammers' ) . '">' . __( 'Settings', 'stop-spammer-registrations-plugin' ) . '</a>';
	} else {
		$link = '<a href="' . admin_url( 'admin.php?page=stop_spammers' ) . '">' . __( 'Settings', 'stop-spammer-registrations-plugin' ) . '</a>';
	}
	// check to see if we are in network
	// to-do
	$links[] = $link;
	return $links;
}

function ss_sp_rightnow() {
	$stats   = ss_get_stats();
	extract( $stats );
	$options = ss_get_options();
	if ( $spmcount > 0 ) {
		// get the path to the plugin
		_e( '<p>Stop Spammers has prevented <strong>' . $spmcount . '</strong> spammers from registering or leaving comments.</p>', 'stop-spammer-registrations-plugin' );
	}
	if ( count( $wlrequests ) == 1 ) {
		echo '<p><strong>' . count( $wlrequests ) . '</strong> ' . __( 'user has been blocked and <a href="admin.php?page=ss_allow_list">requested</a> that you add them to the Allow List.</p>', 'stop-spammer-registrations-plugin' );
	} else if ( count( $wlrequests ) > 0 ) {
		echo '<p><strong>' . count( $wlrequests ) . '</strong> ' . __( 'users have been blocked and <a href="admin.php?page=ss_allow_list">requested</a> that you add them to the Allow List.</p>', 'stop-spammer-registrations-plugin' );
	}
}

function ss_row( $actions, $comment ) {
	$options  = get_option( 'ss_stop_sp_reg_options' ); // for some reason the main call is not available?
	$apikey   = $options['apikey'];
	$email	  = urlencode( $comment->comment_author_email );
	$ip	      = $comment->comment_author_IP;
	$action   = "";
	// $action .= "|";
	// $action .= "<a title=\"" . esc_attr__( 'Check Project HoneyPot', 'stop-spammer-registrations-plugin' ) . "\" target=\"_stopspam\" href=\"https://www.projecthoneypot.org/search_ip.php?ip=$ip\">Check HoneyPot</a>";
	// add the network check
	$whois	  = SS_PLUGIN_URL . 'images/whois.png';
	$who	  = "<a title=\"" . esc_attr__( 'Look Up WHOIS', 'stop-spammer-registrations-plugin' ) . "\" target=\"_stopspam\" href=\"https://whois.domaintools.com/$ip\"><img src=\"$whois\" class=\"icon-action\"></a>";
	$stophand = SS_PLUGIN_URL . 'images/stop.png';
	$stop	  = "<a title=\"" . esc_attr__( 'Check Stop Forum Spam (SFS)', 'stop-spammer-registrations-plugin' ) . "\" target=\"_stopspam\" href=\"https://www.stopforumspam.com/search.php?q=$ip\"><img src=\"$stophand\" class=\"icon-action\"> </a>";
	$action  .= " $who $stop";
	// now add the report function
	$email = urlencode( $comment->comment_author_email );
	if ( empty( $email ) ) {
		$actions['check_spam'] = $action;
		return $actions;
	}
	$ID	      = $comment->comment_ID;
	$exst	  = '';
	$uname	  = urlencode( $comment->comment_author );
	$content  = $comment->comment_content;
	$evidence = $comment->comment_author_url;
	if ( empty( $evidence ) ) {
		$evidence = '';
	}
	preg_match_all( '@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)*)@', $content, $post, PREG_PATTERN_ORDER );
	if ( is_array( $post ) && is_array( $post[1] ) ) {
		$urls1 = array_unique( $post[1] );
	} else {
		$urls1 = array();
	}
	// BBCode
	preg_match_all( '/\[url=(.+)\]/iU', $content, $post, PREG_PATTERN_ORDER );
	if ( is_array( $post ) && is_array( $post[0] ) ) {
		$urls2 = array_unique( $post[0] );
	} else {
		$urls2 = array();
	}
	$urls3 = array_merge( $urls1, $urls2 );
	if ( is_array( $urls3 ) ) {
		$evidence .= "\r\n" . implode( "\r\n", $urls3 );
	}
	$evidence = urlencode( trim( $evidence, "\r\n" ) );
	if ( strlen( $evidence ) > 128 ) {
		$evidence = substr( $evidence, 0, 125 ) . '...';
	}
	$target  = " target=\"_blank\" ";
	$href	 = "href=\"https://www.stopforumspam.com/add.php?username=$uname&email=$email&ip_addr=$ip&evidence=$evidence&api_key=$apikey\" ";
	$onclick = '';
	$blog	 = 1;
	global $blog_id;
	if ( !isset( $blog_id ) || $blog_id != 1 ) {
		$blog = $blog_id;
	}
	$ajaxurl = admin_url( 'admin-ajax.php' );
	if ( !empty( $apikey ) ) {
		// $target = "target=\"ss_sfs_reg_if1\"";
		// make this the xlsrpc call
		$href	 = "href=\"#\"";
		$onclick = "onclick=\"sfs_ajax_report_spam(this,'$ID','$blog','$ajaxurl');return false;\"";
	}
	if ( !empty( $email ) ) {
		$action .= "|";
		$action .= "<a $exst title=\"" . esc_attr__( 'Report to Stop Forum Spam (SFS)', 'stop-spammer-registrations-plugin' ) . "\" $target $href $onclick class='delete:the-comment-list:comment-$ID::delete=1 delete vim-d vim-destructive'>" . __( ' Report to SFS', 'stop-spammer-registrations-plugin' ) . "</a>";
	}
	$action .= '<span class="ss_action" title="' . esc_attr__( 'Add to block list', 'stop-spammer-registrations-plugin' ) . '" onclick="sfs_ajax_process(\'' . $comment->comment_author_IP . '\',\'log\',\'add_black\',\'' . $ajaxurl . '\');return false;"><img src="' . SS_PLUGIN_URL . 'images/tdown.png">|</span>';
	$action .= '<span class="ss_action" title="' . esc_attr__( 'Add to allow list', 'stop-spammer-registrations-plugin' ) . '" onclick="sfs_ajax_process(\'' . $comment->comment_author_IP . '\',\'log\',\'add_white\',\'' . $ajaxurl . '\');return false;"><img src="' . SS_PLUGIN_URL . 'images/tup.png">|</span>';
	$actions['check_spam'] = $action;
	return $actions;
}

function ipChkk() {
	$actionvalid = array( 'chkvalidip', 'chkcloudflare' );
	foreach ( $actionvalid as $chk ) {
		$reason = be_load( $chk, $ip );
		if ( $reason !== false ) {
			return false;
		}
	}
	return true;
}

function sfs_handle_ajax_sub( $data ) {
	if ( ! ss_ajax_action_allowed_for_user() ) {
		wp_send_json_error( __( 'Forbidden', 'stop-spammer-registrations-plugin' ), 403 );
	}

	if ( ! check_ajax_referer( 'sfs_sub_nonce', false, false ) ) {
		wp_send_json_error( __( 'Unauthorized', 'stop-spammer-registrations-plugin' ), 401 );
	}

	// suddenly loading before 'init' has loaded things?
	// get the stuff from the $_GET and call stop forum spam
	// this tages the stuff from the get and uses it to do the get from SFS
	// get the configuration items
	$options = get_option( 'ss_stop_sp_reg_options' ); // for some reason the main call is not available?
	if ( empty( $options ) ) { // can't happen?
		_e( ' No Options Set', 'stop-spammer-registrations-plugin' );
		exit();
	}
	// print_r( $options );
	extract( $options );
	// get the comment_id parameter
	$comment_id = sanitize_text_field( urlencode( $_GET['comment_id'] ) );
	if ( empty( $comment_id ) ) {
		_e( ' No Comment ID Found', 'stop-spammer-registrations-plugin' );
		exit();
	}
	// need to pass the blog ID also
	$blog = '';
	if ( isset( $_GET['blog_id'] ) and !empty( $_GET['blog_id'] ) and is_numeric( $_GET['blog_id'] ) ) {
		if ( function_exists( 'switch_to_blog' ) ) {
			switch_to_blog( ( int ) $_GET['blog_id'] );
		}
	}
	// get the comment
	$comment = get_comment( $comment_id, ARRAY_A );
	if ( $comment_id == 'registration' ) {
		$comment = array(
			'comment_author_email' => sanitize_email( $_GET['email'] ),
			'comment_author'	   => sanitize_user( $_GET['user'] ),
			'comment_author_IP'	   => sanitize_text_field( $_GET['ip'] ),
			'comment_content'	   => 'registration',
			'comment_author_url'   => ''
		);
	} else {
		if ( empty( $comment ) ) {
			_e( ' No Comment Found for ' . $comment_id . '', 'stop-spammer-registrations-plugin' );
			exit();
		}
	}
	// print_r( $comment );
	$email	  = urlencode( $comment['comment_author_email'] );
	$uname	  = urlencode( $comment['comment_author'] );
	$ip_addr  = $comment['comment_author_IP'];
	// code added as per Paul at Stop Forum Spam
	$content  = $comment['comment_content'];
	$evidence = $comment['comment_author_url'];
	if ( $blog != '' ) {
		if ( function_exists( 'restore_current_blog' ) ) {
			restore_current_blog();
		}
	}
	if ( empty( $evidence ) ) {
		$evidence = '';
	}
	preg_match_all( '@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)*)@', $content, $post, PREG_PATTERN_ORDER );
	$urls1 = array();
	$urls2 = array();
	if ( is_array( $post ) && is_array( $post[1] ) ) {
		$urls1 = array_unique( $post[1] );
	} else {
		$urls1 = array();
	}
	// BBCode
	preg_match_all( '/\[url=(.+)\]/iU', $content, $post, PREG_PATTERN_ORDER );
	if ( is_array( $post ) && is_array( $post[0] ) ) {
		$urls2 = array_unique( $post[0] );
	} else {
		$urls2 = array();
	}
	$urls3 = array_merge( $urls1, $urls2 );
	if ( is_array( $urls3 ) ) {
		$evidence .= "\r\n" . implode( "\r\n", $urls3 );
	}
	$evidence = urlencode( trim( $evidence, "\r\n" ) );
	if ( strlen( $evidence ) > 128 ) {
		$evidence = substr( $evidence, 0, 125 ) . '...';
	}
	if ( empty( $apikey ) ) {
		_e( 'Cannot Report Spam without API Key', 'stop-spammer-registrations-plugin' );
		exit();
	}
	$hget = "https://www.stopforumspam.com/add.php?ip_addr=$ip_addr&api_key=$apikey&email=$email&username=$uname&evidence=$evidence";
	// echo $hget;
	$ret  = ss_read_file( $hget );
	if ( stripos( $ret, __( 'data submitted successfully', 'stop-spammer-registrations-plugin' ) ) !== false ) {
		echo $ret;
	} else if ( stripos( $ret, __( 'recent duplicate entry', 'stop-spammer-registrations-plugin' ) ) !== false ) {
		_e( ' Recent Duplicate Entry ', 'stop-spammer-registrations-plugin' );
	} else {
		_e( ' Returning from AJAX: ', 'stop-spammer-registrations-plugin' ) . $hget . ' - ' . $ret;
	}
	exit();
}

function sfs_get_urls( $content ) {
	preg_match_all( '@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)*)@', $content, $post, PREG_PATTERN_ORDER );
	$urls1 = array();
	$urls2 = array();
	$urls3 = array();
	if ( is_array( $post ) && is_array( $post[1] ) ) {
		$urls1 = array_unique( $post[1] );
	} else {
		$urls1 = array();
	}
	// BBCode
	preg_match_all( '/\[url=(.+)\]/iU', $content, $post, PREG_PATTERN_ORDER );
	if ( is_array( $post ) && is_array( $post[0] ) ) {
		$urls2 = array_unique( $post[0] );
	} else {
		$urls2 = array();
	}
	$urls3 = array_merge( $urls1, $urls2 );
	if ( !is_array( $urls3 ) ) {
		return array();
	}
	for ( $j = 0; $j < count( $urls3 ); $j ++ ) {
		$urls3[$j] = urlencode( $urls3[$j] );
	}
	return $urls3;
}

function sfs_handle_ajax_check( $data ) {
	if ( !ipChkk() ) {
		_e( ' Not Enabled', 'stop-spammer-registrations-plugin' );
		exit();
	}
	// this does a call to the SFS site to check a known spammer
	// returns success or not
	$query = "https://www.stopforumspam.com/api?ip=91.186.18.61";
	$check = '';
	$check = ss_sfs_reg_getafile( $query );
	if ( !empty( $check ) ) {
		$check = trim( $check );
		$check = trim( $check, '0' );
		if ( substr( $check, 0, 4 ) == "ERR:" ) {
			_e( ' Access to the Stop Forum Spam Database Shows Errors\r\n', 'stop-spammer-registrations-plugin' );
			_e( ' Response Was: ' . $check . '\r\n', 'stop-spammer-registrations-plugin' );
		}
		// access to the Stop Forum Spam database is working
		$n = strpos( $check, '<response success="true">' );
		if ( $n === false ) {
			_e( ' Access to the Stop Forum Spam Database is Not Working\r\n', 'stop-spammer-registrations-plugin' );
			_e( ' Response was\r\n ' . $check . '\r\n', 'stop-spammer-registrations-plugin' );
		} else {
			_e( ' Access to the Stop Forum Spam Database is Working', 'stop-spammer-registrations-plugin' );
		}
	} else {
		_e( ' No Response from the Stop Forum Spam API Call\r\n', 'stop-spammer-registrations-plugin' );
	}
	return;
}

function sfs_handle_ajax_sfs_process( $data ) {
	if ( ! ss_ajax_action_allowed_for_user() ) {
		wp_send_json_error( __( 'Forbidden', 'stop-spammer-registrations-plugin' ), 403 );
	}

	if ( ! check_ajax_referer( 'sfs_process_nonce', false, false ) ) {
		wp_send_json_error( __( 'Unauthorized', 'stop-spammer-registrations-plugin' ), 401 );
	}

	sfs_errorsonoff();
	sfs_handle_ajax_sfs_process_watch( $data );
	sfs_errorsonoff( 'off' );
}

function sfs_handle_ajax_sfs_process_watch( $data ) {
	// anything in data? never
	// get the things out of the get
	// check for valid get
	if ( !array_key_exists( 'func', $_GET ) ) {
		_e( ' Function Not Found', 'stop-spammer-registrations-plugin' );
		exit();
	}
	$trash	   = SS_PLUGIN_URL . 'images/trash.png';
	$tdown	   = SS_PLUGIN_URL . 'images/tdown.png';
	$tup	   = SS_PLUGIN_URL . 'images/tup.png'; // fix this
	$whois	   = SS_PLUGIN_URL . 'images/whois.png'; // fix this
	$ip		   = sanitize_text_field( $_GET['ip'] );
	$email	   = sanitize_email( $_GET['email'] );
	$container = sanitize_text_field( $_GET['cont'] );
	$func	   = sanitize_text_field( $_GET['func'] );
	// echo "error $ip, $func, $container," . print_r( $_GET, true ) ;exit();
	// container is blank, goodips, badips or log
	// func is add_black, add_white, delete_gcache or delete_bcache
	$options = ss_get_options();
	$stats   = ss_get_stats();
	// $stats, $options );
	$ansa	 = array();
	switch ( $func ) {
		case 'delete_gcache':
			// deletes a Good Cache item
			$ansa = be_load( 'ss_remove_gcache', $ip, $stats, $options );
			$show = be_load( 'ss_get_gcache', 'x', $stats, $options );
			echo $show;
			exit();
			break;
		case 'delete_bcache':
			// deletes a Bad Cache item
			$ansa = be_load( 'ss_remove_bcache', $ip, $stats, $options );
			$show = be_load( 'ss_get_bcache', 'x', $stats, $options );
			echo $show;
			exit();
			break;
		case 'add_black':
			if ( $container == 'badips' ) {
				be_load( 'ss_remove_bcache', $ip, $stats, $options );
			} else if ( $container == 'goodips' ) {
				be_load( 'ss_remove_gcache', $ip, $stats, $options );
			} else { // wlreq
				be_load( 'ss_remove_bcache', $ip, $stats, $options );
				be_load( 'ss_remove_gcache', $ip, $stats, $options );
			}
			be_load( 'ss_addtoblocklist', $ip, $stats, $options );
			break;
		case 'add_white':
			if ( $container == 'badips' ) {
				be_load( 'ss_remove_bcache', $ip, $stats, $options );
			} else if ( $container == 'goodips' ) {
				be_load( 'ss_remove_gcache', $ip, $stats, $options );
			} else {
				be_load( 'ss_remove_bcache', $ip, $stats, $options );
				be_load( 'ss_remove_gcache', $ip, $stats, $options );
			}
			be_load( 'ss_addtoallowlist', $ip, $stats, $options );
// if it is not good or bad IP we don't need the container as it is the log
			break;
		case 'delete_wl_row': // this is from the Allow Requests list
			$ansa = be_load( 'ss_get_alreq', $ip, $stats, $options );
			echo $ansa;
			exit();
			break;
		case 'delete_wlip': // this is from the Allow Requests list
			$ansa = be_load( 'ss_get_alreq', $ip, $stats, $options );
			echo $ansa;
			exit();
			break;
		case 'delete_wlem': // this is from the Allow Requests list
			$ansa = be_load( 'ss_get_alreq', $ip, $stats, $options );
			echo $ansa;
			exit();
			break;
		default:
			_e( '\r\n\r\nUnrecognized function "' . $func . '"', 'stop-spammer-registrations-plugin' );
			exit();
	}
	$ajaxurl  = admin_url( 'admin-ajax.php' );
	$cachedel = 'delete_gcache';
	switch ( $container ) {
		case 'badips':
			$show = be_load( 'ss_get_bcache', 'x', $stats, $options );
			echo $show;
			exit();
			break;
		case 'goodips':
			$show = be_load( 'ss_get_gcache', 'x', $stats, $options );
			echo $show;
			exit();
			break;
		case 'wlreq':
			$ansa = be_load( 'ss_get_alreq', $ip, $stats, $options );
			echo $ansa;
			exit();
		default:
			// coming from logs report we need to display an appropriate message, I think
			_e( 'Something is missing ' . $container . ' ', 'stop-spammer-registrations-plugin' );
			exit();
	}
}

function ss_sfs_ip_column( $value, $column_name, $user_id ) {
	// get the IP for this column
	$trash	  = SS_PLUGIN_URL . 'images/trash.png';
	$tdown	  = SS_PLUGIN_URL . 'images/tdown.png';
	$tup	  = SS_PLUGIN_URL . 'images/tup.png';
	$whois	  = SS_PLUGIN_URL . 'images/whois.png';
	$stophand = SS_PLUGIN_URL . 'images/stop.png';
	$search   = SS_PLUGIN_URL . 'images/search.png';
	if ( $column_name == 'signup_ip' ) {
		$signup_ip  = get_user_meta( $user_id, 'signup_ip', true );
		$signup_ip2 = $signup_ip;
		$ipline	 = "";
		if ( !empty( $signup_ip ) ) {
			$ipline = apply_filters( 'ip2link', $signup_ip2 ); // if the ip2link plugin is installed
			// now add the check
			$user_info   = get_userdata( $user_id );
			$useremail   = urlencode( $user_info->user_email ); // for reporting
			$userurl	 = urlencode( $user_info->user_url );
			$username	 = $user_info->display_name;
			$stopper	 = "<a title=\"" . esc_attr__( 'Check Stop Forum Spam (SFS)', 'stop-spammer-registrations-plugin' ) . "\" target=\"_stopspam\" href=\"https://www.stopforumspam.com/search.php?q=$signup_ip\"><img src=\"$stophand\" class=\"icon-action\"></a>";
			$honeysearch = "<a title=\"" . esc_attr__( 'Check Project HoneyPot', 'stop-spammer-registrations-plugin' ) . "\" target=\"_stopspam\" href=\"https://www.projecthoneypot.org/ip_$signup_ip\"><img src=\"$search\" class=\"icon-action\"></a>";
			$botsearch   = "<a title=\"" . esc_attr__( 'Check BotScout', 'stop-spammer-registrations-plugin' ) . "\" target=\"_stopspam\" href=\"https://botscout.com/search.htm?stype=q&sterm=$signup_ip\"><img src=\"$search\" class=\"icon-action\"></a>";
			$who		 = "<br><a title=\"" . esc_attr__( 'Look Up WHOIS', 'stop-spammer-registrations-plugin' ) . "\" target=\"_stopspam\" href=\"https://whois.domaintools.com/$signup_ip\"><img src=\"$whois\" class=\"icon-action\"></a>";
			$action	     = " $who $stopper $honeysearch $botsearch";
			$options	 = ss_get_options();
			$apikey	     = $options['apikey'];
			if ( !empty( $apikey ) ) {
				$report  = "<a title=\"" . esc_attr__( 'Report to SFS', 'stop-spammer-registrations-plugin' ) . "\" target=\"_stopspam\" href=\"https://www.stopforumspam.com/add.php?username=$username&email=$useremail&ip_addr=$signup_ip&evidence=$userurl&api_key=$apikey\"><img src=\"$stophand\" class=\"icon-action\"></a>";
				$action .= $report;
			}
			return $ipline . $action;
		}
		return "";
	}
	return $value;
}

?>
