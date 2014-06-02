<?php

class Magepress_Category 
{
    public static function getCategoryTree( $id ) 
    {
        $categories = Magepress::call(
            'catalog_category.tree', 
            array( 
                'parentId' => $id, 
                'storeView' => MAGEPRESS_API_STORE 
            ),
            "Category Tree (ID: $id)"
        );

        return $categories;
    }

    public static function getCategoryLevel( $id ) 
    {
        $categories = Magepress::call(
            'catalog_category.level', 
            array( 
                'parentCategory' => $id, 
                'storeView' => MAGEPRESS_API_STORE 
            ),
            "Category Level (ID: $id)"
        );

        return $categories;
    }

    public static function getCategoryInfo( $id ) 
    {
        $category      = Magepress::call(
            'catalog_category.info', 
            array( 
                'categoryId' => $id, 
                'storeView' => MAGEPRESS_API_STORE 
            ),
            "Category Info (ID: $id)"
        );

        return $category;
    }

    public static function getCategoryAssignedProducts( $id ) 
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