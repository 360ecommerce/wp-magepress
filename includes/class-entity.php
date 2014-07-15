<?php

class Magepress_Entity 
{
	/**
	 * Build arguments/filters used for Magento API
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    public static function arguments( $arguments = array() ) 
    {
        return array_merge(
            array( 'storeView' => MAGEPRESS_MAGENTO_STORE ),
            $arguments
        );
    }
}