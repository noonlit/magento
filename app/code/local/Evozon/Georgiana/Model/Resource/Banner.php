<?php


class Evozon_Georgiana_Model_Resource_Banner extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
     
        $this->_init('evozon_georgiana/banner', 'banner_id');
    }
}