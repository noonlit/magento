<?php
/**
 * Banner block
 * 
 * @category   Evozon
 * @package    Evozon_Catalog
 * @author     Sergiu <sergiu.rus@evozon.com>
 */
class Evozon_Catalog_Block_Banner extends Mage_Core_Block_Template
{
    /**
     * Retrieves banners associated with the current category
     * 
     * @return Evozon_Catalog_Model_Resource_Banner_Collection 
     */
    public function getBannersForCategory()
    {        
        return Mage::getModel('evozon_catalog/banner')->getBannersForCategory();
    }
}

