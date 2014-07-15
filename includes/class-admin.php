<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Magepress_Admin
{
    /**
     * Constructor
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function __construct()
	{
		add_action( 'admin_menu', array( &$this, 'menu' ) );
	}

    /**
     * Add item to menu
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    function menu()
    {
        add_options_page(
            __( 'Magepress', 'magepress' ),
            __( 'Magepress', 'magepress' ),
            'manage_options',
            'magepress',
            array( &$this, 'page' )
        ); 
    }

    /**
     * Admin page
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    function page() 
    {
        include MAGEPRESS_DIR . '/admin/page.php';
    }
}