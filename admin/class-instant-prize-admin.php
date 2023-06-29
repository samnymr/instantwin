<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rightglobalgroup.com/
 * @since      4.1.0
 *
 * @package    Instant_Prize
 * @subpackage Instant_Prize/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Instant_Prize
 * @subpackage Instant_Prize/admin
 * @author     Right Global Group <info@rightglobalgroup.com>
 */
class Instant_Prize_Admin {

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
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    4.1.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/instant-prize-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/instant-prize-admin.js', array( 'jquery', 'wp-color-picker' ), false, false );

	}
	
	public function create_winners_page() {
		add_menu_page(
			__( 'Instant Winners', 'winners-page' ),
			__( 'Instant Winners', 'winners-menu' ),
			'manage_options',
			'instant-winners',
			'winners_page',
			'dashicons-tickets',
			3
		);
		
		add_submenu_page('instant-winners', "Options", "Options", "manage_options", "instant-winners-options", "instant_winners_options_page", 2);
	}
	
	public function competition_coupons() {

	$cc_meta = get_post_meta(get_the_ID(), 'cc_product_meta', true);

    $coupon_codes = []; // Initializing

    foreach( $cc_meta as $cc) {
		$start_ts = strtotime($cc['start_date']);
		$end_ts = strtotime($cc['end_date']);
		$current_ts = time();
		$coupon_post = get_post($cc['coupon']);
		if(($current_ts >= $start_ts) && ($end_ts > $current_ts)) {
			$coupon_codes[] = '<div class="competition-coupon"><span class="cc-code">' . $coupon_post->post_name . '</span><p class="cc-description">' . $cc['description'] . '<br><b>Ends in <span class="cc-expires" data-expires="' . $end_ts . '"></span></b></p></div>';
		}
    }

    // Display available coupon codes
    return '<div class="competition-coupons"><div class="competition-coupon"><h4 class="cc-title">Coupons</h4></div>' . implode('', $coupon_codes) . '</div>';
}
	
	public function settings_init() {
		register_setting( 'instant-winners', 'instant-winners_settings' );

		add_settings_section(
			'instant_winners_pluginPage_section', 
			__( 'Instant Winners options', 'instant-winners' ), 
			'instant-winners_settings_section_callback', 
			'instant-winners'
		);

		add_settings_field( 
			'instant_winners_overlay_colour', 
			__( 'Overlay Colour', 'instant-winners' ), 
			'instant_winners_overlay_colour', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		add_settings_field( 
			'instant_winners_box_colour', 
			__( 'Box Colour', 'instant-winners' ), 
			'instant_winners_box_colour', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		add_settings_field( 
			'instant_winners_title_colour', 
			__( 'Title Colour', 'instant-winners' ), 
			'instant_winners_title_colour', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		add_settings_field( 
			'instant_winners_text_colour', 
			__( 'Text Colour', 'instant-winners' ), 
			'instant_winners_text_colour', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		add_settings_field( 
			'instant_winners_button_colour', 
			__( 'Button Colour', 'instant-winners' ), 
			'instant_winners_button_colour', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		add_settings_field( 
			'instant_winners_button_text_colour', 
			__( 'Button Text Colour', 'instant-winners' ), 
			'instant_winners_button_text_colour', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		add_settings_field( 
			'instant_winners_button_text_colour', 
			__( 'Button Text Colour', 'instant-winners' ), 
			'instant_winners_button_text_colour', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
// 		add_settings_field( 
// 			'instant_winners_credit_email_heading', 
// 			__( 'Credit Email Heading', 'instant-winners' ), 
// 			'instant_winners_credit_email_heading', 
// 			'instant-winners', 
// 			'instant_winners_pluginPage_section' 
// 		);
// 		add_settings_field( 
// 			'instant_winners_debit_email_heading', 
// 			__( 'Debit Email Heading', 'instant-winners' ), 
// 			'instant_winners_debit_email_heading', 
// 			'instant-winners', 
// 			'instant_winners_pluginPage_section' 
// 		);
// 		add_settings_field( 
// 			'instant_winners_credit_email_start', 
// 			__( 'Credit Email Start', 'instant-winners' ), 
// 			'instant_winners_credit_email_start', 
// 			'instant-winners', 
// 			'instant_winners_pluginPage_section' 
// 		);
// 		add_settings_field( 
// 			'instant_winners_debit_email_start', 
// 			__( 'Debit Email Start', 'instant-winners' ), 
// 			'instant_winners_debit_email_start', 
// 			'instant-winners', 
// 			'instant_winners_pluginPage_section' 
// 		);
// 		add_settings_field( 
// 			'instant_winners_credit_email_action', 
// 			__( 'Credit Email Action', 'instant-winners' ), 
// 			'instant_winners_credit_email_action', 
// 			'instant-winners', 
// 			'instant_winners_pluginPage_section' 
// 		);
// 		add_settings_field( 
// 			'instant_winners_debit_email_action', 
// 			__( 'Debit Email Action', 'instant-winners' ), 
// 			'instant_winners_debit_email_action', 
// 			'instant-winners', 
// 			'instant_winners_pluginPage_section' 
// 		);
// 		add_settings_field( 
// 			'instant_winners_credit_email_current_balance', 
// 			__( 'Credit Email Current Balance', 'instant-winners' ), 
// 			'instant_winners_credit_email_current_balance', 
// 			'instant-winners', 
// 			'instant_winners_pluginPage_section' 
// 		);
// 		add_settings_field( 
// 			'instant_winners_debit_email_current_balance', 
// 			__( 'Debit Email Current Balance', 'instant-winners' ), 
// 			'instant_winners_debit_email_current_balance', 
// 			'instant-winners', 
// 			'instant_winners_pluginPage_section' 
// 		);
// 		add_settings_field( 
// 			'instant_winners_order_email_text', 
// 			__( 'Order Email Text', 'instant-winners' ), 
// 			'instant_winners_order_email_text', 
// 			'instant-winners', 
// 			'instant_winners_pluginPage_section' 
// 		);
		add_settings_field( 
			'instant_winners_email_heading', 
			__( 'Email Heading', 'instant-winners' ), 
			'instant_winners_email_heading', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		add_settings_field( 
			'instant_winners_email_intro', 
			__( 'Email Intro', 'instant-winners' ), 
			'instant_winners_email_intro', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		add_settings_field( 
			'instant_winners_email_outro', 
			__( 'Email Outro', 'instant-winners' ), 
			'instant_winners_email_outro', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		add_settings_field( 
			'instant_winners_gain_medal_email_subject', 
			__( 'Gain Medal Email Subject', 'instant-winners' ), 
			'instant_winners_gain_medal_email_subject', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		add_settings_field( 
			'instant_winners_gain_medal_email_header', 
			__( 'Gain Medal Email Header', 'instant-winners' ), 
			'instant_winners_gain_medal_email_header', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		add_settings_field( 
			'instant_winners_gain_medal_email', 
			__( 'Gain Medal Email', 'instant-winners' ), 
			'instant_winners_gain_medal_email', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		add_settings_field( 
			'instant_winners_lose_medal_email_subject', 
			__( 'Lose Medal Email Subject', 'instant-winners' ), 
			'instant_winners_lose_medal_email_subject', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		add_settings_field( 
			'instant_winners_lose_medal_email_header', 
			__( 'Lose Medal Email Header', 'instant-winners' ), 
			'instant_winners_lose_medal_email_header', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		add_settings_field( 
			'instant_winners_lose_medal_email', 
			__( 'Lose Medal Email', 'instant-winners' ), 
			'instant_winners_lose_medal_email', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		add_settings_field( 
			'instant_winners_instant_win_points', 
			__( 'Instant Win Points', 'instant-winners' ), 
			'instant_winners_instant_win_points', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		add_settings_field( 
			'instant_winners_competition_win_points', 
			__( 'Competition Win Points', 'instant-winners' ), 
			'instant_winners_competition_win_points', 
			'instant-winners', 
			'instant_winners_pluginPage_section' 
		);
		
		$options = get_option( 'instant-winners_settings' );
		if($options['instant_winners_overlay_colour'] == false) {
			$options['instant_winners_overlay_colour'] = "rgba(0,0,0,.4)";
		}
		if($options['instant_winners_box_colour'] == false) {
			$options['instant_winners_box_colour'] = "#0a0a0a";
		}
		if($options['instant_winners_title_colour'] == false) {
			$options['instant_winners_title_colour'] = "#FFFFFF";
		}
		if($options['instant_winners_text_colour'] == false) {
			$options['instant_winners_text_colour'] = "#FFFFFF";
		}
		if($options['instant_winners_button_colour'] == false) {
			$options['instant_winners_button_colour'] = "#ec5b0b";
		}
		if($options['instant_winners_button_text_colour'] == false) {
			$options['instant_winners_button_text_colour'] = "#FFFFFF";
		}
// 		if($options['instant_winners_credit_email_start'] == false) {
// 			$options['instant_winners_credit_email_start'] = "Thank you for using your wallet.";
// 		}
// 		if($options['instant_winners_debit_email_start'] == false) {
// 			$options['instant_winners_debit_email_start'] = "Thank you for using your wallet.";
// 		}
// 		if($options['instant_winners_credit_email_action'] == false) {
// 			$options['instant_winners_credit_email_action'] = "has been credited to your wallet.";
// 		}
// 		if($options['instant_winners_debit_email_action'] == false) {
// 			$options['instant_winners_debit_email_action'] = "has been debited from your wallet.";
// 		}
// 		if($options['instant_winners_credit_email_current_balance'] == false) {
// 			$options['instant_winners_credit_email_current_balance'] = "Current wallet balance is";
// 		}
// 		if($options['instant_winners_debit_email_current_balance'] == false) {
// 			$options['instant_winners_debit_email_current_balance'] = "Current wallet balance is";
// 		}
// 		if($options['instant_winners_order_email_text'] == false) {
// 			$options['instant_winners_order_email_text'] = "We have finished processing your order.";
// 		}
		if($options['instant_winners_email_heading'] == false) {
			$options['instant_winners_email_heading'] = "Congratulations - You have won a prize!";
		}
		if($options['instant_winners_email_intro'] == false) {
			$options['instant_winners_email_intro'] = "We are delighted to inform you that you have won an Instant Win prize!";
		}
		if($options['instant_winners_email_outro'] == false) {
			$options['instant_winners_email_outro'] = "Enjoy!";
		}
		if($options['instant_winners_gain_medal_email_subject'] == false) {
			$options['instant_winners_gain_medal_email_subject'] = "You are now a [medal] medalist!";
		}
		if($options['instant_winners_gain_medal_email_header'] == false) {
			$options['instant_winners_gain_medal_email_header'] = "Congratulations!";
		}
		if($options['instant_winners_gain_medal_email'] == false) {
			$options['instant_winners_gain_medal_email'] = "You are now a [medal] medalist!";
		}
		if($options['instant_winners_lose_medal_email_subject'] == false) {
			$options['instant_winners_lose_medal_email_subject'] = "You've lost your [medal] medal!";
		}
		if($options['instant_winners_lose_medal_email_header'] == false) {
			$options['instant_winners_lose_medal_email_header'] = "Bad luck!";
		}
		if($options['instant_winners_lose_medal_email'] == false) {
			$options['instant_winners_lose_medal_email'] = "You've lost your [medal] medal'";
		}
		if($options['instant_winners_instant_win_points'] == false) {
			$options['instant_winners_instant_win_points'] = 1;
		}
		if($options['instant_winners_competition_win_points'] == false) {
			$options['instant_winners_competition_win_points'] = 1;
		}
		update_option('instant-winners_settings', $options);
	}
	
	public function cc_add_meta_boxes() {
    	add_meta_box( 'cc-product', 'Competition Coupons', 'cc_product_meta', 'product', 'normal', 'default');
	}
	
	public function cc_product_meta_save($post_id) {
    if ( ! isset( $_POST['cc_product_meta_nonce'] ) ||
    ! wp_verify_nonce( $_POST['cc_product_meta_nonce'], 'cc_product_meta_nonce' ) )
        return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    $old = get_post_meta($post_id, 'cc_product_meta', true);
    $new = array();
    $couponItems = $_POST['coupon'];
    $start_dates = $_POST['start_date'];
    $end_dates = $_POST['end_date'];
    $descriptions = $_POST['description'];
     $count = count( $couponItems );
     for ( $i = 0; $i < $count; $i++ ) {
        if ( $couponItems[$i] != '' ) :
            $new[$i]['coupon'] = $couponItems[$i];
             $new[$i]['start_date'] = $start_dates[$i];
             $new[$i]['end_date'] = $end_dates[$i];
             $new[$i]['description'] = $descriptions[$i];
        endif;
    }
    if ( !empty( $new ) && $new != $old ) {
        update_post_meta( $post_id, 'cc_product_meta', $new );
		foreach ($new as $cc) {
			$start_ts = strtotime($cc['start_date']);
			$end_ts = strtotime($cc['end_date']);
			$current_ts = time();
			$coupon = new WC_Coupon($cc['coupon']);
			if($start_ts > $current_ts) {
				if($coupon->get_status() == "publish") {
					wp_update_post(array(
						'ID' => $cc['coupon'],
						'post_status' => 'draft'
					));
				}
			} elseif(($current_ts >= $start_ts) && ($end_ts > $current_ts)) {
				if($coupon->get_status() == "draft") {
					wp_update_post(array(
						'ID' => $cc['coupon'],
						'post_status' => 'publish'
					));
				}
				$coupon_products = (array) $coupon->get_product_ids();
				if(!in_array($post_id, $coupon_products)) {
					$coupon_products[] = $post_id;
					$coupon->set_product_ids($coupon_products);
					$coupon->save();
				}
			} elseif($current_ts >= $end_ts) {
				$coupon_products = (array) $coupon->get_product_ids();
				if(in_array($post_id, $coupon_products)) {
					$coupon_products = array_filter($coupon_products, function($p) {
						return $p != $post_id;
					});
					$coupon->set_product_ids($coupon_products);
					$coupon->save();
					if(count($coupon_products) == 0) {
						if($coupon->get_status() == "publish") {
							wp_update_post(array(
								'ID' => $cc['coupon'],
								'post_status' => 'draft'
							));
						}
					}
				}
			}
		}
	} elseif ( empty($new) && $old ) {
        delete_post_meta( $post_id, 'cc_product_meta', $old );
	}

}
	
	public function cc_schedule_cron() {
		if(!wp_next_scheduled('cc_cron')) {
			wp_schedule_event(time(), 'daily', 'cc_cron');
		}
	}
	
	public function cc_cron() {
		$products = new WP_Query(array(
			'post_type' => 'product',
			'posts_per_page' => -1
		));
		
		foreach($products as $product) {
			$cc_meta = get_post_meta($product->ID, 'cc_product_meta', true);
			$post_id = $product->ID;
			if($cc_meta) {
				foreach ($cc_meta as $cc) {
					$start_ts = strtotime($cc['start_date']);
					$end_ts = strtotime($cc['end_date']);
					$current_ts = time();
					$coupon = new WC_Coupon($cc['coupon']);
					if($start_ts > $current_ts) {
						if($coupon->get_status() == "publish") {
							wp_update_post(array(
								'ID' => $cc['coupon'],
								'post_status' => 'draft'
							));
						}
					} elseif(($current_ts >= $start_ts) && ($end_ts > $current_ts)) {
						if($coupon->get_status() == "draft") {
							wp_update_post(array(
								'ID' => $cc['coupon'],
								'post_status' => 'publish'
							));
						}
						$coupon_products = (array) $coupon->get_product_ids();
						if(!in_array($post_id, $coupon_products)) {
							$coupon_products[] = $post_id;
							$coupon->set_product_ids($coupon_products);
							$coupon->save();
						}
					} elseif($current_ts >= $end_ts) {
						$coupon_products = (array) $coupon->get_product_ids();
						if(in_array($post_id, $coupon_products)) {
							$coupon_products = array_filter($coupon_products, function($p) {
								return $p != $post_id;
							});
							$coupon->set_product_ids($coupon_products);
							$coupon->save();
							if(count($coupon_products) == 0) {
								if($coupon->get_status() == "publish") {
									wp_update_post(array(
										'ID' => $cc['coupon'],
										'post_status' => 'draft'
									));
								}
							}
						}
					}
				}
			}
		}
	}
	
	public function mw_product_select() {
			$products = wc_get_products(array(
				'status' => 'publish',
				'type' => 'lottery'
			));
			$product_options = "";
			foreach ($products as $product) {
				if(!metadata_exists('post', $product->get_id(), '_lottery_pn_winners')) {
					$product_options = $product_options . '<option value="' . $product->get_id() . '">' . $product->get_name() . '</option>';
				}
			}
			return '<div class="mw-product-nonce" data-nonce="' . wp_create_nonce("mw_product_nonce") . '"></div><div class="mw-submit-nonce" data-nonce="' . wp_create_nonce("mw_submit_nonce") . '"></div><label for="mw_competition">Competition</label><select id="mw_competition" name="mw_competition">' . $product_options . '</select>';
		}

		public function mw_submit() {
		$user = wp_get_current_user();
		if ( !wp_verify_nonce( $_REQUEST['nonce'], "mw_submit_nonce") || !in_array("administrator", $user->roles)) {
		  exit();
		}

		$post_id = $_REQUEST["product_id"];
		$product = wc_get_product($post_id);
			
		if(metadata_exists('post', $post_id, '_lottery_pn_winners')) {
			exit();
		}

		// Retrieve the current winners from the product meta
		$old_lotery_winners = get_post_meta( $post_id, '_lottery_winners', true );

		// Delete the current winners
		delete_post_meta( $post_id, '_lottery_winners' );

		// Define the number of winners and initialize the arrays
		$lottery_num_winners = 1;
		$winners = array();
		$pn_winners = array();
		$losers = array();

		// Define the winner manually by ID or by pick number
		$i = 1;
		$no_ticket = false;
		while ( $i <= $lottery_num_winners ) {
			// Set the winner ID or pick number here
			$winner_id_or_pick_num = $_REQUEST["winner"];

			// If using pick numbers, retrieve the user ID and log by pick number
			$winners[ $i ] = Wc_Lottery_Pn_Admin::get_user_id_by_ticket_number( intval( $winner_id_or_pick_num ), $post_id );

			if($winners[$i] == 0) {
				$no_ticket = true;
			} else {
				$pn_winners [ $i ] = Wc_Lottery_Pn_Admin::get_log_by_ticket_number( intval( $winner_id_or_pick_num ), $post_id );

					// Save the winner to the product meta
			update_post_meta( $post_id, '_lottery_manualy_winner_' . $i, $winner_id_or_pick_num );
			}


			$i++;
		}
			
			if(Wc_Lottery_Pn_Admin::get_user_id_by_ticket_number( intval( $winner_id_or_pick_num - 2 ), $post_id ) != 0) {
					$loser_1 = Wc_Lottery_Pn_Admin::get_log_by_ticket_number( intval( $winner_id_or_pick_num ) - 2, $post_id );
					$l1_order = wc_get_order($loser_1["order_id"]);
					$losers[0] = $l1_order->get_billing_first_name();
				}
				if(Wc_Lottery_Pn_Admin::get_user_id_by_ticket_number( intval( $winner_id_or_pick_num - 1 ), $post_id ) != 0) {
					$loser_2 = Wc_Lottery_Pn_Admin::get_log_by_ticket_number( intval( $winner_id_or_pick_num ) - 1, $post_id );
					$l2_order = wc_get_order($loser_2["order_id"]);
					$losers[1] = $l2_order->get_billing_first_name();
				}
				if(Wc_Lottery_Pn_Admin::get_user_id_by_ticket_number( intval( $winner_id_or_pick_num + 1 ), $post_id ) != 0) {
					$loser_3 = Wc_Lottery_Pn_Admin::get_log_by_ticket_number( intval( $winner_id_or_pick_num ) + 1, $post_id );
					$l3_order = wc_get_order($loser_3["order_id"]);
					$losers[2] = $l3_order->get_billing_first_name();
				}
				if(Wc_Lottery_Pn_Admin::get_user_id_by_ticket_number( intval( $winner_id_or_pick_num + 2 ), $post_id ) != 0) {
					$loser_4 = Wc_Lottery_Pn_Admin::get_log_by_ticket_number( intval( $winner_id_or_pick_num ) + 2, $post_id );
					$l4_order = wc_get_order($loser_4["order_id"]);
					$losers[3] = $l4_order->get_billing_first_name();
				}

		if($no_ticket == false) {
			// Save the winners to the product meta
			update_post_meta( $post_id, '_lottery_winners', $winners );
			update_post_meta( $post_id, '_lottery_pn_winners', $pn_winners );
			foreach ( $winners as $key => $userid ) {
				add_post_meta( $post_id, '_lottery_winners', $userid );
				add_user_meta( $userid, '_lottery_win', $post_id );
				add_user_meta( $userid, '_lottery_win_' . $post_id . '_position', $key );
			}

			if ( $old_lotery_winners !== get_post_meta( $post_id, '_lottery_winners' ) ) {
				do_action('wc_lottery_close', $post_id);
				do_action('wc_lottery_won', $post_id);
			}

			$pn_first = reset($pn_winners);
			$order = wc_get_order($pn_first["order_id"]);
			$first = $order->get_billing_first_name();

			$result['success'] = true;
			$result['first'] = $first;
			$result['losers'] = $losers;
			
			$winner_post = wp_insert_post(array(
				"post_title" => $product->get_name(),
				"post_status" => "publish",
				"post_type" => "winners"
			));
			update_field("competition_name", $product->get_name(), $winner_post);
			update_field("competition_winner", $first, $winner_post);
			update_field("ticket_number", $_REQUEST["winner"], $winner_post);
			update_field("winner_image", $product->get_image_id(), $winner_post);
			update_field("draw_date", date("d/m/Y"), $winner_post);
		} else {
			$result['success'] = false;
			$result['losers'] = $losers;
		}

		echo json_encode($result);

		die();
	}
	
	public function mw_product() {
		$user = wp_get_current_user();
		if ( !wp_verify_nonce( $_REQUEST['nonce'], "mw_product_nonce") || !in_array("administrator", $user->roles)) {
		  exit();
		}

		// Get the product ID from the AJAX request
		$product_id = $_REQUEST['product_id'];
		
		if(metadata_exists('post', $product_id, '_lottery_pn_winners')) {
			exit();
		}
		
		$max_tickets = get_post_meta($product_id, "_max_tickets", true);

		// Get the product object
		$product = wc_get_product($product_id);

		// Prepare the product data to return
		$product_data = array(
			'name' => $product->get_name(),
			'image' => wp_get_attachment_url($product->get_image_id()),
			'max_tickets' => $max_tickets
		);

		// Return the product data as JSON
		echo json_encode($product_data);

		die();
	}
	
	public function winners_post_type() {

		/**
		 * Post Type: Winners.
		 */

		$labels = [
			"name" => esc_html__( "Winners", "hello-elementor-child" ),
			"singular_name" => esc_html__( "Winner", "hello-elementor-child" ),
		];

		$args = [
			"label" => esc_html__( "Winners", "hello-elementor-child" ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"rest_namespace" => "wp/v2",
			"has_archive" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => true,
			"can_export" => false,
			"rewrite" => [ "slug" => "winners", "with_front" => true ],
			"query_var" => true,
			"menu_position" => 3,
			"menu_icon" => "dashicons-format-image",
			"supports" => [ "title", "thumbnail" ],
			"show_in_graphql" => false,
		];

		register_post_type( "winners", $args );
	}
	
	public function winners_acf_fields() {
		if ( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_629f6381365d1',
				'title' => 'Winners',
				'fields' => array(
					array(
						'key' => 'field_629f6383ea7b5',
						'label' => 'Competition Name',
						'name' => 'competition_name',
						'aria-label' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_629f6398ea7b6',
						'label' => 'Competition Winner',
						'name' => 'competition_winner',
						'aria-label' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_629f63a4ea7b7',
						'label' => 'Ticket Number',
						'name' => 'ticket_number',
						'aria-label' => '',
						'type' => 'text',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_629f63b5ea7b8',
						'label' => 'Link to Draw',
						'name' => 'link_to_draw',
						'aria-label' => '',
						'type' => 'url',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
					),
					array(
						'key' => 'field_629f63cbea7b9',
						'label' => 'Winner Image',
						'name' => 'winner_image',
						'aria-label' => '',
						'type' => 'image',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'return_format' => 'array',
						'preview_size' => 'medium',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
					),
					array(
						'key' => 'field_642ed5390d02b',
						'label' => 'Draw Date',
						'name' => 'draw_date',
						'aria-label' => '',
						'type' => 'date_picker',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'display_format' => 'd/m/Y',
						'return_format' => 'd/m/Y',
						'first_day' => 1,
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'winners',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
				'show_in_rest' => 0,
			));

			endif;


	}
}

function winners_page() {
		?>
			<h1>
				Instant winners
			</h1>
			<table>
			  <tr>
				<th>Order ID</th>
				<th>Customer name</th>
				<th>Competition</th>
				<th>Prize</th>
				<th>Date/time</th>
			  </tr>
		<?php
	
		$orders = wc_get_orders(array(
			'status' => array('wc-completed'),
			'limit' => -1,
			'date_created' => '>=' . date('y-m-d', strtotime('-4 days'))
		));
	
		foreach ($orders as $order) {
			foreach ( $order->get_items() as $item_id => $item ) {
				$product = $item->get_product();
				$winners = get_post_meta($item->get_product_id(), '_lottery_instant_instant_winners');
				$order_wins = array_filter($winners, function($w) use ($order) {
					return $w['order_id'] == $order->get_id();
				});
				foreach($order_wins as $win) {
					?>
									<tr>
										<td><a href="<?php echo get_edit_post_link($order->get_id()); ?>"><?php echo $order->get_id(); ?></a></td>
										<td><?php echo $order->get_formatted_billing_full_name(); ?></td>
										<td><a href="<?php echo get_edit_post_link($product->get_id()); ?>"><?php echo $product->get_name(); ?></a></td>
										<td><?php echo $win['prize']; ?></td>
										<td><?php echo $order->get_date_created(); ?></td>
									</tr>
								<?php
				}
			}
		}
		?>
			</table>	
		<?php
		
	}

function instant_winners_options_page() {
	?>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'instant-winners' );
			do_settings_sections( 'instant-winners' );
			submit_button();
			?>
	</form>
<?php
}

function instant_winners_overlay_colour(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input class="iwcolor" type='text' name='instant-winners_settings[instant_winners_overlay_colour]' value='<?php echo $options['instant_winners_overlay_colour']; ?>'>
	<?php

}

function instant_winners_box_colour(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input class="iwcolor" type='text' name='instant-winners_settings[instant_winners_box_colour]' value='<?php echo $options['instant_winners_box_colour']; ?>'>
	<?php

}

function instant_winners_title_colour(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input class="iwcolor" type='text' name='instant-winners_settings[instant_winners_title_colour]' value='<?php echo $options['instant_winners_title_colour']; ?>'>
	<?php

}

function instant_winners_text_colour(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input class="iwcolor" type='text' name='instant-winners_settings[instant_winners_text_colour]' value='<?php echo $options['instant_winners_text_colour']; ?>'>
	<?php

}

function instant_winners_button_colour(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input class="iwcolor" type='text' name='instant-winners_settings[instant_winners_button_colour]' value='<?php echo $options['instant_winners_button_colour']; ?>'>
	<?php

}

function instant_winners_button_text_colour(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input class="iwcolor" type='text' name='instant-winners_settings[instant_winners_button_text_colour]' value='<?php echo $options['instant_winners_button_text_colour']; ?>'>
	<?php

}

function instant_winners_credit_email_heading(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input type='text' style="width: 300px;" name='instant-winners_settings[instant_winners_credit_email_heading]' value='<?php echo $options['instant_winners_credit_email_heading']; ?>'>
	<?php

}

function instant_winners_debit_email_heading(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input type='text' style="width: 300px;" name='instant-winners_settings[instant_winners_debit_email_heading]' value='<?php echo $options['instant_winners_debit_email_heading']; ?>'>
	<?php

}

function instant_winners_credit_email_start(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input type='text' style="width: 300px;" name='instant-winners_settings[instant_winners_credit_email_start]' value='<?php echo $options['instant_winners_credit_email_start']; ?>'>
	<?php

}

function instant_winners_debit_email_start(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input type='text' style="width: 300px;" name='instant-winners_settings[instant_winners_debit_email_start]' value='<?php echo $options['instant_winners_debit_email_start']; ?>'>
	<?php

}

function instant_winners_credit_email_action(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input type='text' style="width: 300px;" name='instant-winners_settings[instant_winners_credit_email_action]' value='<?php echo $options['instant_winners_credit_email_action']; ?>'>
	<?php

}

function instant_winners_debit_email_action(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input type='text' style="width: 300px;" name='instant-winners_settings[instant_winners_debit_email_action]' value='<?php echo $options['instant_winners_debit_email_action']; ?>'>
	<?php

}

function instant_winners_credit_email_current_balance(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input type='text' style="width: 300px;" name='instant-winners_settings[instant_winners_credit_email_current_balance]' value='<?php echo $options['instant_winners_credit_email_current_balance']; ?>'>
	<?php

}

function instant_winners_debit_email_current_balance(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input type='text' style="width: 300px;" name='instant-winners_settings[instant_winners_debit_email_current_balance]' value='<?php echo $options['instant_winners_debit_email_current_balance']; ?>'>
	<?php

}

function instant_winners_order_email_text(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input type='text' style="width: 300px;" name='instant-winners_settings[instant_winners_order_email_text]' value='<?php echo $options['instant_winners_order_email_text']; ?>'>
	<?php

}


function instant_winners_email_heading(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input type='text' style="width: 500px;" name='instant-winners_settings[instant_winners_email_heading]' value='<?php echo $options['instant_winners_email_heading']; ?>'>
	<?php

}

function instant_winners_email_intro(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<textarea style="width: 500px;" name='instant-winners_settings[instant_winners_email_intro]'><?php echo $options['instant_winners_email_intro']; ?></textarea>
	<?php

}


function instant_winners_email_outro(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<textarea style="width: 500px;" name='instant-winners_settings[instant_winners_email_outro]'><?php echo $options['instant_winners_email_outro']; ?></textarea>
	<?php

}

function instant_winners_gain_medal_email_subject(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input type="text" style="width: 500px;" name='instant-winners_settings[instant_winners_gain_medal_email_subject]' value="<?php echo $options['instant_winners_gain_medal_email_subject']; ?>" /><br/>
<small style="display: flex;">Replace the medal type with <pre style="margin: 0 0 0 4px;">[medal]</pre></small>
	<?php

}

function instant_winners_gain_medal_email_header(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input type="text" style="width: 500px;" name='instant-winners_settings[instant_winners_gain_medal_email_header]' value="<?php echo $options['instant_winners_gain_medal_email_header']; ?>" /><br/>
<small style="display: flex;">Replace the medal type with <pre style="margin: 0 0 0 4px;">[medal]</pre></small>
	<?php

}

function instant_winners_gain_medal_email(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<textarea style="width: 500px;" name='instant-winners_settings[instant_winners_gain_medal_email]'><?php echo $options['instant_winners_gain_medal_email']; ?></textarea><br/>
<small style="display: flex;">Replace the medal type with <pre style="margin: 0 0 0 4px;">[medal]</pre></small>
	<?php

}

function instant_winners_lose_medal_email_subject(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input type="text" style="width: 500px;" name='instant-winners_settings[instant_winners_lose_medal_email_subject]' value="<?php echo $options['instant_winners_lose_medal_email_subject']; ?>" /><br/>
<small style="display: flex;">Replace the medal type with <pre style="margin: 0 0 0 4px;">[medal]</pre></small>
	<?php

}

function instant_winners_lose_medal_email_header(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input type="text" style="width: 500px;" name='instant-winners_settings[instant_winners_lose_medal_email_header]' value="<?php echo $options['instant_winners_lose_medal_email_header']; ?>" /><br/>
<small style="display: flex;">Replace the medal type with <pre style="margin: 0 0 0 4px;">[medal]</pre></small>
	<?php

}

function instant_winners_lose_medal_email(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<textarea style="width: 500px;" name='instant-winners_settings[instant_winners_lose_medal_email]'><?php echo $options['instant_winners_lose_medal_email']; ?></textarea><br/>
<small style="display: flex;">Replace the medal type with <pre style="margin: 0 0 0 4px;">[medal]</pre></small>
	<?php

}

function instant_winners_instant_win_points(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input type="number" style="width: 500px;" name='instant-winners_settings[instant_winners_instant_win_points]' value="<?php echo $options['instant_winners_instant_win_points']; ?>" />
	<?php

}

function instant_winners_competition_win_points(  ) { 

	$options = get_option( 'instant-winners_settings' );
	?>
	<input type="number" style="width: 500px;" name='instant-winners_settings[instant_winners_competition_win_points]' value="<?php echo $options['instant_winners_competition_win_points']; ?>" />
	<?php

}

function instant_winners_settings_section_callback(  ) { 

	echo __( 'Instant Winners Options', 'instant-winners' );

}