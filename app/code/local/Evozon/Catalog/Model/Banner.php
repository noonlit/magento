<?php

/**
 * model class type for Banner
 */
class Evozon_Catalog_Model_Banner extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        //sets the resource model class instance used for this model
        $this->_init('evozon_catalog/banner'); 
   }

    /**
     * 
     * @return Evozon_Catalog_Model_Resource_Banner_Collection Object
     */
    public function fetchBanners()
    {
        $collection = $this->getCollection();
        //each page has an unique id by which we print the banners
        $currentCategoryId = Mage::registry('current_category')->getId();

        $collection->addFieldToFilter('category_id', $currentCategoryId)
                ->join(array('mediator' => 'mediator'), 'main_table.banner_id = mediator.banner_id')
                ->getSelect()
                ->order(new Zend_Db_Expr('RAND()'));

        return $collection;
    }

}
