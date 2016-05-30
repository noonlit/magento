<?php

class Evozon_Bogdan_Catalog_Model_Resource_BannerCategoryConnection extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('evozon_bogdan_catalog/bannercategoryconnection','connection_id');
    }
}