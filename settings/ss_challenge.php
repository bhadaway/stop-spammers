<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // just in case
if ( ! current_user_can( 'manage_options' ) ) {
	die( 'Access Denied' );
}
ss_fix_post_vars();
$now     = date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
$options = ss_get_options();
extract( $options );
// $ip=ss_get_ip();
$nonce   = '';
$msg     = '';
if ( array_key_exists( 'ss_stop_spammers_control', $_POST ) ) {
	$nonce = $_POST['ss_stop_spammers_control'];
}
if ( wp_verify_nonce( $nonce, 'ss_stopspam_update' ) ) {
	if ( array_key_exists( 'action', $_POST ) ) {
		$optionlist = array( 'redir', 'notify', 'emailrequest', 'wlreq' );
		foreach ( $optionlist as $check ) {
			$v = 'N';
			if ( array_key_exists( $check, $_POST ) ) {
				$v = $_POST[ $check ];
				if ( $v != 'Y' ) {
					$v = 'N';
				}
			}
			$options[ $check ] = $v;
		}
// other options
		if ( array_key_exists( 'redirurl', $_POST ) ) {
			$redirurl            = trim( stripslashes( $_POST['redirurl'] ) );
			$options['redirurl'] = $redirurl;
		}
		if ( array_key_exists( 'wlreqmail', $_POST ) ) {
			$wlreqmail            = trim( stripslashes( $_POST['wlreqmail'] ) );
			$options['wlreqmail'] = $wlreqmail;
		}
		if ( array_key_exists( 'rejectmessage', $_POST ) ) {
			$rejectmessage            = trim( stripslashes( $_POST['rejectmessage'] ) );
			$options['rejectmessage'] = $rejectmessage;
		}
		if ( array_key_exists( 'chkcaptcha', $_POST ) ) {
			$chkcaptcha            = trim( stripslashes( $_POST['chkcaptcha'] ) );
			$options['chkcaptcha'] = $chkcaptcha;
		}
// added the API key stiff for Captchas
		if ( array_key_exists( 'recaptchaapisecret', $_POST ) ) {
			$recaptchaapisecret            = stripslashes( $_POST['recaptchaapisecret'] );
			$options['recaptchaapisecret'] = $recaptchaapisecret;
		}
		if ( array_key_exists( 'recaptchaapisite', $_POST ) ) {
			$recaptchaapisite            = stripslashes( $_POST['recaptchaapisite'] );
			$options['recaptchaapisite'] = $recaptchaapisite;
		}
		if ( array_key_exists( 'solvmediaapivchallenge', $_POST ) ) {
			$solvmediaapivchallenge            = stripslashes( $_POST['solvmediaapivchallenge'] );
			$options['solvmediaapivchallenge'] = $solvmediaapivchallenge;
		}
		if ( array_key_exists( 'solvmediaapiverify', $_POST ) ) {
			$solvmediaapiverify            = stripslashes( $_POST['solvmediaapiverify'] );
			$options['solvmediaapiverify'] = $solvmediaapiverify;
		}
// validate the chkcaptcha variable
		if ( $chkcaptcha == 'G'
		     && ( $recaptchaapisecret == ''
		          || $recaptchaapisite == '' )
		) {
			$chkcaptcha            = 'Y';
			$options['chkcaptcha'] = $chkcaptcha;
			$msg                   = "You cannot use Google reCAPTCHA unless you have entered an API key";
		}
		if ( $chkcaptcha == 'S'
		     && ( $solvmediaapivchallenge == ''
		          || $solvmediaapiverify == '' )
		) {
			$chkcaptcha            = 'Y';
			$options['chkcaptcha'] = $chkcaptcha;
			$msg                   = "You cannot use Solve Media CAPTCHA unless you have entered an API key";
		}
		ss_set_options( $options );
		extract( $options ); // extract again to get the new options
	}
	if ( ! is_plugin_active( 'stop-spammers-premium/stop-spammers-premium.php' ) ) {
		$update = '<div class="notice notice-success is-dismissible"><p>Options Updated! Add Cracking Defense with Brute Force Protection <strong><a href="https://stopspammers.io/downloads/stop-spammers-premium/" target="_blank">Try Premium</a></strong></p></div>';
	} else {
		$update = '<div class="notice notice-success is-dismissible"><p>Options Updated!</p></div>';
	}
}
$nonce = wp_create_nonce( 'ss_stopspam_update' );
?>
<div id="ss-plugin" class="wrap">
    <h1 class="ss_head">Stop Spammers — Challenge & Deny</h1>
	<?php if ( ! empty( $update ) ) {
		echo "$update";
	} ?>
	<?php if ( ! empty( $msg ) ) {
		echo "<span style=\"color:red;font-size:1.2em\">$msg</span>";
	} ?>
    <form method="post" action="">
        <input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>" />
        <input type="hidden" name="action" value="update challenge" />
	<br />
	<div class="mainsection">Access Denied Message
	<sup class="ss_sup"><a href="https://stopspammers.io/challenge-and-deny/#accessdenied" target="_blank"><i class="fa fa-question-circle fa-2x tooltip"></i></a></sup></div>
            <textarea id="rejectmessage" name="rejectmessage" cols="40" rows="5"><?php echo $rejectmessage; ?></textarea>
        <br />
	<div class="mainsection">Routing and Notifications
	<sup class="ss_sup"><a href="https://stopspammers.io/challenge-and-deny/#visitorexp" target="_blank"><i class="fa fa-question-circle fa-2x tooltip"></i></a></sup></div>
<div class="checkbox switcher">
      <label id="ss_subhead" for="redir">
            <input class"ss_toggle" type="checkbox" id="redir" name="redir" value="Y" onclick="ss_show_option()" <?php if ( $redir == 'Y' ) {
					echo "checked=\"checked\"";
} ?> /><span><small></small></span>
		  <small><span style="font-size:16px!important;">Send Visitor to Another Web Page</span></small></label></div>
			<br />
			<span id="ss_show_option" style="margin-left:30px;margin-bottom:15px;display:none;">Redirect URL:
        	<input size="77" name="redirurl" type="text" placeholder="e.g. https://stopspammers.io/privacy-policy/" value="<?php echo $redirurl; ?>" /></span>
<script>
function ss_show_option() {
  var checkBox = document.getElementById("redir");
  var text = document.getElementById("ss_show_option");
  if (checkBox.checked == true){
    text.style.display = "block";
  } else {
     text.style.display = "none";
  }
}
ss_show_option();
</script>
        <div class="checkbox switcher">
            <label id="ss_subhead" for="wlreq">
                <input class="ss_toggle" type="checkbox" id="wlreq"
                       name="wlreq"
                       value="Y" <?php if ( $wlreq == 'Y' ) {
					echo "checked=\"checked\"";
				} ?> /><span><small></small></span>
                <small>
                    <span style="font-size:16px!important">Blocked users see the Allow Request form</span></small></label></div>
        <br />
<div class="checkbox switcher">
      <label id="ss_subhead" for="notify">
            <input class"ss_toggle" type="checkbox" id="notify" name="notify" value="Y" onclick="ss_show_notify()" <?php if ( $notify == 'Y' ) {
					echo "checked=\"checked\"";
} ?> /><span><small></small></span>
		  <small><span style="font-size:16px!important;">Notify Web Admin when a user requests to be added to the Allow List</span></small></label></div>
            <br />
            <span id="ss_show_notify" style="margin-left:30px;margin-bottom:15px;display:none">(Optional) Specify where email requests are sent:
            <input id="myInput" size="48" name="wlreqmail" type="text" value="<?php echo $wlreqmail; ?>" /></span>
<script>
function ss_show_notify() {
  var checkBox = document.getElementById("notify");
  var text = document.getElementById("ss_show_notify");
  if (checkBox.checked == true){
    text.style.display = "block";
  } else {
     text.style.display = "none";
  }
}
ss_show_notify();
</script>
        <div class="checkbox switcher">
            <label id="ss_subhead" for="emailrequest">
                <input class="ss_toggle" type="checkbox" id="emailrequest"
                       name="emailrequest"
                       value="Y" <?php if ( $emailrequest == 'Y' ) {
					echo "checked=\"checked\"";
				} ?> /><span><small></small></span>
                <small>
                    <span style="font-size:16px!important">Notify Requester when a Web Admin has approved their request to be added to the Allow List </span><sup class="ss_sup">NEW!</sup></small></label></div>
		<br />
		<br />
	<div class="mainsection">CAPTCHA
	<sup class="ss_sup"><a href="https://stopspammers.io/challenge-and-deny/#captcha" target="_blank"><i class="fa fa-question-circle fa-2x tooltip"></i></a></sup></div>
        <div style="margin-left:30px;">
				<small><span style="font-size:16px!important;">Second Chance CAPTCHA Challenge</span></small>
			<?php
			if ( ! empty( $msg ) ) {
				echo "<span style=\"color:red;font-size:1.2em\">$msg</span>";
			}
			?>
            <p>
                <input type="radio" value="N"
                       name="chkcaptcha" <?php if ( $chkcaptcha == 'N' ) {
					echo "checked=\"checked\"";
				} ?> />
                No CAPTCHA (default)<br />
                <input type="radio" value="G"
                       name="chkcaptcha" <?php if ( $chkcaptcha == 'G' ) {
					echo "checked=\"checked\"";
				} ?> />
                Google reCAPTCHA<br />
                <input type="radio" value="S"
                       name="chkcaptcha" <?php if ( $chkcaptcha == 'S' ) {
					echo "checked=\"checked\"";
				} ?> />
                Solve Media CAPTCHA<br />
                <input type="radio" value="A"
                       name="chkcaptcha" <?php if ( $chkcaptcha == 'A' ) {
					echo "checked=\"checked\"";
				} ?> />
                Arithmetic Question</p>
            <p>To use either the Solve Media or Google reCAPTCHA, you will need an API key.</p></div>

        <br />
			<div style="margin-left:30px;"><small><span style="font-size:16px!important;">Google reCAPTCHA API Key</span></small> <br />
            Site Key:
            <input size="64" name="recaptchaapisite" type="text" value="<?php echo $recaptchaapisite; ?>" />
            <br />
            Secret Key:
            <input size="64" name="recaptchaapisecret" type="text" value="<?php echo $recaptchaapisecret; ?>" />
            <br />
			<?php
			if ( ! empty( $recaptchaapisite ) ) {
				?>
                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                <div class="g-recaptcha" data-sitekey="<?php echo $recaptchaapisite; ?>"></div>
                If the reCAPTCHA form looks good, you need to enable the reCAPTCHA on the Challenge &amp; Deny options page. (see left)
				<?php
			}
			?>
        <br />
			<small><span style="font-size:16px!important;">Solve Media CAPTCHA API Key</span></small> <br />
            Solve Media Challenge Key:
            <input size="64" name="solvmediaapivchallenge" type="text" value="<?php echo $solvmediaapivchallenge; ?>" />
            <br />
            Solve Media Verification Key:
            <input size="64" name="solvmediaapiverify" type="text" value="<?php echo $solvmediaapiverify; ?>" />
            <br />
			<?php
			if ( ! empty( $solvmediaapivchallenge ) ) {
				?>
                <script src="https://api-secure.solvemedia.com/papi/challenge.script?k=<?php echo $solvmediaapivchallenge; ?>"></script>
                <p>If the CAPTCHA form looks good, you need to enable the
                    CAPTCHA on the Challenge &amp; Deny options
                    page. (see left)</p>
				<?php
			}
			?>
			</div>
        <br />
        <br />
        <p class="submit"><input class="button-primary" value="Save Changes" type="submit" /></p>
    </form>
</div>
