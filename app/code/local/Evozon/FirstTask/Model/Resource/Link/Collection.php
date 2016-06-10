<?php

/**
 * Created by PhpStorm.
 * User: marius
 * Date: 6/6/16
 * Time: 4:36 PM
 */
class Evozon_FirstTask_Model_Resource_Link_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('evozon_firsttask/link');
    }
}
