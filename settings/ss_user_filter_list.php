<input type="hidden" name="op" value="search_users">

<table>
	<tr>
		<td colspan="2">
			<h3>
				<div class="section-title">
					<?php _e( 'Flags' ) ?>
				</div>
			</h3>
			<hr width="50%" align="left">
			<br>
			<?php echo _( 'Show in list if... ' ) ?>
			<select name="flagsCND">
				<option value="intersept" <?php echo !empty( $_POST[ 'flagsCND'] ) &&$_POST[ 'flagsCND'] == 'intersept' ? 'selected' : '' ?>>
					<?php _e( 'ALL are true' ) ?>
				</option>
				<option value="add" <?php echo !empty( $_POST[ 'flagsCND'] ) && $_POST['flagsCND'] == 'add' ? 'selected' : '' ?>>
					<?php _e( 'ANY are true' ) ?>
				</option>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php echo _( 'User has...' ) ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php _e( 'Approved Comments' ) ?>
		</td>
		<td align="left" width="250">
			<label for="flag_approve_no">
				<?php _e( 'No' ) ?>
				<input id="flag_approve_no" type="radio" name="f_approve" value="no" <?php if ( isset( $_POST[ 'f_approve'] ) and $_POST[ 'f_approve'] === 'no' ) { echo 'checked'; } ?>>
			</label>
			<label for="flag_approve_yes">
				<?php _e( 'Yes' ) ?>
				<input id="flag_approve_yes" type="radio" name="f_approve" value="yes" <?php if ( isset( $_POST[ 'f_approve'] ) and $_POST[ 'f_approve'] === 'yes' ) { echo 'checked'; } ?>>
			</label>
			<label for="flag_approve_nomatter">
				<?php _e( 'Ignore' ) ?>
				<input id="flag_approve_nomatter" type="radio" name="f_approve" value="0" <?php echo empty( $_POST[ 'f_approve'] ) ? 'checked' : '' ?>>
			</label>
		</td>
	</tr>
	<tr>
	<?php // if ( !isset( $_POST[ 'has_spam'] ) ) $_POST[ 'has_spam'] = 'yes'; ?>
		<td>
			<?php _e( 'Spam Comments' ) ?>
		</td>
		<td align="left">
			<label for="flag_has_spam_no">
				<?php _e( 'No' ) ?>
				<input id="flag_has_spam_no" type="radio" name="has_spam" value="no" <?php if ( isset( $_POST[ 'has_spam'] ) and $_POST[ 'has_spam']==='no' ) { echo 'checked'; } ?>>
			</label>
			<label for="flag_has_spam_yes">
				<?php _e( 'Yes' ) ?>
				<input id="flag_has_spam_yes" type="radio" name="has_spam" value="yes" <?php if ( isset( $_POST[ 'has_spam'] ) and $_POST[ 'has_spam'] === 'yes' ) { echo 'checked'; } ?>>
			</label>
			<label for="flag_has_spam_nomatter">
				<?php _e( 'Ignore' ) ?>
				<input id="flag_has_spam_nomatter" type="radio" name="has_spam" value="0" <?php echo empty( $_POST[ 'has_spam'] ) ? 'checked' : '' ?>>
			</label>
		</td>
	</tr>
	<tr>
		<td>
			<?php _e( 'Same First/Last Name' ) ?>
		</td>
		<td align="left" width="250">
			<label for="ss_check_name_no">
				<?php _e( 'No' ) ?>
				<input id="ss_domain_no" type="radio" name="ss_check_name" value="no" <?php echo empty( $_POST[ 'ss_check_name'] ) ? 'checked' : '' ?> <?php if ( isset( $_POST[ 'ss_check_name'] ) and $_POST[ 'ss_domain'] === 'no' ) { echo 'checked';} ?>>
			</label>
			<label for="ss_check_name_yes">
				<?php _e( 'Yes' ) ?>
				<input id="ss_check_name_yes" type="radio" name="ss_check_name" value="yes" <?php if ( isset( $_POST[ 'ss_check_name'] ) and $_POST[ 'ss_check_name'] === 'yes' ) { echo 'checked';} ?>>
			</label>
		</td>
	</tr>
	<tr>
		<td>
			<?php _e( 'Specific TLD (e.g. .xxx, .blog)' ) ?>
		</td>
		<td align="left" width="250">
			<label for="ss_domain_no">
				<?php _e( 'No' ) ?>
				<input id="ss_domain_no" type="radio" name="ss_domain" value="no" <?php echo empty( $_POST[ 'ss_domain'] ) ? 'checked' : '' ?> <?php if ( isset( $_POST[ 'ss_domain'] ) and $_POST[ 'ss_domain'] === 'no' ) { echo 'checked'; } ?>>
			</label>
			<label for="ss_domain_yes">
				<?php _e( 'Yes' ) ?>
				<input id="ss_domain_yes" type="radio" name="ss_domain" value="yes" <?php if ( isset( $_POST[ 'ss_domain'] ) and $_POST[ 'ss_domain'] === 'yes' ) { echo 'checked'; } ?>>
			</label>
			<textarea cols="100" rows="2" name="ss_domain_text">
				<?php echo isset( $_POST[ 'ss_domain_text'] ) ? htmlspecialchars( $_POST['ss_domain_text'] ) : '' ?>
			</textarea>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="2">
			<h3>
				<div class="section-title">
					<?php _e( 'Filters' ) ?>
				</div>
			</h3>
			<hr width="50%" align="left">
			<br>
			<label for="usernameFilter">
				<?php _e( 'Username' ) ?>
			</label>
			<input type="text" size="15" name="ss_username" value="<?php echo isset( $_POST['ss_username'] ) ? htmlspecialchars( $_POST['ss_username'] ) : '' ?>" id="usernameFilter">
			<br>
			<small>
				<?php _e( 'Refine list by a username (e.g. test, example, etc.).' ) ?>
			</small>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="2">
			<label for="flag_daysleft">
			<?php _e( 'User was created' ) ?>
				<select name="f_daysleft">
				<?php if ( !isset( $_POST[ 'f_daysleft'] ) ) $_POST[ 'f_daysleft'] = 1; ?>
					<option value="1" <?php !empty( $_POST[ 'f_daysleft'] ) ? 'selected' : '' ?>>
						<?php _e( 'more' ) ?>
					</option>
					<option value="0" <?php empty( $_POST[ 'f_daysleft'] ) ? 'selected' : '' ?>>
						<?php _e( 'less' ) ?>
					</option>
				</select>
				<?php _e( 'than' ) ?>
				<input type="text" size="4" name="daysleft" value="<?php echo isset( $_POST['daysleft'] ) ? intval( $_POST['daysleft'] ) : 7 ?>">
				<?php _e( 'days ago.' ) ?>
			</label>
			<br>
			<small>
				<?php _e( 'Users need time to begin commenting. This filter can show recent registrations.' ) ?>
			</small>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="2">
			<label for="f_lastlogin">
			<?php _e( 'Last time user logged in is more than' ) ?>
				<select name="f_lastlogin">
					<option value="0">
						<?php _e( 'No Filter' ) ?>
					</option>
					<?php $columns = array( 15, 30, 60, 90, 180, 360, 720 ); foreach ( $columns as $v ) { print '<option value="' . $v . '" ' . ( $_POST[ 'f_lastlogin'] == $v ? 'selected' : '' ) . '>' . $v . '</option>'; } ?>
				</select>
				<?php _e( 'days ago.' ) ?>
			</label>
			<br>
			<small>
				<?php _e( 'Search by last login.' ) ?>
			</small>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<label for="user_role">
				<?php _e( 'User role ' ) ?>
			</label>
			<select name="user_role">
				<?php global $wp_roles; $roles = array( '' => 'Any Role' ) + $wp_roles->get_names(); foreach ( $roles as $roleId => $roleName ) { print '<option value="' . $roleId . '" ' . ($_POST['user_role'] == $roleId ? 'selected ' : ' ' ) . '>' . $roleName . '</option>'; } ?>
			</select>
			<br>
			<small>
				<?php _e( 'Filter by user role.' ) ?>
			</small>
		</td>
	</tr>
	<tr>
		<td align="left" colspan="2">
			<h3>
				<div class="section-title">
					<?php _e( 'Table Formatting' ) ?>
				</div>
			</h3>
			<hr width="50%" align="left">
			<br>
			<label for="sort_order">
				<?php _e( 'Show' ) ?>
			</label>
			<select id="max_size_output" name="max_size_output">
			<?php $columns = array( '150', '300', '500', '1000', '3000', 'All' ); foreach ( $columns as $v ) {
				print '<option value="' . $v . '" ' . ( $_POST['max_size_output'] == $v ? 'selected' : '' ) . '>' . $v . '</option>';
			} ?>
			</select>
			<?php _e( 'records' ) ?>
			<br>
			<small>
				<?php _e( 'Max sent allowed is' ) . ' ' . ini_get( 'max_input_vars' ) . ' ' . __( 'input vars.' ) ?>
			</small>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input class="button-primary" type="submit" value="<?php _e( 'Search' ) ?>" name="ss_search">
			<button class="button-primary" onclick="window.open('<?php echo admin_url( "admin-ajax.php" ) ?>' + '?action=iud_getCsvUserList&' + jQuery('#inactive-user-deleter-form').serialize()); return false;">
				<?php _e( 'Export to CSV' ) ?>
			</button>
		</td>
	</tr>
</table>

<a name="outputs"></a>

<?php

$name = array();
if ( isset( $_POST['ss_search'] ) ) {
	if ( isset( $_POST['ss_username'] ) ) {
		$userListObject = ss_getUsersList( $_POST, '' );
		$user_list = $userListObject->rows;
		$total = $userListObject->total;
		if ( empty( $userListObject->rows ) ) {
			echo __( '<p><strong>No users are found.</strong></p>' );
		} else {
			include_once 'ss_user_list.php';
		}
	}
}

function ss_isVIPUser( $userID ) {
	global $user_ID;
	if ( $userID == $user_ID ) {
		// i never will delete current user
		return __( 'I can\'t delete your profile!' );
	}
	if ( $userID == 1 ) {
		return __( 'I will never delete the super user!' );
	}
	return false;
}

function ss_getUsersList( $ARGS = array(), $environment ) {
	global $wpdb;
	$conditions = array();
	$conditions_sec2 = array( 1 );
	$joins = array( "FROM {$wpdb->prefix}users WU", "LEFT JOIN {$wpdb->prefix}comments WC ON WC.user_id = WU.ID", "LEFT JOIN {$wpdb->prefix}usermeta WUCAP ON WUCAP.user_id = WU.ID AND WUCAP.meta_key = 'wp_capabilities'", "LEFT JOIN {$wpdb->prefix}usermeta WUMD ON WUMD.user_id = WU.ID AND WUMD.meta_key = '_IUD_deltime'", "LEFT JOIN {$wpdb->prefix}usermeta WUMDIS ON WUMDIS.user_id = WU.ID AND WUMDIS.meta_key = '_IUD_userBlockedTime'" );
	$havings = array();
	$groupBy = array( 'WU.ID, WU.user_login, WU.user_email, WU.user_url, WU.user_registered, WU.display_name, WUCAP.meta_value, WUM21.meta_value, WUMD.meta_value, WUMDIS.meta_value' );
	if ( !empty( $ARGS['f_approve'] ) ) {
		//user with approved comments
		if ( $ARGS['f_approve'] == 'yes' ) {
			$conditions[] = "EXISTS (SELECT * FROM {$wpdb->prefix}comments WCAPP WHERE WCAPP.user_id = WU.ID AND WCAPP.comment_approved = 1)";
		} else {
			$conditions[] = "NOT EXISTS (SELECT * FROM {$wpdb->prefix}comments WCAPP WHERE WCAPP.user_id = WU.ID AND WCAPP.comment_approved = 1)";
		}
	}
	if ( !empty( $ARGS['has_spam'] ) ) {
		if ( $ARGS['has_spam'] === 'yes' ) {
			$conditions[] = "EXISTS (SELECT * FROM {$wpdb->prefix}comments WCSPM WHERE WCSPM.user_id = WU.ID AND WCSPM.comment_approved = 'spam' )";
		} else {
			$conditions[] = "NOT EXISTS (SELECT * FROM {$wpdb->prefix}comments WCSPM WHERE WCSPM.user_id = WU.ID AND WCSPM.comment_approved = 'spam' )";
		}
	}
	if ( !empty($ARGS['f_userdisabled'] ) ) {
		if ($ARGS['f_userdisabled'] === 'yes' ) {
			$conditions[] = "WUMDIS.meta_value > 0";
		} else {
			$conditions[] = "(WUMDIS.meta_value is NULL OR WUMDIS.meta_value = 0)";
		}
	}
	if ( !empty( $ARGS['f_lastlogin'] ) ) {
		$days = ( int )$ARGS['f_lastlogin'] + 0;
		$time = time() - $days * 86400;
		$timeStr = date( 'Y-m-d H:i:s', $time );
		$conditions[] = "(WUM2.meta_value < $time OR WUM21.meta_value < '$timeStr' )";
	}
	if ( !empty( $ARGS['has_recs'] ) ) {
		if ( $ARGS['has_recs'] === 'yes' ) {
			$conditions[] = "EXISTS (SELECT * FROM {$wpdb->prefix}posts WP WHERE WP.post_author = WU.ID
			AND NOT WP.post_type in ( 'attachment', 'revision' ) AND WP.post_status = 'publish' )";
		} else {
			// ignore user with posts
			$conditions[] = "NOT EXISTS (SELECT * FROM {$wpdb->prefix}posts WP WHERE WP.post_author = WU.ID
			AND NOT WP.post_type in ( 'attachment', 'revision' ) AND WP.post_status = 'publish' )";
		}
	}
	// section two
	if ( !empty( $ARGS['ss_username'] ) ) {
		$like = '%' . $wpdb->esc_like( $ARGS['ss_username'] ) . '%';
		$conditions_sec2[] = $wpdb->prepare( "WU.user_login like %s", $like );
	}
	if ( !empty( $ARGS['ss_domain'] ) ) {
		if ( $ARGS['ss_domain'] === 'yes' ) {
			$domains = explode( ',', $ARGS['ss_domain_text'] );
			$query1 = "";
			for ( $i = 0;$i < count($domains);$i++ ) {
				$like = '%' . $domains[$i];
				$query1.= "WU.user_email like '$like' or ";
			}
			$query1 = trim( $query1, 'or ' );
			$conditions_sec2[] = $query1;
		}
	}
	$days = empty( $ARGS['daysleft'] ) ? 0 : $ARGS['daysleft'] + 0;
	if ( $days >= 0 ) {
		$tmStr = date( 'Y-m-d H:i:s', time() - $days * 86400 );
		if ( empty( $ARGS['f_daysleft'] ) ) {
			$conditions_sec2[] = "WU.user_registered >= '$tmStr'";
		} else {
			$conditions_sec2[] = "WU.user_registered < '$tmStr'";
		}
	}
	if ( !empty( $ARGS['user_role'] ) ) {
		$conditions[] = 'LOCATE(\'' . esc_sql( $ARGS['user_role'] ) . '\', WUCAP.meta_value) > 0';
	}
	if ( is_plugin_active( 'user-login-history/user-login-history.php' ) && false ) {
		// user-login-history plugin case
		$PLUGIN_LAST_LOGIN_FIELD = 'MAX(UNIX_TIMESTAMP(WUM2.time_login))';
		$joins[] = "LEFT JOIN {$wpdb->prefix}fa_user_logins WUM2 ON WUM2.user_id = WU.ID";
	} else if ( is_plugin_active( 'when-last-login/when-last-login.php' ) ) {
		// when-last-login plugin case
		$PLUGIN_LAST_LOGIN_FIELD = 'WUM2.meta_value';
		$groupBy[] = $PLUGIN_LAST_LOGIN_FIELD;
		$joins[] = "LEFT JOIN {$wpdb->prefix}usermeta WUM2 ON WUM2.user_id = WU.ID AND WUM2.meta_key = 'when_last_login'";
	} else if ( is_plugin_active( 'wp-last-login/wp-last-login.php' ) ) {
		// wp-last-login plugin case
		$PLUGIN_LAST_LOGIN_FIELD = 'WUM2.meta_value';
		$groupBy[] = $PLUGIN_LAST_LOGIN_FIELD;
		$joins[] = "LEFT JOIN {$wpdb->prefix}usermeta WUM2 ON WUM2.user_id = WU.ID AND WUM2.meta_key = 'wp-last-login'";
	} else {
		//use own data
		$PLUGIN_LAST_LOGIN_FIELD = 'WUM2.meta_value';
		$groupBy[] = $PLUGIN_LAST_LOGIN_FIELD;
		$joins[] = "LEFT JOIN {$wpdb->prefix}usermeta WUM2 ON WUM2.user_id = WU.ID AND WUM2.meta_key = 'last_login_gtm'";
	}
	if ( !empty( $ARGS['f_usereverlogin'] ) ) {
		if ( $ARGS['f_usereverlogin'] === 'yes' ) {
			$havings[] = "(last_login > 0 OR WUM21.meta_value > '1970-01-02 00:00:01' )";
		} else {
			$havings[] = "((last_login = 0 OR last_login IS NULL) AND (WUM21.meta_value is NULL OR WUM21.meta_value <= '1970-01-02 00:00:01' ))";
		}
	}
	// Classipress case last-login
	$joins[] = "LEFT JOIN {$wpdb->prefix}usermeta WUM21 ON WUM21.user_id = WU.ID AND WUM21.meta_key = 'last_login'";
	if ( !empty( $conditions ) ) {
		$conditions_sec2[] = implode( $ARGS['flagsCND'] == 'add' ? 'OR ' : 'AND ', $conditions );
	}
	if ( !empty( $ARGS['ss_check_name'] ) ) {
		if ( $ARGS['ss_check_name'] === 'yes' ) {
			$havings[] = 'first_name = last_name and first_name!=""';
		}
	}
	$joins[] = "LEFT JOIN {$wpdb->prefix}usermeta WUM211 ON WUM211.user_id = WU.ID AND WUM211.meta_key = 'first_name'";
	$joins[] = "LEFT JOIN {$wpdb->prefix}usermeta WUM212 ON WUM212.user_id = WU.ID AND WUM212.meta_key = 'last_name'";
	// first action - comments published
	$query = "
		SELECT SQL_CALC_FOUND_ROWS SUM(WC.comment_approved = 1) as approved, SUM(WC.comment_approved = 'spam' ) as spam,
		WU.ID, WU.user_login as login, WU.user_email as mail, WU.user_url as url, WU.user_registered as dt_reg, WU.display_name as name,
		WUMDIS.meta_value as disabled_time, WUM211.meta_value AS first_name,WUM212.meta_value AS last_name,
		WUCAP.meta_value as USL, {$PLUGIN_LAST_LOGIN_FIELD} as last_login, WUM21.meta_value as last_login_classipress, WUMD.meta_value as removetime
		" . implode(" ", $joins) . "
		WHERE (" . implode( ' ) AND ( ', $conditions_sec2 ) . ")
		GROUP BY " . implode( ', ', $groupBy ) . ( !empty( $havings ) ? ' HAVING ' . implode( ' AND ', $havings ) : '' );
	switch ( $ARGS['sort_order'] ) {
		case 'logindate':
			$sort_order = 'WUM21.meta_value DESC, WUM2.meta_value DESC';
		break;
		case 'name':
			$sort_order = 'WU.display_name';
		break;
		case 'mail':
			$sort_order = 'WU.user_email';
		break;
		case 'regdate':
			$sort_order = 'WU.user_registered';
		break;
		case 'spam':
			$sort_order = 'SUM(WC.comment_approved = \'spam\' ) DESC, WU.user_login';
		break;
		case 'userlevel':
			$sort_order = 'WUCAP.meta_value DESC, WU.user_login';
		break;
		case 'comments':
			$sort_order = 'SUM(WC.comment_approved = 1) DESC, WU.user_login';
		break;
		case 'disabled':
			$sort_order = 'WUMDIS.meta_value';
		break;
		case 'posts':
		default:
			$sort_order = 'WU.user_login';
	}
	$query.= $ARGS['max_size_output'] == 'all' ? ' ' : ' LIMIT ' . ( $ARGS['max_size_output'] + 0 );
	$rows = $wpdb->get_results( $query, ARRAY_A );
	$total = $wpdb->get_var( "SELECT FOUND_ROWS();" );
	$user_list = array();
	if ( !empty( $rows ) ) {
		foreach ( $rows as $k => $UR ) {
			$UR['recs'] = 0;
			$user_list[$UR['ID']] = $UR;
		}
	}
	// clean up with registration lifetime ctiteria + check user norecs criteria + count publish posts
	$query = "
		SELECT COUNT(WP.ID) as recs, WU.ID
		FROM $wpdb->posts WP
		LEFT JOIN $wpdb->users WU ON WP.post_author = WU.ID
		WHERE 1 " . (empty($ARGS['f_daysleft']) ? '' : "AND WU.user_registered < '$tmStr' ") . "
		AND NOT WP.post_type in ( 'attachment', 'revision' ) AND post_status = 'publish'
		GROUP BY WU.ID
		HAVING COUNT(WP.ID) > 0";
	$rows = $wpdb->get_results( $query, ARRAY_A );
	if ( !empty( $rows ) ) {
		foreach ( $rows as $k => $UR ) {
			$id = $UR['ID'];
			if ( isset( $user_list[$id] ) ) $user_list[$id]['recs'] = $UR['recs'];
		}
	}
	$result = new \stdClass();
	$result->rows = $user_list;
	$result->total = $total;
	return $result;
}

if ( isset( $_POST['op'] ) ) {
	switch ( $_POST['op'] ) {
		case 'disable':
		// disable accounts
		echo __( 'Disabling...' ) . '<br>';
		$cnt_disabled = 0;
		foreach ( $_POST['f_users'] as $user_id_to_disable ) {
			$result = ss_isVIPUser( $user_id_to_disable );
			if ( $result === false ) {
				$tm = get_user_meta( $user_id_to_disable, '_IUD_userBlockedTime', true );
				if ( !$tm ) {
					update_usermeta( $user_id_to_disable, '_IUD_userBlockedTime', time() );
					$cnt_disabled++;
				}
			} else {
				echo $result . '<br>';
			}
		}
		// output actions status
		if ( $cnt_disabled == 1 ) {
			echo $cnt_disabled . ' ' . __( 'user was disabled.' );
		} else {
			echo $cnt_disabled . ' ' . __( 'users were disabled.' );
		}
		break;
		case 'activate':
		// enable accounts
		echo __( 'Enabling accounts...' ) . '<br>';
		$cnt_enabled = 0;
		foreach ( $_POST['f_users'] as $user_id_to_enable ) {
			$tm = get_user_meta( $user_id_to_enable, '_IUD_userBlockedTime', true );
			if ( $tm ) {
				delete_user_meta( $user_id_to_enable, '_IUD_userBlockedTime' );
				$cnt_enabled++;
			}
		}
		// output actions status
		if ( $cnt_enabled == 1 ) {
			echo $cnt_enabled . ' ' . __( 'user was enabled.' );
		} else {
			echo $cnt_enabled . ' ' . __( 'users were enabled.' );
		}
		break;
	}
}

?>