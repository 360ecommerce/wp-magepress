<?php

/*
Plugin Name: 	Magepress
Plugin URI: 	https://github.com/360ecommerce/magepress
Description: 	Wordpress plugin to integrate Magento
Version: 		0.1
Author: 		360ecommerce
Author URI: 	http://360ecommerce.nl
License: 		GPL2
*/

if( ! defined( 'ABSPATH' ) ) exit;

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 * 
 * @author Gijs Jorissen
 * @since 0.1
 */
register_activation_hook( __FILE__, array( 'Magepress', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Magepress', 'deactivate' ) );


if( ! class_exists( 'Magepress' ) ) :

/**
 * Magepress
 */
class Magepress
{
    /**
     * Instance
     */
	private static $instance;

    /**
     * Method to set or return instance
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	public static function instance()
	{
		if ( ! isset( self::$instance ) ) 
		{
			self::$instance = new Magepress;
			self::$instance->setup_constants();
			self::$instance->includes();
			self::$instance->add_hooks();
			self::$instance->execute();
		}
		
		return self::$instance;
	}

    /**
     * Setups constants (including settings)
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function setup_constants()
	{
		if( ! defined( 'MAGEPRESS_VERSION' ) ) 
			define( 'MAGEPRESS_VERSION', '0.1' );

		if( ! defined( 'MAGEPRESS_DIR' ) ) 
			define( 'MAGEPRESS_DIR', plugin_dir_path( __FILE__ ) );

		if( ! defined( 'MAGEPRESS_URL' ) ) 
			define( 'MAGEPRESS_URL', plugin_dir_url( __FILE__ ) );

		if( ! defined( 'MAGEPRESS_CACHE_PREFIX' ) ) 
			define( 'MAGEPRESS_CACHE_PREFIX', apply_filters( 'magepress_cache_prefix', 'magepress_cache_' ) );

        // Settings
		if( ! defined( 'MAGEPRESS_MAGENTO_URL' ) ) 
			define( 'MAGEPRESS_MAGENTO_URL', get_option( 'magepress_magento_url' ) );

        if( ! defined( 'MAGEPRESS_MAGENTO_STORE' ) )
            define( 'MAGEPRESS_MAGENTO_STORE', get_option( 'magepress_magento_store' ) );

        if( ! defined( 'MAGEPRESS_API_URL' ) ) 
            define( 'MAGEPRESS_API_URL', get_option( 'magepress_api_url' ) );

		if( ! defined( 'MAGEPRESS_API_USER' ) ) 
			define( 'MAGEPRESS_API_USER', get_option( 'magepress_api_user' ) );

		if( ! defined( 'MAGEPRESS_API_KEY' ) ) 
			define( 'MAGEPRESS_API_KEY', get_option( 'magepress_apii_key' ) );

        if( ! defined( 'MAGEPRESS_USE_CACHE' ) ) 
            define( 'MAGEPRESS_USE_CACHE', get_option('magepress_use_cache') );

        if( ! defined( 'MAGEPRESS_CACHING_TIME' ) ) 
            define( 'MAGEPRESS_CACHING_TIME', get_option('magepress_caching_time') );
	}

    /**
     * Includes required files
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function includes()
	{
        // Core
		include( MAGEPRESS_DIR . 'includes/class-admin.php' );
        include( MAGEPRESS_DIR . 'includes/class-cache.php' );
        include( MAGEPRESS_DIR . 'includes/class-cache-table.php' );
		include( MAGEPRESS_DIR . 'includes/class-content-types.php' );
		include( MAGEPRESS_DIR . 'includes/class-shortcodes.php' );

        // Entities
        include( MAGEPRESS_DIR . 'includes/class-category.php' );
        include( MAGEPRESS_DIR . 'includes/class-product.php' );
        include( MAGEPRESS_DIR . 'includes/class-checkout.php' );

        // Functions
        include( MAGEPRESS_DIR . 'includes/functions.php' );        
	}

    /**
     * Add hooks
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function add_hooks()
	{
		// Styles
		add_action( 'wp_enqueue_scripts',	array( &$this, 'register_styles' ) );
		add_action( 'wp_enqueue_scripts', 	array( &$this, 'enqueue_styles' ) );
		
		// Scripts
		add_action( 'wp_enqueue_scripts', 	array( &$this, 'register_scripts' ) );
		add_action( 'wp_enqueue_scripts', 	array( &$this, 'enqueue_scripts' ) );
	}

    /**
     * Execute needed methods
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function execute()
	{
		self::$instance->admin 			= new Magepress_Admin;
		self::$instance->content_types 	= new Magepress_Content_Types;
		self::$instance->shortcodes 	= new Magepress_Shortcodes;
	}

    /**
     * Register styles
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function register_styles()
	{		
		wp_register_style( 'magepress', MAGEPRESS_URL . 'assets/css/magepress.css', false, MAGEPRESS_VERSION, 'screen' );
	}

    /**
     * Enqueue styles
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function enqueue_styles()
	{
		wp_enqueue_style( 'magepress' );
	}

    /**
     * Register scripts
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function register_scripts()
	{
		wp_register_script( 'magepress', MAGEPRESS_URL . 'assets/js/magepress.js', null, MAGEPRESS_VERSION );
	}
	
    /**
     * Enqueue scripts
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function enqueue_scripts()
	{
		wp_enqueue_script( 'magepress' );
		
		self::localize_scripts();
	}

    /**
     * Localize scripts
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function localize_scripts()
	{
		wp_localize_script( 'magepress', 'Magepress', array(
			'home_url'			=> get_home_url(),
			'ajax_url'			=> admin_url( 'admin-ajax.php' ),
			'wp_version'		=> get_bloginfo( 'version' )
		) );
	}

    /**
     * For activation
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    static function activate()
    {
    }

    /**
     * For deactivation
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    static function deactivate()
    {
    }

    /**
     * Setup new SoapClient
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	static function soap()
    {
        if( MAGEPRESS_API_USER ) {
        	return new SoapClient( MAGEPRESS_API_URL, array( 'trace' => 1 ) );
        } else {
            return false;
        }
    }

    /**
     * Login to SoapClient
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	static function login( $force = false )
    {
        $session = mp_get_cache( mp_generate_hash( 'session' ) );
        
        if( $session && !$force ) {
            $session = $session;
        } elseif( $client = self::soap() ) {
        	$session = $client->login( MAGEPRESS_API_USER, MAGEPRESS_API_KEY );
        	mp_set_cache( mp_generate_hash( 'session' ), 'Login', $session, 'login' );
        }

        return $session;
    } 

    /**
     * Fire call
     * Tries to retrieve cache, otherwise build it
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    static function call( $hash, $args, $name, $tries = 0 ) 
    {
        // Get cache if cache enabled
        if( MAGEPRESS_USE_CACHE ) {
            $cache = mp_get_cache( mp_generate_hash( $hash, $args ) );
            if( $cache ) {
                return $cache;
            }
        }

        // Run call
        try {
            $response = self::soap()->call( self::login(), $hash, $args );
        } catch( Exception $e ) {
            if( ( $e->getCode() == 0 || $e->getCode() == 1 ) && $tries < 2 ) {
                self::login( true );
                return self::call( $hash, $args, $name, $tries += 1 );
            }
        }

        // Set cache
        if( isset( $response ) ) {
            if( MAGEPRESS_USE_CACHE ) {
                mp_set_cache( mp_generate_hash( $hash, $args), $name, $response, $hash );
            }
            return $response;
        }

        return false;
    }

    /**
     * Get template
     * Searches for plugin, theme, child theme
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    static function get_template( $templates, $args, $load = false, $require_once = true )
    {
        // No file found yet
        $located = false;
     
        foreach ( (array) $templates as $template ) 
        {
            // Continue if template is empty
            if ( empty( $template ) ) {
                continue;
            }
     
            // Trim off any slashes from the template name
            $template = ltrim( $template, '/' );
     
            // Check child theme first
            if ( file_exists( trailingslashit( get_stylesheet_directory() ) . 'magepress/' . $template ) ) {
                $located = trailingslashit( get_stylesheet_directory() ) . 'magepress/' . $template;
                break;
     
            // Check parent theme next
            } elseif ( file_exists( trailingslashit( get_template_directory() ) . 'magepress/' . $template ) ) {
                $located = trailingslashit( get_template_directory() ) . 'magepress/' . $template;
                break;
     
            // Check theme compatibility last
            } elseif ( file_exists( trailingslashit( MAGEPRESS_DIR ) . 'templates/' . $template ) ) {
                $located = trailingslashit( MAGEPRESS_DIR ) . 'templates/' . $template;
                break;
            }
        }
        
        // Start OB
        ob_start();

        // Extract args
        extract($args);

        // Require when exists
        if( ! empty( $located ) ) {
            require_once $located;
        }

        $output = ob_get_clean();
        
        return $output;
    }

    /**
     * Update a registry
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    static function update_registry( $name, $args )
    {
        $registry = get_option( $name, array() );
        $registry[$args['hash']] = array(
            'ID'    => $args['hash'],
            'hash'  => $args['hash'],
            'name'  => $args['name'],
            'call'  => $args['call'],
        );

        update_option( $name, $registry );
    }
}

endif; // End class_exists check

Magepress::instance();