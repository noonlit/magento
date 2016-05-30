<?php

/**
 * model class type for Mediator
 */
class Evozon_Catalog_Model_Mediator extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        //sets the resource model class instance used for this model
        $this->_init('evozon_catalog/mediator');
    }

}
