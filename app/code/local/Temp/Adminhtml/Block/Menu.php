<?php

//copied
class Evozon_QA_Block_Adminhtml_Menu extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Init grid container
     */
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_menu';
        $this->_blockGroup = 'menu';
        $this->_headerText = $this->__('Custom Menu Items');
        $this->_addButtonLabel = $this->__('Add Menu Item');
    }
}
