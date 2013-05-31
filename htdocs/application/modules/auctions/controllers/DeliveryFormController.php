<?php
/**
 * @class Auctions_DeliveryFormController
 */
class Auctions_DeliveryFormController extends Controller_Abstract
{
    
    public function init()
    {
        Zend_Layout::startMvc();
    }
    
    public function fillAction()
    {
        Zend_Debug::dump($this->getRequest()->getParam(FieldIdEnum::DELIVERY_FORM_ID));
//        die;
    }
}
