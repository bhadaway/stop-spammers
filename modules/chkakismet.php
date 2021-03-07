<?php
// this check never seems to work, so I'll leave it for now, but not use it

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkakismet {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		// do a lookup on Akismet
		if ( !function_exists( 'get_option' ) ) {
			return false;
		}
		if ( !function_exists( 'site_url' ) ) {
			return false;
		}
		$api_key = get_option( 'wordpress_api_key' );
		if ( empty( $api_key ) ) {
			return false;
		}
		$agent   = $_SERVER['HTTP_USER_AGENT'];
		$blogurl = site_url();
		$api_key = urlencode( $api_key );
		$agent   = urlencode( $agent );
		$blogurl = urlencode( $blogurl );
		if ( empty( $api_key ) || empty( $agent ) || empty( $blogurl ) ) {
			return false;
		}
		$refer	 = $_SERVER['HTTP_REFERER'];
		$data	 = array(
			'blog'				   => $blogurl,
			'user_ip'			   => $ip,
			'user_agent'		   => $agent,
			'referrer'			   => $refer,
			'permalink'			   => '',
			'comment_type'		   => 'comment',
			'comment_author'	   => '',
			'comment_author_email' => '',
			'comment_author_url'   => '',
			'comment_content'	   => ''
		);
		$response = $this->akismet_comment_check( 'YourAPIKey', $data );
		return $response;
	}
	function akismet_comment_check( $key, $data ) {
		$request = 'blog=' . urlencode( $data['blog'] ) .
				   '&user_ip=' . urlencode( $data['user_ip'] ) .
				   '&user_agent=' . urlencode( $data['user_agent'] ) .
				   '&referrer=' . urlencode( $data['referrer'] ) .
				   '&permalink=' . urlencode( $data['permalink'] ) .
				   '&comment_type=' . urlencode( $data['comment_type'] ) .
				   '&comment_author=' . urlencode( $data['comment_author'] ) .
				   '&comment_author_email=' . urlencode( $data['comment_author_email'] ) .
				   '&comment_author_url=' . urlencode( $data['comment_author_url'] ) .
				   '&comment_content=' . urlencode( $data['comment_content'] );
		$host	= $http_host = $key . '.rest.akismet.com';
		$path	= '/1.1/comment-check';
		$port	= 80;
		// $akismet_ua = "WordPress/3.8.1 | Akismet/2.5.9";
		$akismet_ua	    = sprintf( 'WordPress/%s | Akismet/%s', $GLOBALS['wp_version'], constant( 'AKISMET_VERSION' ) );
		$content_length = strlen( $request );
		$http_request   = "POST $path HTTP/1.0\r\n";
		$http_request  .= "Host: $host\r\n";
		$http_request  .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$http_request  .= "Content-Length: {$content_length}\r\n";
		$http_request  .= "User-Agent: {$akismet_ua}\r\n";
		$http_request  .= "\r\n";
		$http_request  .= $request;
		$response	    = '';
		if ( false != ( $fs = @fsockopen( $http_host, $port, $errno, $errstr, 10 ) ) ) {
			fwrite( $fs, $http_request );
			while ( !feof( $fs ) ) {
				$response .= fgets( $fs, 1160 );
			} // one TCP-IP packet
			$r = print_r( $response, true );
			fclose( $fs );
			$response = explode( "\r\n\r\n", $response, 2 );
		}
		if ( 'true' == $response[1] ) {
			return $r;
		} else {
			return $r;
		}
	}
}

?>