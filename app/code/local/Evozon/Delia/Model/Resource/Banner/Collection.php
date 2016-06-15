<?php

class Evozon_Delia_Model_Collection_Banner extends Varien_Data_Collection_Db {
    
    protected function _construct()
    {
        $this->_init('evozon_delia/banner', 'banner_id');
    }
    
}
