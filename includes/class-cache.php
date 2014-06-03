<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Magepress_Cache
{
	static function set( $hash, $name, $object, $call )
    {
        if( ! MAGEPRESS_USE_CACHE ) {
        	return null;
        }

        // Set hash and transient
        $hash 	= MAGEPRESS_CACHE_PREFIX . $hash;
        $cache 	= set_transient( $hash, $object, get_option( 'magepress_caching_time' ) );

        // Update registry
        Magepress::update_registry( 'magepress_cache_registry', array(
            'hash'  => $hash, 
            'name'  => $name, 
            'call'  => $call 
        ) );

        return true;
    }

    static function get( $hash ) 
    {
        if( ! MAGEPRESS_USE_CACHE ) {
        	return null;
        }

        // Get hash and transient
        $hash   = MAGEPRESS_CACHE_PREFIX . $hash;
        $result = get_transient( $hash );

        if( ! empty( $result ) ) {
            return maybe_unserialize( $result );
        }

        return null;
    } 
}