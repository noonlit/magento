<?php

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
        $this->_setActiveMenu('evozon_qa')
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
        $this->_setActiveMenu('evozon_qa')
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
        $this->_setActiveMenu('evozon_qa')
                ->_title('Q & A Management');
        $this->_addBreadcrumb($this->__('Q A Management'), $this->__('Q A Management'));
        $this->renderLayout();
    }

    /**
     * checks if current user has permissions
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/evozon_qa');
    }

    /**
     * the first actopm will be edit
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
            $id = $this->getRequest()->getParam('id');
            $this->changeStatus($data, $id);
            $this->addAnswer($data, $id);

            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('evozon_qa')->__('No data found to save'));
        $this->_redirect('*/*/');
    }

    public function changeStatus($formData, $questionId = null)
    {
        if ($questionId) {
            $questionModel = Mage::getModel('evozon_qa/question');
            $questionModel->load($questionId);
            $questionModel->setStatus($formData['status']);
            Mage::getSingleton('adminhtml/session')->setFormData($questionModel->getData());

            $this->trySave($questionModel,'Status');
        }
    }

    public function addAnswer($formData, $questionId = null)
    {
        $answerModel = Mage::getModel('evozon_qa/answer');
        $userId = $this->getUserId();
        if ($questionId) {
            $questions = $answerModel->getQuestionById($questionId);
            $answerId = $questions->getFirstItem()->getData('answer_id');
        }

        if ($answerId) {
            $answerModel->load($answerId);
        }

        $answerModel->setQuestionId($questionId);
        $answerModel->setUserId($userId);
        $answerModel->setAnswer($formData['answer']);

        Mage::getSingleton('adminhtml/session')->setFormData($answerModel->getData());

        $this->trySave($answerModel);
    }

    private function trySave($model,$itemInfo='Answer')
    {
        try {
            $model->save();
            if (!$model->getId()) {
                Mage::throwException(Mage::helper('evozon_qa')->__('Error saving '.lcfirst($itemInfo)));
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('evozon_qa')->__($itemInfo .' was successfully saved.'));
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

    public function massApproveQuestionsAction()
    {
        $questionIds = $this->getRequest()->getParam('evozon_qa_questions_id');

        if (!is_array($questionIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Questions.'));
        } else {
            try {
                $model = Mage::getModel('evozon_qa/question');
                foreach ($questionIds as $questionId) {
                    $model->load($questionId)->setStatus('approved')->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Total of %d question(s) were approved.', count($questionIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDisableQuestionsAction()
    {
        $questionIds = $this->getRequest()->getParam('evozon_qa_questions_id');

        if (!is_array($questionIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Questions.'));
        } else {
            try {
                $model = Mage::getModel('evozon_qa/question');
                foreach ($questionIds as $questionId) {
                    $model->load($questionId)->setStatus('disabled')->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Total of %d questions(s) were disabled.', count($questionIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteQuestionsAction()
    {
        $questionIds = $this->getRequest()->getParam('evozon_qa_questions_id');

        if (!is_array($questionIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Questions.'));
        } else {
            try {
                $model = Mage::getModel('evozon_qa/question');
                foreach ($questionIds as $questionId) {
                    $model->load($questionId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Total of %d questions(s) were deleted.', count($questionIds)));
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

    public function massDeleteAnswersAction()
    {
        $answerIds = $this->getRequest()->getParam('evozon_qa_answers_id');

        if (!is_array($answerIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Answers.'));
        } else {
            try {
                $model = Mage::getModel('evozon_qa/answer');
                foreach ($answerIds as $answerId) {
                    $model->load($answerId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Total of %d answers(s) were deleted.', count($answerIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/answers');
    }

}
