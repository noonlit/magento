<?php

class Evozon_Qa_Adminhtml_Block_Menu extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /*
     * THIS IS JUST A TEST METHOD, IT WILL CONTAIN METHODS FOR THE menu.phtml
     */

    protected $_addButtonLabel = 'Add New Example';

    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_qa';
        $this->_blockGroup = 'qa_menu';
        $this->_headerText = Mage::helper('evozon_qa_adminhtml')->__('Examples');
    }

}
