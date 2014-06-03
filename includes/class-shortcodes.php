<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Magepress_Shortcodes
{
	function __construct()
	{
		add_shortcode( 'magepress-category-list', array( &$this, 'category_list' ) );
		add_shortcode( 'magepress-product-list', array( &$this, 'product_list' ) );
	}

	function category_list( $atts, $content = null )
	{
		extract( shortcode_atts( array(
			'id'		=> 0,
			'class'		=> '',
		), $atts ) );

		$categories = Magepress_Category::get_category_tree( $id );
        $content 	= Magepress::get_template( 'category-list.php', array( 'categories' => $categories ) );

        return $content;
	}

	function product_list( $atts, $content = null )
	{
		extract( shortcode_atts( array(
            'type'      	=> 'list',
            'count'			=> 4,
            'details'   	=> false,
            'ids'           => null
        ), $atts ) );

		// Set filters
        $filters = array( 'count' => $count );
        if( $ids ) {
            $filters['ids'] = explode( ',', $ids );
        }

        // Get collection
        $collection 	= Magepress_Product::get_product_list( $filters );
        $products 		= $collection ? $collection : array();

        $content = Magepress::get_template( 'product-list.php', array( 'products' => $products, 'type' => $type ) );
        
        return $content;
	}
}