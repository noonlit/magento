<?php

class Evozon_Qa_Adminhtml_QaController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('qa')
              ->_title('Q & A Management');
        //create a text block with the name of "example-block"
        $block = $this->getLayout()
                ->createBlock('core/text', 'example-block')
                ->setText('<h1>This is a text block</h1>');

        $this->_addContent($block);
        //var_dump($this->getLayout()->createBlock('evozon_qa_adminhtml/content'));
        $block2 = $this->getLayout()
                ->createBlock('evozon_qa_adminhtml/content')
                ->setText('<h1>This is a text block</h1>');

        $this->_addContent($block2);

        $this->_addBreadcrumb($this->__('Q A Management'), $this->__('Q A Management'));
        $this->renderLayout();
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('qa');
    }

}
