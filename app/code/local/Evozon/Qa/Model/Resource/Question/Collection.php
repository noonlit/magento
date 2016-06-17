<?php

/**
 * Qa_Question Collection
 *
 * @category   Evozon
 * @package    Evozon_Qa
 * @author     Andrei Bodea <andrei.bodea@evozon.com>
 */
class Evozon_Qa_Model_Resource_Question_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('evozon_qa/question');
    }

}
