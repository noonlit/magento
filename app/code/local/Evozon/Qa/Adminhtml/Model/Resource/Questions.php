<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 * @author bogdanhaidu
 */
class Evozon_Qa_Adminhtml_Model_Resource_Questions extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Init
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('evozon_qa_adminhtml/questions', 'question_id');
    }
}
