<?php

/**
 * Question form block
 *
 * @package    Evozon_Qa
 * @author     Ilinca Dobre <ilinca.dobre@evozon.com>
 * @author     Andrei Bodea <andrei.bodea@evozon.com>
 */
class Evozon_Qa_Block_Question extends Mage_Core_Block_Template
{
    /**
     * 
     * @return Evozon_Qa_Model_Resource_Question_Collection
     */
    public function getQuestions()
    {
        return Mage::getModel('evozon_qa/question')->getQuestions();
    }

    /**
     * Return the current product id
     *
     * @return int
     */
    public function getCurrentProductId()
    {
        return Mage::app()->getRequest()->getParam('id');
    }
}