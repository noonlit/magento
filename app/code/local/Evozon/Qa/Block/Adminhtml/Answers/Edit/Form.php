<?php

/**
 * Questions and Answers extension for Magento
 *
 * answers form block
 *
 * @category   Evozon
 * @package    Qa
 * @subpackage adminhtml
 * @author     Haidu Bogdan <bogdan.haidu@evozon.com>
 */
class Evozon_Qa_Block_Adminhtml_Answers_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * prepare the form
     *
     * @return Mage_Adminhtml_Block_Widget_Form|void
     */
    protected function _prepareForm()
    {
        $data = $this->getFormData(); //populate the form with existing data
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/saveEditAnswer', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ));

        $form->setUseContainer(true);

        $this->setForm($form);

        $this->addFieldsToForm($form); //add the form fields

        $form->setValues($data);

        return parent::_prepareForm();
    }

    /**
     * returns the existing data from the question, and adds the answer value if it exists
     * @return array
     */
    protected function getFormData()
    {
        if (Mage::getSingleton('adminhtml/session')->getExampleData()) {
            $data = Mage::getSingleton('adminhtml/session')->getExamplelData();
            Mage::getSingleton('adminhtml/session')->getExampleData(null);
        } elseif (Mage::registry('example_data')) {
            $data = Mage::registry('example_data')->getData();
        } else {
            $data = array();
        }
        return $data;
    }

    /**
     * adds the input fields for the form object
     * 
     * @param object $form
     */
    protected function addFieldsToForm($form)
    {
        $fieldset = $form->addFieldset('answer_form', array(
            'legend' => Mage::helper('evozon_qa')->__('Answer Information') //FORM TAB NAME
        ));

        $fieldset->addField('answer', 'textarea', array(//is this the correct place to set the type textarea?
            'label' => Mage::helper('evozon_qa')->__('Answer'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'answer',
            'note' => Mage::helper('evozon_qa')->__('Answer Content.'),
        ));
    }

}
