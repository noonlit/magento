<?php

class Evozon_Qa_Model_Resource_Answer extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        //sets the main table and the primary key associated to the resource model
        $this->_init('evozon_qa/answer', 'answer_id');
    }

}

