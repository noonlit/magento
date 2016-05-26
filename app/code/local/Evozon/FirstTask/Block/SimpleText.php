<?php

/**
 * Description of SimpleText
 *
 * @author mariusadam
 */
class Evozon_FirsTask_Block_SimpleText extends Mage_Core_Block_Abstract
{

    public function getSimpleText()
    {
        $text = Mage::getModel("firsttask/simpletext")->getSimpleText();
        return $text;
    }

}
