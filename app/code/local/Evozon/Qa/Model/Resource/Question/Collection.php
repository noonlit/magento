<?php

/**
 * Qa_Question Collection
 *
 * @category   Evozon
 * @package    Evozon_Qa
 * @author     Delia Dumitru <delia.dumitru@evozon.com>
 * @author     Andrei Bodea <andrei.bodea@evozon.com>
 */
class Evozon_Qa_Model_Resource_Question_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        //sets the model class for the collection items
        $this->_init('evozon_qa/question');
    }

}
