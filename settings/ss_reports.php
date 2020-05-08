<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // just in case
if ( ! current_user_can( 'manage_options' ) ) {
	die( 'Access Denied' );
}
ss_fix_post_vars();
$trash    = SS_PLUGIN_URL . 'images/trash.png';
$tdown    = SS_PLUGIN_URL . 'images/tdown.png';
$tup      = SS_PLUGIN_URL . 'images/tup.png';
$whois    = SS_PLUGIN_URL . 'images/whois.png';
$stophand = SS_PLUGIN_URL . 'images/stop.png';
$search   = SS_PLUGIN_URL . 'images/search.png';
$now      = date( 'Y/m/d H:i:s',
	time() + ( get_option( 'gmt_offset' ) * 3600 ) );
?>
<div id="ss-plugin" class="wrap">
    <h1 class="ss_head">Stop Spammers — Log Report</h1>
	<?php
	// $ip=ss_get_ip();
	$stats = ss_get_stats();
	extract( $stats );
	$options = ss_get_options();
	extract( $options );
	$ip    = $_SERVER['REMOTE_ADDR'];
	$nonce = '';
	$msg   = '';
	if ( array_key_exists( 'ss_stop_spammers_control', $_POST ) ) {
		$nonce = $_POST['ss_stop_spammers_control'];
	}
	if ( wp_verify_nonce( $nonce, 'ss_stopspam_update' ) ) {
		if ( array_key_exists( 'ss_stop_clear_hist', $_POST ) ) {
// clean out the history
			$hist             = array();
			$stats['hist']    = $hist;
			$spcount          = 0;
			$stats['spcount'] = $spcount;
			$spdate           = $now;
			$stats['spdate']  = $spdate;
			ss_set_stats( $stats );
			extract( $stats ); // extract again to get the new options
			$msg
				= "<div class='notice notice-success'><p>Activity Log Cleared</p></div>";
		}
		if ( array_key_exists( 'ss_stop_update_log_size', $_POST ) ) {
// update log size
			if ( array_key_exists( 'ss_sp_hist', $_POST ) ) {
				$ss_sp_hist            = stripslashes( $_POST['ss_sp_hist'] );
				$options['ss_sp_hist'] = $ss_sp_hist;
				$msg
				                       = "<div class='notice notice-success'><p>Options Updated</p></div>";
// update the options
				ss_set_options( $options );
			}
		}
	}
	if ( ! empty( $msg ) ) {
		echo "$msg";
	}
	$num_comm = wp_count_comments();
	$num      = number_format_i18n( $num_comm->spam );
	if ( $num_comm->spam > 0 && SS_MU != 'Y' ) {
		?>
        <p>There are <a
                    href='edit-comments.php?comment_status=spam'><?php echo $num; ?></a>
            spam comments waiting for
            you to report them.</p>
		<?php
	}
	$num_comm = wp_count_comments();
	$num      = number_format_i18n( $num_comm->moderated );
	if ( $num_comm->moderated > 0 && SS_MU != 'Y' ) {
		?>
        <p>There are <a
                    href='edit-comments.php?comment_status=moderated'><?php echo $num; ?></a>
            comments waiting to be
            moderated.</p>
		<?php
	}
	$nonce = wp_create_nonce( 'ss_stopspam_update' );
	?>
    <script>
        // setTimeout(function(){
        // window.location.reload(1);
        // }, 10000);
    </script>
    <form method="post" action="">
        <input type="hidden" name="ss_stop_spammers_control"
               value="<?php echo $nonce; ?>"/>
        <input type="hidden" name="ss_stop_update_log_size" value="true"/>

        <h2>History Size</h2>

        Select the number of events to save in the history.<br/>
        <p class="submit">
            <select name="ss_sp_hist">
                <option value="10" <?php if ( $ss_sp_hist == '10' ) {
					echo "selected=\"true\"";
				} ?>>10
                </option>
                <option value="25" <?php if ( $ss_sp_hist == '25' ) {
					echo "selected=\"true\"";
				} ?>>25
                </option>
                <option value="50" <?php if ( $ss_sp_hist == '50' ) {
					echo "selected=\"true\"";
				} ?>>50
                </option>
                <option value="75" <?php if ( $ss_sp_hist == '75' ) {
					echo "selected=\"true\"";
				} ?>>75
                </option>
                <option value="100" <?php if ( $ss_sp_hist == '100' ) {
					echo "selected=\"true\"";
				} ?>>100
                </option>
                <option value="150" <?php if ( $ss_sp_hist == '150' ) {
					echo "selected=\"true\"";
				} ?>>150
                </option>
            </select>
            <input class="button-primary" value="Update Log Size"
                   type="submit"/></p>

        <form method="post" action="">
            <input type="hidden" name="ss_stop_spammers_control"
                   value="<?php echo $nonce; ?>"/>
            <input type="hidden" name="ss_stop_clear_hist" value="true"/>
            <p class="submit"><input class="button-primary"
                                     value="Clear Recent Activity"
                                     type="submit"/></p>
        </form>

		<?php
		if ( empty( $hist ) ) {
			echo "<p>Nothing in logs.</p>";
		} else {
			?>
            <br/>
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Date Search" title="Filter by a value">
            <table name="mytable" id="myTable" style="width:100%;background-color:#eee" cellspacing="2">
                <thead>
                <tr style="background-color:#675682;color:white;text-align:center;text-transform:uppercase;font-weight:600">
                    <th onclick="sortTable(0)" class="filterhead ss_cleanup">
                        Date/Time
                    </th>
                    <th class="ss_cleanup">Email</th>
                    <th class="ss_cleanup">IP</th>
                    <th class="ss_cleanup">Author, User/Pwd</th>
                    <th class="ss_cleanup">Script</th>
                    <th class="ss_cleanup">Reason
						<?php
						if ( function_exists( 'is_multisite' )
						     && is_multisite() ) {
						?>
                    </th>
                </thead>
                <tbody>
				<?php
				}
				?>
                </tr>
				<?php
				// sort list by date descending
				krsort( $hist );
				foreach ( $hist as $key => $data ) {
// $hist[$now]=array($ip,$email,$author,$sname,'begin');
					$em = strip_tags( trim( $data[1] ) );
					$dt = strip_tags( $key );
					$ip = $data[0];
					$au = strip_tags( $data[2] );
					$id = strip_tags( $data[3] );
					if ( empty( $au ) ) {
						$au = ' -- ';
					}
					if ( empty( $em ) ) {
						$em = ' -- ';
					}
					$reason = $data[4];
					$blog   = 1;
					if ( count( $data ) > 5 ) {
						$blog = $data[5];
					}
					if ( empty( $blog ) ) {
						$blog = 1;
					}
					if ( empty( $reason ) ) {
						$reason = "passed";
					}
					$stopper
						= "<a title=\"Check Stop Forum Spam (SFS)\" target=\"_stopspam\" href=\"https://www.stopforumspam.com/search.php?q=$ip\"><img src=\"$stophand\" height=\"16px\" /></a>";
					$honeysearch
						= "<a title=\"Check project HoneyPot\" target=\"_stopspam\" href=\"https://www.projecthoneypot.org/ip_$ip\"><img src=\"$search\" height=\"16px\" /></a>";
					$botsearch
						= "<a title=\"Check BotScout\" target=\"_stopspam\" href=\"https://botscout.com/search.htm?stype=q&sterm=$ip\"><img src=\"$search\" height=\"16px\" /></a>";
					$who
						= "<br /><a title=\"Look Up WHOIS\" target=\"_stopspam\" href=\"https://lacnic.net/cgi-bin/lacnic/whois?lg=EN&query=$ip\"><img src=\"$whois\" height=\"16px\" /></a>";
					echo "<tr style=\"background-color:white\">
<td>$dt</td>
<td>$em</td>
<td>$ip $who $stopper $honeysearch $botsearch";
					if ( stripos( $reason, 'passed' ) !== false
					     && ( $id == '/'
					          || strpos( $id, 'login' ) ) !== false
					     || strpos( $id, 'register' ) !== false
					        && ! in_array( $ip, $blist )
					        && ! in_array( $ip, $wlist )
					) {
						$ajaxurl = admin_url( 'admin-ajax.php' );
						echo "<a href=\"\" onclick=\"sfs_ajax_process( '$ip','log','add_black','$ajaxurl' );return false;\" title=\"Add to Deny List\" alt=\"Add to Deny List\" ><img src=\"$tdown\" height=\"16px\" /></a>";
						$options = get_option( 'ss_stop_sp_reg_options' );
						$apikey  = $options['apikey'];
						if ( ! empty( $apikey ) ) {
							$href = "href=\"#\"";
							$onclick
							      = "onclick=\"sfs_ajax_report_spam(this, 'registration', '$blog', '$ajaxurl', '$em', '$ip', '$au');return false;\"";
						}
						if ( ! empty( $em ) ) {
							echo "|";
							echo "<a title=\"Report to Stop Forum Spam (SFS)\" $href $onclick class='delete:the-comment-list:comment-$id::delete=1 delete vim-d vim-destructive'>Report to SFS</a>";
						}
					}
					echo "</td><td>$au</td>
<td>$id</td>
<td>$reason</td>";
					if ( function_exists( 'is_multisite' ) && is_multisite() ) {
// switch to blog and back
						$blogname  = get_blog_option( $blog, 'blogname' );
						$blogadmin = esc_url( get_admin_url( $blog ) );
						$blogadmin = trim( $blogadmin, '/' );
						echo "<td style=\"font-size:.9em;padding:2px\" align=\"center\">";
						echo "<a href=\"$blogadmin/edit-comments.php\">$blogname</a>";
						echo "</td>";
					}
					echo "</tr>";
				}
				?>
                </tbody>
            </table>
            <script>
                function sortTable(n) {
                    var table, rows, switching, i, x, y, shouldSwitch, dir,
                        switchcount = 0;
                    table = document.getElementById("myTable");
                    switching = true;
                    //Set the sorting direction to ascending:
                    dir = "asc";
                    /*Make a loop that will continue until
					no switching has been done:*/
                    while (switching) {
                        //start by saying: no switching is done:
                        switching = false;
                        rows = table.rows;
                        /*Loop through all table rows (except the
						first, which contains table headers):*/
                        for (i = 1; i < (rows.length - 1); i++) {
                            //start by saying there should be no switching:
                            shouldSwitch = false;
                            /*Get the two elements you want to compare,
							one from current row and one from the next:*/
                            x = rows[i].getElementsByTagName("TD")[n];
                            y = rows[i + 1].getElementsByTagName("TD")[n];
                            /*check if the two rows should switch place,
							based on the direction, asc or desc:*/
                            if (dir == "asc") {
                                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                    //if so, mark as a switch and break the loop:
                                    shouldSwitch = true;
                                    break;
                                }
                            } else if (dir == "desc") {
                                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                    //if so, mark as a switch and break the loop:
                                    shouldSwitch = true;
                                    break;
                                }
                            }
                        }
                        if (shouldSwitch) {
                            /*If a switch has been marked, make the switch
							and mark that a switch has been done:*/
                            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                            switching = true;
                            //Each time a switch is done, increase this count by 1:
                            switchcount++;
                        } else {
                            /*If no switching has been done AND the direction is "asc",
							set the direction to "desc" and run the while loop again.*/
                            if (switchcount == 0 && dir == "asc") {
                                dir = "desc";
                                switching = true;
                            }
                        }
                    }
                }

                function myFunction() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("myInput");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("myTable");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[0];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            </script>
			<?php
		}
		?>
</div>
