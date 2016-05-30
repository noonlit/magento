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
        $layer = Mage::getSingleton('catalog/layer');
        $category = $layer->getCurrentCategory();
        $currentCategoryId = $category->getId();

        // get the banner ids from category_banner for the current category id
        $categoryBannerCollection = Mage::getModel('evozon_catalog/categorybanner')
                ->getCollection()
                ->addFieldToFilter('category_id', $currentCategoryId);
        if (!empty($categoryBannerCollection)) {
            $bannerIds = [];
            foreach ($categoryBannerCollection as $categoryBanner) {
                $bannerIds [] = $categoryBanner->getBannerId();
            }
        }

        // get the banner from banner table for the bannerIds
        $banners = [];
        $banner = Mage::getModel('evozon_catalog/banner');
        foreach ($bannerIds as $bannerId) {
            $banners[] = $banner->load($bannerId)->getText();
        }

        // format to string
        $bannerString = implode('<br>', $banners);

        return $bannerString;
    }

}
