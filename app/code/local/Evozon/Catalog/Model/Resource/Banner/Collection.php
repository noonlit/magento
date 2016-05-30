<?php

/**
 * model collection class type for banner
 */
class Evozon_Catalog_Model_Resource_Banner_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        //sets the model class for the collection items
        $this->_init('evozon_catalog/banner');
    }

}
