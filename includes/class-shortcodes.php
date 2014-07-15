<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Magepress_Shortcodes
{
    /**
     * Adds all shortcodes
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function __construct()
	{
		add_shortcode( 'magepress-category-list', array( &$this, 'category_list' ) );
		add_shortcode( 'magepress-product-list', array( &$this, 'product_list' ) );
	}

	/**
     * Category list
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function category_list( $atts, $content = null )
	{
		extract( shortcode_atts( array(
			'id'		=> 0,
			'class'		=> '',
		), $atts ) );

		$tree 		= Magepress_Category::get_category_tree( $id );
		$categories = $tree ? $tree : array();
        $content 	= Magepress::get_template( 'category-list.php', array( 'categories' => $categories ) );

        return $content;
	}

	/**
     * Product list
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
	function product_list( $atts, $content = null )
	{
		extract( shortcode_atts( array(
            'type'      	=> 'list',
            'count'			=> 4,
            'details'   	=> false,
            'ids'           => null
        ), $atts ) );

		// Set filters
        $filters = array( 
        	'count' => $count, 
        	'ids'	=> $ids
        );

        // Get collection
        $collection 	= Magepress_Product::get_product_list( $filters );
        $products 		= $collection ? $collection : array();

        $content = Magepress::get_template( 'product-list.php', array( 'products' => $products, 'type' => $type ) );
        
        return $content;
	}
}