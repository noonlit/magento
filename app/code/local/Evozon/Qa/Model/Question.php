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
        $currentProductId = Mage::registry('current_product')->getId();
        $collection->addFieldToFilter('product_id', $currentProductId)
                ->join(array('answers' => 'evozon_qa/answer'), 'main_table.question_id = answers.question_id')
                ->join(array('customer' => 'customer/entity'), 'main_table.customer_id = customer.entity_id')
                ;
        Mage::log($collection->getSelect()->__toString(), null, 'myLog.log');
        Mage::log($collection->getData(), null, 'myLog.log');
        return $collection;
    }

}
