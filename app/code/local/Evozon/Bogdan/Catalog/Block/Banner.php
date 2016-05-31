<?php

/**
 * Banner Block class
 *
 * @category   Evozon
 * @package    Evozon_Bogdan_Catalog
 * @author     Haidu Bogdan <https://github.com/noonlit/magento.git> bogdan branch
 */

class Evozon_Bogdan_Catalog_Block_Banner extends Mage_Core_Block_Template
{
    //first block function
    public function showText()
    {
        return "PROMOTIE !!!";
    }
    /**
     * shows associated banners of the current page category
     * affects the banner block
     * return array
     */
    public function BannersText()
    {
        $bannersCategories = Mage::getModel("evozon_bogdan_catalog/bannercategoryconnection");
        return $bannersCategories->getBannersForCategory();
    }

}
