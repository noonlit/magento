<?php
/**
 * Description of Banner
 *
 * @author marius
 */
class Evozon_FirstTask_Model_Resource_Banner extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('evozon_firsttask/banner', 'banner_id');
    }
}
