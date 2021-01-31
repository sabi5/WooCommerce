<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       cedcommerce
 * @since      1.0.0
 *
 * @package    Importer
 * @subpackage Importer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Importer
 * @subpackage Importer/admin
 * @author     Sabreen Shakeel <sabreenshakeel@cedcoss.com>
 */
class Importer_Admin {

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
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Importer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Importer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/importer-admin.css', array(), $this->version, 'all' );

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
		 * defined in Importer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Importer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/importer-admin.js', array( 'jquery' ), $this->version, false );

		wp_localize_script(  $this->plugin_name , 'boiler_ajax_url', array('ajax_url'=>admin_url('admin-ajax.php')) );

	}

		/**
		* ced_custom_admin_menu_content
		
		* Description : Contents for custom admin menu page for uploading files to the Importer_uploads folder
		* @since : 1.0.0
		* @version : 1.0
		* @return void
		*/

		public function ced_custom_admin_menu_content() {

            if (isset($_POST['upload'])) {				
                
				$upload = wp_upload_dir();
				$upload_dir = $upload['basedir'];
				$upload_dir = $upload_dir . '/Importer_uploads';
				
				//The temp file path is obtained
				$tmpFilePath = $_FILES['file']['tmp_name'];

				//A file path needs to be present
				if ($tmpFilePath != ""){

					//Setup our new file path
					$newFilePath = $upload_dir. '/Importer_uploads'. $_FILES['file']['name'];

					//File is uploaded to temp dir
					if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					
						$arr = array();
						$arr = get_option('Import_products');
						if(empty($arr)){
						
							$arr[0] = array('file_name' => $_FILES['file']['name'], 'file_path' => $_FILES['file']['tmp_name']);
							
						}else{
							$arr [] = array('file_name' => $_FILES['file']['name'], 'file_path' => $_FILES['file']['tmp_name']);
						}
					
						update_option('Import_products',$arr );
						
						echo 'success';
						
					}else{
						echo 'failed';
					}
				}	
			}

			$product_file = get_option('Import_products');
			// echo "<pre>";
			$upload = wp_upload_dir();
			$upload_dir = $upload['basedir'];
			$upload_dir = $upload_dir . '/Importer_uploads/';
            foreach ($product_file as $key => $value) {
                
				$str = json_decode(file_get_contents($upload_dir.'Importer_uploads'.$value['file_name']));

			}
			
			?>
			<form method="post" enctype="multipart/form-data">
				<input type="file" name="file" multiple="multiple">
				<input type="submit" name="upload" value = "Upload file">
			</form>
			
			<select id ="product_list">
				<?php 
				foreach ($product_file as $key => $value){
					$file = json_decode($value['file_name'][0]);
					print_r($file);
					
					// print_r($value['file_name'][0]);?>
					<option  value="<?php echo $value['file_name'];?>"><?php echo $value['file_name'];?></option>
				<? }
				?>
			</select>
			<div class="result"></div>
			<?
		}

		
		/**
		 * meta_ajax_data
		 * 
		 * Description : This function is used for display data in class list table when particular json file is selected from dropdown 
		 * @since : 1.0.0
		 * @version : 1.0
		 * @return void
		 */

		public function meta_ajax_data(){
			
            if (isset($_POST['file'])) {

				$file = $_POST['file'];
                $upload = wp_upload_dir();
                $upload_dir = $upload['basedir'];
                $upload_dir = $upload_dir . '/Importer_uploads/';
                
                $str = json_decode(file_get_contents($upload_dir.'Importer_uploads'.$file), 1);

				require 'partials/Class_list_table.php';
				$list_obj = new Class_list_table();
				$list_obj->items = $str;

				$list_obj->prepare_items();
				print_r($list_obj->display());
            }
		}
		
		/**
		 * import_ajax_data
		 * 
		 * Description : This function is used for import product when click on import button  
		 * @since : 1.0.0
		 * @version : 1.0
		 * 
		 * @return void
		 */

		public function import_ajax_data(){
			
			if(isset($_POST['id']) && isset($_POST['file'])){

				$id = $_POST['id'];
				$file = $_POST['file'];
				
				$upload = wp_upload_dir();
				$upload_dir = $upload['basedir'];
				$upload_dir = $upload_dir . '/Importer_uploads/';
				$str = json_decode(file_get_contents($upload_dir.'Importer_uploads'.$file) , 1);
				
				
				foreach ($str as $key => $value){
					
					if($id == $value['item']['item_sku']){
					
						$title = $value['item']['name'];
						$sku = $value['item']['item_sku'];
						$price = $value['item']['price'];
						$description = $value['item']['description'];

						$user_id = get_current_user_id();
						
						// Create post object
						global $wpdb;
						$post_sku = $wpdb->get_col( $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_value = %s" , $sku) );
						 
						$my_post = array(
							'post_author'           => $user_id,
							'post_content'          => $description,
							'post_content_filtered' => '',
							'post_title'            => $title,
							'post_excerpt'          => '',
							'post_status'           => 'publish',
							'post_type'             => 'product',
							'comment_status'        => 'closed',
							'ping_status'           => 'closed',
							'post_password'         => '',
							'to_ping'               => '',
							'pinged'                => '',
							'post_parent'           => 0,
							'menu_order'            => 0,
							'guid'                  => '',
							'import_id'             => 0,
							'context'               => '',
						);
						
						if($post_sku){
							echo 'product already exists';
						}else{
							// Insert the post into the database
							$insert_post = wp_insert_post( $my_post );
							if($insert_post){
								echo 'inserted successfully';
							}else{
								echo 'not inserted';
							}
						}
						// print_r($value['item']['images'][0]);
						// Add Featured Image to Post
						$image_url        = $value['item']['images'][0]; // Define the image URL here
						$image_name       = basename($image_url);
						$upload_dir       = wp_upload_dir(); // Set upload folder
						$image_data       = file_get_contents($image_url); // Get image data
						$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
						$filename         = basename( $unique_file_name ); // Create image file name

						// Check folder permission and define file location
						if( wp_mkdir_p( $upload_dir['path'] ) ) {
							$file = $upload_dir['path'] . '/' . $filename;
						} else {
							$file = $upload_dir['basedir'] . '/' . $filename;
						}
						// print_r($filename);
						// Create the image  file on the server
						file_put_contents( $file, $image_data );
						// var_dump($file);

						// Check image file type
						$wp_filetype = wp_check_filetype( $filename, null );

						// Set attachment data
						$attachment = array(
							'post_mime_type' => 'image/png',
							'post_title'     => sanitize_file_name( $filename ),
							'post_content'   => '',
							'post_status'    => 'inherit'
						);

						// Create the attachment
						$attach_id = wp_insert_attachment( $attachment, $file, $insert_post );

						// Include image.php
						require_once(ABSPATH . 'wp-admin/includes/image.php');

						// Define attachment metadata
						$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

						// Assign metadata to attachment
						wp_update_attachment_metadata( $attach_id, $attach_data );

						// And finally assign featured image to post
						// var_dump(set_post_thumbnail( $insert_post, $attach_id ));
						update_post_meta( $insert_post, '_thumbnail_id', $attach_id );
						// var_dump($insert_post);
						// var_dump($attach_id);

						
						if(1 == $value['item']['has_variation']){
							wp_set_object_terms( $insert_post, 'variable','product_type');
							$this->ced_variable_attribute($insert_post, $value['tier_variation']);
							$this->ced_create_variations_product($insert_post,$value['item']['variations'], $value['tier_variation']);
						}else{
							wp_set_object_terms( $insert_post, 'simple', 'product_type' );
							$this->ced_simple_attribute($insert_post, $value['item']['attributes']);
						}
						
						$this->ced_update_post_meta($insert_post, $value['item']);
						// $this->ced_simple_attribute($insert_post, $value['item']['attributes']);
						// $this->ced_variable_attribute($insert_post, $value['tier_variation']);
						// $this->ced_create_variations_product($insert_post,$value['item']['variations'], $value['tier_variation']);
						
					}
				}
			}
			wp_die(); // for avoiding 0 ajax response 
		}
		
		/**
		 * ced_update_post_meta
		 *
		 * Description : This function is used for updating post meta values 
		 * @since : 1.0.0
		 * @version : 1.0
		 * @param  mixed $post_id : post id
		 * @param  mixed $file_data : store post data for updating meta values
		 * @return void
		 */
		public function ced_update_post_meta($post_id, $file_data){

			if(isset($file_data['sale_price'])){

				$sale_price = $file_data['sale_price'];
			}else{

				$sale_price = '';
			}

			update_post_meta($post_id, '_regular_price', $file_data['price']);
			update_post_meta($post_id, '_price', $file_data['original_price']);
			update_post_meta($post_id, '_sale_price', $sale_price );
			update_post_meta($post_id, '_sku', $file_data['item_sku']);
			update_post_meta($post_id, '_stock', $file_data['stock']);
			update_post_meta($post_id, '_stock_status', 'in stock');
			update_post_meta($post_id, '_downloadable', 'no');
			update_post_meta($post_id, '_download_limit', 'no');
			update_post_meta($post_id, '_virtual', 'no');
			update_post_meta($post_id, '_sold_individually', 'no');
			update_post_meta($post_id, '_backorders', 'no');

		}
		
		/**
		 * ced_simple_attribute
		 * 
		 * Description : This function is used for creating attributes for simple products
		 * @since : 1.0.0
		 * @version : 1.0
		 * @param  mixed $post_id : post id
		 * @param  mixed $data : store tier variation data for attributes
		 * @return void
		 */
		public function ced_simple_attribute($post_id, $data){

			foreach ($data as $value){
				$attribute_name = $value['attribute_name'];
				$attribute_value = $value['attribute_value'];
	
			}

			$attribute[$attribute_name] = array(
        
            'name' => $attribute_name,
            'value' => $attribute_value,
            'position' => 1,
            'is_visible' => 1,
            'is_variation' => 0,
            'is_taxonomy' => 0
			);
			$add_attribute = update_post_meta($post_id, '_product_attributes', $attribute);
		}

		// VARIATION ATTRIBUTE
		
		/**
		 * ced_variable_attribute
		 * 
		 * Description : This function is used for creating attributes for variable product
		 * @since : 1.0.0
		 * @version : 1.0
		 * @param  mixed $post_id : post id
		 * @param  mixed $tier_variation : tier variation value in json file
		 
		 * @return void
		 */
		public function ced_variable_attribute($post_id, $tier_variation){
			
			foreach ($tier_variation as $value){

				$attribute_name = $value['name'];
				$attribute_value = $value['options'];
				
				$str_attribute_value=implode("|",$attribute_value);
				$attribute[$attribute_name] = array(

					'name' => $attribute_name,
					'value' => $str_attribute_value,
					'position' => 1,
					'is_visible' => 1,
					'is_variation' => 1,
					'is_taxonomy' => 0
					);
			}
			$add_attribute = update_post_meta($post_id, '_product_attributes', $attribute);	
		}
		
		/**
		 * ced_create_variations_product
		 * 
		 * Description : This function is used for creating variations for attributes
		 * @since : 1.0.0
		 * @version : 1.0
		 * @param  mixed $post_id : post parent id
		 * @param  mixed $variation_value : variations value in json file
		 * @param  mixed $tier_variation : tier variation value in json file
		 * @return void
		 */
		public function ced_create_variations_product($post_id, $variation_value, $tier_variation){

			$user_id = get_current_user_id();
			foreach($variation_value as $key_variation=>$value){

				$attribute_name = $value['name'];
			
				$my_post = array(
					'post_author'           => $user_id,
					'post_content'          => 'variable product',
					'post_content_filtered' => '',
					'post_title'            => $attribute_name,
					'post_excerpt'          => '',
					'post_status'           => 'publish',
					'post_type'             => 'product_variation',
					'comment_status'        => 'closed',
					'ping_status'           => 'closed',
					'post_password'         => '',
					'to_ping'               => '',
					'pinged'                => '',
					'post_parent'           => $post_id,
					'menu_order'            => 0,
					'guid'                  => '',
					'import_id'             => 0,
					'context'               => '',
				);
	
				$insert_post = wp_insert_post( $my_post );
				foreach($tier_variation as $key => $val){

					$images = $val['images_url'];
				
					foreach ($images as $k => $v) {

						if($key_variation == $k ) {
							// print_r($k);
							// Add Featured Image to Post
							$image_url        = $v; // Define the image URL here
							$image_name       = basename($image_url);
							$upload_dir       = wp_upload_dir(); // Set upload folder
							$image_data       = file_get_contents($image_url); // Get image data
							$unique_file_name = wp_unique_filename($upload_dir['path'], $image_name); // Generate unique name
							$filename         = basename($unique_file_name); // Create image file name

							// Check folder permission and define file location
							if (wp_mkdir_p($upload_dir['path'])) {
								$file = $upload_dir['path'] . '/' . $filename;
							} else {
								$file = $upload_dir['basedir'] . '/' . $filename;
							}
							// print_r($filename);
							// Create the image  file on the server
							file_put_contents($file, $image_data);
							// var_dump($file);

							// Check image file type
							$wp_filetype = wp_check_filetype($filename, null);

							// Set attachment data
							$attachment = array(
								'post_mime_type' => 'image/png',
								'post_title'     => sanitize_file_name($filename),
								'post_content'   => '',
								'post_status'    => 'inherit'
							);

							// Create the attachment
							$attach_id = wp_insert_attachment($attachment, $file, $insert_post);

							// Include image.php
							require_once(ABSPATH . 'wp-admin/includes/image.php');

							// Define attachment metadata
							$attach_data = wp_generate_attachment_metadata($attach_id, $file);

							// Assign metadata to attachment
							wp_update_attachment_metadata($attach_id, $attach_data);

							// And finally assign featured image to post
							// var_dump(set_post_thumbnail( $insert_post, $attach_id ));
							update_post_meta($insert_post, '_thumbnail_id', $attach_id);
							// var_dump($insert_post);
							// var_dump($attach_id);
						}
					}
				}
				$this->ced_variations_update_post_meta($insert_post, $value, $tier_variation);
			}
		}
		
		/**
		 * ced_variations_update_post_meta
		 * 
		 * Description : This function is used for updating variations post meta values
		 * @since : 1.0.0
		 * @version : 1.0
		 * 
		 * @param  mixed $insert_post : variation post id
		 * @param  mixed $value : variations value in json file
		 * @param  mixed $tier_variation : tier variation value in json file
		 * @return void
		 */
		public function ced_variations_update_post_meta($insert_post, $value, $tier_variation){
			
			$data= '';

			foreach($tier_variation as $key => $val){
				
				$tier = $val['options'];
				$attribute_name = $val['name'];
				
				foreach($tier as $k => $v){
					
					if($value['name'] == $v){
					
						$data = $v;
						break;
					}
					
				}
			}
			update_post_meta($insert_post, '_regular_price', $value['price']);
			update_post_meta($insert_post, '_price', $value['original_price']);
			update_post_meta($insert_post, '_sale_price', $sale_price);
			update_post_meta($insert_post, '_sku', $value['variation_sku']);
			update_post_meta($insert_post, '_stock', $value['stock']);
			// update_post_meta($insert_post, 'attribute_'.strtolower($attribute_name), $var_name);
			update_post_meta($insert_post, 'attribute_'.strtolower($attribute_name), $data);
			update_post_meta($insert_post, '_stock_status', 'in stock');
			update_post_meta($insert_post, '_downloadable', 'no');
			update_post_meta($insert_post, '_download_limit', 'no');
			update_post_meta($insert_post, '_virtual', 'no');
			update_post_meta($insert_post, '_sold_individually', 'no');
			update_post_meta($insert_post, '_backorders', 'no');

		}


		// ALL PRODUCTS IMPORTED
		
		/**
		 * all_products_import_ajax_data
		 *
		 * Description : This function is used for bulk import
		 * @since : 1.0.0
		 * @version : 1.0
		 * @return void
		 */
		public function all_products_import_ajax_data(){

			if(isset($_POST['product_id'])){

				$product_id = $_POST['product_id'];
				// $count_check = $_POST['count_check'];
				$import_click = $_POST['import_click'];
				$apply_click = $_POST['apply_click'];
				$file = $_POST['file'];

				$upload = wp_upload_dir();
				$upload_dir = $upload['basedir'];
				$upload_dir = $upload_dir . '/Importer_uploads/';
				$str = json_decode(file_get_contents($upload_dir.'Importer_uploads'.$file) , 1);
				
				foreach ($str as $key => $value){
					
					if($product_id == $value['item']['item_sku']){
						// print_r($product_id);
						$title = $value['item']['name'];
						$sku = $value['item']['item_sku'];
						$price = $value['item']['price'];
						$description = $value['item']['description'];

						$user_id = get_current_user_id();
						
						// Get meta value(get all sku values) column from postmeta table
						global $wpdb;
						$post_sku = $wpdb->get_col( $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_value = %s" , $sku) );
						 
						// Create post object
						$my_post = array(
							'post_author'           => $user_id,
							'post_content'          => $description,
							'post_content_filtered' => '',
							'post_title'            => $title,
							'post_excerpt'          => '',
							'post_status'           => 'publish',
							'post_type'             => 'product',
							'comment_status'        => 'closed',
							'ping_status'           => 'closed',
							'post_password'         => '',
							'to_ping'               => '',
							'pinged'                => '',
							'post_parent'           => 0,
							'menu_order'            => 0,
							'guid'                  => '',
							'import_id'             => 0,
							'context'               => '',
						);
						
						if($post_sku){
							echo 'product already exists';
						}else{

							if($import_click == 'bulk-delete' && $apply_click == 'Apply'){
								// Insert the post into the database
								$insert_post = wp_insert_post( $my_post );
							}
							
							if($insert_post){
								echo 'inserted successfully';
							}else{
								echo 'not inserted';
							}
						}

						if(1 == $value['item']['has_variation']){
							wp_set_object_terms( $insert_post, 'variable','product_type');
						}else{
							wp_set_object_terms( $insert_post, 'simple', 'product_type' );
						}
						
						$this->ced_update_post_meta($insert_post, $value['item']);
						$this->ced_simple_attribute($insert_post, $value['item']['attributes']);
						$this->ced_variable_attribute($insert_post, $value['tier_variation']);
						$this->ced_create_variations_product($insert_post,$value['item']['variations'], $value['tier_variation']);
						
					}
				}
			}
			wp_die();
		}

	/**
	* ced_cpt_wporg_options_page
	* Description : creating custom admin menu for uploading json files and importing products 
	* @since : 1.0.0
	* @version : 1.0
	* @return void
	*/
	public function ced_admin_menu_page() {
		
		add_menu_page(
			'Import Product', //menu title
			'Import Product', //menu name
			'manage_options', // capabality
			'import', //slug
			array( $this, 'ced_custom_admin_menu_content'), //function
			0, //position
			5
		);
	}
}
