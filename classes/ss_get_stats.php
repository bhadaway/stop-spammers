<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class ss_get_stats {
	public function process(
		$ip, &$stats = array(), &$options = array(), &$post = array() ) {
		// gets the stats when reset or new version
		$stats = get_option( 'ss_stop_sp_reg_stats' );
		if ( empty( $stats ) || !is_array( $stats ) ) {
			$stats = array();
		}
		$defaults   = array(
			'badips'	 => array(),
			'goodips'	 => array(),
			'hist'	     => array(),
			'wlrequests' => array(),
			'addonstats' => array(),
			'multi'	     => array()
		);
		$defaultsWL = array(
			'cntchkaws'		      => 0,
			'cntchkcloudflare'	  => 0,
			'cntchkgcache'		  => 0,
			'cntchkgenallowlist'  => 0,
			'cntchkgoogle'		  => 0,
			'cntchkmiscallowlist' => 0,
			'cntchkpaypal'		  => 0,
			'cntchkform'		  => 0,
			'cntchkscripts'	      => 0,
			'cntchkvalidip'	      => 0,
			'cntchkwlem'		  => 0,
			'cntchkwluserid'	  => 0,
			'cntchkwlist'		  => 0,
			'cntchkyahoomerchant' => 0
		);
		// Block List Y/N settings
		$defaultsBL = array(
			'cntchk404'		    => 0,
			'cntchkaccept'	    => 0,
			'cntchkadmin'	    => 0,
			'cntchkadminlog'	=> 0,
			'cntchkagent'	    => 0,
			'cntchkamazon'	    => 0,
			'cntchkakismet'	    => 0,
			'cntchkbcache'	    => 0,
			'cntchkblem'		=> 0,
			'cntchkuserid'	    => 0,
			'cntchkblip'		=> 0,
			'cntchkbotscout'	=> 0,
			'cntchkdisp'		=> 0,
			'cntchkdnsbl'	    => 0,
			'cntchkexploits'	=> 0,
			'cntchkgooglesafe'  => 0,
			'cntchkhoney'	    => 0,
			'cntchkhosting'		=> 0,
			'cntchkinvalidip'   => 0,
			'cntchklong'		=> 0,
			'cntchkshort'	    => 0,
			'cntchkbbcode'	    => 0,
			'cntchkreferer'	    => 0,
			'cntchksession'	    => 0,
			'cntchksfs'		    => 0,
			'cntchkspamwords'   => 0,
			'cntchkchkurlshort' => 0,
			'cntchktld'		    => 0,
			'cntchkubiquity'	=> 0,
			'cntchkmulti'	    => 0
		);
		$defaultsTOTALS = array(
			'spcount'  => 0,
			'spmcount' => 0,
			'cntcap'   => 0, // CAPTCHA success
			'cntncap'  => 0, // CAPTCHA not success
			'cntpass'  => 0, // passed
			'spmdate'  => date( 'Y/m/d',
				time() + ( get_option( 'gmt_offset' ) * 3600 ) ),
			'spdate'   => date( 'Y/m/d',
				time() + ( get_option( 'gmt_offset' ) * 3600 ) )
		);
		$defaultsCountries = array(
			'cntchkAD' => 0,
			'cntchkAE' => 0,
			'cntchkAF' => 0,
			'cntchkAL' => 0,
			'cntchkAM' => 0,
			'cntchkAR' => 0,
			'cntchkAT' => 0,
			'cntchkAU' => 0,
			'cntchkAX' => 0,
			'cntchkAZ' => 0,
			'cntchkBA' => 0,
			'cntchkBB' => 0,
			'cntchkBD' => 0,
			'cntchkBE' => 0,
			'cntchkBG' => 0,
			'cntchkBH' => 0,
			'cntchkBN' => 0,
			'cntchkBO' => 0,
			'cntchkBR' => 0,
			'cntchkBS' => 0,
			'cntchkBY' => 0,
			'cntchkBZ' => 0,
			'cntchkCA' => 0,
			'cntchkCD' => 0,
			'cntchkCH' => 0,
			'cntchkCL' => 0,
			'cntchkCN' => 0,
			'cntchkCO' => 0,
			'cntchkCR' => 0,
			'cntchkCU' => 0,
			'cntchkCW' => 0,
			'cntchkCY' => 0,
			'cntchkCZ' => 0,
			'cntchkDE' => 0,
			'cntchkDK' => 0,
			'cntchkDO' => 0,
			'cntchkDZ' => 0,
			'cntchkEC' => 0,
			'cntchkEE' => 0,
			'cntchkES' => 0,
			'cntchkEU' => 0,
			'cntchkFI' => 0,
			'cntchkFJ' => 0,
			'cntchkFR' => 0,
			'cntchkGB' => 0,
			'cntchkGE' => 0,
			'cntchkGF' => 0,
			'cntchkGI' => 0,
			'cntchkGP' => 0,
			'cntchkGR' => 0,
			'cntchkGT' => 0,
			'cntchkGU' => 0,
			'cntchkGY' => 0,
			'cntchkHK' => 0,
			'cntchkHN' => 0,
			'cntchkHR' => 0,
			'cntchkHT' => 0,
			'cntchkHU' => 0,
			'cntchkID' => 0,
			'cntchkIE' => 0,
			'cntchkIL' => 0,
			'cntchkIN' => 0,
			'cntchkIQ' => 0,
			'cntchkIR' => 0,
			'cntchkIS' => 0,
			'cntchkIT' => 0,
			'cntchkJM' => 0,
			'cntchkJO' => 0,
			'cntchkJP' => 0,
			'cntchkKE' => 0,
			'cntchkKG' => 0,
			'cntchkKH' => 0,
			'cntchkKR' => 0,
			'cntchkKW' => 0,
			'cntchkKY' => 0,
			'cntchkKZ' => 0,
			'cntchkLA' => 0,
			'cntchkLB' => 0,
			'cntchkLK' => 0,
			'cntchkLT' => 0,
			'cntchkLU' => 0,
			'cntchkLV' => 0,
			'cntchkMD' => 0,
			'cntchkME' => 0,
			'cntchkMK' => 0,
			'cntchkMM' => 0,
			'cntchkMN' => 0,
			'cntchkMO' => 0,
			'cntchkMP' => 0,
			'cntchkMQ' => 0,
			'cntchkMT' => 0,
			'cntchkMV' => 0,
			'cntchkMX' => 0,
			'cntchkMY' => 0,
			'cntchkNC' => 0,
			'cntchkNI' => 0,
			'cntchkNL' => 0,
			'cntchkNO' => 0,
			'cntchkNP' => 0,
			'cntchkNZ' => 0,
			'cntchkOM' => 0,
			'cntchkPA' => 0,
			'cntchkPE' => 0,
			'cntchkPG' => 0,
			'cntchkPH' => 0,
			'cntchkPK' => 0,
			'cntchkPL' => 0,
			'cntchkPR' => 0,
			'cntchkPS' => 0,
			'cntchkPT' => 0,
			'cntchkPW' => 0,
			'cntchkPY' => 0,
			'cntchkQA' => 0,
			'cntchkRO' => 0,
			'cntchkRS' => 0,
			'cntchkRU' => 0,
			'cntchkSA' => 0,
			'cntchkSC' => 0,
			'cntchkSE' => 0,
			'cntchkSG' => 0,
			'cntchkSI' => 0,
			'cntchkSK' => 0,
			'cntchkSV' => 0,
			'cntchkSX' => 0,
			'cntchkSY' => 0,
			'cntchkTH' => 0,
			'cntchkTJ' => 0,
			'cntchkTM' => 0,
			'cntchkTR' => 0,
			'cntchkTT' => 0,
			'cntchkTW' => 0,
			'cntchkUA' => 0,
			'cntchkUK' => 0,
			'cntchkUS' => 0,
			'cntchkUY' => 0,
			'cntchkUZ' => 0,
			'cntchkVC' => 0,
			'cntchkVE' => 0,
			'cntchkVN' => 0,
			'cntchkYE' => 0
		);
		$ansa = array_merge( $defaults, $defaultsWL, $defaultsTOTALS, $defaultsBL, $defaultsCountries );
		// get rid of old values no longer used in this version_compare
		foreach ( $ansa as $key => $val ) {
			if ( array_key_exists( $key, $stats ) ) {
				$ansa[$key] = $stats[$key];
			}
		}
		if ( !is_array( $ansa['wlrequests'] ) ) {
			$ansa['wlrequests'] = array();
		}
		if ( !is_array( $ansa['badips'] ) ) {
			$ansa['badips'] = array();
		}
		if ( !is_array( $ansa['hist'] ) ) {
			$ansa['hist'] = array();
		}
		if ( !is_array( $ansa['addonstats'] ) ) {
			$ansa['addonstats'] = array();
		}
		if ( !is_array( $ansa['goodips'] ) ) {
			$ansa['goodips'] = array();
		}
		if ( !is_numeric( $ansa['spcount'] ) ) {
			$ansa['spcount'] = 0;
		}
		if ( !is_numeric( $ansa['spmcount'] ) ) {
			$ansa['spmcount'] = 0;
		}
		if ( $ansa['spcount'] == 0 ) {
			$ansa['spdate'] = date( 'Y/m/d', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
		}
		if ( $ansa['spmcount'] == 0 ) {
			$ansa['spmdate'] = date( 'Y/m/d', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
		}
		$ansa['version'] = SS_VERSION;
		ss_set_stats( $ansa );
		// sfs_debug_msg( "in get ansa\r\n" . print_r( $ansa, true ) );
		return $ansa;
	}
}

?>