<?php

class Evozon_Catalog_Block_Text extends Mage_Core_Block_Template
{

    public function showText()
    {
        $m = 'logged string';
        Mage::log($m, null, 'debugging.log');
        return 'This is text.';
    }

}
