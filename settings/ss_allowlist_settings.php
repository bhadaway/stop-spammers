<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // just in case

if ( ! current_user_can( 'manage_options' ) ) {
	die( 'Access Denied' );
}

ss_fix_post_vars();
$stats   = ss_get_stats();
extract( $stats );
$now     = date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
$options = ss_get_options();
extract( $options );
$stats   = ss_get_stats();
extract( $stats );
$trash   = SS_PLUGIN_URL . 'images/trash.png';
$tdown   = SS_PLUGIN_URL . 'images/tdown.png';
$tup     = SS_PLUGIN_URL . 'images/tup.png'; // fix this
$whois   = SS_PLUGIN_URL . 'images/whois.png'; // fix this
$nonce   = "";
$ajaxurl = admin_url( 'admin-ajax.php' );

// update options
if ( array_key_exists( 'ss_stop_spammers_control', $_POST ) ) {
	$nonce = $_POST['ss_stop_spammers_control'];
}

if ( ! empty( $nonce ) && wp_verify_nonce( $nonce, 'ss_stopspam_update' ) ) {
	if ( array_key_exists( 'ss_stop_clear_wlreq', $_POST ) ) {
		$wlrequests          = array();
		$stats['wlrequests'] = $wlrequests;
		ss_set_stats( $stats );
	}

	$msg = '';
}

$nonce = wp_create_nonce( 'ss_stopspam_update' );
?>
<div id="ss-plugin" class="wrap">
    <h1 class="ss_head">Stop Spammers — Allow Requests</h1>
	<?php
	if ( ! empty( $msg ) ) {
		echo "$msg";
	} ?>
    <p>When users are blocked they can fill out a form asking to be added to the
        allow list. Any users that have filled out the form will appear below.
        Some spam robots fill in any form that they find so their may be some
        garbage here.</p>
	<?php
	if ( count( $wlrequests ) == 0 ) {
		echo "<p><strong>There are currently no pending requests.</strong></p></div>";
	} else {
		?>
        <h2>Allow List Requests</h2>
        <form method="post" action="">
            <input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>" />
            <input type="hidden" name="ss_stop_clear_wlreq" value="true" />
            <p class="submit"><input class="button-primary" value="Clear the Requests" type="submit" /></p>
        </form>
		<?php
		?>
        <table name="mytable" id="myTable" style="width:100%;background-color:#eee" cellspacing="2">
            <thead>
            <tr style="background-color:#675682;color:white;text-align:center;text-transform:uppercase;font-weight:600">
                <th>Time</th>
                <th>IP</th>
                <th>Email</th>
                <th>Reason</th>
                <th>URL</th>
            </tr>
            </thead>
            <tbody id="wlreq">
			<?php
			$show = '';
			$cont = 'wlreqs';
			// wlrequs has an array of arrays
			// time,ip,email,author,reason,info,sname
			// time,ip,email,author,reason,info,sname
			// use the be_load to get badips
			$options = ss_get_options();
			$stats   = ss_get_stats();
			$show    = be_load( 'ss_get_alreq', 'x', $stats, $options );
			echo $show;
			?>
            </tbody>
        </table>
		<?php
	}

ss_fix_post_vars();
$now           = date( 'Y/m/d H:i:s', time() + ( get_option( 'gmt_offset' ) * 3600 ) );
$options       = ss_get_options();
extract( $options );
$chkcloudflare = 'Y'; // force back to on - always fix Cloudflare if the plugin is not present and Cloudflare detected
$nonce         = '';

if ( array_key_exists( 'ss_stop_spammers_control', $_POST ) ) {
	$nonce = $_POST['ss_stop_spammers_control'];
}

if ( ! empty( $nonce ) && wp_verify_nonce( $nonce, 'ss_stopspam_update' ) ) {
	if ( array_key_exists( 'wlist', $_POST ) ) {
		$wlist  = $_POST['wlist'];
		$wlist  = explode( "\n", $wlist );
		$tblist = array();
		foreach ( $wlist as $bl ) {
			$bl = trim( $bl );
			if ( ! empty( $bl ) ) {
				$tblist[] = $bl;
			}
		}
		$options['wlist'] = $tblist;
		$wlist            = $tblist;
	}
	$optionlist = array(
		'chkgoogle',
		'chkaws',
		'chkwluserid',
		'chkpaypal',
		'chkstripe',
		'chkauthorizenet',
		'chkbraintree',
		'chkrecurly',
		'chkgenallowlist',
		'chkmiscallowlist',
		'chkyahoomerchant'
	);
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
	ss_set_options( $options );
	extract( $options ); // extract again to get the new options
	$msg = '<div class="notice notice-success is-dismissible"><p>Options Updated</p></div>';
}
$nonce = wp_create_nonce( 'ss_stopspam_update' );
?>
<div id="ss-plugin" class="wrap">
    <h1 class="ss_head">Stop Spammers — Allow Lists</h1>
	<?php if ( ! empty( $msg ) ) {
		echo "$msg";
	} ?>
    <form method="post" action="">
		<input type="hidden" name="action" value="update"/>
        <input type="hidden" name="ss_stop_spammers_control" value="<?php echo $nonce; ?>" />
				<h2>Personalized Allow List</h2>
            
            <p>Put IP addresses or emails here that you don't want blocked.
                One email or IP to a line. You can use wild cards here for
                emails. These are checked first so they override any blocking.</p>

<div class="checkbox switcher">
      <label id="ss_subhead" for="chkwluserid">
            <input class"ss_toggle" type="checkbox" id="chkwluserid" name="chkwluserid" value="Y" <?php if ( $chkwluserid == 'Y' ) {
					echo "checked=\"checked\"";
} ?> /><span><small></small></span>
		  <small><span style="font-size:16px!important;">Enable Allow by User ID (not recommended)</span></small></label> <i class="fa fa-question-circle fa-2x tooltip"><span class="tooltiptext">
            If enabled, you may put user IDs here, but this isn't recommended because spammers
                can easily find a user's ID from
                previous comments, and add comments using it.
                </span></i></div>
             <br />
            <textarea name="wlist" cols="40" rows="8" class="ipbox"><?php
				for ( $k = 0; $k < count( $wlist ); $k ++ ) {
					echo $wlist[ $k ] . "\r\n";
				}
				?></textarea>

        <br/>
        <h2>Allow Options</h2>
        <p>These options will be checked first and will allow some users to
            continue without being checked further.
            You can prevent Google, PayPal, and other services from ever being
            blocked.</p>

 <br />
		<div class="checkbox switcher">
      <label id="ss_subhead" for="chkgoogle">
            <input class"ss_toggle" type="checkbox" id="chkgoogle" name="chkgoogle" value="Y" <?php if ( $chkgoogle == 'Y' ) {
					echo "checked=\"checked\"";
} ?> /><span><small></small></span>
		  <small><span style="font-size:16px!important;">Google (Keep enabled under most circumstances)</span></small></label> <i class="fa fa-question-circle fa-2x tooltip"><span class="tooltiptext">
                Google is very important to most
                websites. In most cases, you won't want Google blocked</span></i></div>

        <br />

<div class="checkbox switcher">
      <label id="ss_subhead" for="chkgenallowlist">
            <input class"ss_toggle" type="checkbox" id="chkgenallowlist" name="chkgenallowlist" value="Y" <?php if ( $chkgenallowlist == 'Y' ) {
					echo "checked=\"checked\"";
} ?> /><span><small></small></span>
		  <small><span style="font-size:16px!important;">Generated Allow List</span></small></label> <i class="fa fa-question-circle fa-2x tooltip"><span class="tooltiptext">
                An Allow List of well-behaved and responsible IP blocks in North
                America, Western Europe, and
                Australia.
                These are a major source of spam, but also a major source of
                paying customers.
                Checking this will let in some spam, but will not block
                residential ISP customers from
                industrialized countries.</span></i></div>

        <br />


<div class="checkbox switcher">
      <label id="ss_subhead" for="chkmiscallowlist">
            <input class"ss_toggle" type="checkbox" id="chkmiscallowlist" name="chkmiscallowlist" value="Y" <?php if ( $chkmiscallowlist == 'Y' ) {
					echo "checked=\"checked\"";
} ?> /><span><small></small></span>
		  <small><span style="font-size:16px!important;">Other Allow Lists</span></small></label> <i class="fa fa-question-circle fa-2x tooltip"><span class="tooltiptext">
                A list of small web service providers that can be accidentally
                blocked as bad actors.
                Currently on the list: VaultPress.
                Request other services be added to this whitelist
                <a href="https://github.com/bhadaway/stop-spammers/issues"
                   target="_blank">on GitHub</a>.</span></i></div>

        <br />


<div class="checkbox switcher">
      <label id="ss_subhead" for="chkpaypal">
            <input class"ss_toggle" type="checkbox" id="chkpaypal" name="chkpaypal" value="Y" <?php if ( $chkpaypal == 'Y' ) {
					echo "checked=\"checked\"";
} ?> /><span><small></small></span>
		  <small><span style="font-size:16px!important;">Allow PayPal</span></small></label> <i class="fa fa-question-circle fa-2x tooltip"><span class="tooltiptext">
                If you accept payment through PayPal, enable this setting.</span></i></div>

        <br />

<div class="checkbox switcher">
      <label id="ss_subhead" for="chkstripe">
            <input class"ss_toggle" type="checkbox" id="chkstripe" name="chkstripe" value="Y" <?php if ( $chkstripe == 'Y' ) {
					echo "checked=\"checked\"";
} ?> /><span><small></small></span>
		  <small><span style="font-size:16px!important;">Allow Stripe <sup class="ss_sup">NEW!</sup></span></small></label> <i class="fa fa-question-circle fa-2x tooltip"><span class="tooltiptext">
                If you accept payment through Stripe, enable this setting.</span></i></div>

        <br />
		
<div class="checkbox switcher">
      <label id="ss_subhead" for="chkauthorizenet">
            <input class"ss_toggle" type="checkbox" id="chkauthorizenet" name="chkauthorizenet" value="Y" <?php if ( $chkauthorizenet == 'Y' ) {
					echo "checked=\"checked\"";
} ?> /><span><small></small></span>
		  <small><span style="font-size:16px!important;">Allow Authorize.Net <sup class="ss_sup">NEW!</sup></span></small></label> <i class="fa fa-question-circle fa-2x tooltip"><span class="tooltiptext">
                If you accept payment through Authorize.Net, enable this setting.</span></i></div>

        <br />

<div class="checkbox switcher">
      <label id="ss_subhead" for="chkbraintree">
            <input class"ss_toggle" type="checkbox" id="chkbraintree" name="chkbraintree" value="Y" <?php if ( $chkbraintree == 'Y' ) {
					echo "checked=\"checked\"";
} ?> /><span><small></small></span>
		  <small><span style="font-size:16px!important;">Allow Braintree <sup class="ss_sup">NEW!</sup></span></small></label> <i class="fa fa-question-circle fa-2x tooltip"><span class="tooltiptext">
                If you accept payment through Braintree, enable this setting.</span></i></div>
 
        <br />
		
<div class="checkbox switcher">
      <label id="ss_subhead" for="chkrecurly">
            <input class"ss_toggle" type="checkbox" id="chkrecurly" name="chkrecurly" value="Y" <?php if ( $chkrecurly == 'Y' ) {
					echo "checked=\"checked\"";
} ?> /><span><small></small></span>
		  <small><span style="font-size:16px!important;">Allow Recurly <sup class="ss_sup">NEW!</sup></span></small></label> <i class="fa fa-question-circle fa-2x tooltip"><span class="tooltiptext">
                If you accept payment through Recurly, enable this setting.</span></i></div>
 
        <br />

<div class="checkbox switcher">
      <label id="ss_subhead" for="chkyahoomerchant">
            <input class"ss_toggle" type="checkbox" id="chkyahoomerchant" name="chkyahoomerchant" value="Y" <?php if ( $chkyahoomerchant == 'Y' ) {
					echo "checked=\"checked\"";
} ?> /><span><small></small></span>
		  <small><span style="font-size:16px!important;">Allow Yahoo Merchant Services</span></small></label> <i class="fa fa-question-circle fa-2x tooltip"><span class="tooltiptext">
                If you use Yahoo Merchant Services, enable this setting.</span></i></div>

        <br />
 
<div class="checkbox switcher">
      <label id="ss_subhead" for="chkaws">
            <input class"ss_toggle" type="checkbox" id="chkaws" name="chkaws" value="Y" <?php if ( $chkaws == 'Y' ) {
					echo "checked=\"checked\"";
} ?> /><span><small></small></span>
		  <small><span style="font-size:16px!important;">Allow Amazon Cloud</span></small></label> <i class="fa fa-question-circle fa-2x tooltip"><span class="tooltiptext">
                The Amazon Cloud is the source of occasional spam, but they shut
                it down right away. Lots of startup web
                services use
                Amazon Cloud Servers to host their services. If you use a
                service to check your site, share on Facebook,
                or cross post from Twitter,
                it may be using Amazon's cloud services. Enable this if you want
                to always allow Amazon AWS.</span></i></div>

        <br />
        <p class="submit"><input class="button-primary" value="Save Changes" type="submit" /></p>
    </form>
</div>