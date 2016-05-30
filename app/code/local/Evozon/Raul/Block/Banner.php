<?php

class Evozon_Raul_Block_Banner extends Mage_Core_Block_Template
{

    public function showText()
    {
        Mage::log("My log entry",null,'mylogfile.log');
        return "Aici este textul meu!!!";
    }

}
