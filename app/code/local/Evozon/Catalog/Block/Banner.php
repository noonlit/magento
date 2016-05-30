<?php

class Evozon_Catalog_Block_Banner extends Mage_Core_Block_Template
{

    /**
     * 
     * @return Evozon_Catalog_Model_Resource_Banner_Collection Object
     */
    public function fetchBanners()
    {
        return Mage::getModel('evozon_catalog/banner')->fetchBanners();
    }

}
