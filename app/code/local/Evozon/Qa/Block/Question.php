<?php

/**
 * Magento
 * 
 * PHP version 5.5.9-1
 * 
 * @category Evozon
 * @package  Evozon_Qa
 * @author   Andrei Bodea <andrei.bodea@evozon.com>
 * @author   Ilinca Dobre <ilinca.dobre@evozon.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link     https://github.com/noonlit/magento
 */

/**
 * Question form block
 * 
 * @category Evozon
 * @package  Evozon_Qa
 * @author   Andrei Bodea <andrei.bodea@evozon.com>
 * @author   Ilinca Dobre <ilinca.dobre@evozon.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link     https://github.com/noonlit/magento
 */
class Evozon_Qa_Block_Question extends Mage_Core_Block_Template
{

    /**
     * Returns questions of current product
     * 
     * @return Evozon_Qa_Model_Resource_Question_Collection
     */
    public function getQuestions()
    {
        return Mage::getModel('evozon_qa/question')->getQuestions();
    }

    /**
     * Returns the current product id
     *
     * @return int
     */
    public function getCurrentProductId()
    {
        return Mage::app()->getRequest()->getParam('id');
    }

}
