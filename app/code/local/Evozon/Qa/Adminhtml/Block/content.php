<?php

class Evozon_Qa_Adminhtml_Block_Content extends Mage_Adminhtml_Block_Template
{
    /**
     * Init grid container
     */
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_qa';
        $this->_blockGroup = 'qa';
        $this->_headerText = $this->__('Custom Qa Items');
        $this->_addButtonLabel = $this->__('Add Qa Item');
    }
}
