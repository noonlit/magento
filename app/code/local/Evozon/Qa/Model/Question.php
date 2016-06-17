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

    const STATUS_NEW      = 1;
    const STATUS_PENDING  = 2;
    const STATUS_APPROVED = 3;
    const STATUS_DISABLED = 4;

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

        $currentProductId = Mage::registry('current_product')->getId();
        $currentStore = Mage::app()->getStore()->getStoreId();

        $collection = $this->getCollection();
        $collection->getSelect()
                ->joinLeft(array('answers' => 'evozon_answers'), 'main_table.question_id = answers.question_id', array('answer', 'admin_id'))
//                ->joinLeft(array('name' => 'customer_entity_varchar'), 'main_table.customer_id = name.entity_id', array('attribute_id', 'value'))
//                ->joinLeft(array('att' => 'eav_attribute'), 'name.attribute_id = att.attribute_id', array('attribute_code'))
                ->joinLeft(array('admin' => 'admin_user'), 'answers.admin_id = admin.user_id', array('firstname', 'lastname'))
//                ->where('attribute_code IN (?)', array('firstname', 'lastname'))
                ->where('product_id = ?', $currentProductId)
                ->where('status = ?', static::STATUS_APPROVED)
                ->where('main_table.store_id = ?', $currentStore);
//                ->from(null, array('user_name' => new Zend_Db_Expr('GROUP_CONCAT(name.value ORDER BY name.attribute_id SEPARATOR \' \')')))
//                ->group('main_table.question_id');
//        ;

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
        $productId = Mage::app()->getRequest()->getParam('id');
        $this->setData(array(
            'question'      => $formData['qa_question'],
            'status'        => static::STATUS_NEW,
            'product_id'    => $formData['qa_current_product'],
            'customer_name' => $formData['qa_username'],
            'store_id'      => Mage::app()->getStore()->getStoreId(),
            'created_at'    => strtotime('now'),
        ));
        $this->save();

        return $this;
    }

    /**
     * Validation for form inputs: checks if the question field is not empty
     * 
     * @author     Ilinca Dobre <ilinca.dobre@evozon.com>
     * @return boolean/array
     */
    public function validate($formData)
    {
        $errors = array();
        $questionText = $formData['qa_question'];
        if (!Zend_Validate::is($questionText, 'NotEmpty')) {
            $errors[] = Mage::helper('evozon_qa/data')->__('Question can\'t be empty');
        }

        if (empty($errors)) {
            return true;
        }
        return $errors;
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    static public function getOptionArray()
    {
        return array(
            static::STATUS_NEW        => Mage::helper('evozon_qa')->__('New'),
            static::STATUS_PENDING    => Mage::helper('evozon_qa')->__('Pending'),
            static::STATUS_APPROVED   => Mage::helper('evozon_qa')->__('Approved'),
            static::STATUS_DISABLED   => Mage::helper('evozon_qa')->__('Disabled')
        );
    }

}
