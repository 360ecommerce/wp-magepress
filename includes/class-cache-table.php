<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Check that 'class-wp-list-table.php' is available
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
	function get_bulk_actions() 
	{
		return array(
			'purge'    	=> 'Purge'
		);
	}

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

	function get_sortable_columns() 
	{
        return array(
            'name'  	=> array( 'name', false )
        );
    }

	function prepare_items() 
	{
		$columns 				= $this->get_columns();
		$hidden 				= array();
		$sortable 				= array();
		
		// Set properties
		$this->_column_headers 	= array( $columns, $hidden, $sortable );
		$this->items 			= get_option( 'magepress_cache_registry' );

		// Listen for bulk actions
		$this->process_bulk_action();
	}

	function column_default( $item, $column )  
	{
		switch( $column ) { 
			case 'name':
			case 'call':
			case 'purge':
				return $item[$column];
				break;
			case 'hash':
				return str_replace( MAGEPRESS_CACHE_PREFIX, '', $item[$column] );
				break;
			default:
				return print_r( $item, true );
				break;
		}
	}

	function column_cb($item) 
	{
        return sprintf( '<input type="checkbox" name="cache[]" value="%s" />', $item['ID'] );    
    }

    function process_bulk_action() 
    {
    	switch( $this->current_action() ) :
    		case 'purge' :
    			
    		break;
    	endswitch;
    }
}