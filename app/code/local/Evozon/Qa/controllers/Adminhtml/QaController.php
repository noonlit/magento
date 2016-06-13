<?php

class Evozon_Qa_Adminhtml_QaController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();

        //create a text block with the name of "example-block"
        $block = $this->getLayout()
                ->createBlock('core/text', 'example-block')
                ->setText('<h1>This is a text block</h1>');

        $this->_addContent($block);

        $this->renderLayout();
    }

}
