<?php

/**
 * Question form block
 *
 * @package    Evozon_Qa
 * @author     Ilinca Dobre: ilinca.dobre@evozon.com
 */
class Evozon_QA_Block_Form extends Mage_Core_Block_Template
{

    /**
     * Returns the action URL of the question form
     * 
     * @return string
     */
    public function getFormActionUrl()
    {
        return $this->getUrl('evozon_qa/question/addquestion');
    }

    /**
     * Return the current product id
     * 
     * @return int
     */
    public function getCurrentProductId()
    {
        return Mage::registry('current_product')->getId();
    }

}
