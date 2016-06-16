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
     * block - answer question form
     */
    public function answerAction()
    {
        $id = $this->getRequest()->getParam('id', null);
        $model = Mage::getModel('evozon_qa/question');
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
        $model = Mage::getModel('evozon_qa/answer');
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
        $answerModel = Mage::getModel('evozon_qa/answer');
        $questionModel = Mage::getModel('evozon_qa/question');

        try {
            if ($data) {

                $questionId = $this->getRequest()->getParam('id');

                $questionModel->editQuestion($data, $questionId);
                $questionModel->save();
                $questionInfo = 'Status for Question';
                if (!$questionModel->getId()) {
                    Mage::throwException(Mage::helper('evozon_qa')->__('Error saving ' . lcfirst($questionInfo)));
                    Mage::getSingleton('adminhtml/session')->setFormData(false);
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('evozon_qa')
                                ->__($questionInfo . ' was successfully saved.'));
                $answerModel->addAnswer($data, $questionId);
                $answerModel->save();
                $answerInfo = 'Answer for Question';
                if (!$answerModel->getId()) {
                    Mage::throwException(Mage::helper('evozon_qa')->__('Error saving ' . lcfirst($answerInfo)));
                    Mage::getSingleton('adminhtml/session')->setFormData(false);
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('evozon_qa')
                                ->__($answerInfo . ' was successfully saved.'));
            }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

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
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('evozon_qa')->__('No data found to save'));
        $this->_redirect('*/*/answers');
    }

    /**
     * common delete action
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
     * Deletes the selected answers from the grid
     *
     * @return null
     * @author Raul Onea <raul.onea@evozon.com>
     * @author Marius Adam <marius.adam@evozon.com>
     */
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
     * Checks if the current logged admin has permissions to access evozon_qa resource
     *
     * verify if the Module is allowed on Admin Panel
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/evozon_qa');
    }

}
