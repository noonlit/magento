<?php

/**
 *  Qa_Question model
 * @category   Evozon
 * @package    Evozon_Qa
 * @author     Ilinca Dobre <ilinca.dobre@evozon.com>
 * @author     Georgiana Tobosi <georgiana.tobosi@evozon.com>
 * @author     Delia Dumitru <delia.dumitru@evozon.com>
 * @author     Andrei Bodea <andrei.bodea@evozon.com>
 */
class Evozon_Qa_Model_Question extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        //sets the resource model class instance used for this model
        $this->_init('evozon_qa/question');
    }

    /**
     * Gets questions and answers for current product
     * 
     * @author     Andrei Bodea <andrei.bodea@evozon.com>
     * @return Evozon_Qa_Model_Resource_Question_Collection
     */
    public function fetchQuestions()
    {
        $status = 'approved';
        $currentProductId = Mage::registry('current_product')->getId();

        $collection = $this->getCollection();
        $collection->getSelect()
                ->joinLeft(array('answers' => 'evozon_answers'), 'main_table.question_id = answers.question_id', array('answer', 'user_id'))
                ->joinLeft(array('customer' => 'customer_entity'), 'main_table.customer_id = customer.entity_id', array('email'))
                ->joinLeft(array('admin' => 'admin_user'), 'answers.user_id = admin.user_id', array('firstname', 'lastname'))
                ->where('product_id = ?', $currentProductId)
                ->where('status = ?', $status);

        return $collection;
    }

    /**
     * Saves a submitted question to database
     * 
     * @author     Ilinca Dobre <ilinca.dobre@evozon.com>
     * @param array $formData
     * @return boolean
     */
    public function addQuestion($formData)
    {
        $questionModel = Mage::getModel('evozon_qa/question');

        $question = $formData['qa_question'];
        $productId = $formData['qa_current_product'];

        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();
        } else {
            $customer = Mage::getModel("customer/customer");
            $id = $customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                            ->loadByEmail('guestUser@madisonIsland.com')->getId();
            $customerId = $id;
        }

        $questionModel->setData(array(
            'text' => $question,
            'status' => 'new',
            'product_id' => $productId,
            'customer_id' => $customerId
        ));
        $questionModel->save();

        return true;
    }

    /**
     * Validation for form inputs: checks if the question field is not empty
     * @author     Ilinca Dobre <ilinca.dobre@evozon.com>
     * @return boolean/array
     */
    public function validate()
    {
        $errors = array();
        $data = $this->getData();
        $questionText = $data['qa_question'];
        if (!Zend_Validate::is($questionText, 'NotEmpty')) {
            $errors[] = Mage::helper('evozon_qa/data')->__('Question can\'t be empty');
        }

        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

}
