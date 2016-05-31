<?php

class Evozon_Bogdan_Catalog_Model_BannerCategoryConnection extends Mage_Core_Model_Abstract
{

    //JUST TO VERIFY THE CLASS
    private $test = 1;

    protected function _construct()
    {
        $this->_init('evozon_bogdan_catalog/bannercategoryconnection');
    }

    public function getBannerConnectionCategoryIds()
    {
        $categories = $this->getCollection();
        $categoriesIds = array();
        foreach ($categories as $category) {
            $categoriesIds[] = $category->getCategoryId();
        }
        return $categoriesIds;
    }

    public function getBannersConnectionIds()
    {
        $categories = $this->getCollection();
        $categoriesIds = array();
        foreach ($categories as $category) {
            $categoriesIds[] = $category->getBannerId();
        }
        return $categoriesIds;
    }

    public function getConnectionsIds()
    {
        $categories = $this->getCollection();
        $connections = array();
        foreach ($categories as $category) {
            $connections[] = $category->getId();
        }
        return $connections;
    }

    public function loadConnectionBannerId($id)
    {
        return $this->load($id)->getBannerId();
    }

    public function getBannersForCategory()
    {
        $currentCategoryId = Mage::registry('current_category')->getId();
        $collections = $this->getCollection();
        $collections->addFieldToFilter('category_id', $currentCategoryId);
        $collections->getSelect()->join('evozon_catalog_banners', 'main_table.banner_id = evozon_catalog_banners.banner_id');
        $collections->getSelect()->order(new Zend_Db_Expr('RAND()'));
        $bannersText =array();
        foreach ($collections as $collection) {
            $bannersText[] =  $collection->getText();
        }
        return $bannersText;
    }

}
