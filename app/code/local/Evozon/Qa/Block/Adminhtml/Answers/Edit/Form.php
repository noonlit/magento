<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Form
 *
 * @author bogdanhaidu
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
        if (Mage::getSingleton('adminhtml/session')->getExampleData())
        {
            $data = Mage::getSingleton('adminhtml/session')->getExamplelData();
            Mage::getSingleton('adminhtml/session')->getExampleData(null);
        }
        elseif (Mage::registry('example_data'))
        {
            $data = Mage::registry('example_data')->getData();
        }
        else
        {
            $data = array();
        }
 
        $form = new Varien_Data_Form(array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data',
        ));
 
        $form->setUseContainer(true);
 
        $this->setForm($form);
 
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
        
        $fieldset->addField('question_id', 'text', array(
            'label' => Mage::helper('evozon_qa')->__('Question Id'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'question_id',
        ));
 
        $form->setValues($data);
 
        return parent::_prepareForm();
    }
}
