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
 * @license    Bla Bla
 */
/**
 * questions grid controller
 *
 * @category   Evozon Qa
 * @package    Evozon Qa Adminhtml 
 * @subpackage controllers
 * @author     Haidu Bogdan <bogdan.haidu@evozon.com>
 */

class Evozon_Qa_Block_Adminhtml_AnswerQuestions extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    
    protected $_addButtonLabel = 'Remove this button'; //Name of the Visible Button

    public function __construct()
    {
        
        parent::__construct();
        $this->_controller = 'answerquestions';
        $this->_blockGroup = 'evozon_qa_adminhtml'; //block_adminhtml tag
        $this->_headerText = Mage::helper('evozon_qa')->__('Questions Answer Panel'); //Name of the Grid
        
    }

}
