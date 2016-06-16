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
        $formData = $this->getRequest()->getPost();
        $session = Mage::getSingleton('core/session');
        $question = Mage::getModel('evozon_qa/question');

        $validate = $question->validate($formData);
        if ($validate === true) {
            try {
                $question->addQuestion($formData);
                $session->addSuccess($this->__('Your question has been accepted for moderation.'));
            } catch (Exception $ex) {
                $session->setFormData($formData);
                $session->addError($this->__('Unable to post the question.'));
            }
        } else {
            $session->setFormData($formData);
            if (is_array($validate)) {
                foreach ($validate as $errorMessage) {
                    $session->addError($errorMessage);
                }
            } else {
                $session->addError($this->__('Unable to post the question'));
            }
        }
        $this->_redirectReferer();
    }
}
