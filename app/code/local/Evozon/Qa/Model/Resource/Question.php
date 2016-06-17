<?php

/**
 * Qa_Question Resource
 *
 * @category   Evozon
 * @package    Evozon_Qa
 * @author     Andrei Bodea <andrei.bodea@evozon.com>
 */
class Evozon_Qa_Model_Resource_Question extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('evozon_qa/question', 'question_id');
    }

}
