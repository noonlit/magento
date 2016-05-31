<?php

class Evozon_Bogdan_Catalog_Block_Banner extends Mage_Core_Block_Template
{

    public function showText()
    {

        $bannersCategories = Mage::getModel("evozon_bogdan_catalog/bannercategoryconnection");

        foreach ($bannersCategories->getBannersForCategory() as $bannerText) {
            echo "<p>$bannerText</p>";
        }

        return "PROMOTIE !!!";
    }

}
