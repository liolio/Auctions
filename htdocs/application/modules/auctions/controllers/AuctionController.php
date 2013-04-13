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
    
    public function showAction()
    {
        $auction = AuctionTable::getInstance()->find($this->getRequest()->getParam(FieldIdEnum::AUCTION_ID));
        
        $this->view->auction = $auction;
        $this->view->categoriesCollection = $auction->Category->getCategoryWithParentsForCategory();
    }

    public function showListForCategoryAction()
    {
        $categoryId = $this->getRequest()->getParam(FieldIdEnum::CATEGORY_ID);
        $category = CategoryTable::getInstance()->find($categoryId);
        
        $this->_setCategoriesList($category);
        $this->view->auctionsArray = AuctionTable::getInstance()->getAuctionsAllChildrenAuctions($category, Zend_Date::now());
    }
    
    private function _setCategoriesList(Category $category)
    {
        $activeCategories = $category->getCategoryAllParentIds();
        $activeCategories[] = $category->id;
        $this->view->activeCategoriesIds = $activeCategories;
        
        $this->view->categoriesIdsToShow = CategoryTable::getInstance()->getCategoriesToExpand($category);
        
        $this->view->categories = CategoryTable::getInstance()->getCategoriesList();
    }
    
}