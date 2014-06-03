<?php

class Magepress_Product 
{
    public static function get_product_list( $filters ) {
        $products = Magepress::call(
            'catalog_product.list', 
            array( 
                'filters' => $filters, 
                'storeView' => MAGEPRESS_MAGENTO_STORE 
            ), 
            'Product List'
        );
        return $products;
    }

    public static function get_product( $id ) {
        $product = self::call(
            'catalogproduct.info', 
            array( 
                'productId' => $id, 
                'storeView' => MAGEPRESS_MAGENTO_STORE 
            ), 
            "Product (ID: $id)"
        );
        return $_product;
    }

    public static function get_recently_viewed_products() 
    {
        if( isset( $_COOKIE['magepress_recently_viewed'] ) ) {
            $viewed = maybe_unserialize( base64_decode( maybe_unserialize( $_COOKIE['magepress_recently_viewed'] ) ) );
            return $viewed;
        }
        return null;
    }
}