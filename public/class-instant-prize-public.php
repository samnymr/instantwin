<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://rightglobalgroup.com/
 * @since      4.1.0
 *
 * @package    Instant_Prize
 * @subpackage Instant_Prize/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Instant_Prize
 * @subpackage Instant_Prize/public
 * @author     Right Global Group <info@rightglobalbgroup.com>
 */
class Instant_Prize_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    4.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    4.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    4.1.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    4.1.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Instant_Prize_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Instant_Prize_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/instant-prize-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    4.1.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Instant_Prize_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Instant_Prize_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/instant-prize-public.js', array( 'jquery' ), null, false );
		wp_enqueue_script( "sweetalert", plugin_dir_url( __FILE__ ) . 'js/sweetalert.min.js', array(), $this->version, false );

	}

	public function check_instant_prize($order_id) {
		$options = get_option( 'instant-winners_settings' );
		$order = wc_get_order($order_id);
		if($order->get_status() == "pending") {
			echo "<script>window.location.reload();</script>";
		}
		$wins = [];
		foreach ( $order->get_items() as $item_id => $item ) {
			$winners = get_post_meta($item->get_product_id(), '_lottery_instant_instant_winners');
			$order_wins = array_filter($winners, function($w) use ($order) {
				return $w['order_id'] == $order->get_id();
			});
			$wins = array_merge($wins, $order_wins);
		}
		foreach($wins as $win) {
			echo '<span class="winning-ticket-instant">You won ' . $win['prize'] . ' with ticket #' . $win['ticket'] . '.</span>';
		}
		echo "<style>
					.swal-overlay {
						background-color: " . $options['instant_winners_overlay_colour'] . " !important;
					}

					.swal-modal {
						background-color: " . $options['instant_winners_box_colour'] . " !important;
					}

					.swal-icon--success:after, .swal-icon--success:before, .swal-icon--success__hide-corners {
						background-color: " . $options['instant_winners_box_colour']. " !important;
					}

					.swal-icon--success:before {
						left: -32px !important;
					}

					.swal-icon--success:after {
						left: 29px !important;
					}

					.swal-title {
						color: " . $options['instant_winners_title_colour'] . " !important;
					}

					.swal-text {
						color: " . $options['instant_winners_text_colour'] . " !important;
					}

					.swal-button {
						background-color: " . $options['instant_winners_button_colour'] . " !important;
						color: " . $options['instant_winners_button_text_colour'] . " !important;
					}
				</style>";
	}
	
	
	public function my_instant_prizes() {					
		if(get_post_meta(get_the_ID(), "_lottery_instant_win", true) == "yes" && is_user_logged_in()) {
			$winners = get_post_meta(get_the_ID(), '_lottery_instant_instant_winners');
			$wins = array_filter($winners, function($w) {
				return $w['user_id'] == get_current_user_id();
			});
			?>
				<div class="my-instant-prizes">
					<?php
						foreach($wins as $win) {
							?>
								<span class="winning-ticket-instant">You won <?php echo $win['prize']; ?> with ticket <?php echo $win['ticket']; ?></span>
							<?php
						}
					?>
				</div>
			<?php
		}
	}
	
	public function instant_prize_table() {	
		if(get_post_meta(get_the_ID(), "_lottery_instant_win", true) == "yes") {
			$prizes = wc_lottery_get_lottery_instant_ticket_numbers_prizes_field(get_the_ID());
			$winners = get_post_meta(get_the_ID(), '_lottery_instant_instant_winners');
			$random = get_post_meta(get_the_ID(), "_lottery_pick_numbers_random", true);
			?>
				<div class="instant-prize-table">
					<strong>Instant Win Ticket Numbers: </strong><br><br>
					<ul class="instant-prize-table">
						<?php
							foreach($prizes as $prize) {
								$winner_key = array_search($prize['ticket'], array_column($winners, 'ticket'));
								if($winner_key != false) {
									$winner_val = $winners[$winner_key];
									$winner = get_user_by("id", $winner_val['user_id']);
									?>
						<li><?php echo $prize['prize']; ?> - <?php echo $prize['ticket']; ?> - <span style="color: orange !important; margin-left: 10px;" class="winner-ticket">Won by <?php echo $winner->display_name; ?></span></li>
									<?php
								} else {
									?>
										<li><?php echo $prize['prize']; ?><?php if($random == "yes") { echo " - " . $prize['ticket']; } ?></li>
									<?php
								}
							}
						?>
					</ul>	
				</div>
			<?php
		}
	}
	
	public function auto_add_site_credit($order_id) {
		global $wpdb;
    	$table_name = $wpdb->prefix . 'instant_prize';
		$order = wc_get_order($order_id);
		$wins = [];
		foreach ( $order->get_items() as $item_id => $item ) {
			$winners = get_post_meta($item->get_product_id(), '_lottery_instant_instant_winners');
			$order_wins = array_filter($winners, function($w) use ($order) {
				return $w['order_id'] == $order->get_id();
			});
			$wins = array_merge($wins, $order_wins);
		}
		$currentMonth = date('m');
			$currentYear = date('Y');

			$query = "SELECT COUNT(id), winner_id, winner_name
						  FROM $table_name
						  WHERE MONTH(date) = %d AND YEAR(date) = %d
						  GROUP BY winner_id";

			$instant_results = $wpdb->get_results($wpdb->prepare($query, $currentMonth, $currentYear));

			$table_name = $wpdb->prefix . 'prize_winners';
			$query = "SELECT COUNT(id), winner_id, winner_name
						  FROM $table_name
						  WHERE MONTH(date) = %d AND YEAR(date) = %d
						  GROUP BY winner_id";

			$prize_results = $wpdb->get_results($wpdb->prepare($query, $currentMonth, $currentYear));

			$totals = array();
			$names = array();
			$options = get_option( 'instant-winners_settings' );
			$instant_points = $options["instant_winners_instant_win_points"];
			$prize_points = $options["instant_winners_competition_win_points"];

			foreach($instant_results as $result) {
				$vars = get_object_vars($result);
				$totals[$result->winner_id] += $vars["COUNT(id)"];
				$names[$result->winner_id] = $result->winner_name;
			}
			foreach($prize_results as $result) {
				$vars = get_object_vars($result);
				$totals[$result->winner_id] += $vars["COUNT(id)"];
				$names[$result->winner_id] = $result->winner_name;
			}

			arsort($totals);

			$old_totals = array_slice($totals, 0, 3, true);

		foreach($wins as $win) {
			if(str_starts_with($win['prize'], "£") && str_contains(strtolower($win['prize']), "site credit")) {
				$amount = floatval(explode(" ", ltrim($win['prize'], "£"))[0]);
				woo_wallet()->wallet->credit($order->get_user_id(), $amount, "Instant prize - order " . $order_id);
			}

			$table_name = $wpdb->prefix . 'instant_prize';
			
			$data = array(
				'date' => current_time('mysql'), // Current date and time
				'prize_name' => $win['prize'],
				'ticket_number' => $win['ticket'],
				'winner_name' => $order->get_formatted_billing_full_name(),
				'winner_id' => $win['user_id']
			);

			$wpdb->insert($table_name, $data);
			
			$subject = 'Winner Order No: ' . $order_id;
			$site_url = get_site_url();
			$body = "Hello!<br><br>There is a new winner for the Instant Prize!<br><br>Ticket: {$win['ticket']} for {$win['prize']}<br><br><a href='{$site_url}/wp-admin/post.php?post={$order_id}&action=edit'>View Order & Customer Details here</a>";

			$headers = array('Content-Type: text/html; charset=UTF-8');
			$headers['From']    = "From: " . get_bloginfo( 'name' ) . " <noreply@" . str_replace(' ',  '', strtolower(get_bloginfo('name'))) . ".com>";       
			wp_mail( get_bloginfo('admin_email'), $subject, $body, $headers );	
		}
		
		if (!empty($wins)) {
			$options = get_option( 'instant-winners_settings' );
			$subject = $options['instant_winners_email_heading'];
			$heading = $options['instant_winners_email_heading'];
			$body = "Hi " . $order->get_billing_first_name() . ", <br/><br/>" . $options['instant_winners_email_intro'] . "<br/> " . implode("<br/>", array_map("map_wins", $wins)) . " <br/>" . $options['instant_winners_email_outro'];
			$headers = array('Content-Type: text/html; charset=UTF-8');
// 			$headers['From']    = "From: " . get_bloginfo( 'name' ) . " <noreply@" . str_replace(' ',  '', strtolower(get_bloginfo('name'))) . ".com>";    
			
			$mailer = WC()->mailer();
			$wrapped_message = $mailer->wrap_message($heading, $body);
			$wc_email = new WC_Email;
			$html_message = $wc_email->style_inline($wrapped_message);
			$mailer->send($order->get_billing_email(), $subject, $html_message, $headers);
			
			$table_name = $wpdb->prefix . 'instant_prize';
			
			$query = "SELECT COUNT(id), winner_id, winner_name
						  FROM $table_name
						  WHERE MONTH(date) = %d AND YEAR(date) = %d
						  GROUP BY winner_id";

			$instant_results = $wpdb->get_results($wpdb->prepare($query, $currentMonth, $currentYear));

			$table_name = $wpdb->prefix . 'prize_winners';
			$query = "SELECT COUNT(id), winner_id, winner_name
						  FROM $table_name
						  WHERE MONTH(date) = %d AND YEAR(date) = %d
						  GROUP BY winner_id";

			$prize_results = $wpdb->get_results($wpdb->prepare($query, $currentMonth, $currentYear));

			$totals = array();
			$names = array();
			$options = get_option( 'instant-winners_settings' );
			$instant_points = $options["instant_winners_instant_win_points"];
			$prize_points = $options["instant_winners_competition_win_points"];

			foreach($instant_results as $result) {
				$vars = get_object_vars($result);
				$totals[$result->winner_id] += $vars["COUNT(id)"];
				$names[$result->winner_id] = $result->winner_name;
			}
			foreach($prize_results as $result) {
				$vars = get_object_vars($result);
				$totals[$result->winner_id] += $vars["COUNT(id)"];
				$names[$result->winner_id] = $result->winner_name;
			}

			arsort($totals);

			$new_totals = array_slice($totals, 0, 3, true);
			$place = "";
			if(array_keys($old_totals)[0] != array_keys($new_totals)[0] && intval(array_keys($new_totals)[0]) == get_current_user_id()) {
				$place = "gold";
			}
			if(array_keys($old_totals)[1] != array_keys($new_totals)[1] && intval(array_keys($new_totals)[1]) == get_current_user_id()) {
				$place = "silver";
			}
			if(array_keys($old_totals)[2] != array_keys($new_totals)[2] && intval(array_keys($new_totals)[2]) == get_current_user_id()) {
				$place = "bronze";
			}
			
			if($place != "") {
				$subject = str_replace("[medal]", $place, $options["instant_winners_gain_medal_email_subject"]);
				$header = str_replace("[medal]", $place, $options["instant_winners_gain_medal_email_header"]);
				$body = str_replace("[medal]", $place, $options["instant_winners_gain_medal_email"]);
				$headers = array('Content-Type: text/html; charset=UTF-8');
				$mailer = WC()->mailer();
				$wrapped_message = $mailer->wrap_message($header, $body);
				$wc_email = new WC_Email;
				$html_message = $wc_email->style_inline($wrapped_message);
				$mailer->send($order->get_billing_email(), $subject, $html_message, $headers);
			}
			$place = "";
			if(array_keys($old_totals)[0] != array_keys($new_totals)[0] && intval(array_keys($old_totals)[0]) == get_current_user_id()) {
				$place = "gold";
			}
			if(array_keys($old_totals)[1] != array_keys($new_totals)[1] && intval(array_keys($old_totals)[1]) == get_current_user_id()) {
				$place = "silver";
			}
			if(array_keys($old_totals)[2] != array_keys($new_totals)[2] && intval(array_keys($old_totals)[2]) == get_current_user_id()) {
				$place = "bronze";
			}
			
			if($place != "") {
				$subject = str_replace("[medal]", $place, $options["instant_winners_lose_medal_email_subject"]);
				$header = str_replace("[medal]", $place, $options["instant_winners_lose_medal_email_header"]);
				$body = str_replace("[medal]", $place, $options["instant_winners_lose_medal_email"]);
				$headers = array('Content-Type: text/html; charset=UTF-8');
				$mailer = WC()->mailer();
				$wrapped_message = $mailer->wrap_message($header, $body);
				$wc_email = new WC_Email;
				$html_message = $wc_email->style_inline($wrapped_message);
				$mailer->send($order->get_billing_email(), $subject, $html_message, $headers);
			}
		}
	}
	
	
	public function instant_prize_table_custom() {
		if(get_post_meta(get_the_ID(), "_lottery_instant_win", true) == "yes") {
			$prizes = wc_lottery_get_lottery_instant_ticket_numbers_prizes_field(get_the_ID());
			$winners = get_post_meta(get_the_ID(), '_lottery_instant_instant_winners');
			$random = get_post_meta(get_the_ID(), "_lottery_pick_numbers_random", true);						
			?>
				<div class="instant-prize-table">
					<table class="instant-prize-table">
						<thead><th>Ticket No.</th><th>Prize Name</th><th>Winner</th></thead>
						<?php
							foreach($prizes as $prize) {
								$winner_key = array_search($prize['ticket'], array_column($winners, 'ticket'));
								if($winner_key != false) {
									$winner_val = $winners[$winner_key];
									$winner = get_user_by("id", $winner_val['user_id']);
									if(!empty($winner->first_name)) {
										$winner_name = $winner->first_name . " " . $winner->last_name;
									} else {
										$winner_name = $winner->display_name;
									}
								}
								?>
									<tr <?php if($winner_key != false): ?>class="winner"<?php endif; ?>>
										<td><?php if($random == "yes" || $winner_key != false) { echo $prize['ticket']; } else { echo '-'; } ?></td>
										<td><?php echo $prize['prize']; ?></td>
										<td>
											<?php if($winner_key != false) { echo "🏆 " . $winner_name; } ?>
										</td>
									</tr>
								<?php
							}
						?>
					</table>	
				</div>
			<?php
		}
	}
	
	public function on_win($post_id) {
error_log('on_win() called');
		global $wpdb;
    	$table_name = $wpdb->prefix . 'prize_winners';
		$pn_winners = get_post_meta($post_id, "_lottery_pn_winners", true);
		if(get_post_status($post_id) != false) {
			$post = get_post($post_id);
			foreach($pn_winners as $win) {
				$order = wc_get_order($win['order_id']);
				
				$table_name = $wpdb->prefix . 'instant_prize';
			
				$currentMonth = date('m');
				$currentYear = date('Y');

				$query = "SELECT COUNT(id), winner_id, winner_name
							  FROM $table_name
							  WHERE MONTH(date) = %d AND YEAR(date) = %d
							  GROUP BY winner_id";

				$instant_results = $wpdb->get_results($wpdb->prepare($query, $currentMonth, $currentYear));

				$table_name = $wpdb->prefix . 'prize_winners';
				$query = "SELECT COUNT(id), winner_id, winner_name
							  FROM $table_name
							  WHERE MONTH(date) = %d AND YEAR(date) = %d
							  GROUP BY winner_id";

				$prize_results = $wpdb->get_results($wpdb->prepare($query, $currentMonth, $currentYear));

				$totals = array();
				$names = array();
				$options = get_option( 'instant-winners_settings' );
				$instant_points = $options["instant_winners_instant_win_points"];
				$prize_points = $options["instant_winners_competition_win_points"];

				foreach($instant_results as $result) {
					$vars = get_object_vars($result);
					$totals[$result->winner_id] += $vars["COUNT(id)"];
					$names[$result->winner_id] = $result->winner_name;
				}
				foreach($prize_results as $result) {
					$vars = get_object_vars($result);
					$totals[$result->winner_id] += $vars["COUNT(id)"];
					$names[$result->winner_id] = $result->winner_name;
				}

				arsort($totals);

				$old_totals = array_slice($totals, 0, 3, true);
				
				$data = array(
					'date' => current_time('mysql'), // Current date and time
					'prize_name' => $post->post_title,
					'ticket_number' => $win['ticket_number'],
					'winner_name' => $order->get_formatted_billing_full_name(),
					'winner_id' => $win['userid']
				);

				$wpdb->insert($table_name, $data);

				$table_name = $wpdb->prefix . 'instant_prize';

				$query = "SELECT COUNT(id), winner_id, winner_name
							  FROM $table_name
							  WHERE MONTH(date) = %d AND YEAR(date) = %d
							  GROUP BY winner_id";

				$instant_results = $wpdb->get_results($wpdb->prepare($query, $currentMonth, $currentYear));

				$table_name = $wpdb->prefix . 'prize_winners';
				$query = "SELECT COUNT(id), winner_id, winner_name
							  FROM $table_name
							  WHERE MONTH(date) = %d AND YEAR(date) = %d
							  GROUP BY winner_id";

				$prize_results = $wpdb->get_results($wpdb->prepare($query, $currentMonth, $currentYear));

				$totals = array();
				$names = array();
				$options = get_option( 'instant-winners_settings' );
				$instant_points = $options["instant_winners_instant_win_points"];
				$prize_points = $options["instant_winners_competition_win_points"];

				foreach($instant_results as $result) {
					$vars = get_object_vars($result);
					$totals[$result->winner_id] += $vars["COUNT(id)"];
					$names[$result->winner_id] = $result->winner_name;
				}
				foreach($prize_results as $result) {
					$vars = get_object_vars($result);
					$totals[$result->winner_id] += $vars["COUNT(id)"];
					$names[$result->winner_id] = $result->winner_name;
				}

				arsort($totals);

				$new_totals = array_slice($totals, 0, 3, true);
				$place = "";
				if(array_keys($old_totals)[0] != array_keys($new_totals)[0] && intval(array_keys($new_totals)[0]) == get_current_user_id()) {
					$place = "gold";
				}
				if(array_keys($old_totals)[1] != array_keys($new_totals)[1] && intval(array_keys($new_totals)[1]) == get_current_user_id()) {
					$place = "silver";
				}
				if(array_keys($old_totals)[2] != array_keys($new_totals)[2] && intval(array_keys($new_totals)[2]) == get_current_user_id()) {
					$place = "bronze";
				}

				if($place != "") {
					$subject = str_replace("[medal]", $place, $options["instant_winners_gain_medal_email_subject"]);
					$header = str_replace("[medal]", $place, $options["instant_winners_gain_medal_email_header"]);
					$body = str_replace("[medal]", $place, $options["instant_winners_gain_medal_email"]);
					$headers = array('Content-Type: text/html; charset=UTF-8');
					$mailer = WC()->mailer();
					$wrapped_message = $mailer->wrap_message($header, $body);
					$wc_email = new WC_Email;
					$html_message = $wc_email->style_inline($wrapped_message);
					$mailer->send($order->get_billing_email(), $subject, $html_message, $headers);
				}
				$place = "";
				if(array_keys($old_totals)[0] != array_keys($new_totals)[0] && intval(array_keys($old_totals)[0]) == get_current_user_id()) {
					$place = "gold";
				}
				if(array_keys($old_totals)[1] != array_keys($new_totals)[1] && intval(array_keys($old_totals)[1]) == get_current_user_id()) {
					$place = "silver";
				}
				if(array_keys($old_totals)[2] != array_keys($new_totals)[2] && intval(array_keys($old_totals)[2]) == get_current_user_id()) {
					$place = "bronze";
				}

				if($place != "") {
					$subject = str_replace("[medal]", $place, $options["instant_winners_lose_medal_email_subject"]);
					$header = str_replace("[medal]", $place, $options["instant_winners_lose_medal_email_header"]);
					$body = str_replace("[medal]", $place, $options["instant_winners_lose_medal_email"]);
					$headers = array('Content-Type: text/html; charset=UTF-8');
					$mailer = WC()->mailer();
					$wrapped_message = $mailer->wrap_message($header, $body);
					$wc_email = new WC_Email;
					$html_message = $wc_email->style_inline($wrapped_message);
					$mailer->send($order->get_billing_email(), $subject, $html_message, $headers);
				}
			}
		}
	}
}

function map_wins($win) {
		return "<b>" . $win['prize'] . "</b><br/>Ticket number " . $win['ticket'] . "<br/>";
	}