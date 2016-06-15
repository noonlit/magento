<?php

/**
 * Questions and Answers extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Evozon Q A Adminhtml module to newer versions in the future.
 * If you wish to customize the Evozon Q A Adminhtml module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Evozon Qa
 * @package    Evozon Qa Adminhtml
 * @copyright  Copyright (C) 2016 Evozon Internship (https://github.com/noonlit/magento.git branch develop)
 * @license    Bla Bla
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
     * DON'T KNOW IF THIS WORKS
     */
    protected function _isAllowed()
    {return true;
        return Mage::getSingleton('admin/session')->isAllowed('admin/evozon_qa');
    }

    /**
     * the first actopm will be edit
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * edit action
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id', null);
        $model = Mage::getModel('evozon_qa/question'); //adminhtml questions model
        if ($id) {
            $model->load((int) $id);
            if ($model->getId()) {
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                if ($data) {
                    $model->setData($data)->setId($id); //TODO search wat is this
                }
            } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('evozon_qa')->__('Example does not exist'));
                $this->_redirect('*/*/');
            }
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
            $model->load((int) $id);
            if ($model->getId()) {
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                if ($data) {
                    $model->setData($data)->setId($id); //TODO search wat is this
                }
            } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('evozon_qa')->__('Example does not exist'));
                $this->_redirect('*/*/');
            }
        }
        //TODO WHAT name to put instead of example_data ??
        Mage::register('example_data', $model);

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }

    /**
     * answer action
     */
    public function answerAction()
    {
        $id = $this->getRequest()->getParam('id', null);
        $model = Mage::getModel('evozon_qa/question'); //adminhtml questions model
        if ($id) {
            $model->load((int) $id);
            if ($model->getId()) {
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                if ($data) {
                    $model->setData($data)->setId($id); //TODO search wat is this
                }
            } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('evozon_qa')->__('Example does not exist'));
                $this->_redirect('*/*/');
            }
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
            $model->load((int) $id);
            if ($model->getId()) {
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                if ($data) {
                    $model->setData($data)->setId($id); //TODO search wat is this
                }
            } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('evozon_qa')->__('Example does not exist'));
                $this->_redirect('*/*/');
            }
        }
        //TODO WHAT name to put instead of example_data ??
        Mage::register($dataName, $model);
    }

    public function saveAction()
    {
        //IT CAN JUST EDIT EXISTING ASNWERS, TODO FOR NEW ANSWERS
        //SHOULD USE A NEW ADD ANSWER
        if ($data = $this->getRequest()->getPost()) {

            $model = Mage::getModel('evozon_qa/question');
            $answerModel = Mage::getModel('evozon_qa/answer');
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
                $answer = $answerModel->getQuestionById($id)->getFirstItem();
            }
            if (!empty($data['answer'])) {
                $answerText = $data['answer'];
                unset($data['answer']);
            }
            if (!empty($answerId = $answer->getData('answer_id'))) {
                $answerModel->load($answerId);
                $answer->setAnswer($answerText);
            }
            $model->setData($data);
            if (!empty($answer)) {
                $answerModel->setData($answer->getData());
            }
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            try {
                if ($id) {
                    $model->setId($id);
                }
                if ($answerId) {
                    $answerModel->setId($answerId);
                }
                $model->save();
                $answerModel->save();
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('evozon_qa')->__('Error saving example'));
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('evozon_qa')->__('Example was successfully saved.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // The following line decides if it is a "save" or "save and continue"
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/answer', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/');
                }
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                if ($model && $model->getId()) {
                    $this->_redirect('*/*/answer', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/');
                }
            }

            return;
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('evozon_qa')->__('No data found to save'));
        $this->_redirect('*/*/');
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
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to find the example to delete.'));
        $this->_redirect('*/*/');
    }

    public function massApproveQuestionsAction()
    {
        $questionIds = $this->getRequest()->getParam('evozon_qa_questions_id');

        if(!is_array($questionIds)) {
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

        if(!is_array($questionIds)) {
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

        if(!is_array($questionIds)) {
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

    public function massDeleteAnswersAction()
    {
        $answerIds = $this->getRequest()->getParam('evozon_qa_answers_id');

        if(!is_array($answerIds)) {
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
