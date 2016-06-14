<?php

class Evozon_Qa_Model_Answer extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        //sets the resource model class instance used for this model
        $this->_init('evozon_qa/answer');
    }

    public function fetchAnser()
    {
        $collection = $this->getCollection();
        $currentProductId = Mage::registry('current_product')->getId();
        $collection->addFieldToFilter('product_id', $currentProductId)
//                ->join(array('mediator' => 'mediator'), 'main_table.banner_id = mediator.banner_id')
        ;
        return $collection;
    }

}
