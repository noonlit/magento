<?php

/**
 * Magento
 * 
 * PHP version 5.5.9-1
 * 
 * @category Evozon
 * @package  Evozon_Qa
 * @author   Andrei Bodea <andrei.bodea@evozon.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link     https://github.com/noonlit/magento
 */

/**
 * Qa_Question Resource
 * 
 * @category Evozon
 * @package  Evozon_Qa
 * @author   Andrei Bodea <andrei.bodea@evozon.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link     https://github.com/noonlit/magento
 */
class Evozon_Qa_Model_Resource_Question extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Initialize collection
     * 
     * @return void
     */
    protected function _construct()
    {
        $this->_init('evozon_qa/question', 'question_id');
    }

}
