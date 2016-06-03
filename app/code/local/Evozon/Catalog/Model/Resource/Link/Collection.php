<?php

/**
 * Banner resource collection
 * 
 * @category   Evozon
 * @package    Evozon_Catalog
 * @author     Andra <andra.barsoianu@evozon.com>
 */
class Evozon_Catalog_Model_Resource_Link_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('evozon_catalog/link');
    }

}
