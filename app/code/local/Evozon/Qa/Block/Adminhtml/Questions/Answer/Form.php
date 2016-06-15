<?php

/**
 * Questions and Answers extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Evozon Q A Adminhtml module to newer versions in the future.
 * If you wish to customize the Evozon Q A Adminhtml module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Evozon Qa
 * @package    Evozon Qa Adminhtml
 * @copyright  Copyright (C) 2016 Evozon Internship (https://github.com/noonlit/magento.git branch develop)
 * @license    -----
 */

/**
 * questions answer form
 *
 * @category   Evozon Qa
 * @package    Evozon Qa Adminhtml 
 * @subpackage form block
 * @author     Haidu Bogdan <bogdan.haidu@evozon.com>
 */
class Evozon_Qa_Block_Adminhtml_Questions_Answer_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * prepare the form
     *
     * @return Mage_Adminhtml_Block_Widget_Form|void
     */
    protected function _prepareForm()
    {
        $questionId = $this->getRequest()->getParam('id');
        $answerItems = Mage::getModel('evozon_qa/answer')->getQuestionById($questionId)->getFirstItem();

        $answerText = array('answer'=>$answerItems->getAnswer());

        if (Mage::getSingleton('adminhtml/session')->getExampleData()) {
            $data = Mage::getSingleton('adminhtml/session')->getExamplelData();
            Mage::getSingleton('adminhtml/session')->getExampleData(null);
        } elseif (Mage::registry('example_data')) {
            $data = Mage::registry('example_data')->getData();
        } else {
            $data = array();
        }
        //THIS SHOULD BE LOOKED UPP
        if ($answerItems->getAnswer()) {
            $data+=$answerText;
        }
        
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $questionId)),
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ));

        $form->setUseContainer(true);

        $this->setForm($form);

        $fieldset = $form->addFieldset('question_form', array(
            'legend' => Mage::helper('evozon_qa')->__('Question Information') //FORM TAB NAME
        ));

        $fieldset->addField('text', 'textarea', array(//is this the correct place to set the type textarea?
            'label' => Mage::helper('evozon_qa')->__('Text'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'text',
            'readonly' => true,
            'note' => Mage::helper('evozon_qa')->__('Question Content.'),
        ));

        $values = Evozon_Qa_Model_Resource_Question_Attribute_Source_Status::getValues();

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('evozon_qa')->__('Status'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'status',
            'options' => $values,
        ));

        $fieldset->addField('answer', 'textarea', array(//is this the correct place to set the type textarea?
            'label' => Mage::helper('evozon_qa')->__('Answer'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'answer',
            'note' => Mage::helper('evozon_qa')->__('Answer Content.'),
        ));

        $form->setValues($data);



        return parent::_prepareForm();
    }

}
