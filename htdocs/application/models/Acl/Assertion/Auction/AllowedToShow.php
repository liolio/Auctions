<?php
/**
 * @class Acl_Assertion_Auction_AllowedToShow
 */
class Acl_Assertion_Auction_AllowedToShow extends Acl_Assertion_Abstract implements Zend_Acl_Assert_Interface
{
    
    /**
     * Returns true if:
     *      - logged user has administrator role
     *      - logged user id equals owner auction id
     *      - auction is started and not finished
     * 
     * @param Zend_Acl $acl
     * @param Zend_Acl_Role_Interface $role
     * @param Zend_Acl_Resource_Interface $resource
     * @param type $privilege
     * @return boolean
     */
    public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $role = null, Zend_Acl_Resource_Interface $resource = null, $privilege = null)
    {
        $auctionId = $this->_getParam(FieldIdEnum::AUCTION_ID);
        
        if (!is_null($auctionId))
        {
            $authUser = Auth_User::getInstance()->getUser();
            
//            echo"\nis null auth user: " . (int) is_null($authUser);
//            echo"\nauth user role: " . $authUser->role;
//            die;
            if (!is_null($authUser) && $authUser->role === Enum_Acl_Role::ADMINISTRATOR)
                return true;
            
            $auction = AuctionTable::getInstance()->findOneBy("id", $auctionId);
            
            if ($auction !== false) 
            {
                return 
                    !is_null($authUser) && $auction->user_id === $authUser->id ||
                    $auction->isStartedAndNotFinished();
            }
        }        
        
        return false;
    }

}
