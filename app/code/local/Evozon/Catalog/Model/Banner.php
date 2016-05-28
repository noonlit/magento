<?php

class Evozon_Catalog_Model_Banner extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        // _init in a model sets the resource model class instance used for that model.
        $this->_init('evozon_catalog/banner');
    }
    
    public function getBanners() 
    {                
        $resource = $this->getResource();
        $table = $resource->getTable('evozon_catalog/banner');
        Mage::log($table);

        return 'sigh.';
    }
 
}
