<?php


class Evozon_Georgiana_Block_Banner extends Mage_Core_Block_Template
{
    public function getBannersForCategory()
    {        
        return Mage::getModel('evozon_georgiana/banner')->getBannersForCategory();
    }
}