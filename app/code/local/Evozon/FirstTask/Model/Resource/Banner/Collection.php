<?php

/**
 * Description of Collection
 *
 * @author marius
 */
class Evozon_FirstTask_Model_Resource_Banner_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct() 
    {
        $this->_init('evozon_firsttask/banner');
    }
}
