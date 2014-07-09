<?php

/**
 * mage_generate_hash - Generates a hash based on two vars
 *
 * @access public
 * @return string
 */
function mage_generate_hash( $one, $two = null )
{
	return substr( md5( $one . maybe_serialize( $two ) ), 0, 24 );
}

/**
 * mage_get_cache - Get a cache object (transient)
 *
 * @access public
 * @return string|array
 */
function mage_get_cache( $hash )
{
	return Magepress_Cache::get( $hash );
}

/**
 * mage_set_cache - Set a cache object (transient)
 *
 * @access public
 * @return bool
 */
function mage_set_cache( $hash, $title, $object, $name )
{
	return Magepress_Cache::set( $hash, $title, $object, $name );
}

/**
 * mage_purge_cache - Purge a cache object (transient)
 *
 * @access public
 * @return bool
 */
function mage_purge_cache( $hash )
{
	return Magepress_Cache::purge( $hash );
}

/**
 * mage_get_cart_count - Get the curren cart (from cookie)
 *
 * @access public
 * @return bool
 */
function mage_get_cart_count()
{
	return Magepress_Checkout::get_cart_count();
}

/**
 * get_recently_viewed - Get recently viewed products (from cookie)
 *
 * @access public
 * @return bool
 */
function mage_get_recently_viewed()
{
	return Magepress_Product::get_recently_viewed();
}

/**
 * mage_get_user - Get current logged in user (from cookie)
 *
 * @access public
 * @return bool
 */
function mage_get_current_user()
{
	return Magepress_User::get_current_user();
}