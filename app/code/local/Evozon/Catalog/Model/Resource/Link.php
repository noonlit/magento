<?php

class Evozon_Catalog_Model_Resource_Link extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {        
        $this->_init('evozon_catalog/link', 'id');
    }

}

