<?php

/**
 * Created by PhpStorm.
 * User: marius
 * Date: 6/14/16
 * Time: 4:49 PM
 */
class Evozon_Qa_Block_Adminhtml_Question extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'evozon_qa';
        $this->_controller = 'adminhtml_questions';
        $this->_headerText = Mage::helper('evozon_qa')->__('Questions - Evozon');

        parent::__construct();
        $this->_removeButton('add');
    }
}