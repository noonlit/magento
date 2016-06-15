<?php

/*
 *  @author Ilinca Dobre <>
 *  @author Haidu Bogdan <bogdan.haidu@evozon.com>
 */

class Evozon_Qa_Model_Answer extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        //sets the resource model class instance used for this model
        $this->_init('evozon_qa/answer');
    }

    /**
     * Saves a submitted answer to database
     * 
     * @param array $formData
     * @return boolean
     */
    public function addAnswer($formData,$questionId=null)
    {
        $answerModel = Mage::getModel('evozon_qa/answer');

        //$answer = $formData['answer'];
        //$questionId = $formData['question_id'];
        $userId = $this->getUserId();
        $data = array(
            'question_id' => $questionId,
            'user_id' => $userId,
            'answer' => $formData['answer'],
        );
        
        $answerModel->setData($data);
        
        Mage::getSingleton('adminhtml/session')->setFormData($data);
        
        //$answerModel->save();
        $this->trySave($answerModel);
        
        return;
    }
    
    public function trySave($answerModel)
    {
        try {
            $answerModel->save();
            if (!$answerModel->getId()) {
                Mage::throwException(Mage::helper('evozon_qa')->__('Error saving example'));
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('evozon_qa')->__('Example was successfully saved.'));
            Mage::getSingleton('adminhtml/session')->setFormData(false);
            $this->setBackButton($answerModel,'answer'); //set the back button
            
        } catch (Exception $e) {
            $this->SetExceptionError($answerModel, $e);
        }
    }
    
    
    public function getUserId(){
        $userId = null;
        if (Mage::getSingleton('customer/session')->isLoggedIn()) { //cheks the customer ID
            $userId = Mage::getSingleton('customer/session')->getCustomer()->getId();
        } else if (Mage::getSingleton('admin/session')->isLoggedIn()) {//checks the user ID
            $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        } else {
            $customer = Mage::getModel("customer/customer");
            $id = $customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                            ->loadByEmail('guestUser@madisonIsland.com')->getId();
            $userId = $id;
        }
        return $userId;
    }

    public function getQuestionById($id)
    {
        $question = $this->getCollection();

        $question->getSelect()
                ->where('question_id = ?', $id);

        return $question;
    }
    /**
     * sets The Exception Error, used after try
     * 
     * @param object $model
     * @param object $e
     * @param string $redirect
     */
    public function SetExceptionError($model, $e, $redirect = 'answer')
    {
        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        if ($model && $model->getId()) {
            $this->_redirect('*/*/' . $redirect, array('id' => $model->getId()));
        } else {
            $this->_redirect('*/*/');
        }
    }
}
