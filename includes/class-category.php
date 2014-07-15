<?php

class Magepress_Category extends Magepress_Entity
{
    /**
     * Get category view
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    public static function get_category_tree( $id ) 
    {
        $categories = Magepress::call(
            'catalog_category.tree', 
            self::arguments( array( 'parentId' => $id ) ),
            "Category Tree (ID: $id)"
        );
        return $categories;
    }

    /**
     * Get category info
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    public static function get_category_info( $id ) 
    {
        $category      = Magepress::call(
            'catalog_category.info', 
            self::arguments( array( 'categoryId' => $id ) ),
            "Category Info (ID: $id)"
        );
        return $category;
    }

    /**
     * Get category level
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    public static function get_category_level( $id ) 
    {
        $categories = Magepress::call(
            'catalog_category.level', 
            self::arguments( array( 'parentCategory' => $id, ) ),
            "Category Level (ID: $id)"
        );
        return $categories;
    }

    /**
     * Get category assigned products
     *
     * @author Gijs Jorissen
     * @since 0.1
     */
    public static function get_category_assigned_products( $id ) 
    {
        $products = Magepress::call(
            'catalog_category.assignedProducts', 
            self::arguments( array( 'categoryId' => $id ) ),
            "Category Assigned Products (ID: $id)"
        );
        return $products;
    }
}