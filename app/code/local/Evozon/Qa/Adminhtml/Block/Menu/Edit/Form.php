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
class Evozon_Qa_Adminhtml_Block_Menu_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
 
        $fieldset = $form->addFieldset('example_form', array(
             'legend' =>Mage::helper('awesome')->__('Example Information')
        ));
 
        $fieldset->addField('name', 'text', array(
             'label'     => Mage::helper('awesome')->__('Name'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'name',
             'note'     => Mage::helper('awesome')->__('The name of the example.'),
        ));
 
        $fieldset->addField('description', 'text', array(
             'label'     => Mage::helper('awesome')->__('Description'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'description',
        ));
 
        $fieldset->addField('other', 'text', array(
             'label'     => Mage::helper('awesome')->__('Other'),
             'class'     => 'required-entry',
             'required'  => true,
             'name'      => 'other',
        ));
 
        $form->setValues($data);
 
        return parent::_prepareForm();
    }
}
