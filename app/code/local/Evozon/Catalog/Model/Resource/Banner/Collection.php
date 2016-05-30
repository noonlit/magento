<?php
/**
 * Banner resource cellection
 * 
 * @category   Evozon
 * @package    Evozon_Catalog
 * @author     Sergiu <sergiu.rus@evozon.com>
 */
class Evozon_Catalog_Model_Resource_Banner_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('evozon_catalog/banner');
    }
    
}
    