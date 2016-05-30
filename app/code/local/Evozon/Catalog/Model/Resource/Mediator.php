<?php

/**
 * model resource class type for Mediator
 */
class Evozon_Catalog_Model_Resource_Mediator extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        //sets the main table and the primary key associated to the resource model
        $this->_init('evozon_catalog/mediator', 'id');
    }

}
