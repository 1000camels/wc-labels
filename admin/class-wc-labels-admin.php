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
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'wc_labels_options';

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
	 * Load the required dependencies for the Admin facing functionality.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wppb_Demo_Plugin_Admin_Settings. Registers the admin settings and page.
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	// private function load_dependencies() {
	// 	*
	// 	 * The class responsible for orchestrating the actions and filters of the
	// 	 * core plugin.
		 
	// 	require_once plugin_dir_path( dirname( __FILE__ ) ) .  'admin/class-wc-labels-settings.php';
	// }

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
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {
	
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'WC Labels Settings', 'wc-labels' ),
			__( 'WC Labels', 'wc-labels' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);
	
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/wc-labels-admin-display.php';
	}

	/**
	 * Register all related settings of this plugin
	 *
	 * @since  1.0.0
	 */
	public function register_setting() {
		add_settings_section(
			$this->option_name . '_general',
			__( 'General', 'wc-labels' ),
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);
		add_settings_field(
			$this->option_name . '_zpl',
			__( 'ZPL', 'wc-labels' ),
			array( $this, $this->option_name . '_zpl_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_zpl' )
		);
		register_setting( $this->plugin_name, $this->option_name . '_zpl', 'string' );
	}

	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function wc_labels_options_general_cb() {
		echo '<p>' . __( 'Please change the settings accordingly.', 'wc-labels' ) . '</p>';
	}

	/**
	 * Render the audio_selector field
	 *
	 * @since  1.0.0
	 */
	public function wc_labels_options_zpl_cb() {
		$zpl_string = $this->get_zpl();

		echo '<textarea name="'.$this->option_name.'_zpl" id="'.$this->option_name.'_zpl" cols="80" rows="50" class="zpl_text_options">';
		echo $zpl_string;
		echo '</textarea>';

		//$zpl_url_string = urlencode($zpl_string);

		echo '<div class="option-help">';
		echo '<p><b>Available variables</b>: {{price}} {{sku}} {{weight}} {{ticket_description}} {{supplier_stock_code}}</p>';
		echo '<p><a href="https://www.zebra.com/content/dam/zebra/manuals/printers/common/programming/zpl-zbi2-pm-en.pdf" target="_blank">ZPL Manual</a></p>';
		//echo '<p><a href="http://labelary.com/viewer.html?density=6&width=4&height=6&units=inches&index=0&zpl='.$zpl_url_string.'" target="_blank">Online ZPL Viewer</a></p>';
		echo '</div>';
	}

	/**
	 * Add link to settings from Plugin list
	 *
	 * @since  1.0.1
	 */
	function add_plugin_page_settings_link( $links ) {
		$links[] = '<a href="' .
			admin_url( 'options-general.php?page=wc-labels' ) .
			'">' . __('Settings') . '</a>';
		return $links;
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

	    $supplier_stock_code = get_field( 'supplier_stock_code', $post->ID );

	    $variables = array(
	    	'price' => $price,
	    	'sku' => $sku,
	    	'weight' => $weight,
	    	'ticket_description' => $ticket_description,
	    	'supplier_stock_code' => $supplier_stock_code,
	    );


    	header('Content-Type:text/plain');

		echo $this->evaluate_zpl($variables);

    	exit;

    }


   	/**
   	 *
   	 */
    public function evaluate_zpl($variables) {
    	require_once('Mustache/Autoloader.php');
		Mustache_Autoloader::register();

		$m = new Mustache_Engine;
		return $m->render($this->get_zpl(True), $variables);
	}


    public function get_zpl( $remove_blank_lines = False ) {
		$zpl_string = get_option( $this->option_name . '_zpl' );
		if( empty($zpl_string) ) {
    		$zpl_file = plugin_dir_path( __FILE__ ) . 'partials/default-zpl.txt';
    		$zpl_string = file_get_contents($zpl_file);
    	}

    	if( $remove_blank_lines ) {
    		$zpl_string = preg_replace('/^[ \t]*[\r\n]+/m', '', $zpl_string);
    		$zpl_string = preg_replace('/^\/\/.*[\r\n]+/m', '', $zpl_string);
    	}

    	return $zpl_string;
    }

}
