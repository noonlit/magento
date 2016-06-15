<?php

class Evozon_Qa_Model_Question extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        //sets the resource model class instance used for this model
        $this->_init('evozon_qa/question');
    }

    public function fetchQuestions()
    {
        $collection = $this->getCollection();
        $status = 'approved';
        $currentProductId = Mage::registry('current_product')->getId();
        $collection->getSelect()
                ->joinLeft(array('answers' => 'evozon_answers'), 'main_table.question_id = answers.question_id', array('answer', 'user_id'))
                ->joinLeft(array('customer' => 'customer_entity'), 'main_table.customer_id = customer.entity_id', array('email'))
                ->joinLeft(array('admin' => 'admin_user'), 'answers.user_id = admin.user_id', array('firstname', 'lastname'))
                ->where('product_id = ?', $currentProductId)
                ->where('status = ?', $status);
//        Mage::log($collection->getSelect()->__toString(), null, 'myLog.log');
//        Mage::log($collection->getData(), null, 'myLog.log');
//        Mage::log($currentProductId, null, 'myLog.log');
        return $collection;
    }

    public function addQuestion($formData = null)
    {
        $questionModel = Mage::getModel('evozon_qa/question');
        $question = $formData['question'];
        $productId = $formData['product_id'];
        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();
        } else {
            $customer = Mage::getModel("customer/customer");
            $id = $customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                            ->loadByEmail('guestUser@madisonIsland.com')->getId();
            $customerId = $id;
        }

        $questionModel->setData(array(
            'text' => $question,
            'status' => 'new',
            'product_id' => $productId,
            'customer_id' => $customerId
        ));
        $questionModel->save();
        return true;
    }

}
