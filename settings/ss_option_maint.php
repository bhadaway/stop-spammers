<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

if ( !current_user_can( 'manage_options' ) ) {
	die ( 'Access Blocked' );
}

ss_fix_post_vars();

$active_tab = !empty( $_GET['tab'] ) ? $_GET['tab'] : 'disable_users';

?>

<div id="ss-plugin" class="wrap">
	<h1 class="ss_head">Stop Spammers — Cleanup</h1>
	<?php if ( array_key_exists( 'autol', $_POST ) || array_key_exists( 'delo', $_POST ) ) {
		echo '<div class="notice notice-success is-dismissible"><p>' . __( 'Options Updated', 'stop-spammer-registrations-plugin' ) . '</p></div>';
	}
	?>
	<div class="ss_info_box">
		<h2 class="nav-tab-wrapper">
        	<a href="<?php echo esc_url( admin_url( 'admin.php?page=ss_option_maint&tab=disable_users' ) ); ?>" class="nav-tab <?php echo 'disable_users' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__( 'Disable Users', 'stop-spammer-registrations-plugin' ); ?></a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=ss_option_maint&tab=delete_comments' ) ); ?>" class="nav-tab <?php echo 'delete_comments' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__( 'Delete Comments', 'stop-spammer-registrations-plugin' ); ?></a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=ss_option_maint&tab=db-cleaup' ) ); ?>" class="nav-tab <?php echo 'db-cleaup' === $active_tab ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__( 'Database Cleanup', 'stop-spammer-registrations-plugin' ); ?></a>
		</h2>
		<br>
		<?php
		global $wpdb;
		$ptab  = $wpdb->options;
		$nonce = '';
		if ( array_key_exists( 'ss_opt_control', $_POST ) ) {
			$nonce = $_POST['ss_opt_control'];
		}
		if ( !empty( $nonce ) && wp_verify_nonce( $nonce, 'ss_update' ) ) {
			if ( array_key_exists( 'view', $_POST ) ) {
				$op = sanitize_text_field( $_POST['view'] );
				$v  = get_option( $op );
				if ( is_serialized( $v ) && @unserialize( $v ) !== false ) {
					$v = @unserialize( $v );
				}
				$v = print_r( $v, true );
				$v = htmlentities( $v );
				_e( '<h2>contents of ' . $op . '</h2><pre>' . $v . '</pre>', 'stop-spammer-registrations-plugin' );
			}
			if ( array_key_exists( 'autol', $_POST ) ) {
				foreach ( $_POST['autol'] as $name ) {
					$au = substr( $name, 0, strpos( $name, '_' ) );
					if ( strtolower( $au ) == 'no' ) {
						$au = 'yes';
					} else {
						$au = 'no';
					}
					$name = substr( $name, strpos( $name, '_' ) + 1 );
					_e( 'changing ' . $name . ' autoload to $au<br>', 'stop-spammer-registrations-plugin' );
					$sql  = "update $ptab set autoload='$au' where option_name='$name'";
					$wpdb->query( $sql );
				}
			}
			if ( array_key_exists( 'delo', $_POST ) ) {
				foreach ( $_POST['delo'] as $name ) {
					$name = sanitize_key( $name );
					_e( 'deleting ' . $name . ' <br>', 'stop-spammer-registrations-plugin' );
					$sql = "delete from $ptab where option_name='$name'";
					$wpdb->query( $sql );
				}
			}
		}
    	$magic_string = __( "I am sure I want to delete all pending comments and realize this can't be undone", 'stop-spammer-registrations-plugin' );	
		if ( isset( $_POST['ss_delete_pending_comment'] ) and stripslashes ( $_POST['ss_delete_pending_comment_confirmation_text'] ) == $magic_string ) {
			if ( !current_user_can( 'manage_options' ) ) {
				return;
			}
			$wpdb->query( "DELETE FROM $wpdb->comments WHERE comment_approved = 0" );
			_e( 'Comments','stop-spammer-registrations-plugin' );
		}
		$sysops = array(
			'_transient_',
			'active_plugins',
			'admin_email',
			'advanced_edit',
			'avatar_default',
			'avatar_rating',
			'blocklist_keys',
			'blog_charset',
			'blog_public',
			'blogdescription',
			'blogname',
			'can_compress_scripts',
			'category_base',
			'close_comments_days_old',
			'close_comments_for_old_posts',
			'comment_max_links',
			'comment_moderation',
			'comment_order',
			'comment_registration',
			'comment_allowlist',
			'comments_notify',
			'comments_per_page',
			'cron',
			'current_theme',
			'dashboard_widget_options',
			'date_format',
			'db_version',
			'default_category',
			'default_comment_status',
			'default_comments_page',
			'default_email_category',
			'default_link_category',
			'default_ping_status',
			'default_pingback_flag',
			'default_post_edit_rows',
			'default_post_format',
			'default_role',
			'embed_autourls',
			'embed_size_h',
			'embed_size_w',
			'enable_app',
			'enable_xmlrpc',
			'fileupload_url',
			'ftp_credentials',
			'gmt_offset',
			'gzipcompression',
			'hack_file',
			'home',
			'ht_user_roles',
			'html_type',
			'image_default_align',
			'image_default_link_type',
			'image_default_size',
			'initial_db_version',
			'large_size_h',
			'large_size_w',
			'links_recently_updated_append',
			'links_recently_updated_prepend',
			'links_recently_updated_time',
			'links_updated_date_format',
			'mailserver_login',
			'mailserver_pass',
			'mailserver_port',
			'mailserver_url',
			'medium_size_h',
			'medium_size_w',
			'moderation_keys',
			'moderation_notify',
			'page_comments',
			'page_for_posts',
			'page_on_front',
			'permalink_structure',
			'ping_sites',
			'posts_per_page',
			'posts_per_rss',
			'recently_edited',
			'require_name_email',
			'rss_use_excerpt',
			'show_avatars',
			'show_on_front',
			'sidebars_widgets',
			'siteurl',
			'start_of_week',
			'sticky_posts',
			'stylesheet',
			'tag_base',
			'template',
			'theme_mods_harptab',
			'theme_mods_twentyeleven',
			'theme_switched',
			'thread_comments',
			'thread_comments_depth',
			'thumbnail_crop',
			'thumbnail_size_h',
			'thumbnail_size_w',
			'time_format',
			'timezone_string',
			'uninstall_plugins',
			'upload_path',
			'upload_url_path',
			'uploads_use_yearmonth_folders',
			'use_balanceTags',
			'use_smilies',
			'use_trackback',
			'users_can_register',
			'widget_archives',
			'widget_categories',
			'widget_meta',
			'widget_recent-comments',
			'widget_recent-posts',
			'widget_rss',
			'widget_search',
			'widget_text',
			// some that I added because changing caused problems
			'akismet_available_servers',
			'auth_key',
			'auth_salt',
			'akismet_connectivity_time',
			'akismet_discard_month',
			'akismet_spam_count',
			'akismet_show_user_comments_approved',
			'akismet_strictness',
			'category_children',
			'db_upgraded',
			'recently_activated',
			'rewrite_rules',
			'wordpress_api_key',
			'theme_mods_',
			'widget_',
			'_user_roles',
			'logged_in_key',
			'logged_in_salt',
			'nonce_key',
			'nonce_salt',
			'nav_menu_options',
			'auto_core_update_notified',
			'link_manager_enabled',
			'WPLANG',
			// added by jetsam -------------------------------------------
			'ss_stop_sp_reg_options', // not for all
			'ss_stop_sp_reg_stats', // not for all
			// wp opts
			'blacklist_keys',
			'comment_whitelist',
			'customize_stashed_theme_mods',
			'finished_splitting_shared_terms',
			'fresh_site',
			'recovery_keys',
			'recovery_mode_email_last_sent',
			'show_comments_cookies_opt_in',
			'site_icon',
			'theme_switch_menu_locations',
			'wp_page_for_privacy_policy',
			// ----------------------------------------------------------
		);
		global $wpdb;
		// global $wp_query;
		$ptab  = $wpdb->options;
		// option_id, option_name, option_value, autoload
		$sql   = "SELECT * from $ptab order by autoload,option_name";
		$arows = $wpdb->get_results( $sql, ARRAY_A );
		// filter out the ones we don't like
		// echo "<br> $sql : size of options array " . $ptab . " = " . count( $arows ) . "<br>";
		$rows  = array();
		foreach ( $arows as $row ) {
			$uop  = true;
			$name = $row['option_name'];
			if ( !in_array( $name, $sysops ) ) {
				// check for name like for transients
				// _transient_ , _site_transient_
				foreach ( $sysops as $op ) {
					if ( strpos( $name, $op ) !== false ) {
						// hit a name like
						$uop = false;
						break;
					}
				}
			} else {
				$uop = false;
			}
			if ( $uop ) {
				$rows[] = $row;
			}
		}
		// $rows has the allowed options - all default and system options have been excluded
		$nonce = wp_create_nonce( 'ss_update' );
		?>
		<form method="post" name="DOIT2" action="">
			<!-- <input type="hidden" name="ss_opt_control" value="<?php echo $nonce; ?>"> -->
			<?php if ( !isset( $_GET['tab'] ) or $_GET['tab'] == 'disable_users' ): ?>
				<?php include_once 'ss_user_filter_list.php' ?>
			<?php endif; ?>
			<?php
			$pending_comment_ids    = $wpdb->get_col( "SELECT comment_ID FROM $wpdb->comments WHERE comment_approved = 0" );
			$pending_comments_count = count( $pending_comment_ids );
			if ( isset ( $_GET['tab'] ) and  $_GET['tab'] == 'delete_comments' ) {
				if ( $pending_comments_count > 0 ) {
					?>
					<p>
						<?php
						printf(
							_n(
								'You have %s pending comment in your site. Do you want to delete it?',
								'You have %s pending comments in your site. Do you want to delete all of them?',
								$pending_comments_count,
								'stop-spammer-registrations-plugin'
							),
							number_format_i18n( $pending_comments_count )
						);
						?>
					</p>
					<p>
						<?php _e( 'You have to type the following text into the textbox to delete all the pending comments:', 'stop-spammer-registrations-plugin' ); ?>
					</p>
					<blockquote>
						<em>
							<?php echo $magic_string ?>
						</em>
					</blockquote>
					<textarea name="ss_delete_pending_comment_confirmation_text"></textarea>
					<button name="ss_delete_pending_comment" class="button-primary"><?php _e( 'Delete', 'stop-spammer-registrations-plugin' ); ?></button>
					<?php
				} else {
					?>
					<p>
						<?php _e( 'There are no pending or spam comments in your site.', 'stop-spammer-registrations-plugin' ); ?>
					</p>
					<?php
				}
			}
			?>
			<?php if ( isset ( $_GET['tab'] ) and $_GET['tab'] == 'db-cleaup' ): ?>
			<p><?php _e( 'Inspect and delete orphan or suspicious options or change plugin options so that they don&acute;t autoload. Be aware that you can break some plugins by deleting their options. Before making updates, please <a href="https://github.com/bhadaway/stop-spammers/wiki/Docs:-Database-Cleanup" target="_blank">review our documentation</a>.', 'stop-spammer-registrations-plugin' ); ?></p>
			<table id="sstable" name="sstable" cellspacing="2">
				<thead>
					<tr bgcolor="#fff">
						<th class="ss_cleanup"><?php _e( 'Option', 'stop-spammer-registrations-plugin' ); ?></th>
						<th class="ss_cleanup"><?php _e( 'Autoload', 'stop-spammer-registrations-plugin' ); ?></th>
						<th class="ss_cleanup"><?php _e( 'Size', 'stop-spammer-registrations-plugin' ); ?></th>
						<th class="ss_cleanup"><?php _e( 'Change Autoload', 'stop-spammer-registrations-plugin' ); ?></th>
						<th class="ss_cleanup"><?php _e( 'Delete', 'stop-spammer-registrations-plugin' ); ?></th>
						<th class="ss_cleanup"><?php _e( 'View Contents', 'stop-spammer-registrations-plugin' ); ?></th>
					</tr>
				</thead>
				<?php
				foreach ( $rows as $row ) {
					extract( $row );
					$sz = strlen( $option_value );
					$au = $autoload;
					$sz = number_format( $sz );
					// if ( $autoload=='no' ) $au='No';
					?>
					<tr class="ss_cleanup_tr" bgcolor="#fff">
						<td align="center"><?php echo $option_name; ?></td>
						<td align="center"><?php echo $autoload; ?></td>
						<td align="center"><?php echo $sz; ?></td>
						<td align="center"><input type="checkbox" value="<?php echo $autoload . '_' . $option_name; ?>" name="autol[]">&nbsp;<?php echo $autoload; ?></td>
						<td align="center"><input type="checkbox" value="<?php echo $option_name; ?>" name="delo[]"></td>
						<td align="center"><button type="submit" name="view" value="<?php echo $option_name; ?>"><?php _e( 'view', 'stop-spammer-registrations-plugin' ); ?></button></td>
					</tr>
					<?php
				}
				?>
			</table>
			<p class="submit"><input class="button-primary" value="<?php _e( 'Update', 'stop-spammer-registrations-plugin' ); ?>" type="submit" onclick="return confirm('Are you sure? These changes are permenant.');"></p>
			<?php endif;?>
		</form>
		<?php
		$m1 = memory_get_usage();
		$m3 = memory_get_peak_usage();
		$m1 = number_format( $m1 );
		$m3 = number_format( $m3 );
		_e( '<p>Memory Usage Currently: ' . $m1 . ' Peak: ' . $m3 . '</p>', 'stop-spammer-registrations-plugin' );
		$nonce		    = wp_create_nonce( 'ss_update2' );
		$showtransients = false; // change to true to clean up transients
		if ( $showtransients && countTransients() > 0 ) { // personal use - probably too dangerous for casual users ?>
			<hr>
			<p><?php _e( 'WordPress creates temporary objects in the database called transients.<br>WordPress is not good about cleaning them up afterwards. You can clean these up safely and it might speed things up.', 'stop-spammer-registrations-plugin' ); ?></p>
			<form method="post" name="DOIT2" action="">
				<input type="hidden" name="ss_opt_tdel" value="<?php echo $nonce; ?>">
				<p class="submit"><input class="button-primary" value="<?php _e( 'Delete Transients', 'stop-spammer-registrations-plugin' ); ?>" type="submit"></p>
			</form>
			<?php
			$nonce = '';
			if ( array_key_exists( 'ss_opt_tdel', $_POST ) ) {
				$nonce = $_POST['ss_opt_tdel'];
			}
			if ( !empty( $nonce ) && wp_verify_nonce( $nonce, 'ss_update2' ) ) {
				// doit!
				deleteTransients();
			}
			?>
			<p><?php _e( 'Currently there are ' . countTransients() . ' found.', 'stop-spammer-registrations-plugin' ); ?></p>
		<?php
		}
		?>
	</div>
</div>

<?php

function countTransients() {
	$blog_id = get_current_blog_id();
	global $wpdb;
	$optimeout = time() - 60;
	$table	   = $wpdb->get_blog_prefix( $blog_id ) . 'options';
	$count	   = 0;
	$sql	   = "
		select count(*) from $table 
		where
		option_name like '\_transient\_timeout\_%'
		or option_name like '\_site\_transient\_timeout\_%'
		or option_name like 'displayed\_galleries\_%'
		or option_name like 'displayed\_gallery\_rendering\_%'
		or t1.option_name like '\_transient\_feed\_mod_%' 
		or t1.option_name like '\_transient\__bbp\_%' 
		and option_value < '$optimeout'
	";
	$sql = str_replace( "\t", '', $sql );
	$sql = "
		select count(*) from $table 
		where instr(t1.option_name,'SS_SECRET_WORD')>0
	";
	$sql = str_replace( "\t", '', $sql );
	$count	  += $wpdb->get_var( $sql );
	if ( empty( $count ) ) {
		$count = "0";
	}
	return $count;
}

// clear expired transients for current blog
function deleteTransients() {
	$blog_id = get_current_blog_id();
	global $wpdb;
	$optimeout = time() - 60;
	$table	   = $wpdb->get_blog_prefix( $blog_id ) . 'options';
	$sql	   = "
		delete from $table
		where 
		option_name like '\_transient\_timeout\_%'
		or option_name like '\_site\_transient\_timeout\_%'
		or option_name like 'displayed\_galleries\_%'
		or option_name like 'displayed\_gallery\_rendering\_%'
		or t1.option_name like '\_transient\_feed\_mod_%' 
		or t1.option_name like '\_transient\__bbp\_%' 
		or instr(t1.option_name,'SS_SECRET_WORD')>0
		and option_value < '$optimeout'
	";
	$sql = str_replace( "\t", '', $sql );
	$wpdb->query( $sql );
	$sql = "
		select count(*) from $table 
		where instr(t1.option_name,'SS_SECRET_WORD')>0
	";
	$sql = str_replace( "\t", '', $sql );
	$wpdb->query( $sql );
}

?>