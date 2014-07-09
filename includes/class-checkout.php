<?php

class Magepress_Checkout
{
    public static function get_cart_count() 
    {
        if( isset( $_COOKIE['magepress_cart_count'] ) ) {
            $cart = maybe_unserialize( maybe_unserialize( $_COOKIE['magepress_cart_count'] ) );
            return $cart;
        }
        return null;
    }
}