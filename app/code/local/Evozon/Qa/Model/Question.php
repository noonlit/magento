<?php

/**
 * Magento
 * 
 * PHP version 5.5.9-1
 * 
 * @category Evozon
 * @package  Evozon_Qa
 * @author   Ilinca Dobre <ilinca.dobre@evozon.com>
 * @author   Georgiana Tobosi <georgiana.tobosi@evozon.com>
 * @author   Delia Dumitru <delia.dumitru@evozon.com>
 * @author   Andrei Bodea <andrei.bodea@evozon.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link     https://github.com/noonlit/magento
 */

/**
 *  Qa_Question model
 * 
 * @category Evozon
 * @package  Evozon_Qa
 * @author   Ilinca Dobre <ilinca.dobre@evozon.com>
 * @author   Georgiana Tobosi <georgiana.tobosi@evozon.com>
 * @author   Delia Dumitru <delia.dumitru@evozon.com>
 * @author   Andrei Bodea <andrei.bodea@evozon.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link     https://github.com/noonlit/magento
 */
class Evozon_Qa_Model_Question extends Mage_Core_Model_Abstract
{

    const STATUS_NEW = 1;
    const STATUS_PENDING = 2;
    const STATUS_APPROVED = 3;
    const STATUS_DISABLED = 4;

    /**
     * Initialize resource
     * 
     * @return void
     */
    protected function construct()
    {
        $this->_init('evozon_qa/question');
    }

    /**
     * Gets questions and answers for current product
     * 
     * @author     Andrei Bodea <andrei.bodea@evozon.com>
     * @return Evozon_Qa_Model_Resource_Question_Collection
     */
    public function getQuestions()
    {

        $currentProductId = Mage::registry('current_product')->getId();
        $currentStore = Mage::app()->getStore()->getStoreId();

        $collection = $this->getCollection();
        $collection->getSelect()
            ->joinLeft(
                array('answers' => 'evozon_answers'), 'main_table.question_id = answers.question_id', array('answer', 'admin_id')
            )
            ->joinLeft(
                array('admin' => 'admin_user'), 'answers.admin_id = admin.user_id', array('firstname', 'lastname')
            )
            ->where('product_id = ?', $currentProductId)
            ->where('status = ?', static::STATUS_APPROVED)
            ->where('main_table.store_id = ?', $currentStore);

        return $collection;
    }

    /**
     * Saves a submitted question to database
     * 
     * @param array $formData form information
     * 
     * @return boolean
     */
    public function addQuestion($formData)
    {
        $this->setData(
            array(
                'question' => $formData['qa_question'],
                'status' => static::STATUS_NEW,
                'product_id' => $formData['qa_current_product'],
                'customer_name' => $formData['qa_username'],
                'store_id' => Mage::app()->getStore()->getStoreId(),
                'created_at' => strtotime('now')
            )
        );

        $this->save();
        try {
            $this->save();
        } catch (Exception $ex) {
            throw new Exception('Unable to post the question');
        }

        return $this;
    }

    /**
     * Validation for form inputs: checks if the question field is not empty
     * 
     * @param array $formData form information
     * 
     * @return boolean
     */
    public function validate($formData)
    {
        $errors = array();
        $questionText = $formData['qa_question'];
        if (!Zend_Validate::is($questionText, 'NotEmpty')) {
            $errors[] = Mage::helper('evozon_qa/data')
                ->__('Question can\'t be empty');

            $errors = '';
            foreach ($formData as $field => $input) {
                switch ($field) {
                    case 'question':
                        if (!Zend_Validate::is($input, 'NotEmpty')) {
                            $errors .= 'Question can\'t be empty! ';
                        }
                        if (!Zend_Validate::is($input, 'StringLength', array('max' => 255))) {
                            $errors .= "Question is too long (max is 255)!";
                        }
                        break;
                    case 'qa_question':
                        if (!Zend_Validate::is($input, 'NotEmpty')) {
                            $errors .= 'Question can\'t be empty! ';
                        }
                        if (!Zend_Validate::is($input, 'StringLength', array('max' => 255))) {
                            $errors .= "Question is too long (max is 255)!";
                        }
                        break;
                    case 'qa_username':
                        if (!Zend_Validate::is($input, 'NotEmpty')) {
                            $errors .= 'Username can\'t be empty! ';
                        }
                        break;
                    case 'answer':
                        if (!Zend_Validate::is($input, 'NotEmpty')) {
                            $errors .= 'Answer can\'t be empty! ';
                        }
                        if (!Zend_Validate::is($input, 'StringLength', array('max' => 255))) {
                            $errors .= "Answer is too long (max is 255)!";
                        }
                        break;
                }
            }
            if ($errors) {
                throw new Exception($errors);
            }
            return $this;
        }
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    static public function getOptionArray()
    {
        return array(
            static::STATUS_NEW => Mage::helper('evozon_qa')->__('New'),
            static::STATUS_PENDING => Mage::helper('evozon_qa')->__('Pending'),
            static::STATUS_APPROVED => Mage::helper('evozon_qa')->__('Approved'),
            static::STATUS_DISABLED => Mage::helper('evozon_qa')->__('Disabled')
        );
    }

}
