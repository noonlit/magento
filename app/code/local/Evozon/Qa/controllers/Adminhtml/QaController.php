<?php

/**
 * Questions and Answers extension for Magento
 *
 *
 * @category   Evozon Qa
 * @package    Evozon Qa Adminhtml
 * @copyright  Copyright (C) 2016 Evozon Internship (https://github.com/noonlit/magento.git branch develop)
 */

/**
 * manage Questions and Answers controller
 *
 * @category   Evozon Qa
 * @package    Evozon Qa Adminhtml 
 * @subpackage controllers
 * @author     Haidu Bogdan <bogdan.haidu@evozon.com>
 */
class Evozon_Qa_Adminhtml_QaController extends Mage_Adminhtml_Controller_Action
{

    /**
     * shows the questions grid
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('qa')
                ->_title('Q & A Management');
        $this->_addBreadcrumb($this->__('Q A Management'), $this->__('Q A Management'));
        $this->renderLayout();
    }

    /**
     * shows the answers grid
     */
    public function answersAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('qa')
                ->_title('Q & A Management');
        $this->_addBreadcrumb($this->__('Q A Management'), $this->__('Q A Management'));
        $this->renderLayout();
    }

    /**
     * shows the questions grid
     */
    public function questionsAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('qa')
                ->_title('Q & A Management');
        $this->_addBreadcrumb($this->__('Q A Management'), $this->__('Q A Management'));
        $this->renderLayout();
    }

    /**
     * the first action will be edit
     */
    public function newAction()
    {
        $this->_forward('answer');
    }

    /**
     * answer action
     */
    public function answerAction()
    {
        $id = $this->getRequest()->getParam('id', null);
        $model = Mage::getModel('evozon_qa/question'); //adminhtml questions model
        if ($id) {
            $this->setIdToFormData($id, $model);
        }
        //TODO WHAT name to put instead of example_data ??
        Mage::register('example_data', $model);

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
//        $block = $this->getLayout()
//        ->createBlock('core/text', 'example-block')
//        ->setText('<h1>This is a text block</h1>');
//
//        $this->_addContent($block);
        $this->renderLayout();
    }

    /**
     * edit action
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id', null);
        $model = Mage::getModel('evozon_qa/question'); //adminhtml questions model
        if ($id) {
            $this->setIdToFormData($id, $model);
        }
        //TODO WHAT name to put instead of example_data ??
        Mage::register('example_data', $model);

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }

    public function editanswerAction()
    {
        $id = $this->getRequest()->getParam('id', null);
        $model = Mage::getModel('evozon_qa/answer'); //adminhtml questions model
        if ($id) {
            $this->setIdToFormData($id, $model);
        }
        //TODO WHAT name to put instead of example_data ??
        Mage::register('example_data', $model);

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }

    public function registerModel($id, $model, $dataName)
    {
        if ($id) {
            $this->setIdToFormData($id, $model);
        }
        //TODO WHAT name to put instead of example_data ??
        Mage::register($dataName, $model);
    }

    public function saveAction()
    {
        //IT CAN JUST EDIT EXISTING ANSWERS, TODO FOR NEW ANSWERS
        //SHOULD USE A NEW ADD ANSWER
        $data = $this->getRequest()->getPost();

        if ($data) {
            $model = Mage::getModel('evozon_qa/question');
            $answerModel = Mage::getModel('evozon_qa/answer');
            $id = $this->getRequest()->getParam('id');
            $this->addAnswer($data, $id);

//            if ($id) {
//                $model->load($id);
//                $answer = $answerModel->getQuestionById($id)->getFirstItem();
//            }
//
//            if (!empty($answerId = $answer->getData('answer_id'))) {
//                $answerModel->load($answerId);
//                $answer->setAnswer($answerText);
//            }
//            $model->setData($data);
//            if (!empty($answer)) {
//                $answerModel->setData($answer->getData());
//            }
//            
//            Mage::getSingleton('adminhtml/session')->setFormData($data);
//            $this->trySave($id,$answerId,$model,$answerModel);

            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('evozon_qa')->__('No data found to save'));
        $this->_redirect('*/*/');
    }

    public function addAnswer($formData, $questionId = null)
    {
        $answerModel = Mage::getModel('evozon_qa/answer');
        $userId = $this->getUserId();
        if ($questionId) {
            $questions = $answerModel->getQuestionById($questionId);
            $answerId = $questions->getFirstItem()->getData('answer_id');
        }
        
        if ($answerId){
            $answerModel->load($answerId);
        }
        
        $answerModel->setQuestionId($questionId);
        $answerModel->setUserId($userId);
        $answerModel->setAnswer($formData['answer']);

        Mage::getSingleton('adminhtml/session')->setFormData($answerModel->getData());

        $this->trySave($answerModel);
    }

    private function trySave($model)
    {
        try {
            $model->save();
            if (!$model->getId()) {
                Mage::throwException(Mage::helper('evozon_qa')->__('Error saving example'));
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('evozon_qa')->__('Example was successfully saved.'));
            Mage::getSingleton('adminhtml/session')->setFormData(false);
            $this->setBackButton($model, 'answer'); //set the back button
        } catch (Exception $e) {
            $this->SetExceptionError($model, $e);
        }
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('evozon_qa/question');
                $model->setId($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('evozon_qa')->__('The example has been deleted.'));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/answer', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to find the example to delete.'));
        $this->_redirect('*/*/');
    }

    public function massApproveAction()
    {
        $adListingIds = $this->getRequest()->getParam('evozon_qa_id');

        if (!is_array($adListingIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Questions.'));
        } else {
            try {
                $model = Mage::getModel('evozon_qa/question');
                foreach ($adListingIds as $adId) {
                    $model->load($adId)->setStatus('approved')->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Total of %d record(s) were approved.', count($adListingIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDisableAction()
    {
        $adListingIds = $this->getRequest()->getParam('evozon_qa_id');

        if (!is_array($adListingIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Questions.'));
        } else {
            try {
                $model = Mage::getModel('evozon_qa/question');
                foreach ($adListingIds as $adId) {
                    $model->load($adId)->setStatus('disabled')->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Total of %d record(s) were disabled.', count($adListingIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $adListingIds = $this->getRequest()->getParam('evozon_qa_id');

        if (!is_array($adListingIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Questions.'));
        } else {
            try {
                $model = Mage::getModel('evozon_qa/question');
                foreach ($adListingIds as $adId) {
                    $model->load($adId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Total of %d record(s) were deleted.', count($adListingIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * sets the Id for the Answer Form Data
     * 
     * @param int $id
     * @param object $model
     */
    public function setIdToFormData($id, $model)
    {
        $model->load((int) $id);
        if ($model->getId()) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if ($data) {
                $model->setData($data)->setId($id); //sets the QuestionId for the formdata
            }
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('evozon_qa')->__('Example does not exist'));
            $this->_redirect('*/*/');
        }
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

    /**
     * set the redirect parameter for the back button
     * 
     * @param object $model
     * @param string $redirect
     */
    public function setBackButton($model, $redirect)
    {
        if ($this->getRequest()->getParam('back')) {
            $this->_redirect('*/*/' . $redirect, array('id' => $model->getId()));
        } else {
            $this->_redirect('*/*/');
        }
    }

    public function getUserId()
    {
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

    /**
     * DON'T KNOW IF THIS WORKS
     */
    protected function _isAllowed()
    {
        return true;
        //return Mage::getSingleton('admin/session')->isAllowed('admin/evozon_qa');
    }

}
