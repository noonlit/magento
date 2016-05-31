<?php

/**
 * model for BannerCategoryConnection Entities
 *
 * @category   Evozon
 * @package    Evozon_Bogdan_Catalog
 * @author     Haidu Bogdan <https://github.com/noonlit/magento.git> bogdan branch
 */

class Evozon_Bogdan_Catalog_Model_BannerCategoryConnection extends Mage_Core_Model_Abstract
{
    //entity connection
    protected function _construct()
    {
        $this->_init('evozon_bogdan_catalog/bannercategoryconnection');
    }

    /**
     * does a query through the current entity table
     * with a banner entity table join to obtain rows which have the current 
     * page category id-s
     * the rows will be fetched in a random order 
     * @return array with the text column values from the banner entity table
     */
    
    public function getBannersForCategory()
    {
        //retrieve current page category id
        $currentCategoryId = Mage::registry('current_category')->getId();
        //query
        $collections = $this->getCollection();
        $collections->addFieldToFilter('category_id', $currentCategoryId);
        $collections->getSelect()->join('evozon_catalog_banners', 'main_table.banner_id = evozon_catalog_banners.banner_id');
        $collections->getSelect()->order(new Zend_Db_Expr('RAND()'));
        
        //return results through an array
        $bannersText = array();
        foreach ($collections as $collection) {
            $bannersText[] = $collection->getText();
        }
        return $bannersText;
    }
}
