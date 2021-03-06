<?php 

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Class_list_table extends WP_List_Table {


	/** Class constructor */
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'customer', 'sp' ), //singular name of the listed records
			'plural'   => __( 'customers', 'sp' ), //plural name of the listed records
			'ajax'     => false //should this table support ajax?

		] );

  }
    
  /**
   * Retrieve customer’s data from the database
   *
   * @param int $per_page
   * @param int $page_number
   *
   * @return mixed
   */
  public static function get_customers( $per_page = 5, $page_number = 1 ) {

      global $wpdb;
  
      // $sql = "SELECT * FROM wp_contact";
  
      if ( ! empty( $_REQUEST['orderby'] ) ) {
      $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
      $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
      }
  
      $sql .= " LIMIT $per_page";
  
      $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;
  
  
      $result = $wpdb->get_results( $sql, 'ARRAY_A' );
  
      return $result;
  }

  /**
   * Delete a customer record.
   *
   * @param int $id customer ID
   */
  public static function delete_customer( $id ) {
      global $wpdb;
      // die("okk");
      $wpdb->delete(
    
      "{$wpdb->prefix}options",
      [ 'id' => $id ],
      [ '%d' ]
      );
  }
  /**
   * Returns the count of records in the database.
   *
   * @return null|string
   */
      public static function record_count() {
      global $wpdb;
  
      $sql = "SELECT COUNT(*) FROM wp_options";
  
      return $wpdb->get_var( $sql );
  }

  /** Text displayed when no customer data is available */
  public function no_items() {
  _e( 'No customers avaliable.', 'sp' );
  }

  /**
   * Method for name column
   *
   * @param array $item an array of DB data
   *
   * @return string
   */
  public function column_name( $item ) {

    // create a nonce
    $delete_nonce = wp_create_nonce( 'sp_delete_customer' );

    $title = '<strong>' . $item['name'] . '</strong>';

    $actions = [
      'delete' => sprintf( '<a href="?page=%s&action=%s&customer=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce )
    ];

    return $title . $this->row_actions( $actions );
  }

  /**
   * Render a column when no column specific method exists.
   *
   * @param array $item
   * @param string $column_name
   *
   * @return mixed
  */
  public function column_default( $item, $column_name ) {

    // print_r($item);
    switch ( $column_name ) {

      case 'Product Image':
        return "<img src = '".$item['item']['images'][0]."' height = '10%' width = '60%'>";
      case 'title':
          return $item['item']['name'];
      case 'sku':
          return $item['item']['item_sku'];
      case 'price':
          return $item['item']['price'];
      case 'type':
            $item['item']['has_variation'];
          if(1 == $item['item']['has_variation']){
              return 'Variable';
          }else{
              return 'Simple';
          }
      case 'action':
          return "<input type = 'button' data-id = '".$item['item']['item_sku']."' class = 'import' value = 'Import'>";
      //   return $item[$column_name ];
      default:
        return print_r( $item, true ); //Show the whole array for troubleshooting purposes
    }
  }

  /**
   * Render the bulk edit checkbox
   *
   * @param array $item
   *
   * @return string
   */
  public function column_cb( $item ) {

    return sprintf(
      '<input type="checkbox" class = "save" name="bulk-delete[]" value="%s" />', $item['item']['item_sku']
    );
  }

  /**
   *  Associative array of columns
   *
   * @return array
   */
  public function get_columns() {

    $columns = [
      'cb'      => '<input type="checkbox" />',
      'Product Image'    => __( 'product image', 'sp' ),
      'title'    => __( 'title', 'sp' ),
      'sku' => __( 'sku', 'sp' ),
      'price'    => __( 'price', 'sp' ),
      'type'    => __( 'type', 'sp' ),
      'action'    => __( 'action', 'sp' )
      
      
    ];
  
    return $columns;
  }

  /**
   * Columns to make sortable.
   *
   * @return array
   */
  public function get_sortable_columns() {

    $sortable_columns = array(
      'id' => array( 'id', true ),
      'email' => array( 'email', false ),
      'title' => array( 'title', false )
      
    );
  
    return $sortable_columns;
  }

  /**
   * Returns an associative array containing the bulk action
   *
   * @return array
   */
  public function get_bulk_actions() {

    $actions = [
      'bulk-delete' => 'Import'
    ];
  
    return $actions;
  }

  /**
   * Handles data query and filter, sorting, and pagination.
  */

  public function prepare_items() {

    $columns = $this->get_columns();
    $hidden = array();
    $sortable = $this->get_sortable_columns();
    $this->_column_headers =array($columns, $hidden, $sortable);
    
    /** Process bulk action */
    $this->process_bulk_action();
  
    $per_page     = $this->get_items_per_page( 'customers_per_page', 5 );
    $current_page = $this->get_pagenum();
    $total_items  = self::record_count();
  
    $this->set_pagination_args( [
      'total_items' => $total_items, //WE have to calculate the total number of items
      'per_page'    => $per_page //WE have to determine how many items to show on a page
    ] );
    // echo "ghkj";
  }
    

  public function process_bulk_action() {

    //Detect when a bulk action is being triggered...
    if ( 'delete' === $this->current_action() ) {
  
      // In our file that handles the request, verify the nonce.
      $nonce = esc_attr( $_REQUEST['_wpnonce'] );
  
      if ( ! wp_verify_nonce( $nonce, 'sp_delete_customer' ) ) {
        die( 'Go get a life script kiddies' );
      }
      else {
        self::delete_customer( absint( $_GET['customer'] ) );
  
        wp_redirect( esc_url( add_query_arg() ) );
        exit;
      }
  
    }
  
    // If the delete bulk action is triggered
    if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
         || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
    ) {
      $delete_ids = esc_sql( $_POST['bulk-delete'] );
  
      // loop over the array of record IDs and delete them
      foreach ( $delete_ids as $id ) {
        self::delete_customer( $id );
  
      }
  
      wp_redirect( esc_url( add_query_arg() ) );
      exit;
    }
  }
}

?>