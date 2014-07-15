<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Magepress_Options
{
    /**
     * Array with settings
     */
    var $settings;

    /**
     * Constructor
     * Calls function to add settings
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function __construct()
	{
        // Settings
        add_action( 'admin_init', array( &$this, 'set_settings' ) );
        add_action( 'admin_init', array( &$this, 'add_settings' ) );
	}

    /**
     * Set settings
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    function set_settings()
    {
        $this->settings = array(
            'magepress_magento'     => array( 
                'magepress_magento'         => array(
                    'id'                    => 'magepress_magento',
                    'title'                 => '',
                    'callback'              => array( &$this, 'callback_section' ),
                    'fields'                => array(
                        array(
                            'id'            => 'magepress_magento_url',
                            'title'         => 'URL',
                            'callback'      => array( &$this, 'callback_text' ),
                        ),
                        array(
                            'id'            => 'magepress_magento_store',
                            'title'         => 'Storeview',
                            'callback'      => array( &$this, 'callback_text' ),
                        ),
                        array(
                            'id'            => 'magepress_use_cache',
                            'title'         => 'Use Cache',
                            'callback'      => array( &$this, 'callback_checkbox' ),
                        ),
                        array(
                            'id'            => 'magepress_caching_time',
                            'title'         => 'Caching Time',
                            'callback'      => array( &$this, 'callback_text' ),
                        )
                    )
                )
            ),
            'magepress_api'         => array(
                'magepress_api'             => array(
                    'id'                    => 'magepress_api',
                    'title'                 => '',
                    'callback'              => array( &$this, 'callback_section' ),
                    'fields'                => array(
                        array(
                            'id'            => 'magepress_api_url',
                            'title'         => 'API URL',
                            'callback'      => array( &$this, 'callback_text' ),
                        ),
                        array(
                            'id'            => 'magepress_api_user',
                            'title'         => 'API User',
                            'callback'      => array( &$this, 'callback_text' ),
                        ),
                        array(
                            'id'            => 'magepress_api_key',
                            'title'         => 'API Key',
                            'callback'      => array( &$this, 'callback_text' ),
                        ),
                    )
                )
            )
        );
    }

    /**
     * Add settings to Wordpress
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    function add_settings()
    {
        // Data
        foreach( $this->settings as $page => $data )
        {
            // Sections
            foreach( $data as $section )
            {
                add_settings_section(
                    $section['id'], 
                    $section['title'],
                    $section['callback'],
                    $page
                );

                // Settings
                foreach( $section['fields'] as $setting )
                {
                    register_setting( $section['id'], $setting['id'] );

                    add_settings_field(
                        $setting['id'],
                        $setting['title'],
                        $setting['callback'],
                        $page,
                        $section['id'],
                        array( 'id' => $setting['id'], 'section' => $section['id'] )
                    );
                }
            }
        }
    }

    function callback_section( $hoi )
    {

    }

    /**
     * Callback for textfields
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    function callback_text( $args )
    {
        $value = get_option( $args['id'] );
        $value = ! empty( $value ) ? esc_attr( $value ) : '';

        printf( '<input type="text" id="' . $args['id'] . '" name="' . $args['id'] . '" value="%s" />', $value );
    }

    /**
     * Callback for checkboxes
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    function callback_checkbox( $args )
    {
        $value      = get_option($args['id']);
        $checked    = checked( 1, $value, false );

        echo '<input type="checkbox" id="' . $args['id'] . '" name="' . $args['id'] . '" value="1" ' . $checked . ' />';
    }
}