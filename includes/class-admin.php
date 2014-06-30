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
		add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
	}

    /**
     * Add item to menu
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
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

    /**
     * Admin page
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    function admin_page() 
    {
        $tab = ( isset( $_GET[ 'tab' ] ) ) ? $_GET['tab'] : 'magento';
        ?>
        <div class="wrap">
            <?php echo $this->tabs( $tab ); ?>
 
            <div class="metabox-holder">
                <?php 
                switch( $tab ) :
                    case 'cache' :
                        $this->cache_tab();
                    break;
                    case 'api' :
                        $this->api_tab();
                    break;
                    case 'magento' :
                        $this->magento_tab();
                    break;
                endswitch;
                ?>
            </div>
        </div>
        <?php
    }

    /**
     * Output tabs
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    function tabs( $tab )
    {
        ?>
        <h2 class="nav-tab-wrapper">
            <a href="<?php echo admin_url( 'options-general.php?page=magepress' ) ?>" class="nav-tab <?php if($tab == 'magento'): ?>nav-tab-active<?php endif; ?>">
                <?php _e( 'Magento', 'magepress' ) ?>
            </a>
            <a href="<?php echo admin_url( 'options-general.php?page=magepress&tab=api' ) ?>" class="nav-tab <?php if($tab == 'api'): ?>nav-tab-active<?php endif; ?>">
                <?php _e( 'API', 'magepress' ) ?>
            </a>
            <a href="<?php echo admin_url( 'options-general.php?page=magepress&tab=cache' ) ?>" class="nav-tab <?php if($tab == 'cache'): ?>nav-tab-active<?php endif; ?>">
                <?php _e( 'Cache', 'magepress' ) ?>
            </a>
        </h2>
        <?php
    }

    /**
     * Settings tab
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    function magento_tab()
    {
        echo '<form method="post" action="options.php">';
            settings_fields( 'magepress_magento' );
            do_settings_sections( 'magepress_magento' );
            submit_button();
        echo '</form>';
    }

    /**
     * Settings tab
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    function api_tab()
    {
        echo '<form method="post" action="options.php">';
            settings_fields( 'magepress_api' );
            do_settings_sections( 'magepress_api' );
            submit_button();
        echo '</form>';
    }

    /**
     * Cache tabs
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    function cache_tab()
    {
        $registry   = get_option( 'magepress_cache_registry' );
        $table      = new Magepress_Cache_Table();

        echo '<form id="magepress-cache-table" method="post">';
            $table->prepare_items(); 
            $table->display(); 
        echo '</form>';
    }
}