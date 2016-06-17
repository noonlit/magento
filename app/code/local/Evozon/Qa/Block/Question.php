<?php

class Evozon_Qa_Block_Question extends Mage_Core_Block_Template
{
    public function fetchQuestions()
    {
        return Mage::getModel('evozon_qa/question')->fetchQuestions();
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