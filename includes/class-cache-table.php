<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Check if 'class-wp-list-table.php' is available
 */
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Cache table
 *
 * @class 		Magepress_Cache_Table
 * @version		0.1
 * @package		Magepress/Classes
 * @category	Class
 * @author 		360ecommerce
 */
class Magepress_Cache_Table extends WP_List_Table
{
	/**
     * Get bulk actions
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function get_bulk_actions() 
	{
		return array(
			'purge_all'	=> __( 'Purge All', 'magepress' )
		);
	}

	/**
     * Get table columns
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function get_columns()
	{
		return array(
			'cb'		=> '<input type="checkbox" />',
			'name' 		=> 'Name',
			'hash'    	=> 'Hash',
			'call'		=> 'Call',
			'purge'     => 'Purge'
		);
	}

	/**
     * Define sortable columns
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function get_sortable_columns() 
	{
        return array(
            'name'  	=> array( 'name', false )
        );
    }

    /**
     * Populate items
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function prepare_items() 
	{
		$columns 		= $this->get_columns();
		$hidden 		= array();
		$sortable 		= array();
		
		// Set properties
		$this->_column_headers 	= array( $columns, $hidden, $sortable );
		$this->items 			= get_option( 'magepress_cache_registry', array() );

		// Listen for bulk actions
		$this->process_action();
	}

	/**
     * Default output
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function column_default( $item, $column )
	{
		switch( $column ) { 
			case 'name':
			case 'call':
				return @$item[$column];
				break;
			case 'hash':
				return str_replace( MAGEPRESS_CACHE_PREFIX, '', $item[$column] );
				break;
			case 'purge':
				printf( '<a href="' . admin_url( 'options-general.php?page=magepress&tab=cache&purge=' . $item['hash'] ) . '">%s</a>', __('Purge', 'magepress') );
				break;
			default:
				return print_r( $item, true );
				break;
		}
	}

	/**
     * Output for checkbox
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function column_cb($item) 
	{
        return sprintf( '<input type="checkbox" name="cache[]" value="%s" />', $item['id'] );    
    }

    /**
     * Processor for actions
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    function process_action() 
    {
    	// Bulk actions
    	switch( $this->current_action() ) :
    		case 'purge_all' :
    			Magepress_Cache::purge_all();
    		break;
    	endswitch;

    	// Single actions
    	if( isset( $_GET['purge'] ) ) {
    		$hash = $_GET['purge'];
    		mage_purge_cache( $hash );
    	}
    }
}