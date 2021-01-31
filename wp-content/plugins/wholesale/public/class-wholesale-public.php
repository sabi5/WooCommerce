<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       cedcommerce
 * @since      1.0.0
 *
 * @package    Wholesale
 * @subpackage Wholesale/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wholesale
 * @subpackage Wholesale/public
 * author     Sabreen Shakeel <sabreenshakeel@cedcoss.com>
 */
class Wholesale_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wholesale-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wholesale-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * save_checkbox_value_to_account_details
	 * 
	 * Description : This function is used to request for wholesale customer at registration time
	 * @version : 1.0
	 *
	 * @param  mixed $user_id - contains all user data
	 * @return void
	 */

	public function save_checkbox_value_to_account_details( $user_id ) {
		if (isset($_POST['checkbox_nonce']) && wp_verify_nonce(sanitize_text_field($_POST['checkbox_nonce'], 'checkbox_nonce'))) {
			$value = isset($_POST['send_user_notification']) ? 'Request_Wholesale_customer' : '0';
			update_user_meta($user_id, 'wholesale_customer', $value);
		}
	}

		

	/**
	 * ced_checkbox_add_user_frontend
	 * Description : This function is used to add checkbox for wholesale customer in Add new user backend
	 * @version : 1.0

	 * @return void
	*/
	public function ced_checkbox_add_user_frontend(){?>
		<table class="form-table" role="presentation">
	
			<tr>
				<th scope="row"><?php esc_html_e( 'Wants to be a Wholesale Customer?' ); ?></th>
				<td>
					<input type="checkbox" name="send_user_notification" id="send_user_notification" value="1"  />
					<label for="send_user_notification"><?php esc_html_e( 'Able to see the wholesale price.' ); ?></label>
					<input type="hidden" value = "<?php echo esc_html_e(wp_create_nonce('generate_checkbox_nonce')); ?>" id = "checkbox_nonce">
				</td>
			</tr>
			
		</table><?
	}

	
	/**
	 * ced_display_wholesale_price_simple_product
	 *
	 * Description : This function is used to display wholesale price for wholesale customer in shop page
	 * @version : 1.0
	 * @return void
	 */
	public function ced_display_wholesale_price_simple_product(){

		global $product;
		$product_type = $product->get_type();
		global $post;
		
		$user_id = get_current_user_id();
		$user = get_user_meta( $user_id, 'wholesale_customer', true );

		$enable_wholesale = get_option('myplugin_checkbox_1');
		$wholesale_customer = get_option('woocommerce_prices_include_tax');
		
		if($user == 'Request_Wholesale_customer'){
			if (is_user_logged_in()) {
				if ('yes' == $enable_wholesale) {
					if ('no' == $wholesale_customer) {  // Display wholesale price to only wholesale customer
						
						if ('simple' == $product_type) {
							if (get_post_meta($post->ID, 'wholesale_price_save', true) != '') {
								
								echo '<b>'.get_option('woocommerce_wholesale_text').'</b>'.get_post_meta($post->ID, 'wholesale_price_save', true);
								
							}
						}
					}
				}
			}
		}else{
			if('yes' == $enable_wholesale){
				if('yes' == $wholesale_customer){  // Display wholesale price to all users
					
					if('simple' == $product_type){
						if(get_post_meta( $post->ID, 'wholesale_price_save', true ) != ''){
							
							echo '<b>'.get_option('woocommerce_wholesale_text').'</b>'.get_post_meta( $post->ID, 'wholesale_price_save', true ).'</br>';
					
						}
					}
				}
			}
		}

	}

	
	/**
	 * ced_display_wholesale_price_simple_product_single_page
	 * 
	 * Description : This function is used to display wholesale price for wholesale customer in single page
	 * @version : 1.0
	 * @return void
	 */
	public function ced_display_wholesale_price_simple_product_single_page(){

		global $product;
		
		$product_type = $product->get_type();
		global $post;
	
		$user_id = get_current_user_id();
		$user = get_user_meta( $user_id, 'wholesale_customer', true );


		$enable_wholesale = get_option('myplugin_checkbox_1');
		$wholesale_customer = get_option('woocommerce_prices_include_tax');
		
		if('Request_Wholesale_customer' == $user){
			if (is_user_logged_in()) {
				if ('yes' == $enable_wholesale) {
					if ('no' == $wholesale_customer) {  // Display wholesale price to only wholesale customer
					   
						if ('simple' == $product_type) {
							if (get_post_meta($post->ID, 'wholesale_price_save', true) != '') {
								
								echo '<b>'.get_option('woocommerce_wholesale_text').'</b>'.get_post_meta($post->ID, 'wholesale_price_save', true);
								
							}
						}
					}
				}
			}
		}else{
			if ('yes' == $enable_wholesale) {
				if ('yes' == $wholesale_customer) {  // Display wholesale price to all users
					
					if ('simple' == $product_type) {
						if (get_post_meta($post->ID, 'wholesale_price_save', true) != '') {
							echo '<b>'.get_option('woocommerce_wholesale_text').'</b>'.get_post_meta($post->ID, 'wholesale_price_save', true).'</br>';
						}
					}
				}
			}
		}

	}

	
	
	/**
	 * ced_display_wholesale_price_variation_product
	 *
	 * Description : This function is used to display wholesale price for wholesale customer in variation  	  single page
	 * @since : 1.0.0
	 * @version : 1.0
	 * 
	 * @param  mixed $description
	 * @param  mixed $product
	 * @param  mixed $variation
	 * @return void
	 */
	public function ced_display_wholesale_price_variation_product($description, $product, $variation){

		global $product;
		
		$product_type = $product->get_type();
		global $post;
		
		$user_id = get_current_user_id();
		$user = get_user_meta( $user_id, 'wholesale_customer', true );

		$enable_wholesale = get_option('myplugin_checkbox_1');
		$wholesale_customer = get_option('woocommerce_prices_include_tax');
		
		if('Request_Wholesale_customer' == $user){
			if (is_user_logged_in()) {
				if ('yes' == $enable_wholesale) {
					if ('no' == $wholesale_customer ) {  // Display wholesale price to only wholesale customer
						if ('variable' == $product_type) {	
							if (get_post_meta($description['variation_id'], 'variation_wholesale_price_save', true) != '') {
								
								$description['price_html'] = '<b>'.get_option('woocommerce_wholesale_text').'</b>'.get_post_meta($description['variation_id'], 'variation_wholesale_price_save', true);
							
							}
						}
					}
				}
			}
		}else{
			if('yes' == $enable_wholesale){
				if('yes' == $wholesale_customer){  // Display wholesale price to all users
					if ( 'variable' == $product_type) {
						if (get_post_meta($description['variation_id'], 'variation_wholesale_price_save', true) != '') {
							
							$description['price_html'] = '<b>'.get_option('woocommerce_wholesale_text').'</b>'.get_post_meta($description['variation_id'], 'variation_wholesale_price_save', true);
						
						}
					}
				}
			}
		}
		return $description;
	}

	
	/**
	 * ced_add_to_cart
	 * 
	 * Description : This function is used to manage add to cart and checkout when Wholesale Price to be applied when min. qty setting is achieved.(if setting enabled)
	 * @since : 1.0.0
	 * @version : 1.0
	 * 
	 * @param  mixed $cart_data - contains all cart data
	 * @return void
	 */
	public function ced_add_to_cart($cart_data){
	
		$enable_qty = get_option('myplugin_inventory_1');
		$common_min_qty_for_all_products = get_option('woocommerce_prices_include_tax');
		
		foreach( WC()->cart->get_cart() as $cart_item ){
			if('yes' == $enable_qty){
				if($common_min_qty_for_all_products == 'yes'){
					
					// Loop through cart items
					$product_type = $cart_item['data']->get_type(); 
				
					if('variation' == $product_type){

						$product_id = $cart_item['variation_id'];
						$product_type = $cart_item['data']->get_type(); 
						$common_min_qty = get_post_meta($product_id, 'variation_min_quantity', true);
						$wholesale_price = get_post_meta($product_id, 'variation_wholesale_price_save', true);

						if($cart_item['quantity'] >= $common_min_qty){
							$cart_item['data'] ->set_price($wholesale_price);
						}
					}

					if('simple' == $product_type){

						$product_id = $cart_item['product_id'];
						
						$product_type = $cart_item['data']->get_type(); 
				
						$common_min_qty = get_post_meta($product_id, 'min_quantity', true);
					
						$wholesale_price = get_post_meta($product_id, 'wholesale_price_save', true);

						if($cart_item['quantity'] >= $common_min_qty){

							$cart_item['data'] ->set_price($wholesale_price);
						}
					}
					
				}elseif($common_min_qty_for_all_products == 'no'){

					// Loop through cart items
					$product_type = $cart_item['data']->get_type(); 
					$common_min_qty = get_option('woocommerce_min_price');

					if('variation' == $product_type){

						$product_id = $cart_item['variation_id'];
						$product_type = $cart_item['data']->get_type(); 
						
						$wholesale_price = get_post_meta($product_id, 'variation_wholesale_price_save', true);

						if($cart_item['quantity'] >= $common_min_qty){
							$cart_item['data'] ->set_price($wholesale_price);
						}
					}

					if('simple' == $product_type){

						$product_id = $cart_item['product_id'];
						$product_type = $cart_item['data']->get_type(); 
			
						$wholesale_price = get_post_meta($product_id, 'wholesale_price_save', true);

						if($cart_item['quantity'] >= $common_min_qty){

							$cart_item['data'] ->set_price($wholesale_price);
						}
					}
				}		
			}
		}
	}
}

