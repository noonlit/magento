<?php
/**
 * Catalog banner 
 * 
 * @category   Evozon
 * @package    Evozon_Catalog
 * @author     Sergiu <sergiu.rus@evozon.com>
 */
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
        
        $collection->addFieldToFilter('category_id', $currentCategoryId)
            ->join(array('link' => 'link'), 'main_table.banner_id = link.banner_id')
            ->getSelect()
            ->order(new Zend_Db_Expr('RAND()'));


        return $collection;
    }

}
