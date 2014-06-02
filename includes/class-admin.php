<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Magepress_Admin
{
    var $settings;

	function __construct()
	{
        // Settings
        add_action('admin_init', array( &$this, 'set_settings' ));
        add_action('admin_init', array( &$this, 'add_settings' ));

        // Page
		add_action('admin_menu', array( &$this, 'admin_menu' ));
	}

    function set_settings()
    {
        $this->settings = array(
            'magepress' => array(
                'magepress_settings'        => array( 
                    'id'                    => 'magepress_settings',
                    'title'                 => 'Settings',
                    'callback'              => '',
                    'fields'                => array(
                        'magepress_url'     => array(
                            'id'            => 'magepress_api_url',
                            'title'         => 'Magento API Url',
                            'callback'      => array( &$this, 'callback_text' ),
                        ),
                        'magepress_storeview'   => array(
                            'id'                => 'magepress_storeview',
                            'title'             => 'Magento API Store',
                            'callback'          => array( &$this, 'callback_text' ),
                        ),
                        'magepress_user'    => array(
                            'id'            => 'magepress_user',
                            'title'         => 'Magento API User',
                            'callback'      => array( &$this, 'callback_text' ),
                        ),
                        'magepress_key'     => array(
                            'id'            => 'magepress_key',
                            'title'         => 'Magento API Key',
                            'callback'      => array( &$this, 'callback_text' ),
                        ),
                        'magepress_use_cache' => array(
                            'id'            => 'magepress_use_cache',
                            'title'         => 'Use Cache',
                            'callback'      => array( &$this, 'callback_checkbox' ),
                        ),
                        'magepress_caching_time' => array(
                            'id'            => 'magepress_caching_time',
                            'title'         => 'Caching Time',
                            'callback'      => array( &$this, 'callback_text' ),
                        )
                    )
                )
            )
        );
    }

    function add_settings()
    {
        foreach( $this->settings as $page => $data )
        {
            foreach( $data as $section )
            {
                add_settings_section(
                    $section['id'], 
                    $section['title'],
                    $section['callback'],
                    $page
                );

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

    function admin_menu()
    {
        add_options_page(
            __( 'Magepress', 'magepress' ),
            __( 'Magepress', 'magepress' ),
            'manage_options',
            'magepress',
            array( &$this, 'admin_page' )
        ); 
    }

    function admin_page() 
    {
        $tab = ( isset( $_GET[ 'tab' ] ) ) ? $_GET['tab'] : 'settings';
        ?>
        <div class="wrap">
            <?php echo $this->tabs( $tab ); ?>
 
            <div class="metabox-holder">
                <?php 
                switch( $tab ) :
                    case 'cache' :
                        $this->cache_tab();
                    break;
                    default :
                        $this->settings_tab();
                    break;
                endswitch;
                ?>
            </div>
        </div>
        <?php
    }

    function tabs( $tab )
    {
        ?>
        <h2 class="nav-tab-wrapper">
            <a href="<?php echo admin_url( 'options-general.php?page=magepress' ) ?>" class="nav-tab <?php if($tab == 'settings'): ?>nav-tab-active<?php endif; ?>">
                <?php _e( 'Settings', 'magepress' ) ?>
            </a>
            <a href="<?php echo admin_url( 'options-general.php?page=magepress&tab=cache' ) ?>" class="nav-tab <?php if($tab == 'cache'): ?>nav-tab-active<?php endif; ?>">
                <?php _e( 'Cache', 'magepress' ) ?>
            </a>
        </h2>
        <?php
    }

    function settings_tab()
    {
        echo '<form method="post" action="options.php">';
            settings_fields( 'magepress_settings' );
            do_settings_sections( 'magepress' );
            submit_button();
        echo '</form>';
    }

    function cache_tab()
    {
        $registry   = get_option( 'magepress_cache_registry' );
        $table      = new Magepress_Cache_Table();

        echo '<form id="magepress-cache-table" method="post">';
            $table->prepare_items(); 
            $table->display(); 
        echo '</form>';
    }

    function callback_text( $args )
    {
        $value  = get_option( $args['id'] );

        printf( '<input type="text" id="' . $args['id'] . '" name="' . $args['id'] . '" value="%s" />', ! empty( $value ) ? esc_attr( $value ) : '' );
    }

    function callback_checkbox( $args )
    {
        $value  = get_option($args['id']);

        echo '<input type="checkbox" id="' . $args['id'] . '" name="' . $args['id'] . '" value="1" ' . checked( 1, $value, false ) . ' />';
    }
}