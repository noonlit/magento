<?php
class Evozon_Catalog_Model_Banner extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        // _init in a model sets the resource model class instance used for that model.
        $this->_init('evozon_catalog/banner');
    }
    public function getBannersForCategory()
    {
        $collection = $this->getCollection();
        $currentCategoryId = Mage::registry('current_category')->getId();
        // query should go smth like SELECT * FROM evozon_banners JOIN evozon_banners_to_categories ON evozon_banners.banner_id = evozon_banners_to_categories.banner_id WHERE category_id = 4 ORDER BY RAND()
        $collection->addFieldToFilter('category_id', $currentCategoryId)->join(array('link' => 'link'), 'main_table.banner_id = link.banner_id')->getSelect()->order(new Zend_Db_Expr('RAND()'));
        // Mage::log($collection->getSelect()->__toString());
        // Mage::log($collection);
        // Mage::log($collection->getData());
        return $collection;
    }
}