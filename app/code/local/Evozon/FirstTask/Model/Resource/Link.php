<?php

/**
 * Description of Link
 *
 * @author marius
 */
class Evozon_FirstTask_Model_Resource_Link extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('evozon_firsttask/link', 'id');
    }
}
