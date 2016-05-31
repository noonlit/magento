<?php

//RENAME BANNERTABLE TO BANNER

class Evozon_Bogdan_Catalog_Model_BannerTable extends Mage_Core_Model_Abstract
{

    //JUST TO VERIFY THE CLASS
    private $test = 1;

    protected function _construct()
    {
        $this->_init('evozon_bogdan_catalog/bannertable');
    }

    public function getBannersIds()
    {
        $banners = $this->getCollection();
        $bannersIds = array();
        foreach ($banners as $banner) {
            $bannersIds[] = $banner->getId();
        }
        return $bannersIds;
    }

    public function loadBannerTextById($id)
    {
        return $this->load($id)->getText();
    }

    public function getBannersForCategory()
    {
        $collections = $this->getCollection();
        $currentCategoryId = Mage::registry('current_category')->getId();
        $collections->addFieldToFilter('category_id', $currentCategoryId)
                ->join(array('bannercategoryconnection' => 'bannercategoryconnection'),
                        'main_table.banner_id = evozon_catalog_banners_category_connection.banner_id')
                ->getSelect()
                ->order(new Zend_Db_Expr('RAND()'));
        
        return $collections;
    }

}
