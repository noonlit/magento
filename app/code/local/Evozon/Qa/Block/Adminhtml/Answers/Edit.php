<?php

class Evozon_Qa_Adminhtml_Block_Answers_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'evozon_qa_adminhtml';
        $this->_controller = 'answers';
        $this->_mode = 'edit';

        $this->_addButton('save_and_continue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
                ), -100);
        $this->_updateButton('save', 'label', Mage::helper('evozon_qa')->__('Save Example'));

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('form_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'edit_form');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'edit_form');
                }
            }
 
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('example_data') && Mage::registry('example_data')->getId()) {
            return Mage::helper('evozon_qa')->__('Edit Example "%s"', $this->htmlEscape(Mage::registry('example_data')->getName()));
        } else {
            return Mage::helper('evozon_qa')->__('New Example');
        }
    }

}
