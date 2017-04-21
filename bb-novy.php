<?php
/**
 * Plugin Name: Novy
 * Plugin URI: http://novfr.com/
 * Description: Plugin qui facilite la gestion de contenu.
 * Version: 2.0
 * Author: NOVFR
 * Author URI: http://novfr.com/
 */

final class BB_Novy {

	public static $instance;

	public function __construct()
	{

		$this->define_constants();

		/* Hooks */
		$this->init_hooks();

		/* Classes */
		//require_once 'classes/novy-admin-settings.php';
	}

	private function define_constants()
	{
		define( 'NOVY_DIR', plugin_dir_path( __FILE__ ) );
		define( 'NOVY_URL', plugins_url( '/', __FILE__ ) );
	}

	public function init_hooks()
	{

		require_once 'novy-admin-settings.php'; 

		add_action( 'plugins_loaded', array( $this, 'loader' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ), 10000 );
	}

	public function loader()
	{
		if ( !is_admin() && class_exists( 'FLBuilder' ) ) {

			require_once 'includes/novy-functions.php';
		}
	}

	public function load_scripts()
	{
		wp_register_style( 'novy-animate', NOVY_URL . 'assets/css/animate.min.css' );
		wp_register_style( 'novy-panel-style', NOVY_URL . 'assets/css/novy-panel.css' );
		wp_register_style( 'novy-admin-menu-style', NOVY_URL . 'assets/css/novy-admin-menu.css' );
		wp_register_script( 'novy-panel-script', NOVY_URL . 'assets/js/novy-panel.js', array( 'jquery' ), rand(), true );

		wp_enqueue_style( 'novy-animate' );
		if ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) {
			wp_enqueue_style( 'novy-panel-style' );
			wp_enqueue_style( 'novy-admin-menu-style' );
			wp_enqueue_script( 'novy-panel-script' );
		}
	}

	public static function get_instance()
	{
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof BB_Novy ) ) {
			self::$instance = new BB_Novy();
		}

		return self::$instance;
	}

}

$bb_novy = BB_Novy::get_instance();