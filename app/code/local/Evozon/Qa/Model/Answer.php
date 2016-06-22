<?php

/**
 * Magento
 * 
 * PHP version 5.5.9-1
 * 
 * @category Evozon
 * @package  Evozon_Qa
 * @author   Ilinca Dobre <ilinca.dobre@evozon.com>
 * @author   Haidu Bogdan <bogdan.haidu@evozon.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link     https://github.com/noonlit/magento
 */

/**
 *  Qa_Question model
 * 
 * @category Evozon
 * @package  Evozon_Qa
 * @author   Ilinca Dobre <ilinca.dobre@evozon.com>
 * @author   Haidu Bogdan <bogdan.haidu@evozon.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link     https://github.com/noonlit/magento
 */
class Evozon_Qa_Model_Answer extends Mage_Core_Model_Abstract
{
     /**
     * Initialize resource
     * 
     * @return void
     */
    protected function construct()
    {
        $this->_init('evozon_qa/answer');
    }

}
