<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       cedcommerce
 * @since      1.0.0
 *
 * @package    Badge
 * @subpackage Badge/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Badge
 * @subpackage Badge/public
 * @author     Sabreen Shakeel <sabreenshakeel@cedcoss.com>
 */
class Badge_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
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
	 * @since    1.0.0
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
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Badge_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Badge_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/badge-public.css', array(), $this->version, 'all' );

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
		 * defined in Badge_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Badge_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/badge-public.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	* ced_badge_single_page
	* Description : Showing sold out badge on item when quantity is zero on single page
	* @version : 1.0
	* @return void
	*/

	public function ced_badge_single_page() {
			
		global $product;  
		
		$quantity = $product->get_stock_quantity();

		// echo $quantity;

		if($quantity == 0){
			echo '<div class="woocommerce-message">Sold Out!</div>';
			// echo "sold out";
		}
	}
		
	/**
	* ced_badge_shop_page

	* Description : Showing sold out badge on item when quantity is zero on shop page
	* @version : 1.0
	* @return void
	*/
	
	public function ced_badge_shop_page(){

		global $product;  
		
		$quantity = $product->get_stock_quantity();

		// echo $quantity;

		if($quantity == 0){
			echo '<div class="woocommerce-message">Sold Out!</div>';
			// echo "sold out";
		}


	}
	
	/**
	 * ced_billing_form
	 * Description : Changing checkout label when plugin activated
	 * @version : 1.0
	 * @param  mixed $fields - containing whole fields of checkout form
	 * @return void
	 */
	
	public function ced_billing_form($fields){
		
		// print_r($fields);
		$fields['billing']['billing_email']['label'] = 'Email';
		$fields['billing']['billing_phone']['label'] = 'Mobile';
		return $fields;


	}
	
	/**
	 * myplugin_woocommerce_locate_template
	 * Description : Override title file by using overriding template file concept
	 * @param  mixed $template
	 * @param  mixed $template_name
	 * @param  mixed $template_path
	 * @return void
	 */

	public function myplugin_woocommerce_locate_template( $template, $template_name, $template_path ) {

		global $woocommerce;
	
		$_template = $template;
	
		if ( ! $template_path ) $template_path = $woocommerce->template_url;
	
		$plugin_path  = CED_BADGE . '/woocommerce/';
		
	
		// Look within passed path within the theme - this is priority
		$template = locate_template(
	
		array(
			$template_path . $template_name,
			$template_name
		)
		);
	
		// Modification: Get the template from this plugin, if it exists
		if ( ! $template && file_exists( $plugin_path . $template_name ) )
		$template = $plugin_path . $template_name;
	
		// Use default template
		if ( ! $template )
		$template = $_template;
	
		// Return what we found
		return $template;
	}
}
