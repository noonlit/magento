<?php

/**
 * Catalog link (for the banners_to_categories table)
 * 
 * @category   Evozon
 * @package    Evozon_Catalog
 * @author     Andra <andra.barsoianu@evozon.com>
 */

class Evozon_Catalog_Model_Link extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {        
        $this->_init('evozon_catalog/link');
    }
    
}
