<?php

/**
 * Questions and Answers extension for Magento
 *
 * edit answer form container
 *
 * @category   Evozon
 * @package    Qa
 * @subpackage adminhtml
 * @author     Haidu Bogdan <bogdan.haidu@evozon.com>
 */
class Evozon_Qa_Block_Adminhtml_Answers_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'evozon_qa_adminhtml';
        $this->_controller = 'answers';
        $this->_mode = 'edit';

        $this->addButtons(); //adds new buttons to the container
        $this->updateButtons(); //updates existing buttons from the container
        $this->formScripts(); //updated form scripts
    }

    /**
     * sets the header of the form
     * return the table header
     * 
     * @return object
     */
    public function getHeaderText()
    {

        if (Mage::registry('example_data') && Mage::registry('example_data')->getId()) {
            $id = $this->htmlEscape(Mage::registry('example_data')->getId()); //returns the answer Id
            $questionId = $this->htmlEscape(Mage::registry('example_data')->getQuestionId()); //returns the question Id
            return Mage::helper('evozon_qa')->__('Edit Answer %s', $id . ' for Question ' . $questionId);
        } else {
            return Mage::helper('evozon_qa')->__('New Answer');
        }
    }

    //adds new buttons to the container

    protected function addButtons()
    {
        $this->_addButton('save_and_continue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
                ), -100);
    }


    //updates existing buttons from the container

    public function updateButtons()
    {
        $this->_updateButton('save', 'label', Mage::helper('evozon_qa')->__('Save Answer'));
        $this->_updateButton('back', 'onclick', 'setLocation(\'' . $this->getUrl('*/*/answers') . '\')');
    }

    //updated form scripts

    protected function formScripts()
    {
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('form_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'edit_form');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'edit_form');
                }
            }
 
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/editanswer/');
            }
        ";
    }

}
