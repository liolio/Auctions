<?php

/**
 * Category
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Category extends BaseCategory
{

    public function getCategoryAllParentIds()
    {
        $parent = $this->Category;
        $parentIds = array();
        
        do {
            if (!is_null($parent->id))
                $parentIds[] = $parent->id;
            
            $parent = $parent->Category;
        } while (!is_null($parent->id));
        
        return $parentIds;
    }
    
}