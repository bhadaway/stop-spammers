<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class ss_challenge extends be_module {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		// it looks like I am not getting my stats and options correctly
		// sfs_debug_msg( 'Made it into challenge' );
		$ip	     = ss_get_ip();
		$stats   = ss_get_stats();
		$options = ss_get_options();
		// $post = get_post_variables();
		/*
		page is HEADER, Allow List Request, CAPTCHAs and then a button
		processing is
		1) check for response from form
		2) else display form
		*/
		// display block message and CAPTCHA if set
		// first, check to see if they should be redirected
		if ( $options['redir'] == 'Y' && !empty( $options['redirurl'] ) ) {
			// sfs_debug_msg( 'Redir?' );
			if ( isset( $_POST["_wpcf7"] ) ) {
				// echo json_encode( $_POST );
				return json_encode( $_POST );
			} else {
				header( 'HTTP/1.1 307 Moved' );
				header( 'Status: 307 Moved' );
				header( "location: " . $options['redirurl'] );
				exit();
			}	
		}
		extract( $options );
		$ke = '';
		$km = '';
		$kr = '';
		$ka = '';
		$kp = ''; // serialized post
		// step 1 look for form response
		// nonce is in a field named kn - this is not to confuse with other forms that may be coming in
		$nonce = '';
		$msg   = ''; // this is the body message for failed CAPTCHAs, notifies and requests
		if ( !empty( $_POST ) && array_key_exists( 'kn', $_POST ) ) {
			// sfs_debug_msg( 'second time' );
			// get the post items
			if ( isset( $_POST['ke'] ) ) {
				$ke = sanitize_email( $_POST['ke'] );
			}
			if ( array_key_exists( 'ke', $_POST ) ) {
				$ke = sanitize_email( $_POST['ke'] );
			}
			if ( array_key_exists( 'km', $_POST ) ) {
				$km = sanitize_text_field( $_POST['km'] );
			}
			if ( strlen( $km ) > 80 ) {
				$km = substr( $km, 0, 77 ) . '...';
			}
			if ( array_key_exists( 'kr', $_POST ) ) {
				$kr = sanitize_text_field( $_POST['kr'] );
			}
			if ( array_key_exists( 'ka', $_POST ) ) {
				$ka = sanitize_text_field( $_POST['ka'] );
			}
			if ( array_key_exists( 'kp', $_POST ) ) {
				$kp = sanitize_textarea_field( $_POST['kp'] );
			} // serialized post
			if ( !empty( $_POST['kn'] ) && wp_verify_nonce( $_POST['kn'], 'ss_stopspam_block' ) ) {
				// sfs_debug_msg( 'nonce is good' );
				// have a form return
				// 1) to see if the allow by request has been triggered
				$emailsent = $this->ss_send_email( $options );
				// 2) see if we should add to the Allow List
				$allowset = false;
				if ( $wlreq == 'Y' ) { // allow things to added to Allow List
					$allowset = $this->ss_add_allow( $ip, $options, $stats, $post, $post );
				}
				// now the CAPTCHA settings
				$msg = __( 'Thank you,<br>', 'stop-spammer-registrations-plugin' );
				if ( $emailsent ) {
					$msg .= __( 'The webmaster has been notified by email.<br>', 'stop-spammer-registrations-plugin' );
				}
				if ( $allowset ) {
					$msg .= __( 'Your request has been recorded.<br>', 'stop-spammer-registrations-plugin' );
				}
				if ( empty( $chkcaptcha ) || $chkcaptcha == 'N' ) {
					// send out the thank you message
					wp_die( $msg, "Stop Spammers", array( 'response' => 200 ) );
					exit();
				}
				// they submitted a CAPTCHA
				switch ( $chkcaptcha ) {
					case 'G':
						if ( array_key_exists( 'recaptcha', $_POST ) && !empty( $_POST['recaptcha'] ) && array_key_exists( 'g-recaptcha-response', $_POST ) ) {
							// check reCAPTCHA
							$recaptchaapisecret = $options['recaptchaapisecret'];
							$recaptchaapisite   = $options['recaptchaapisite'];
							if ( empty( $recaptchaapisecret ) || empty( $recaptchaapisite ) ) {
								$msg = __( 'reCAPTCHA keys are not set.', 'stop-spammer-registrations-plugin' );
							} else {
								$g = sanitize_textarea_field( $_REQUEST['g-recaptcha-response'] );
								// $url = "https://www.google.com/recaptcha/api/siteverify";
								$url  = "https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaapisecret&response=$g&remoteip=$ip";
								$resp = ss_read_file( $url );
								// sfs_debug_msg( "recaptcha '$g', '$ip' '$resp' - \r\n" . print_r( $_POST, true ) );
								if ( strpos( $resp, '"success": true' ) !== false ) { // found success
									// $kp = base64_encode( serialize( $_POST ) );
									$_POST = unserialize( base64_decode( $kp ), ['allowed_classes' => false] );
									// sfs_debug_msg( "trying to return the post to the comments program" . print_r( $_POST, true ) );
									// success add to cache
									ss_log_good( $ip, __( 'Passed reCAPTCHA', 'stop-spammer-registrations-plugin' ), 'pass' );
									do_action( 'ss_stop_spam_ok', $ip, $post ); // so plugins can undo spam report
									return false;
								} else {
									$msg = __( 'Google reCAPTCHA entry does not match. Try again.', 'stop-spammer-registrations-plugin' );
								}
							}
						}
						break;
					case 'H':
						if ( array_key_exists( 'h-captcha', $_POST ) && !empty( $_POST['h-captcha'] ) && array_key_exists( 'h-captcha-response', $_POST ) ) {
							// check hCaptcha
							$hcaptchaapisecret = $options['hcaptchaapisecret'];
							$hcaptchaapisite   = $options['hcaptchaapisite'];
							/*print_r( $hcaptchaapisecret );
							echo "<pre>";
							print_r( $hcaptchaapisite );
							exit;*/
							if ( empty( $hcaptchaapisecret ) || empty( $hcaptchaapisite ) ) {
								$msg = __( 'hCaptcha keys are not set.', 'stop-spammer-registrations-plugin' );
							} else {
								$h = sanitize_textarea_field( $_REQUEST['h-captcha-response'] );
								// $url = "https://hcaptcha.com/siteverify";
								$url  = "https://hcaptcha.com/siteverify?secret=$hcaptchaapisecret&response=$h&remoteip=$ip";
								$resp = ss_read_file( $url );
								// sfs_debug_msg( "hcaptcha '$h', '$ip' '$resp' - \r\n" . print_r( $_POST, true ) );
								$response = json_decode( $resp );
								if ( $response->success and $response->success == true ) { // found success
									// $kp = base64_encode( serialize( $_POST ) );
									$_POST = unserialize( base64_decode( $kp ), ['allowed_classes' => false] );
									// sfs_debug_msg( "trying to return the post to the comments program" . print_r( $_POST, true ) );
									// success add to cache
									ss_log_good( $ip, __( 'Passed hCaptcha', 'stop-spammer-registrations-plugin' ), 'pass' );
									do_action( 'ss_stop_spam_ok', $ip, $post ); // so plugins can undo spam report
									return false;
								} else {
									$msg = __( 'hCaptcha entry does not match. Try again.', 'stop-spammer-registrations-plugin' );
								}
							}
						}
						break;
					case 'S':
						if ( array_key_exists( 'adcopy_challenge', $_POST ) && !empty( $_POST['adcopy_challenge'] ) ) {
							// solve media
							$solvmediaapivchallenge = $options['solvmediaapivchallenge'];
							$solvmediaapiverify	    = $options['solvmediaapiverify'];
							$adcopy_challenge	    = sanitize_textarea_field( $_REQUEST['adcopy_challenge'] );
							$adcopy_response		= sanitize_textarea_field( $_REQUEST['adcopy_response'] );
							// $ip = '127.0.0.1';
							$postdata = http_build_query(
								array(
									'privatekey' => $solvmediaapiverify,
									'challenge'  => $adcopy_challenge,
									'response'   => $adcopy_response,
									'remoteip'   => $ip
								)
							);
							$opts	 = array(
								'http' =>
									array(
										'method'  => 'POST',
										'header'  => 'Content-type: application/x-www-form-urlencoded',
										'content' => $postdata
									)
							);
							// $context = stream_context_create( $opts );
							// need to rewrite this post with the WP class
							/**********************************************
							 * try to use the sp function
							 **********************************************/
							$body		= array(
								'privatekey' => $solvmediaapiverify,
								'challenge'  => $adcopy_challenge,
								'response'   => $adcopy_response,
								'remoteip'   => $ip
							);
							$args		= array(
								'user-agent'  => 'WordPress/' . '4.2' . '; ' . get_bloginfo( 'url' ),
								'blocking'	  => true,
								'headers'	  => array( 'Content-type: application/x-www-form-urlencoded' ),
								'method'	  => 'POST',
								'timeout'	  => 45,
								'redirection' => 5,
								'httpversion' => '1.0',
								'body'		  => $body,
								'cookies'	  => array()
							);
							$url		 = 'https://verify.solvemedia.com/papi/verify/';
							$resultarray = wp_remote_post( $url, $args );
							$result	     = $resultarray['body'];
							// $result = file_get_contents( '//verify.solvemedia.com/papi/verify/', false, $context );  
							if ( strpos( $result, 'true' ) !== false ) {
								$_POST = unserialize( base64_decode( $kp ), ['allowed_classes' => false] );
								// sfs_debug_msg( "trying to return the post to the comments program" . print_r( $_POST, true ) );
								// success add to cache
								ss_log_good( $ip, __( 'Passed Solve Media CAPTCHA', 'stop-spammer-registrations-plugin' ), 'pass' );
								do_action( 'ss_stop_spam_ok', $ip, $post ); // so plugins can undo spam report
								return false;
							} else {
								$msg = __( 'CAPTCHA entry does not match. Try again.', 'stop-spammer-registrations-plugin' );
							}
						}
						break;
					case 'A':
					case 'Y':
						if ( array_key_exists( 'nums', $_POST ) && !empty( $_POST['nums'] ) ) {
							// simple arithmetic - at least it is different for each website and changes occasionally
							$seed   = 5;
							$spdate = $stats['spdate'];
							if ( !empty( $spdate ) ) {
								$seed = strtotime( $spdate );
							}
							$nums  = really_clean( sanitize_text_field( $_POST['nums'] ) );
							$nums += $seed;
							$sum   = really_clean( sanitize_text_field( $_POST['sum'] ) );
							if ( $sum == $nums ) {
								$_POST = unserialize( base64_decode( $kp ), ['allowed_classes' => false] );
								// sfs_debug_msg( "trying to return the post to the comments program" . print_r( $_POST, true ) );
								// success add to cache
								ss_log_good( $ip, __( 'Passed Simple Arithmetic CAPTCHA', 'stop-spammer-registrations-plugin' ), 'pass' );
								do_action( 'ss_stop_spam_ok', $ip, $post ); // so plugins can undo spam report
								return false;
							} else {
								$msg = __( 'Incorrect. Try again.', 'stop-spammer-registrations-plugin' );
							}
						}
						break;
					case 'F':
						// future - more free CAPTCHAs
						break;
				}
			} // nonce check - not a valid nonce on form submit yet the value is there - what do we do?
		// sfs_debug_msg( 'leaving second time' );
		} else {
			// first time through
			$ke = $post['email'];
			$km = '';
			$kr = "";
			if ( array_key_exists( 'reason', $post ) )
				$kr = $post['reason'];
			$ka = sanitize_user( $post['author'] );
			$kp = base64_encode( serialize( $_POST ) );
			// sfs_debug_msg( 'first time getting post stuff' );
		}
		// sfs_debug_msg( 'creating form data' );
		// made it here - we display the screens
		$knonce = wp_create_nonce( 'ss_stopspam_block' );
		// this may be the second time through
		$formtop = '';
		if ( !empty( $msg ) ) {
			$msg = "\r\n<br><span style='color:red'> $msg </span><hr>\r\n";
		}
		$formtop .= '
			<form action="" method="post">
				<input type="hidden" name="kn" value="' . esc_attr( $knonce ) . '">
				<input type="hidden" name="ss_block" value="' . esc_attr( $chkcaptcha ) . '">
				<input type="hidden" name="kp" value="' . esc_attr( $kp ) . '">
				<input type="hidden" name="kr" value="' . esc_attr( $kr ) . '">
				<input type="hidden" name="ka" value="' . esc_attr( $ka ) . '">
		';
		$formbot = __( '
				<p><input style="background:#007cba;padding:10px 15px;border:none;border-radius:3px;color:white;cursor:pointer" type="submit" value="Submit Request"></p>
			</form>
		', 'stop-spammer-registrations-plugin' );
		$not	 = '';
		if ( $wlreq == 'Y' ) {
			// halfhearted attempt to hide which field is the email field
			$not = __( '
				<h1>Allow Request</h1>
				<p>You have been blocked from entering information on this site. In order to prevent this from happening in the future, complete the request below to have the admin add your IP to a list that allows you full access.</p>
				<p>Please enter your <strong>e</strong><strong>ma</strong><strong>il</strong> <strong>add</strong><strong>re</strong><strong>ss</strong> and a short note requesting access here.</p>
				Email Address (required)<!-- not the message -->: <input type="text" value="" name="ke" style="padding:5px" class="regular-text"><br>
				Message<!-- not email -->:<br><textarea name="km" placeholder="Explain what you were trying to do or if you were submitting a contact form, re-enter your message." rows="5" style="box-sizing:border-box;width:100%;padding:15px" class="large-text"></textarea>
			', 'stop-spammer-registrations-plugin' );
		}
		$captop = __( '<h1>Are you human?</h1>', 'stop-spammer-registrations-plugin' );
		$capbot = "";
		// now the CAPTCHAs
		$cap = '';
		switch ( $chkcaptcha ) {
			case 'G':
				// reCAPTCHA
				$recaptchaapisite = $options['recaptchaapisite'];
				$cap			  = "
					<script src='https://www.google.com/recaptcha/api.js' async defer></script>\r\n
					<input type='hidden' name='recaptcha' value='recaptcha'>
					<div class='g-recaptcha' data-sitekey='$recaptchaapisite'></div>
				";
				break;
			case 'H':
				// HCAPTCHA
				$hcaptchaapisite = $options['hcaptchaapisite'];
				$cap			  = "
					<script src='https://hcaptcha.com/1/api.js' async defer></script>\r\n
					<input type='hidden' name='h-captcha' value='h-captcha'>
					<div class='h-captcha' data-sitekey='$hcaptchaapisite'></div>
				";
				break;
			case 'S':
				$solvmediaapivchallenge = $options['solvmediaapivchallenge'];
				$cap					= "
					<script src='https://api-secure.solvemedia.com/papi/challenge.script?k=$solvmediaapivchallenge'></script>
					<noscript>
					<iframe src='https://api-secure.solvemedia.com/papi/challenge.noscript?k=$solvmediaapivchallenge' height='300' width='500' frameborder='0'></iframe><br>
					<textarea name='adcopy_challenge' rows='3' cols='40'></textarea>
					<input type='hidden' name='adcopy_response' value='manual_challenge'>
					</noscript><br>
				";
				break;
			case 'A':
			case 'Y':
				// arithmetic
				$n1 = rand( 1, 9 );
				$n2 = rand( 1, 9 );
				// try a much more interesting way that can't be generalized
				// use the "since" date from stats
				$seed   = 5;
				$spdate = $stats['spdate'];
				if ( !empty( $spdate ) ) {
					$seed = strtotime( $spdate );
				}
				$stupid = $n1 + $n2 - $seed;
				$cap	= __( '
					<p>Enter the SUM of these two numbers: <span style="size:4em;font-weight:bold">' . $n1 . ' + ' . $n2 . '</span><br>
					<input name="sum" value="" type="text">
					<input type="hidden" name="nums" value="' . $stupid . '"><br>
				', 'stop-spammer-registrations-plugin' );
				break;
			case 'F':
			// future
			default:
				$captop = '';
				$capbot = '';
				$cap	= '';
				break;
		}
		// have a display
		// need to send it to the display
		if ( empty( $msg ) ) {
			$msg = html_entity_decode($rejectmessage);
			$msg = str_replace('[ip]', $ip, $msg);
			$msg = str_replace('[reason]', $post['reason'], $msg);
		}
		$ansa = "
			$msg
			$formtop
			$not
			$captop
			$cap
			$capbot
			$formbot
		";
		wp_die( $ansa, "Stop Spammers", array( 'response' => 200 ) );
		exit();
	}

	public function ss_send_email( $options = array() ) {
		if ( !array_key_exists( 'notify', $options ) ) {
			return false;
		}
		$notify	   = $options['notify'];
		$wlreqmail = $options['wlreqmail'];
		if ( $notify == 'N' ) {
			return false;
		}
		if ( array_key_exists( 'ke', $_POST ) && !empty( $_POST['ke'] ) ) {
			// send wp_mail to sysop
			$now = date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
			$ke  = sanitize_email( $_POST['ke'] );
			if ( !is_email( $ke ) || empty( $ke ) ) {
				return false;
			}
			$km = sanitize_text_field( $_POST['km'] );
			if ( strlen( $km ) > 200 ) {
				$km = substr( $km, 0, 197 ) . '...';
			}
			$kr = really_clean( sanitize_text_field( $_POST['kr'] ) );
			$to = get_option( 'admin_email' );
			if ( !empty( $wlreqmail ) ) {
				$to = $wlreqmail;
			}
			$subject = __( 'Allow List Request from ', 'stop-spammer-registrations-plugin' ) . get_bloginfo( 'name' );
			$ip	     = ss_get_ip();
			$web 	 = __( 'Approve or Block Request: ', 'stop-spammer-registrations-plugin' ) . admin_url( 'admin.php?page=ss_allow_list' );
			$message = __( "
				A request has been received from someone who has been marked as a spammer by the Stop Spammers plugin.

				You are being notified because you have toggled on the option indicating that you wanted this email.

				The information from the request is:

				Time: $now
				User IP: $ip
				User Email: $ke
				Spam Reason: $kr
				User Message: $km

				$web

				Please be aware that the user has been recognized as a potential spammer.

				Some spam bots fill out the request form with a fake explanation.

				— Stop Spammers
			", 'stop-spammer-registrations-plugin' );
			$message = str_replace( "\t", '', $message );
			$headers = __( 'From: ', 'stop-spammer-registrations-plugin' ) . get_option( 'admin_email' ) . "\r\n";
			wp_mail( $to, $subject, $message, $headers );
			$rejectmessage = __( '<h2>Email sent. Thank you.</h2>', 'stop-spammer-registrations-plugin' );
			return true;
		}
	}

	public function ss_add_allow( $ip, $options = array(), $stats = array(), $post = array(), $post1 = array() ) {
		// add to the wlrequest option
		// time, ip, email, author, reasion, info, sname
		$sname = $this->getSname();
		$now   = date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
		$ke	   = "";
		if ( array_key_exists( 'ke', $_POST ) ) {
			$ke = sanitize_text_field( $_POST['ke'] ); // email
		}
		// sfs_debug_msg( "in add allow: '$ke'" );
		if ( empty( $ke ) ) {
			return false;
		}
		if ( !is_email( $ke ) ) {
			return false;
		}
		$km  = really_clean( sanitize_text_field( $_POST['km'] ) ); // user message
		if ( strlen( $km ) > 80 ) {
			$km = substr( $km, 0, 77 ) . '...';
		}
		$kr  = really_clean( sanitize_text_field( $_POST['kr'] ) ); // reason
		$ka  = really_clean( sanitize_user( $_POST['ka'] ) ); // author
		$req = array( $ip, $ke, $ka, $kr, $km, $sname );
		// add to the request list
		$wlrequests = $stats['wlrequests'];
		if ( empty( $wlrequests ) || !is_array( $wlrequests ) ) {
			$wlrequests = array();
		}
		$wlrequests[$now]  = $req;
		// save stats
		$stats['wlrequests'] = $wlrequests;
		// sfs_debug_msg( "added request: '$ke'" );
		ss_set_stats( $stats );
		return true;
	}
}

?>