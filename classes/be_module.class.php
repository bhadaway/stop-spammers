<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class be_module {
	// useful functions for be classes
	// attemping to make this stand-alone
	// if not passed an array of variables then extract it
	public $searchname = '';
	public $searchlist = array();

	// most common use is as a country lookup - this does the base country lookup if there is no process
	public static function getafile( $f, $method = 'GET' ) {
		// try this using Wp_Http
		if ( !class_exists( 'WP_Http' ) ) {
			include_once( ABSPATH . WPINC . '/class-http.php' );
		}
		$request		  = new WP_Http;
		$parms			  = array();
		$parms['timeout'] = 10; // bump timeout a little we are timing out in Google
		$parms['method']  = $method;
		$result		      = $request->request( $f, $parms );
		// see if there is anything there
		if ( empty( $result ) ) {
			return '';
		}
		if ( is_array( $result ) ) {
			$ansa = $result['body'];
			return $ansa;
		}
		if ( is_object( $result ) ) {
			$ansa = 'ERR: ' . $result->get_error_message();
			return $ansa; // return $ansa when debugging
			// return '';
		}
		return '';
	}

	public static function getSname() {
	// gets the module name from the URL address line
		$sname = '';
		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			$sname = $_SERVER["REQUEST_URI"];
		}
		if ( empty( $sname ) ) {
			$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
			$sname				    = $_SERVER["SCRIPT_NAME"];
			if ( $_SERVER['QUERY_STRING'] ) {
				$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
			}
		}
		// echo "sname = $sname<br>";
		if ( empty( $sname ) ) {
			$sname = '';
		}
		return $sname;
	}

	public static function cidr2str( $ipl, $bits ) {
		// finds end range for a numstr input
		$ipl = ip2long( $ipl );
		$ipl = sprintf( "%u", $ipl );
		$num = pow( 2, 32 - $bits ) - 1;
		$ipl = $ipl + 0;
		$ipl = $ipl | $num;
		$ipl ++;
		return long2ip( $ipl );
	}

	public function searchList( $needle, &$haystack ) { // array in haystack is time=>reason
		// searches an array for an IP or an email
		// simple search array no key
		$searchname = $this->searchname;
		if ( !is_array( $haystack ) ) {
			return false;
		}
		$needle = strtolower( $needle );
		if ( empty( $needle ) ) {
			return false;
		}
		foreach ( $haystack as $search ) { // haystack is a list of names or emails, possibly with wildcards
			$search = trim( strtolower( $search ) );
			$reason = $search;
			if ( empty( $search ) ) {
				continue;
			} // in case there is a null in the list
			if ( $needle == $search ) {
				return "$searchname: $needle";
			}
			// four kinds of search, looking for an IP, cidr, wildcard or an email
			if ( substr_count( $needle, '.' ) == 3
				 && strpos( $search, '.' ) !== false
				 && strpos( $search, '/' ) !== false
			) {
				// searching for an cidr in the list
				list( $subnet, $mask ) = explode( '/', $search );
				$x2 = ip2long( $needle ) & ~( ( 1 << ( 32 - $mask ) ) - 1 );
				$x3 = ip2long( $subnet ) & ~( ( 1 << ( 32 - $mask ) ) - 1 );
				if ( $x2 == $x3 ) {
					return "$searchname: $reason";
				}
			}
			// check for wildcard - both email and IP
			if ( strpos( $search, '*' ) !== false || strpos( $search, '?' ) !== false ) {
				// new wildcard search
				if ( be_module::wildcard_match( $search, $needle ) ) {
					return "$searchname: $reason: $needle";
				}
				continue;
			}
			// check for partial both email and IP
			if ( strlen( $needle ) > strlen( $search ) ) {
				$n = substr( $needle, 0, strlen( $search ) );
				if ( $n == $search ) {
					return "$searchname: $reason";
				}
			}
		}
		return false;
	}

	/**
	 * Matches wilcards on string or array
	 * $pattern in wilcarded pattern with ? counted as single character
	 * and * as multiple characters
	 * if $value is string, returns true/false
	 * if $value is an array, returns matches strings from array
	 *
	 * @param string $pattern
	 * @param string $value
	 *
	 * @return bool|array
	 */
	public static function wildcard_match( $pattern, $value ) {
		if ( is_array( $value ) ) {
			$return = array();
			foreach ( $value as $string ) {
				if ( wildcard_match( $pattern, $string ) ) {
					$return[] = $string;
				}
			}
			return $return;
		}
		// split patterns by *? but not \* \?
		$pattern = preg_split( '/((?<!\\\)\*)|((?<!\\\)\?)/', $pattern, null,
			PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );
		foreach ( $pattern as $key => $part ) {
			if ( $part == '?' ) {
				$pattern[$key] = '.';
			} elseif ( $part == '*' ) {
				$pattern[$key] = '.*';
			} else {
				$pattern[$key] = preg_quote( $part );
			}
		}
		$pattern = implode( '', $pattern );
		$pattern = '/^' . $pattern . '$/';
		return preg_match( $pattern, $value );
	}

	public function searchcache( $needle, &$haystack ) { // array in haystack is ip=>reason
		// searches an array for an IP or an email - uses wildcards, short instances and cidrs
		// the wlist array is of the form $time->ip
		$searchname = $this->searchname;
		if ( !is_array( $haystack ) ) {
			return false;
		}
		$needle = strtolower( $needle );
		foreach ( $haystack as $search => $reason ) {
			$search = trim( strtolower( $search ) );
			if ( empty( $search ) ) {
				continue;
			} // in case there is a null in the list
			if ( $needle == $search ) {
				return "$searchname: $needle";
			}
			// four kinds of search, looking for an IP, cidr, wildcard or an email
			// check for wildcard - both email and IP
			if ( strpos( $search, '*' ) !== false
				 || strpos( $search, '?' ) !== false
			) {
				if ( be_module::wildcard_match( $search, $needle ) ) {
					return "$searchname: $reason: $needle";
				}
				// $search=substr( $search, 0, strpos( $search, '*' ) );
				// if ( $search = substr( $needle, 0, strlen( $search ) ) ) return "$searchname: $reason";
			}
			// check for partial both email and IP
			if ( strlen( $needle ) > strlen( $search ) ) {
				$n = substr( $needle, 0, strlen( $search ) );
				if ( $n == $search ) {
					return "$searchname: $reason";
				}
			}
			if ( substr_count( $needle, '.' ) == 3 && strpos( $search, '/' ) !== false ) {
				// searching for an cidr in the list
				list( $subnet, $mask ) = explode( '/', $search );
				$x2 = ip2long( $needle ) & ~( ( 1 << ( 32 - $mask ) ) - 1 );
				$x3 = ip2long( $subnet ) & ~( ( 1 << ( 32 - $mask ) ) - 1 );
				if ( $x2 == $x3 ) {
					return "$searchname: $reason";
				}
			}
		}
		return false;
	}

	public function process(
		$ip, &$stats = array(), &$options = array(), &$post = array() ) {
			return be_module::ipListMatch( $ip );
		}
		// https://github.com/andrewtch/phpwildcard/blob/master/wildcard_match.php

	public function ipListMatch( $ip ) {
		// does a match agains a list of IP addresses
		$ipt = be_module::ip2numstr( $ip );
		foreach ( $this->searchlist as $c ) {
			if ( !is_array( $c ) ) {
				// this might be a cidr
				if ( substr_count( $c, '.' ) == 3 ) {
					if ( strpos( $c, '/' ) !== false ) {
						// cidr
						$c = be_module::cidr2ip( $c );
					} else {
						// single IP
						$c = array( $c, $c );
					}
				}
				if ( !is_array( $c ) ) {
					$this->searchname = $c;
				}
			}
			if ( is_array( $c ) ) {
				list( $ips, $ipe ) = $c;
				if ( strpos( $ips, '.' ) === false
					 && strpos( $ips, ':' ) === false
				) { // new numstr format
					if ( $ipt < $ips ) {
						return false;
					}
					if ( $ipt >= $ips && $ipt <= $ipe ) {
						return $this->searchname . ': ' . $ip;
					}
				} else if ( strpos( $ips, ':' ) !== false ) { // IPv6
					if ( $ip >= $ips && $ip <= $ipe ) {
						return $this->searchname . ': ' . $ip;
					}
				} else {
					$ips = be_module::ip2numstr( $ips );
					$ipe = be_module::ip2numstr( $ipe );
					if ( $ipt >= $ips && $ipt <= $ipe ) {
						if ( is_array( $ip ) ) {
							_e( 'Array in IP: ', 'stop-spammer-registrations-plugin' ) . print_r( $ip, true )
								 . "<br>";
							$ip = $ip[0];
						}
						return $this->searchname . ': ' . $ip;
					}
				}
			}
		}
		return false;
	}

	public static function ip2numstr( $ip ) {
		if ( long2ip( ip2long( $ip ) ) != $ip ) {
			return false;
		}
		list( $b1, $b2, $b3, $b4 ) = explode( '.', $ip );
		$b1 = str_pad( $b1, 3, '0', STR_PAD_LEFT );
		$b2 = str_pad( $b2, 3, '0', STR_PAD_LEFT );
		$b3 = str_pad( $b3, 3, '0', STR_PAD_LEFT );
		$b4 = str_pad( $b4, 3, '0', STR_PAD_LEFT );
		$s  = $b1 . $b2 . $b3 . $b4;
		return $s;
	}

	public static function cidr2ip( $cidr ) { // returns numstr
		if ( strpos( $cidr, '/' ) === false ) {
			return false;
		}
		list( $ip, $bits ) = explode( '/', $cidr );
		// echo "1) Bad end $ip, $bits,<br>";
		$ip = be_module::fixip( $ip ); // in case the wrong number of dots
		// echo "2) Bad end $ip, $bits,<br>";
		if ( $ip === false ) {
			return false;
		}
		$start = $ip;
		$end   = ip2long( $ip );
		$end   = sprintf( "%u", $end );
		$end1  = $end + 0;
		$num   = pow( 2, 32 - $bits ) - 1;
		// echo "4) Bad end $num,<br>";
		$end = ( $end + 0 ) | $num;
		$end = $end + 1;
		// $pend = long2ip( $end );
		// echo "3) Bad end $pend,<br>";
		$end2 = long2ip( $end );
		if ( $end == '128.0.0.0' ) {
		// echo "Bad end $ip, $bits,$end, $end1, $end2, $num )<br>";
		}
		$start = be_module::cidrStart2str( $start, $bits );
		return array( $start, $end2 );
	}

	public static function fixip( $ip ) {
		// checks IP for right number of zeros
		$ip = trim( $ip );
		if ( empty( $ip ) ) {
			return false;
		}
		if ( strpos( $ip, '.' ) === false ) {
			return false;
		}
		if ( count( explode( '.', $ip ) ) == 2 ) {
			$ip .= '.0.0';
		}
		if ( count( explode( '.', $ip ) ) == 3 ) {
			$ip .= '.0';
		}
		if ( long2ip( ip2long( $ip ) ) != $ip ) {
			return false;
		}
		return $ip;
	}

	public static function cidrStart2str( $ipl, $bits ) {
		// finds end range for a numstr input
		$ipl = ip2long( $ipl );
		$ipl = sprintf( "%u", $ipl );
		$num = pow( 2, 32 - $bits ) - 1;
		// echo decbin( $num ) . '<br>';
		$ipl = $ipl + 0;
		// echo decbin( $ipl ) . '<br>';
		$z = pow( 2, 33 ) - 1;
		// echo 'z' . decbin( $z ) . '<br>';
		$z = $num ^ $z; // 10000000000000000000000000000 xor 0000000000000000000011111 = 011111111111111111111111100000
		// echo 'z2' . decbin( $z ) . '<br>';
		$ipl = $ipl & $z;
		return long2ip( $ipl );
	}
	/**************************************************
	 * check if an IP is in a CIDR range
	 * From https://secure.php.net/manual/en/ref.network.php
	 ***************************************************/
}

?>