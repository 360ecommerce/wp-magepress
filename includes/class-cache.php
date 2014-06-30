<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Magepress_Cache
{
    /**
     * Get a Magepress Cache object, based on hash
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    static function get( $hash )
    {
        if( ! MAGEPRESS_USE_CACHE ) {
            return null;
        }

        if( $result = get_transient( $hash ) ) {
            return maybe_unserialize( $result );
        }
    }

    /**
     * Set a Cache object
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    static function set( $hash, $name, $object, $call )
    {
        if( ! MAGEPRESS_USE_CACHE ) {
            return null;
        }

        // Prefix hash
        $hash = self::prefix( $hash );

        // Update registry
        if( $cache = set_transient( $hash, $object, MAGEPRESS_CACHING_TIME ) )  {
            Magepress::update_registry( 'magepress_cache_registry', array(
                'id'    => $hash,
                'hash'  => $hash, 
                'name'  => $name, 
                'call'  => $call
            ) );
        }        
    }

    /**
     * Purge a cache object
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    static function purge( $hash ) 
    {
        $hash       = self::prefix( $hash );
        $registry   = get_option( 'magepress_cache_registry', array() );

        if( delete_transient( $hash ) ) {
            unset( $registry[$hash] );
        }

        if( empty( $registry ) ) {
            delete_option( 'magepress_cache_registry' );
        } else {
            update_option( 'magepress_cache_registry', $registry );
        }
    }

    /**
     * Purge all cache objects
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    static function purge_all()
    {
        $registry = get_option( 'magepress_cache_registry', array() );

        foreach( $registry as $cache ) {
            self::purge( $cache['hash'] );
        }
    }

    /**
     * Prefix a string with Magepress Cache Prefix
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    static function prefix( $hash ) 
    {
        if( strpos( $hash, MAGEPRESS_CACHE_PREFIX ) !== false ) {
            return $hash;
        } else {
            return MAGEPRESS_CACHE_PREFIX . $hash;
        }
    }
}