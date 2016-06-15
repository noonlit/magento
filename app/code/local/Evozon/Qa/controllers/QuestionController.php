<?php

class Evozon_Qa_QuestionController extends Mage_Core_Controller_Front_Action
{

    public function addAction()
    {  
        $formData['question'] = $this->getRequest()->getPost('qa_question');
        $formData['product_id'] = $this->getRequest()->getPost('qa_current_product');       
        Mage::getModel('evozon_qa/question')->addQuestion($formData);
        $this->_redirectReferer();
    }

}
