<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       cedcommerce
 * @since      1.0.0
 *
 * @package    Wholesale
 * @subpackage Wholesale/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wholesale
 * @subpackage Wholesale/admin
 * author     Sabreen Shakeel <sabreenshakeel@cedcoss.com>
 */
class Wholesale_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wholesale_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wholesale_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wholesale-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wholesale_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wholesale_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wholesale-admin.js', array( 'jquery' ), $this->version, false );

	}


		
	/**
	 * add_settings_tab
	 * 
	 * Description : This function is used for add Wholesale Market setting tab
	 * @since : 1.0.0
	 * @version : 1.0
	 * @param  mixed $settings_tabs
	 * @return void
	 */
	public static function add_settings_tab( $settings_tabs ) {
		$settings_tabs['settings_tab_demo'] = __( 'Wholesale Market', 'woocommerce-settings-tab-demo' );
		return $settings_tabs;
	}
		
	/**
	 * ced_add_setting_section
	 * 
	 * Description : Create the section beneath the Wholesale Market tab
	 * @since : 1.0.0
	 * @version : 1.0
	 * @param  mixed $sections
	 * @return void
	 */
	public function ced_add_setting_section( $sections ) {
		
		global $current_section;

		$sections = array(
			''         => __( 'General', 'my-textdomain' ),
			'inventory' => __( 'Inventory', 'my-textdomain' )
		);

		if ( empty( $sections ) || 1 === count( $sections ) ) {
			return;
		}

		echo '<ul class="subsubsub">';

		$array_keys = array_keys( $sections );

		foreach ( $sections as $id => $label ) {
			// print_r($sections);
			echo '<li><a href="' . esc_url(admin_url( 'admin.php?page=wc-settings&tab=settings_tab_demo &section=' . sanitize_title( $id ) ) ) . '" class="' . ( $current_section == $id ? 'current' : '' ) . '">' . esc_html($label) . '</a> ' . ( end( $array_keys ) == $id ? '' : '|' ) . ' </li>';
		}

		echo '</ul><br class="clear" />';
	}



	/**
	 * Get settings array
	 *
	 * @since 1.0.0
	 * @param string $current_section Optional. Defaults to empty string.
	 * @return array Array of settings
 	*/
	public function ced_get_settings( $current_section = '' ) {
		
		if ( '' == $current_section ) {
			
			$settings =  array(
				
				array(
					'name' => __( 'Price Settings', 'my-textdomain' ),
					'type' => 'title',
					'desc' => '',
					'id'   => 'myplugin_group1_options',
				),
					
				array(
					'type'     => 'checkbox',
					'id'       => 'myplugin_checkbox_1',
					'name'     => __( 'Pricing setting', 'my-textdomain' ),
					'desc'     => __( 'Enable wholesale pricing setting', 'my-textdomain' ),
					'default'  => 'no',
				),

				array(
					'title'    => __( 'Display wholesale price', 'woocommerce' ),
					'id'       => 'woocommerce_prices_include_tax',
					'default'  => 'no',
					'type'     => 'radio',
					'desc_tip' => __( 'This option is important as it will show the wholesale price to whom you select.', 'woocommerce' ),
					'options'  => array(
						'yes' => __( 'Display wholesale price to all users ', 'woocommerce' ),
						'no'  => __( 'Display wholesale price to only wholesale customer', 'woocommerce' ),
					),
				),
					
				array(
					'type' => 'sectionend',
					'id'   => 'myplugin_group1_options'
				),
						
				array(
					'name' => __( 'Wholesale Text', 'my-textdomain' ),
					'type' => 'title',
					'desc' => '',
					'id'   => 'myplugin_group2_options',
				),

				array(
					'title'       => __( 'Text for wholesale price', 'woocommerce' ),
					'id'          => 'woocommerce_wholesale_text',
					'type'        => 'text',
					'default'     => '',
					'class'       => '',
					'css'         => '',
					'placeholder' => __( 'Enter text', 'woocommerce' ),
					'desc_tip'    => __( 'Text Field to store what text should be shown with Wholesale Price.', 'woocommerce' ),
				),
						
				
				array(
					'type' => 'sectionend',
					'id'   => 'myplugin_group2_options'
				),
				
			) ;
				
		} else {
				
			$settings =  array(
			
				array(
					'name' => __( 'Important Stuff', 'my-textdomain' ),
					'type' => 'title',
					'desc' => '',
					'id'   => 'myplugin_important_options',
				),
					
				array(
					'type'     => 'checkbox',
					'id'       => 'myplugin_inventory_1',
					'name'     => __( 'Pricing setting', 'my-textdomain' ),
					'desc'     => __( 'Enable min. qty setting for applying wholesale price', 'my-textdomain' ),
					'default'  => 'no',
				),

				array(
					'title'    => __( 'Display wholesale price', 'woocommerce' ),
					'id'       => 'woocommerce_prices_include_tax',
					'default'  => 'no',
					'type'     => 'radio',
					'desc_tip' => __( 'This option is important as it will show the min quantity.', 'woocommerce' ),
					'options'  => array(
						'yes' => __( 'Set Min qty on product level ', 'woocommerce' ),
						'no'  => __( 'Set common min qty for all products', 'woocommerce' ),
					),
				),

				array(
					'title'       => __( 'Min. qty for wholesale price', 'woocommerce' ),
					'id'          => 'woocommerce_min_price',
					'type'        => 'text',
					'default'     => '',
					'class'       => '',
					'css'         => '',
					'type'		  => 'number',
					'placeholder' => __( 'Enter text', 'woocommerce' ),
					'desc_tip'    => __( 'Text Field to store min qty for wholesale price.', 'woocommerce' ),
					'custom_attributes' => array(
						'min' => 1
						// 'required' => 'required'
						)
				),
					
				
				array(
					'type' => 'sectionend',
					'id'   => 'myplugin_important_options'
				),
			
			);
			
		}
		return apply_filters( 'woocommerce_get_settings_' , $settings, $current_section );
			
	}

	/**
	 * Output the settings
	 * 
	 * Description : This function is used for displaying the setting tab contents
	 * @since : 1.0.0
	 * @version : 1.0
	 * @since 1.0
	 */
	public function output() {
			
		global $current_section;
				
		$settings = $this->ced_get_settings( $current_section );
		WC_Admin_Settings::output_fields( $settings );
	}

	/**
	 * Save settings
	 * 
	 * Description : This function is used for saving setting tab values into database
	 * @since : 1.0.0
	 * @version : 1.0
	 * @since 1.0
	 */
	public function save() {
			
		global $current_section;
				
		$settings = $this->ced_get_settings( $current_section );
		WC_Admin_Settings::save_fields( $settings );
	}

	// FOR SIMPLE PRODUCT
	
	/**
	 * ced_display_wholesale_field
	 * 
	 * Description : creating custom filelds for simple products 
	 * @since : 1.0.0
	 * @version : 1.0
	 * @return void
	 */
	public function ced_display_wholesale_field() {
		
		global $woocommerce;

		$options = get_option( 'myplugin_checkbox_1' );
		// print_r($options);
		if ('yes' == $options ) {
			woocommerce_wp_text_input(
				array(
					'id'          => 'wholesale_price_save',
					'label'       => __('Wholesale Price <br>(<b>should not be less than 0</b>)', 'woocommerce'),
					'placeholder' => 'Price should not be less than 0',
					'type'        => 'number',
					'desc_tip'    => 'true',
					// 'custom_attributes' => array(
					// 	'min' => 1,
					// 	'required' => 'required'
					// 	)
				)
			);
		} 
		woocommerce_wp_text_input(
			array(
				'id'          => 'wholesale_price_nonce',
				'label'       => '',
				'placeholder' => '',
				'type'        => 'hidden',
				'desc_tip'    => 'true',
				'value' => wp_create_nonce('generate_nonce')
			)
		);
		$product_level_quantity = get_option('woocommerce_prices_include_tax');
		if ('yes' == $product_level_quantity) {
			woocommerce_wp_text_input(
				array(
					'id'          => 'min_quantity',
					'label'       => __('Minimum quantity <br>(<b>should not be less than 0</b>)', 'woocommerce'),
					'placeholder' => 'Quantity should not be less than 0',
					'type'        => 'number',
					'desc_tip'    => 'true',
					// 'custom_attributes' => array(
					// 	'min' => 1,
					// 	'required' => 'required'
					// 	)
				)
			);
		}
		
	}

	
	/**
	 * woocommerce_product_custom_fields_save
	 *
	 * Description : This function is used for saving simple products custom fields values in post meta table
	 * @since : 1.0.0
	 * @version : 1.0
	 * @param  mixed $post_id
	 * @return void
	 */
	public function woocommerce_product_custom_fields_save( $post_id) {

		if (isset( $_POST['wholesale_price_nonce']) && wp_verify_nonce(sanitize_text_field($_POST['wholesale_price_nonce'], 'wholesale_price_nonce'))) {
			
			 // Custom Product Text Field for Wholesale Price
			if (!empty(sanitize_text_field($_POST['wholesale_price_save']))) {
				$woocommerce_custom_product_text_field = sanitize_text_field($_POST['wholesale_price_save']);
			}
			
			if ($woocommerce_custom_product_text_field < 0) {
				
				//add_action( 'admin_notices', array( $this, 'sample_admin_notice__error' ));
				$this->sample_admin_notice__error();
			// echo '<script>alert("Wholesale price simple should not be less than 0")</script>';
			} else {
				
				if (!empty($woocommerce_custom_product_text_field)) {
					update_post_meta($post_id, 'wholesale_price_save', esc_attr($woocommerce_custom_product_text_field));
				}
			}
			
			// Custom Product Text Field for Minimum Quantity

			if (!empty(sanitize_text_field($_POST['min_quantity']))) {
				$woocommerce_custom_product_text_field = sanitize_text_field($_POST['min_quantity']);
			}
			if ($woocommerce_custom_product_text_field < 0) {
				echo '<script>alert("Minimum quantity should not be less than 0")</script>';
			} else {
				if (!empty($woocommerce_custom_product_text_field)) {
					update_post_meta($post_id, 'min_quantity', esc_attr($woocommerce_custom_product_text_field));
				}
			}
		}
	}

	// FOR VARIATION PRODUCT
	
	/**
	 * ced_variation_display_wholesale_field
	 * 
	 * Description : Creating custom fields for variable product
	 * @since : 1.0.0
	 * @version : 1.0
	 *
	 * @param  mixed $loop
	 * @param  mixed $variation_data
	 * @param  mixed $variation
	 * @return void
	 */
	public function ced_variation_display_wholesale_field( $loop, $variation_data, $variation) {

		global $woocommerce;

		$options = get_option( 'myplugin_checkbox_1' );
		// print_r($options);
		if ('yes' == $options) {
			woocommerce_wp_text_input(
				array(
				'id'          => 'variation_wholesale_price_save[' . $loop . ']',
				'value'		  => get_post_meta($variation->ID, 'variation_wholesale_price_save', true),
				'label'       => __('Wholesale Price <br>(<b>should not be less than 0</b>)', 'woocommerce'),
				'placeholder' => 'Price should not be less than 0',
				'desc_tip'    => 'true',
				'type'        => 'number',

				'custom_attributes' => array(
					'min' => 1,
					'required' => 'required'
					)
				)
			);
		}

		woocommerce_wp_text_input(
			array(
				'id'          => 'variation_wholesale_price_save_nonce',
				'label'       => '',
				'placeholder' => '',
				'type'        => 'hidden',
				'desc_tip'    => 'true',
				'value' => wp_create_nonce('generate_variation_nonce')
			)
		);
			
		$product_level_quantity = get_option('woocommerce_prices_include_tax');
		if ('yes' == $product_level_quantity) {
			woocommerce_wp_text_input(
				array(
				'id'          => 'variation_min_quantity[' . $loop . ']',
				'value'		  => get_post_meta($variation->ID, 'variation_min_quantity', true),
				'label'       => __('Minimum quantity <br>(<b>should not be less than 0</b>)', 'woocommerce'),
				'placeholder' => 'Quantity should not be less than 0',
				'type' => 'number',
			
				'desc_tip'    => 'true',
				'custom_attributes' => array(
					'min' => 1,
					'required' => 'required'
					)
				)
			);
		}
	}

	
	/**
	 * woocommerce_variation_custom_fields_save
	 * 
	 * Description : This function is used for saving variation custom fields values in post meta table
	 * @since : 1.0.0
	 * @version : 1.0
	 * @param  mixed $variation_id
	 * @param  mixed $i
	 * @return void
	 */
	public function woocommerce_variation_custom_fields_save( $variation_id, $i) {


		// Custom Product Text Field for Wholesale Price
		if (isset($_POST['variation_wholesale_price_save_nonce']) && wp_verify_nonce(sanitize_text_field($_POST['variation_wholesale_price_save_nonce'], 'variation_wholesale_price_save_nonce'))) {
			if (!empty(sanitize_text_field($_POST['variation_wholesale_price_save']))) {
				$woocommerce_custom_product_text_field = isset($_POST['variation_wholesale_price_save'][$i]) ? sanitize_text_field($_POST['variation_wholesale_price_save'][$i]) : '';
			}

			if ($woocommerce_custom_product_text_field < 0) {
				echo "<script>alert('wholesale price should not be less than 0')</script>";
			} else {
				if (!empty($woocommerce_custom_product_text_field)) {
					update_post_meta($variation_id, 'variation_wholesale_price_save', esc_attr($woocommerce_custom_product_text_field));
				}
			}

			// Custom Product Text Field for Minimum Quantity
			if (!empty(sanitize_text_field($_POST['variation_min_quantity']))) {
				$woocommerce_custom_product_text_field = isset($_POST['variation_min_quantity'][$i]) ? sanitize_text_field($_POST['variation_min_quantity'][$i]) : '';
			}
			if ($woocommerce_custom_product_text_field < 0) {
				echo "<script>alert('Minimum quantity should not be less than 0')</script>";
			} else {
				if (!empty($woocommerce_custom_product_text_field)) {
					update_post_meta($variation_id, 'variation_min_quantity', esc_attr($woocommerce_custom_product_text_field));
				}
			}
		}
	}
	
	
	/**
	 * add_custom_user_columns
	 * Description : This function is used to add custom column to the users table
	 * @version : 1.0
	
	 * @param  mixed $column_headers
	 * @return void
	 */
	
	public function add_custom_user_columns( $column_headers) {
	
		$column_headers['num_posts'] = ' Wholesale Customer';
		return $column_headers;
	}
	
	/**
	 * ced_custom_column_button
	 *
	 * Description : This function is used to add data into custom column to the users table
	 * @version : 1.0
	 
	 * @param  mixed $value
	 * @param  mixed $column_name
	 * @param  mixed $user_id
	 * @return void
	 */
	public function ced_custom_column_button( $value, $column_name, $user_id) {
		
		$user = get_userdata( $user_id );
		
		if (!empty($user->caps['administrator']) != 1) {
			
			$user_request = get_user_meta( $user_id, 'wholesale_customer', true );

			if (1 == isset($user->caps['customer']) && 'Request_Wholesale_customer' == $user_request) {
				if ( 'num_posts' == $column_name ) {
					
					$value = "<form method = 'get'><input type='submit' name='changeit' id='changeit' class='button' value='Approved'><input type = 'hidden' name = 'id' value = '$user_id'></form>";

				}
				return $value;
			}
		}

		
	}

	/**
	 * bbloomer_assign_custom_role
	 * Description : This function is used to assign new role
	 * @version : 1.0
	
	 * @return void
	 */

	public function bbloomer_assign_custom_role() {
		
		if (!empty($_GET['changeit'])) {
			
			if (!empty( sanitize_text_field($_GET['id']) )) {
				$id = sanitize_text_field($_GET['id']);
			}
			
			$user = get_userdata( $id );
			// print_r($user);
			$u = new WP_User( $id );

			// Remove role
			$u->remove_role( 'customer' );

			// Add role
			$u->add_role( 'wholesale_customer' );
		}
	}

	
	/**
	 * ced_checkbox_add_user_backend
	 *
	 * Description : This function is used to add checkbox for wholesale customer in backend Add new user
	 * @version : 1.0
	
	 * @return void
	 */

	public function ced_checkbox_add_user_backend(){?>
		<table class="form-table" role="presentation">
	
			<tr>
				<th scope="row"><?php esc_html_e( 'Want to be a Wholesale Customer?' ); ?></th>
				<td>
					<input type="checkbox" name="send_user_notification" id="send_user_notification" value="1"  />
					<label for="send_user_notification"><?php esc_html_e( 'Able to see the wholesale price.' ); ?></label>
				</td>
			</tr>
			
		</table><?
	}

		
	/**
	 * ced_add_custom_role
	 *
	 * Description : This function is used to create custom new role for users in backend
	 * @version : 1.0
	 * @return void
	
	 */
	
	public function ced_add_custom_role(){
		add_role(
			'wholesale_customer',
			__( 'Wholesale Customer' ),
			array(
				'read'        => true,  // true allows this capability
				'edit_posts'   => true,
			)
		);
	}
	
	/**
	 * sample_admin_notice__error
	 *
	 * Description : This function is used to display error message when wholesale price of simple product is < 0
	 * @version : 1.0
	 * @return void 

	 */
	
	public function sample_admin_notice__error() {
	   //die();
		?>
		<div class="notice notice-error is-dismissible">
			<p><?php esc_html_e('error!', 'sample-text-domain'); ?></p>
		</div>
		<?php
		
	}
}
