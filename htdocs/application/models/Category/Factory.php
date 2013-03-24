<?php
/**
 * @class Category_Factory
 */
class Category_Factory
{
    
    /**
     * Creates new Category object
     * 
     * @param array $data Array of valid data.
     * @return Address
     */
    public static function create(array $data)
    {
        $category = new Category();
        
        $category->name = $data[FieldIdEnum::CATEGORY_NAME];
        $category->description = $data[FieldIdEnum::CATEGORY_DESCRIPTION];
        $category->parent_category_id = empty($data[FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID]) ? null : $data[FieldIdEnum::CATEGORY_PARENT_CATEGORY_ID];
        
        return $category;
    }
}
