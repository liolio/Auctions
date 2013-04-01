<?php
/**
 * @class Auctions_AuctionController
 */
class Auctions_AuctionController extends Controller_Abstract
{

    public function init()
    {
        Zend_Layout::startMvc();
    }

    public function showListForCategoryAction()
    {
        $this->_setCategoriesList();
        $this->view->auctions = null;
    }
    
    private function _setCategoriesList()
    {
        $categoryId = $this->getRequest()->getParam(FieldIdEnum::CATEGORY_ID);
        $category = CategoryTable::getInstance()->find($categoryId);
        $activeCategories = $category->getCategoryAllParentIds();
        $activeCategories[] = $categoryId;
        $this->view->activeCategoriesIds = $activeCategories;
        
        $this->view->categoriesIdsToShow = CategoryTable::getInstance()->getCategoriesToExpand($category);
        
        $this->view->categories = CategoryTable::getInstance()->getCategoriesList();
    }
    
}