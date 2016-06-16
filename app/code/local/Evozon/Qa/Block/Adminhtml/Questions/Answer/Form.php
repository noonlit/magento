<?php

/**
 * answer question form block
 *
 * @category   Evozon
 * @package    Qa
 * @subpackage adminhtml
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

        $data = $this->getFormData($questionId); //populate the form with existing data
        //create a form object
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $questionId)),
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ));

        $form->setUseContainer(true);

        $this->setForm($form);

        $statusModel = Mage::getResourceModel('evozon_qa/question_attribute_source_status');
        $statusValues = $statusModel::getValues(); //returns the optionValues for the Status field

        $this->addFieldsToForm($form, $statusValues); //add the form fields

        $form->setValues($data);

        return parent::_prepareForm();
    }

    /**
     * returns the existing data from the question, and adds the answer value if it exists
     * @param int $questionId
     * @return array
     */
    protected function getFormData($questionId)
    {
        $answerItems = Mage::getModel('evozon_qa/answer')->getQuestionById($questionId)->getFirstItem();

        if (Mage::getSingleton('adminhtml/session')->getExampleData()) {
            $data = Mage::getSingleton('adminhtml/session')->getExamplelData();
            Mage::getSingleton('adminhtml/session')->getExampleData(null);
        } elseif (Mage::registry('example_data')) {
            $data = Mage::registry('example_data')->getData();
        } else {
            $data = array();
        }

        if ($answerItems->getAnswer()) { //if a answer to the question exists
            $answerText = array('answer' => $answerItems->getAnswer());
            $data+=$answerText;
        }
        return $data;
    }
    
    /**
     * adds the input fields for the form object
     * 
     * @param object $form
     * @param array $statusValues
     */
    protected function addFieldsToForm($form, $statusValues)
    {
        $fieldset = $form->addFieldset('question_form', array(
            'legend' => Mage::helper('evozon_qa')->__('Question Information') //form tab name
        ));

        /* question text
         * type = textarea
         * disabled
         */

        $fieldset->addField('text', 'textarea', array(
            'label' => Mage::helper('evozon_qa')->__('Text'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'text',
            'disabled' => true,
            'readonly' => true,
            'note' => Mage::helper('evozon_qa')->__('Question Content.'),
        ));

        /* question status
         * type = select
         */

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('evozon_qa')->__('Status'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'status',
            'options' => $statusValues,
        ));

        /* question answer, different table
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
