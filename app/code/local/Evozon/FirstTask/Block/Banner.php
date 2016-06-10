<?php

/**
 * Class Evozon_FirstTask_Block_Banner
 */
class Evozon_FirstTask_Block_Banner extends Mage_Core_Block_Template
{
    /**
     * @return mixed
     */
    public function getBannersForCategory()
    {
        return Mage::getModel('evozon_firsttask/banner')->getBannersForCategory();
    }
}
