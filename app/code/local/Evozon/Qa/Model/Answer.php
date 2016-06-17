<?php

/*
 *  Qa_Answer model
 *  @category   Evozon
 *  @package    Evozon_Qa
 *  @author     Ilinca Dobre <ilinca.dobre@evozon.com>
 *  @author Haidu Bogdan <bogdan.haidu@evozon.com>
 */
class Evozon_Qa_Model_Answer extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('evozon_qa/answer');
    }

    /**
     * saves the answer value from the Answer form data
     * 
     * @param type $formData
     * @param type $questionId
     */
    public function addAnswer($formData, $questionId = null)
    {
        $userId = $this->getUserId();
        if ($questionId) {
            $questions = $this->getQuestionById($questionId);
            $answerId = $questions->getFirstItem()->getData('answer_id');
        }

        if ($answerId) {
            $this->load($answerId);
        }

        $this->setQuestionId($questionId);
        $this->setUserId($userId);
        $this->setAnswer($formData['answer']);
        return $this;
    }

    /**
     * returns the current logged in user id
     * 
     * @return int
     */
    public function getUserId()
    {
        $userId = null;
        //checks the user ID
        if (Mage::getSingleton('admin/session')->isLoggedIn()) {
            $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        } else {
            $customer = Mage::getModel("customer/customer");
            $id = $customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                            ->loadByEmail('guest_user@madison_island.com')->getId();
            $userId = $id;
        }
        return $userId;
    }

}
