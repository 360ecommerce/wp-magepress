<?php

class Magepress_User
{
    public static function get_current_user() 
    {
        if( isset( $_COOKIE['magepress_user'] ) ) {
            $user = maybe_unserialize( base64_decode( maybe_unserialize( $_COOKIE['magepress_user'] ) ) );
            return $user;
        }
        return null;
    }
}