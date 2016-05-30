<?php

/**
 * Description of Banner
 *
 * @author marius
 */
class Evozon_FirstTask_Block_Banner extends Mage_Core_Block_Template
{
    public function getBannersForCategory()
    {
        return Mage::getModel('evozon_firsttask/banner')->getBannersForCategory();
    }
}
