<?php

/**
 * Created by PhpStorm.
 * User: marius
 * Date: 6/14/16
 * Time: 2:49 PM
 */
class Evozon_Qa_Adminhtml_QuestionsController extends Mage_Adminhtml_Controller_Action
{

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()
            ->setBody(
            $this->
            getLayout()
                ->createBlock('evozon_qa/adminhtml_question_grid')
                ->toHtml()
        );
    }

    public function indexAction()
    {
        $this->_title($this->__('Questions'))->_title($this->__('Questions'));
        $this->loadLayout();
        $layout = $this->getLayout();
        $content = $layout->createBlock('evozon_qa/adminhtml_question');
        $this->_addContent($content);
        $this->renderLayout();
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('evozon_qa/manage-questions');
    }
}