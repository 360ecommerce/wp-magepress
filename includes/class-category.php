<?php

class Magepress_Category 
{
    public static function get_category_tree( $id ) 
    {
        $categories = Magepress::call(
            'catalog_category.tree', 
            array( 
                'parentId' => $id, 
                'storeView' => MAGEPRESS_MAGENTO_STORE 
            ),
            "Category Tree (ID: $id)"
        );
        return $categories;
    }

    public static function get_category_level( $id ) 
    {
        $categories = Magepress::call(
            'catalog_category.level', 
            array( 
                'parentCategory' => $id, 
                'storeView' => MAGEPRESS_MAGENTO_STORE 
            ),
            "Category Level (ID: $id)"
        );
        return $categories;
    }

    public static function get_category_info( $id ) 
    {
        $category      = Magepress::call(
            'catalog_category.info', 
            array( 
                'categoryId' => $id, 
                'storeView' => MAGEPRESS_MAGENTO_STORE 
            ),
            "Category Info (ID: $id)"
        );
        return $category;
    }

    public static function get_category_assigned_products( $id ) 
    {
        $products = Magepress::call(
            'catalog_category.assignedProducts', 
            array( 
                'categoryId' => $id 
            ),
            "Category Assigned Products (ID: $id)"
        );
        return $products;
    }
}