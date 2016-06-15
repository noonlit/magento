<?php

class Evozon_Qa_Block_Adminhtml_Questions_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'evozon_qa_adminhtml'; //block_adminhtml tag
        $this->_controller = 'questions';
        $this->_mode = 'edit';

        $this->_addButton('save_and_continue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
                ), -100);
        $this->_updateButton('save', 'label', Mage::helper('evozon_qa')->__('Save Question'));
        $this->_updateButton('back', 'onclick', 'setLocation(\'' . $this->getUrl('*/*/questions') . '\')');
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

//header of the form
    public function getHeaderText()
    {
        if (Mage::registry('example_data') && Mage::registry('example_data')->getId())
        {
            return Mage::helper('evozon_qa')->__('Edit Question "%s"', $this->htmlEscape(Mage::registry('example_data')->getQuestionId()));
        } else
        {
            return Mage::helper('evozon_qa')->__('New Question');
        }
    }

}
