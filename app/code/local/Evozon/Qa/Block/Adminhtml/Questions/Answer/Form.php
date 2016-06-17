<?php

/**
 * Answer question form block
 *
 * @category   Evozon
 * @package    Qa
 * @subpackage adminhtml
 * @author     Haidu Bogdan <bogdan.haidu@evozon.com>
 */
class Evozon_Qa_Block_Adminhtml_Questions_Answer_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * @return Mage_Adminhtml_Block_Widget_Form|void
     */
    protected function _prepareForm()
    {
        $questionId = $this->getRequest()->getParam('id');
        //populate the form with existing data
        $data = $this->getFormData($questionId);
        
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $questionId)),
            'method' => 'post',
        ));

        $form->setUseContainer(true);
        $this->setForm($form);
        $this->addFieldsToForm($form);
        $form->setValues($data);

        return parent::_prepareForm();
    }

    /**
     * Returns the existing data from the question, and adds the answer value if it exists
     * 
     * @param int $questionId
     * @return array
     */
    protected function getFormData($questionId)
    {
        $answer = Mage::getModel('evozon_qa/answer')->load($questionId, 'question_id')->getAnswer();
        /* @var $questionModel Evozon_Qa_Model_Question */
        $questionModel = Mage::getModel('evozon_qa/question')->load($questionId);

        $status = $questionModel->getStatus();
        if ($status == $questionModel::STATUS_NEW) {
            $status = $questionModel::STATUS_PENDING;
        }

        $data = array(
            'question' => $questionModel->getQuestion(),
            'answer' => $answer,
            'status' => $status,
        );

        return $data;
    }

    /**
     * Adds the input fields for the Varien_Data_Form object
     * 
     * @param object $form Varien_Data_Form
     * @param array $statusValues
     */
    protected function addFieldsToForm($form)
    {
        $fieldset = $form->addFieldset('question_form', array( 
            //form tab name
            'legend' => Mage::helper('evozon_qa')->__('Question Information')
        ));

        /* 
         * question text
         * type = textarea
         */
        $fieldset->addField('question', 'textarea', array(
            'label' => Mage::helper('evozon_qa')->__('Question'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'question',
            'note' => Mage::helper('evozon_qa')->__('Question Content.'),
        ));

        /* 
         * question status
         * type = select
         */
        $model = Mage::getModel('evozon_qa/question');

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('evozon_qa')->__('Status'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'status',
            'options' => $model::getOptionArray(),
        ));

        /* 
         * question answer, different table
         * type = textarea
         */
        $fieldset->addField('answer', 'textarea', array(
            'label' => Mage::helper('evozon_qa')->__('Answer'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'answer',
            'note' => Mage::helper('evozon_qa')->__('Answer Content.'),
        ));
    }

}
