<?php

/*
 *  @author Ilinca Dobre <>
 *  @author Haidu Bogdan <bogdan.haidu@evozon.com>
 */

class Evozon_Qa_Model_Answer extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        //sets the resource model class instance used for this model
        $this->_init('evozon_qa/answer');
    }
    
    public function getUserId(){
        $userId = null;
        if (Mage::getSingleton('customer/session')->isLoggedIn()) { //cheks the customer ID
            $userId = Mage::getSingleton('customer/session')->getCustomer()->getId();
        } else if (Mage::getSingleton('admin/session')->isLoggedIn()) {//checks the user ID
            $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        } else {
            $customer = Mage::getModel("customer/customer");
            $id = $customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                            ->loadByEmail('guest_user@madison_island.com')->getId();
            $userId = $id;
        }
        return $userId;
    }

    public function getQuestionById($id)
    {
        $question = $this->getCollection();

        $question->getSelect()
                ->where('question_id = ?', $id);

        return $question;
    }

}
