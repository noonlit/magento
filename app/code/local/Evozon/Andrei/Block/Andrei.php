<?php

class Evozon_Andrei_Block_Andrei extends Mage_Core_Block_Template
{

    public function getRandomText()
    {
        $text = Mage::getModel("Andrei/Andrei")->getRandomText();
        return $text;
    }

}