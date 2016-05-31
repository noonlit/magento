<?php

class Evozon_Catalog_Block_Banner extends Mage_Core_Block_Template
{

    /**
     * Displays a static text for every category selected
     *  
     * @return string
     */
    
    public function showText()
    {
        Mage::log('nothing');
        Mage::log('another nothing', null, 'addBlock_logs.log');
        return "nothing";
    }

    /**
     * Displays a banner text for each category selected
     * 
     * @return array
     */
    public function showBanner()
    {
        // get the current category id
        $currentCategoryId = Mage::registry('current_category')->getId();
       
        // get the banner ids from category_banner for the current category id
        $bannerIds = Mage::getModel('evozon_catalog/categorybanner')
                ->getCollection()
                ->addFieldToSelect('banner_id')
                ->addFieldToFilter('category_id', $currentCategoryId)
                ->getdata();
       
        // get the banner from banner table for the bannerIds        
        $banners = Mage::getModel('evozon_catalog/banner')
                ->getCollection()
                ->addFieldToSelect('text')
                ->addFieldToFilter('id', array("in"=> $bannerIds))
                ->getdata();

        // format to string
        $bannerString = '';
        foreach($banners as $banner) {
            $bannerString .= implode('', $banner) . '<br>';
        }
        return $bannerString;
    }

}
