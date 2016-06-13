<?php

class Evozon_QA_Model_Resource_Menu_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * Init menu collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('menu/menu');
    }
}

