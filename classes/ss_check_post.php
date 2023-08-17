<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class ss_check_post extends be_module {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		// does all of the post checks
		// these are the block before addons
		// returns array 
		// [0] = class location,
		// [1] = class name (also used as counter),
		// [2] = addon name,
		// [3] = addon author,
		// [4] = addon description
		// if already in Good Cache then exit quick - prevents looking when good checking has already been done
		$reason = be_load( 'chkgcache', ss_get_ip(), $stats, $options, $post );
		if ( $reason !== false ) {
			return;
		}
		$addons = array();
		$addons = apply_filters( 'ss_addons_block', $addons );
		if ( !empty( $addons ) && is_array( $addons ) ) {
			foreach ( $addons as $add ) {
				if ( !empty( $add ) && is_array( $add ) ) {
					$reason = be_load( $add, ss_get_ip(), $stats, $options,
						$post );
					if ( $reason !== false ) {
						// need to log a passed hit on post here
						ss_log_bad( ss_get_ip(), $reason, $add[1], $add );
						exit();
					}
				}
			}
		}
		// here on a post only so it will not check GET vars
		$noipactions = array( // these don't need the IP to detect spam
			'chkagent',
			'chkbbcode',
			'chkblem',
			'chkbluserid',
			'chkdisp',
			'chkexploits',
			'chklong',
			'chkshort',
			'chkreferer',
			'chksession',
			'chkspamwords',
			'chkperiods',
			'chkurlshort',
			'chktld',
			'chkaccept',
			'chkadmin',
			'chkurls'
		);
		$actions = array( // these require an IP that can be trusted
			'chkamazon',
			'chkbcache',
			'chkblip',
			'chkdisp',
			'chkhosting',
			'chkinvalidip',
			'chkubiquity',
			'chkmulti',
			'chkgooglesafe',
			'chkAD',
			'chkAE',
			'chkAF',
			'chkAL',
			'chkAM',
			'chkAR',
			'chkAT',
			'chkAU',
			'chkAX',
			'chkAZ',
			'chkBA',
			'chkBB',
			'chkBD',
			'chkBE',
			'chkBG',
			'chkBH',
			'chkBN',
			'chkBO',
			'chkBR',
			'chkBS',
			'chkBY',
			'chkBZ',
			'chkCA',
			'chkCD',
			'chkCH',
			'chkCL',
			'chkCN',
			'chkCO',
			'chkCR',
			'chkCU',
			'chkCW',
			'chkCY',
			'chkCZ',
			'chkDE',
			'chkDK',
			'chkDO',
			'chkDZ',
			'chkEC',
			'chkEE',
			'chkES',
			'chkEU',
			'chkFI',
			'chkFJ',
			'chkFR',
			'chkGB',
			'chkGE',
			'chkGF',
			'chkGI',
			'chkGP',
			'chkGR',
			'chkGT',
			'chkGU',
			'chkGY',
			'chkHK',
			'chkHN',
			'chkHR',
			'chkHT',
			'chkHU',
			'chkID',
			'chkIE',
			'chkIL',
			'chkIN',
			'chkIQ',
			'chkIR',
			'chkIS',
			'chkIT',
			'chkJM',
			'chkJO',
			'chkJP',
			'chkKE',
			'chkKG',
			'chkKH',
			'chkKR',
			'chkKW',
			'chkKY',
			'chkKZ',
			'chkLA',
			'chkLB',
			'chkLK',
			'chkLT',
			'chkLU',
			'chkLV',
			'chkMD',
			'chkME',
			'chkMK',
			'chkMM',
			'chkMN',
			'chkMO',
			'chkMP',
			'chkMQ',
			'chkMT',
			'chkMV',
			'chkMX',
			'chkMY',
			'chkNC',
			'chkNI',
			'chkNL',
			'chkNO',
			'chkNP',
			'chkNZ',
			'chkOM',
			'chkPA',
			'chkPE',
			'chkPG',
			'chkPH',
			'chkPK',
			'chkPL',
			'chkPR',
			'chkPS',
			'chkPT',
			'chkPW',
			'chkPY',
			'chkQA',
			'chkRO',
			'chkRS',
			'chkRU',
			'chkSA',
			'chkSC',
			'chkSE',
			'chkSG',
			'chkSI',
			'chkSK',
			'chkSV',
			'chkSX',
			'chkSY',
			'chkTH',
			'chkTJ',
			'chkTM',
			'chkTR',
			'chkTT',
			'chkTW',
			'chkUA',
			'chkUK',
			'chkUS',
			'chkUY',
			'chkUZ',
			'chkVC',
			'chkVE',
			'chkVN',
			'chkYE',
			'chksfs', // IO checks last - these can take a few seconds
			'chkhoney',
			'chkbotscout',
			'chkdnsbl'
			// check countries
		);
		$chk = '';
		// start with the no IP list
		foreach ( $noipactions as $chk ) {
			if ( $options[$chk] == 'Y' ) {
				$reason = be_load( $chk, ss_get_ip(), $stats, $options, $post );
				if ( $reason !== false ) {
					break;
				}
			}
		}
		if ( $reason === false ) {
			// check for a valid IP - if IP is valid we can do the IP checks
			$actionvalid = array( 'chkvalidip' ); // took out the Cloudflare exclusion
			foreach ( $actionvalid as $chk ) {
				$reason = be_load( $chk, ss_get_ip(), $stats, $options, $post );
				if ( $reason !== false ) {
					break;
				}
			}
			// if the IP is valid reason will be false - things like 127.0.0.1, etc. or IP same as server
			// can't check the IP based checks because the IP is invalid
			if ( $reason !== false ) {
				return false;
			}
		}
		if ( $reason === false ) {
			foreach ( $actions as $chk ) {
				if ( $options[$chk] == 'Y' ) {
					$reason = be_load( $chk, ss_get_ip(), $stats, $options, $post );
					if ( $reason !== false ) {
						break;
					}
				}
			}
		}
		// sfs_debug_msg( "check post $ip, " . print_r( $post,true ) );
		// for testing the cache without doing spam
		if ( array_key_exists( 'email', $post ) && $post['email'] == 'email@example.com' ) {
			$post['reason'] = __( 'Testing Email (will always be blocked)', 'stop-spammer-registrations-plugin' ); // use to test plugin
			be_load( 'ss_challenge', ss_get_ip(), $stats, $options, $post );
			return;
		}
		// these are the block after addons
		// returns array 
		// [0] = class location,
		// [1] = class name (also used as counter),
		// [2] = addon name,
		// [3] = addon author,
		// [4] = addon description
		if ( $reason === false ) {
			return false;
		}
		// here because we have a spammer that's been caught
		$ss_check_sempahore = true;
		ss_log_bad( ss_get_ip(), $reason, $chk );
		exit;
	}
}

?>