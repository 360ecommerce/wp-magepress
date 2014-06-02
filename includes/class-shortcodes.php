<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Magepress_Shortcodes
{
	function __construct()
	{
		add_shortcode( 'magento-category-list', array( &$this, 'magento_category_list' ) );
	}

	function magento_category_list( $atts, $content = null )
	{
		extract( shortcode_atts( array(
			'class'		=> '',
			'id'		=> 0
		), $atts ) );

		$categories = Magepress_Category::getCategoryTree( $id );
        $content 	= Magepress::get_template( 'category-list.php', array( 'categories' => $categories ) );

        return $content;
	}
}