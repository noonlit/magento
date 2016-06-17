<?php

/**
 * answer question form container
 *
 * @category   Evozon
 * @package    Qa
 * @subpackage adminhtml
 * @author     Haidu Bogdan <bogdan.haidu@evozon.com>
 */
class Evozon_Qa_Block_Adminhtml_Questions_Answer extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'evozon_qa_adminhtml'; //block_adminhtml tag
        $this->_controller = 'questions';
        $this->_mode = 'answer';

        $this->updateButtons(); //updates existing buttons from the container
        $this->formScripts(); //updated form scripts
    }

    /**
     * sets the header of the form
     * 
     * @return object
     */
    public function getHeaderText()
    {
        if (Mage::registry('example_data') && Mage::registry('example_data')->getId()) {
            return Mage::helper('evozon_qa')->__('Answer Question "%s"', $this->htmlEscape(Mage::registry('example_data')->getQuestionId()));
        }
    }

    //updates existing buttons from the container

    public function updateButtons()
    {
        //change the save button label
        $this->_updateButton('save', 'label', Mage::helper('evozon_qa')->__('Save Question'));
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
                answerForm.submit($('edit_form').action+'back/answer/');
            }
        ";
    }

}
