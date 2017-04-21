<?php

final class BB_Novy_Admin_Settings {

    static public function init()
    {

        add_action( 'plugins_loaded', __CLASS__ . '::init_hooks' );

    }

    static public function init_hooks()
    {
        if ( ! is_admin() ) {
            return;
        }

        add_action( 'admin_enqueue_scripts', __CLASS__ . '::styles_scripts' );
    }

    static public function styles_scripts()
    {

        wp_register_style( 'novy-admin-menu-style', NOVY_URL . 'assets/css/novy-admin-menu.css' );
        wp_enqueue_style( 'novy-admin-menu-style' );
    }

    function novy_admin_menu()
    {
        add_options_page( 'Novy Options', 'Novy', 'manage_options', 'novy-settings', __CLASS__ . '::novy_admin_options' );
    }

    function novy_admin_options() 
    {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'Autorisations insuffisantes pour accéder aux paramétrages.' ) );
        }

        include NOVY_DIR . 'includes/novy-ui-admin-settings.php';    
    }

    function add_novy_menu()
    {
        add_action( 'admin_menu', BB_Novy_Admin_Settings . '::novy_admin_menu' );
    }

}

BB_Novy_Admin_Settings::init();
BB_Novy_Admin_Settings::add_novy_menu();
