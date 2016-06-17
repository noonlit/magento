<?php

/**
 * Questions grid container
 *
 * @category   Evozon
 * @package    Evozon Qa
 * @subpackage adminhtml
 * @author     Haidu Bogdan <bogdan.haidu@evozon.com>
 */
class Evozon_Qa_Block_Adminhtml_Questions extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {

        parent::__construct();
        $this->_controller = 'questions';
        //block definition
        $this->_blockGroup = 'evozon_qa_adminhtml';
        //grid header text
        $this->_headerText = Mage::helper('evozon_qa')->__('Questions Panel');
        //remove the mage automatic generated add button
        $this->removeButton('add');
    }

}
