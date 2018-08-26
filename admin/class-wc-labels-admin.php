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
	        'normal', 
	        'default'
	    );
	
	}


	/**
	 * Render the meta box
	 *
	 * @since    1.0.0
	 */
	public function printable_label_meta_box_callback( $post ) {

	    // Add a nonce field so we can check for it later.
	    wp_nonce_field( 'printable_label_nonce', 'printable_label_nonce' );

	    $value = get_post_meta( $post->ID, '_printable_label', true );

	    echo '<textarea style="width:100%" id="printable_label" name="printable_label">Test' . esc_attr( $value ) . '</textarea>';
	}

}
