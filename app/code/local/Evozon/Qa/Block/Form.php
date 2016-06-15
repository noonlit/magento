<?php

class Evozon_QA_Block_Form extends Mage_Core_Block_Template
{

    public function getFormActionUrl()
    {
        return $this->getUrl('evozon_qa/question/addquestion');
    }    
    
    public function showQuestion()
    {
        return $this->getRequest()->getParam('qa_question');
    }

    public function showSubmitMessage()
    {
        return "Your question was submitted and will be soon reviewed!";
    }
    public function getCurrentProductId() 
    {
        return Mage::registry('current_product')->getId();       
    }
}


