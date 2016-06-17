<?php

/**
 * Manage Questions and Answers controller
 *
 * @category   Evozon
 * @package    Qa 
 * @subpackage Adminhtml
 * @author     Haidu Bogdan <bogdan.haidu@evozon.com>
 * @author     Marius Adam  <marius.adam@evozon.com>
 */
class Evozon_Qa_Adminhtml_QaController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Shows the questions grid
     */
    public function indexAction()
    {
        $this->questionsAction();
    }

    /**
     * Shows the questions grid
     */
    public function questionsAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('evozon_qa')
                ->_title('Q & A Management');
        $this->_addBreadcrumb($this->__('Q A Management'), $this->__('Q A Management'));
       
        $block = $this->getLayout()
                ->createBlock('evozon_qa/adminhtml_questions', 'questions_grid_container');

        $this->_addContent($block);
        $this->renderLayout();
    }

    /**
     * First action will be edit
     */
    public function newAction()
    {
        $this->_forward('answer');
    }

    /**
     * Answer action
     */
    public function answerAction()
    {
        $id = $this->getRequest()->getParam('id', null);

        if (is_null($id)) {
            $this->_redirect('*/*/');
        }
        $model = Mage::getModel('evozon_qa/question');

        if ($id) {
            $this->setIdToFormData($id, $model);
        }
        Mage::register('question_data', $model);

        $this->loadLayout();
        $this->_setActiveMenu('evozon_qa')
                ->_title('Q & A Management');
        
        $block = $this->getLayout()
                ->createBlock('evozon_qa/adminhtml_questions_answer', 'questions_answer_container');
        
        $this->_addContent($block);
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }

    /**
     * Save Answer Question Form
     * @author     Marius Adam  <marius.adam@evozon.com>
     */
    public function saveAction()
    {
        if ($this->_validateFormKey() === false) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('evozon_qa')->__('Invalid form key! Reload the page...'));
            $this->_redirect('*/*/');
            return;
        }

        $data = $this->getRequest()->getPost();
        $questionId = $this->getRequest()->getParam('id');
        $now = strtotime('now');
        try {
            Mage::getModel('evozon_qa/question')->load($questionId)
                    ->setQuestion($data['question'])
                    ->setStatus($data['status'])
                    ->setUpdatedAt($now)
                    ->save();

            $answerModel = Mage::getModel('evozon_qa/answer')->load($questionId, 'question_id');
            if (is_null($answerModel->getId())) {
                //set created_at and question_id attributes only if the answer does not exists
                $answerModel
                        ->setCreatedAt($now)
                        ->setQuestionId($questionId);
            } else {
                $answerModel->setUpdatedAt($now);
            }
            $answerModel
                    ->setAnswer($data['answer'])
                    ->setAdminId(Mage::getSingleton('admin/session')->getUser()->getId())
                    ->save();

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('evozon_qa')->__('Question informations have been saved.'));
        } catch (Exception $ex) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('evozon_qa')->__($ex->getMessage()));
        }

        $this->_redirect('*/*/');
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
                $model = Mage::getModel('evozon_qa/question')
                        ->load($id)
                        ->delete();
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

        if (!is_array($questionIds) || empty($questionIds)) {
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

        if (!is_array($questionIds) || empty($questionIds)) {
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

        if (!is_array($questionIds) || empty($questionIds)) {
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
     * Sets the Id for the Answer Form Data
     * 
     * @param int $id
     * @param object evozon_qa/question $model 
     */
    public function setIdToFormData($id, $model)
    {
        $model->load((int) $id);
        if ($model->getId()) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if ($data) {
                $model->setData($data)->setId($id);
            }
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('evozon_qa')->__('Question does not exist'));
            $this->_redirect('*/*/');
        }
    }

    /**
     * Checks if the current logged admin has permissions to access evozon_qa resource
     * 
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/evozon_qa');
    }

}
