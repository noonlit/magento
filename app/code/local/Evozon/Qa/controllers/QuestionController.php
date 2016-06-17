<?php

/**
 * Question controller
 *
 * @category   
 * @package    Evozon_Qa
 * @author     Ilinca Dobre <ilinca.dobre@evozon.com>
 * @author     Georgiana Tobosi <georgiana.tobosi@evozon.com>
 */
class Evozon_Qa_QuestionController extends Mage_Core_Controller_Front_Action
{

    /**
     * Validates form data and adds it to database
     * 
     */
    public function addAction()
    {
        if (!$this->_validateFormKey()) {
            $this->_redirectReferer();
            return;
        }

        $formData = $this->getRequest()->getPost();
        $formData = $this->sanitize($formData);
        $session = Mage::getSingleton('core/session');
        $question = Mage::getModel('evozon_qa/question');

        try {
            $question->validate($formData);
            $question->addQuestion($formData);
            $session->addSuccess($this->__('Your question has been accepted for moderation.'));
        } catch (Exception $ex) {
            $session->addError($ex->getMessage());
        }

        $this->_redirectReferer();
    }

    /**
     * Sanitizes input form from special characters
     * 
     * @param array $formData
     * @return array
     */
    public function sanitize($formData)
    {
        $formData['qa_question'] = filter_var($formData['qa_question'], FILTER_SANITIZE_SPECIAL_CHARS);
        $formData['qa_username'] = filter_var($formData['qa_username'], FILTER_SANITIZE_SPECIAL_CHARS);
        return $formData;
    }

}
