<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grid
 *
 * @author bogdanhaidu
 */
class Evozon_Qa_Adminhtml_Block_Answers_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('example_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('evozon_qa_adminhtml/answers')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        //NEED TO ADD THE COLUMNS FROM THE QUESTION TABLE
        $this->addColumn('answer_id', array(
            'header' => Mage::helper('evozon_qa_adminhtml')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'answer_id',
        ));

        $this->addColumn('question_id', array(
            'header' => Mage::helper('evozon_qa_adminhtml')->__('Question Id'),
            'align' => 'left',
            'index' => 'question_id',
        ));

        $this->addColumn('answer', array(
            'header' => Mage::helper('evozon_qa_adminhtml')->__('Answer'),
            'align' => 'left',
            'index' => 'answer',
        ));

        $this->addColumn('user_id', array(
            'header' => Mage::helper('evozon_qa_adminhtml')->__('User Id'),
            'align' => 'left',
            'index' => 'user_id',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
