<?php

/**
 * @class Auction_ViewHelperTest
 */
class Auction_ViewHelperTest extends TestCase_Controller
{
    
    /**
     * @test
     * @dataProvider getTransactionDivDataProvider
     */
    public function getTransactionDiv($fixture, $auctionTransactionTypeId, $expectedResult)
    {
        $this->_loadFixtures(array(
            'Currency/1',
            'Category/1',
            'Auction/1_category_1_start_2012-05-02',
            $fixture
        ));
        
        $this->assertEquals(
            $expectedResult,
            Auction_ViewHelper::getTransactionDiv(AuctionTransactionTypeTable::getInstance()->find($auctionTransactionTypeId))
        );
    }
    
    public function getTransactionDivDataProvider()
    {
        return array(
            array(
                'AuctionTransactionType/1_auction_1_tt_2',
                1,
                "<div id='bidding'> " .
                    $this->_getTranslator()->translate('label-auction_transaction_type_bidding_price') . " <strong>PLN 122.12</strong><br/>" .
                    "<a class=" . ParamIdEnum::AUCTION_TRANSACTION_TYPE_BIDDING . " href='/transaction/bid/1'></a>" .
                "</div>"
            ),
            array(
                'AuctionTransactionType/2_auction_1_tt_1',
                2,
                "<div id='buyOut'> " .
                    $this->_getTranslator()->translate('label-auction_transaction_type_buy_out_price') . " <strong>PLN 22.12</strong><br/>" .
                    "<a class=" . ParamIdEnum::AUCTION_TRANSACTION_TYPE_BUY_OUT . " href='/transaction/buy-out/1'></a>" .
                "</div>"
            ),
        );
    }
}
