<?php

class Evozon_QA_Block_Form extends Mage_Core_Block_Template
{
    public function addQuestion() {
        
    }
    
    public function showQuestion() {
        return $this->getRequest()->getParam('qa_question');
    }
    
    public function showSubmitMessage() {
        if ($this->getRequest()->getParam('qa_question')) {
            return "Your question was submitted and will be soon reviewed!";
        }
    }
}
