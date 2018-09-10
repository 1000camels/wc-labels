<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://aporia.info
 * @since      1.0.0
 *
 * @package    Wc_Labels
 * @subpackage Wc_Labels/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wc_Labels
 * @subpackage Wc_Labels/admin
 * @author     Darcy Christ <darcy@aporia.info>
 */
class Wc_Labels_Admin {

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
		 * defined in Wc_Labels_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_Labels_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wc-labels-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'rsvp', plugin_dir_url( __FILE__ ) . 'js/qz-tray/dependencies/rsvp-3.1.0.min.js', array( 'jquery', 'jquery' ), $this->version, false );

		wp_enqueue_script( 'sha-256', plugin_dir_url( __FILE__ ) . 'js/qz-tray/dependencies/sha-256.min.js', array( 'jquery', 'jquery' ), $this->version, false );

		wp_enqueue_script( 'qz-tray', plugin_dir_url( __FILE__ ) . 'js/qz-tray/qz-tray.js', array( 'jquery', 'jquery' ), $this->version, false );


		// wp_enqueue_script( 'Zebra-BrowserPrint', plugin_dir_url( __FILE__ ) . 'js/Zebra/BrowserPrint-1.0.4.min.js', array( 'jquery', 'jquery' ), $this->version, false );


		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc-labels-admin.js', array( 'jquery' ), $this->version, false );
		

	}


	/**
	 * Declare the meta box
	 *
	 * @since    1.0.0
	 */
	public function printable_label_meta_box() {
	
		add_meta_box(
	        'printable-label',
	        __( 'Printable Label', 'wc-labels' ),
	        array( $this, 'printable_label_meta_box_callback' ),
	        'product',
	        'side', 
	        'default'
	    );
	
	}


	/**
	 * Render the meta box
	 *
	 * @since    1.0.0
	 */
	public function printable_label_meta_box_callback( $post ) {
	 
        $print_link = admin_url( 'admin.php?action=print_label&post=' . $post->ID );

	    echo '<button class="print-label" href="'.$print_link.'">Print Label</button>';

	}


	/**
	 * Add Print Label link to each product
	 *
	 * @since    1.0.0
	 */
	function modify_product_list_row_actions( $actions, $post ) {
	    // Check for your post type.
	    if ( $post->post_type == "product" ) {
	 
	        $print_link = admin_url( 'admin.php?action=print_label&post=' . $post->ID );

	        $new_actions = array(
	            'print' => sprintf( '<a class="print-label" href="%1$s">%2$s</a>',
	            esc_url( $print_link ),
	            esc_html( __( 'Print Label', 'wc-labels' ) ) )
	        );

	        $actions = array_merge( $actions, $new_actions );

	    }
	 
	    return $actions;
	}


	/**
	 * Display Label in ZPL format
	 *
	 * In order for this to print, it needs to be captured by Javascript and passed to 
	 * the print function
	 */
    public function print_label() {

    	$post = get_post($_GET['post']);	    
    	$product = get_product( $post->ID );

	    $price = html_entity_decode(strip_tags($product->get_price_html()));
	    $sku = $product->get_sku();
	    $weight = $product->get_weight();

	    if( ! $ticket_description = get_field( 'ticket_description', $post->ID ) ) {
	    	$ticket_description = wp_trim_words( $product->get_short_description(), 30 );
	    }

    	header('Content-Type:text/plain');

    	echo '^XA' . "\n";

		// Area 1 - Price
    	echo '^CF0,32' . "\n";
    	//echo '^A@,,,E:TIM000.FNT' . "\n"
    	echo '^FO12,38' . "\n";
    	echo '^A0B^FD'.$price.'^FS' . "\n";

		// Area 2 - Details
		// Price
    	echo '^CF0,19' . "\n";
    	echo '^A@,,,E:TIM000.FNT' . "\n";
    	echo '^FO54,28' . "\n";
    	echo '^FD'.$price.'^FS' . "\n";

		// SKU
    	echo '^CF0,14' . "\n";
    	echo '^FO54,46' . "\n";
    	echo '^FD'.$sku.'^FS' . "\n";

		// Description
    	echo '^CF0,14' . "\n";
    	echo '^FO54,60' . "\n";
    	echo '^FD'.$ticket_description.'^FS' . "\n";

		// Weight
    	echo '^CF0,14' . "\n";
    	echo '^FO54,86' . "\n";
    	echo '^FD'.$weight.'^FS' . "\n";

		// Area 3 - Barcode
    	echo '^FO62,114' . "\n";
    	echo '^BY1' . "\n";
    	echo '^B8N,50,Y^FD'.$sku.'^FS' . "\n";

    	echo '^XZ' . "\n";

    	exit;

    }

}
