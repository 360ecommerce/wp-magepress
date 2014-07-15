<?php

class Magepress_Checkout extends Magepress_Entity
{
	/**
     * Get cart count
     * Uses cookie
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    public static function get_cart_count() 
    {
        if( isset( $_COOKIE['magepress_cart_count'] ) ) {
            return maybe_unserialize( $_COOKIE['magepress_cart_count'] );
        }
        return null;
    }
}