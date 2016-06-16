<?php

/**
 * manage Questions and Answers controller
 *
 * @category   Evozon
 * @package    Qa 
 * @subpackage Adminhtml
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
        Mage::register('example_data', $model);

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }

    /**
     * edit answer
     * block - edit answer form
     */
    public function editAnswerAction()
    {
        $id = $this->getRequest()->getParam('id', null);
        $model = Mage::getModel('evozon_qa/answer'); //adminhtml questions model
        if ($id) {
            $this->setIdToFormData($id, $model);
        }
        Mage::register('example_data', $model);

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }

    /**
     * save Answer Question Form
     */
    public function saveAction()
    {
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

    /**
     * save Edit Answer Form
     */
    public function saveEditAnswerAction()
    {
        $data = $this->getRequest()->getPost();

        if ($data) {
            $id = $this->getRequest()->getParam('id');
            $this->editAnswerFormData($data, $id);

            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('evozon_qa')->__('No data found to save'));
        $this->_redirect('*/*/answers');
    }

    /**
     * saves the status value from the Answer form data
     * @param type $formData
     * @param type $questionId
     */
    public function changeStatus($formData, $questionId = null)
    {
        if ($questionId) {
            $questionModel = Mage::getModel('evozon_qa/question');
            $questionModel->load($questionId);
            $questionModel->setStatus($formData['status']); //TODO check if the answer is pending, and change it to approved
            Mage::getSingleton('adminhtml/session')->setFormData($questionModel->getData());

            $this->trySave($questionModel, 'answer', 'Status for Question ' . $questionId);
        }
    }

    /**
     * saves the answer value from the Answer form data
     * @param type $formData
     * @param type $questionId
     */
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

        $this->trySave($answerModel, 'answer', 'Answer for Question ' . $questionId);
        $this->_redirect('*/*/');
    }

    /**
     * saves the answer value from the Edit Answer form data
     * @param type $formData
     * @param type $answerId
     */
    public function editAnswerFormData($formData, $answerId = null)
    {
        $answerModel = Mage::getModel('evozon_qa/answer');

        if ($answerId) {
            $answerModel->load($answerId);
        }

        $answerModel->setAnswer($formData['answer']);

        Mage::getSingleton('adminhtml/session')->setFormData($answerModel->getData());

        $this->trySave($answerModel, 'answers', 'Answer ' . $answerId);
        $this->_redirect('*/*/answers');
    }

    /**
     * final form saving process
     * 
     * @param object $model
     * @param string $backurl // adjust the back button url
     * @param string $itemInfo // adjust the info message after a succesfully save
     */
    private function trySave($model, $backurl, $itemInfo = 'Answer')
    {
        try {
            $model->save();
            if (!$model->getId()) {
                Mage::throwException(Mage::helper('evozon_qa')->__('Error saving ' . lcfirst($itemInfo)));
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('evozon_qa')->__($itemInfo . ' was successfully saved.'));
            Mage::getSingleton('adminhtml/session')->setFormData(false);
            $this->setBackButton($model, $backurl); //set the back button
        } catch (Exception $e) {
            $this->SetExceptionError($model, $e, $backurl);
        }
    }

    /**
     * common delete action
     * bogdan : TODO check the element type which is due to be deleted
     * and adjust the messages and redirect paths accordingly
     * @return
     */
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $model = Mage::getModel('evozon_qa/question');
                $model->setId($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('evozon_qa')->__('The item has been deleted.'));
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/answer', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to find the item to delete.'));
        $this->_redirect('*/*/');
    }

    /**
     * Changes the status of the selected questions from the grid to approved
     *
     * @return null
     * @author Raul Onea <raul.onea@evozon.com>
     * @author Marius Adam <marius.adam@evozon.com>
     */
    public function massApproveQuestionsAction()
    {
        $questionIds = $this->getRequest()->getParam('evozon_qa_questions_id');

        if (!is_array($questionIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Questions.'));
        } else {
            try {
                /* @var $model Evozon_Qa_Model_Question */
                $model = Mage::getModel('evozon_qa/question');
                foreach ($questionIds as $questionId) {
                    $model->load($questionId)->setStatus($model::STATUS_APPROVED)->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Total of %d question(s) were approved.', count($questionIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Changes the status of the selected questions from the grid to disabled
     *
     * @return null
     * @author Raul Onea <raul.onea@evozon.com>
     * @author Marius Adam <marius.adam@evozon.com>
     */
    public function massDisableQuestionsAction()
    {
        $questionIds = $this->getRequest()->getParam('evozon_qa_questions_id');

        if (!is_array($questionIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Questions.'));
        } else {
            try {
                /* @var $model Evozon_Qa_Model_Question */
                $model = Mage::getModel('evozon_qa/question');
                foreach ($questionIds as $questionId) {
                    $model->load($questionId)->setStatus($model::STATUS_DISABLED)->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Total of %d questions(s) were disabled.', count($questionIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Deletes the selected questions from the grid
     *
     * @return null
     * @author Raul Onea <raul.onea@evozon.com>
     * @author Marius Adam <marius.adam@evozon.com>
     */
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

    /**
     * returns the current logged in user id
     * 
     * @return int
     */
    public function getUserId()
    {
        $userId = null;
        if (Mage::getSingleton('customer/session')->isLoggedIn()) { //checks the customer ID
            $userId = Mage::getSingleton('customer/session')->getCustomer()->getId();
        } else if (Mage::getSingleton('admin/session')->isLoggedIn()) {//checks the user ID
            $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        } else {
            $customer = Mage::getModel("customer/customer");
            $id = $customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                            ->loadByEmail('guest_user@madison_island.com')->getId();
            $userId = $id;
        }
        return $userId;
    }

    /**
     * Checks if the current logged admin has permissions to access evozon_qa resource
     *
     * verify if the Module is allowed on Admin Panel
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/evozon_qa');
    }

    /**
     * registers a model
     * 
     * @param int $id
     * @param object $model
     * @param string $dataName
     */
    public function registerModel($id, $model, $dataName)
    {
        if ($id) {
            $this->setIdToFormData($id, $model);
        }
        Mage::register($dataName, $model);
    }

}
