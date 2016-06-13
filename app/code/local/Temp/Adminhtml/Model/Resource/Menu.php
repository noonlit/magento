<?php

class Evozon_QA_Model_Resource_Menu extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Init
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('menu/menu', 'item_id');
    }
}
