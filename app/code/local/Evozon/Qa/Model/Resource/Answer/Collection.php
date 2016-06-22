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
 *  Qa_Question collection
 * 
 * @category Evozon
 * @package  Evozon_Qa
 * @author   Andrei Bodea <andrei.bodea@evozon.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link     https://github.com/noonlit/magento
 */
class Evozon_Qa_Model_Resource_Answer_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    /**
     * Initialize model
     * 
     * @return void
     */
    protected function construct()
    {
        $this->_init('evozon_qa/answer');
    }

}
