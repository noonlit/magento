<?php

/**
 * Questions and Answers extension for Magento
 *
 * questions grid container
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
        $this->_blockGroup = 'evozon_qa_adminhtml'; //block_adminhtml tag
        $this->_headerText = Mage::helper('evozon_qa')->__('Questions Panel'); //Name of the Grid
        $this->removeButton('add'); //Removes the add button
    }

}
