<?php
// this does the get for the tbody in Allow Requests

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class ss_get_alreq {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		extract( $stats );
		extract( $options );
		$trash	     = SS_PLUGIN_URL . 'images/trash.png';
		$tdown	     = SS_PLUGIN_URL . 'images/tdown.png';
		$tup		 = SS_PLUGIN_URL . 'images/tup.png';
		$whois	     = SS_PLUGIN_URL . 'images/whois.png';
		$ajaxurl	 = admin_url( 'admin-ajax.php' );
		$show		 = '';
		$nwlrequests = array();
		// sfs_debug_msg( 'wlrequests ' . print_r( $wlrequests, true ) );
		foreach ( $wlrequests as $key => $value ) {
			$sw = true;
			if ( !empty( $ip ) && $ip != 'x' ) {
				if ( $key == $ip ) {
					// sfs_debug_msg( "wlreq matched '$ip'" );
					$sw = false;
				}
				if ( $ip == trim( $value[0] ) ) { // match IP
					// sfs_debug_msg( "wlreq val 0 '$value[0]'" );
					$sw = false;
				}
				if ( $ip == trim( $value[1] ) ) { // match email
					// sfs_debug_msg( "wlreq val 1 '$value[1]'" );
					$sw = false;
				}
			}
			$container = 'wlreq';
			if ( $sw ) {
				$nwlrequests[$key] = $value;
				$show			    .= "<tr style=\"background-color:white\">";
				$trsh				 = "<a href=\"\" onclick=\"sfs_ajax_process('$key','wlreq','delete_wl_row','$ajaxurl');return false;\" title=\"" . esc_attr__( 'Delete row', 'stop-spammer-registrations-plugin' ) . "\" alt=\"" . esc_attr__( 'Delete row', 'stop-spammer-registrations-plugin' ) . "\" ><img src=\"$trash\" class=\"icon-action\"></a>";
				$addtoblock		     = "<a href=\"\"onclick=\"sfs_ajax_process('$value[0]','$container','add_black','$ajaxurl');return false;\" title=\"" . esc_attr__( 'Add ' . $value[0] . ' to Block List', 'stop-spammer-registrations-plugin' ) . "\" alt=\"" . esc_attr__( 'Add ' . $value[0] . ' to Block List', 'stop-spammer-registrations-plugin' ) . "\" ><img src=\"$tdown\" class=\"icon-action\"></a>";
				$addtoallow		     = "<a href=\"\"onclick=\"sfs_ajax_process('$value[0]','$container','add_white','$ajaxurl', '$value[1]');return false;\" title=\"" . esc_attr__( 'Add ' . $value[0] . ' to Allow List', 'stop-spammer-registrations-plugin' ) . "\" alt=\"" . esc_attr__( 'Add ' . $value[0] . ' to Allow List', 'stop-spammer-registrations-plugin' ) . "\" ><img src=\"$tup\" class=\"icon-action\"></a>";
				$show			    .= "<td>$key $trsh $addtoblock $addtoallow</td>";
				$who				 = "<br><a title=\"" . esc_attr__( 'Look up WHOIS', 'stop-spammer-registrations-plugin' ) . "\" target=\"_stopspam\" href=\"https://whois.domaintools.com/$value[0]\"><img src=\"$whois\" class=\"icon-action\"/></a> ";
				$trsh				 = "<a href=\"\" onclick=\"sfs_ajax_process('$value[0]','wlreq','delete_wlip','$ajaxurl');return false;\" title=\"" . esc_attr__( 'Delete all ' . $value[0] . '', 'stop-spammer-registrations-plugin' ) . "\" alt=\"" . esc_attr__( 'Delete all ' . $value[0] . '', 'stop-spammer-registrations-plugin' ) . "\" ><img src=\"$trash\" class=\"icon-action\"></a>";
				$show			    .= "<td>$value[0] $who $trsh</td>";
				$trsh				 = "<a href=\"\" onclick=\"sfs_ajax_process('$value[1]','wlreq','delete_wlem','$ajaxurl');return false;\" title=\"" . esc_attr__( 'Delete all ' . $value[1] . '', 'stop-spammer-registrations-plugin' ) . "\" alt=\"" . esc_attr__( 'Delete all ' . $value[1] . '', 'stop-spammer-registrations-plugin' ) . "\" ><img src=\"$trash\" class=\"icon-action\"></a>";
				$show			    .= "<td><a target=\"_stopspam\" href=\"mailto:$value[1]?subject=Website Access\">$value[1] $trsh</td>";
				$show			    .= "<td>$value[3]</td>";
				$show			    .= "<td>$value[4]</td>";
				$show			    .= "<tr>";
			}
		}
		$stats['wlrequests'] = $nwlrequests;
		// sfs_debug_msg( 'nwlrequests ' . print_r( $nwlrequests, true ) );
		if ( array_key_exists( 'addon', $post ) ) {
			ss_set_stats( $stats, $post['addon'] );
		} else {
			ss_set_stats( $stats );
		}
		return $show;
	}
}

?>