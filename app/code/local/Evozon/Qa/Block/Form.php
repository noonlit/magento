<?php

class Evozon_QA_Block_Form extends Mage_Core_Block_Template
{
    public function addQuestion() {
        
    }
    
    public function showQuestion() {
        return $this->getRequest()->getParam('qa_question');
    }
    
    public function showSubmitMessage() {        
           return "Your question was submitted and will be soon reviewed!";              
    }
}
