<?php

class Evozon_Georgiana_Model_Banner extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        
        $this->_init('evozon_georgiana/banner');
    }
    public function getBannersForCategory()
    {
        $collection = $this->getCollection();
        $currentCategoryId = Mage::registry('current_category')->getId();
       mage::log($currentCategoryId);
        $collection->addFieldToFilter('category_id', $currentCategoryId)->join(array('link' => 'link'), 'main_table.banner_id = link.banner_id')->getSelect()->order(new Zend_Db_Expr('RAND()'));

        return $collection;
    }
}