<?php

class Evozon_Qa_Adminhtml_Block_Questions extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /*
     * THIS IS JUST A TEST METHOD, IT WILL CONTAIN METHODS FOR THE menu.phtml
     */

    protected $_addButtonLabel = 'Add Question';

    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'questions';
        $this->_blockGroup = 'evozon_qa_adminhtml';
        $this->_headerText = Mage::helper('evozon_qa_adminhtml')->__('Qa Panel');
    }

}
