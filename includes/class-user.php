<?php

class Magepress_User
{
	/**
     * Get current user
     * From cookie
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    public static function get_current_user() 
    {
        if( isset( $_COOKIE['magepress_user'] ) ) {
            return maybe_unserialize( base64_decode( maybe_unserialize( $_COOKIE['magepress_user'] ) ) );
        }
        return null;
    }
}