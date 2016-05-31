<?php

/**
 * Collection model for Banner Entity
 *
 * @category   Evozon
 * @package    Evozon_Bogdan_Catalog
 * @author     Haidu Bogdan <https://github.com/noonlit/magento.git> bogdan branch
 */

class Evozon_Bogdan_Catalog_Model_Resource_Banner_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('evozon_bogdan_catalog/banner');
    }
}