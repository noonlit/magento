
<?php
class Evozon_Catalog_Block_Banner extends Mage_Core_Block_Template
{
    public function getBannersForCategory()
    {        
        return Mage::getModel('evozon_catalog/banner')->getBannersForCategory();
    }
}