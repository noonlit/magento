<?php

class Evozon_Andra_Block_FancyBlock extends Mage_Core_Block_Template
{

    public function toHtml()
    {
        $text = Mage::getModel("Andra/FancyModel")->getFancyText();
        return $text;
    }

}
