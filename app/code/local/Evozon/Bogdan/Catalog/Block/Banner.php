<?php

class Evozon_Bogdan_Catalog_Block_Banner extends Mage_Core_Block_Template
{

    public function showText()
    {
        $banners = Mage::getModel("evozon_bogdan_catalog/bannertable"); 
        $bannersCategories = Mage::getModel("evozon_bogdan_catalog/bannercategoryconnection");
        $connectionsIds = $bannersCategories->getConnectionsIds();
        
        $randBannerId = rand (min($connectionsIds),max($connectionsIds));
        $resultedBannerId = $bannersCategories->loadConnectionBannerId($randBannerId);
        return "PROMOTIE !!!" . $banners->loadBannerTextById($resultedBannerId);
    }

}
