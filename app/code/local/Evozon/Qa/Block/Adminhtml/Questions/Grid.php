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
class Evozon_Qa_Adminhtml_Block_Questions_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $collection = Mage::getModel('evozon_qa_adminhtml/questions')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        //NEED TO ADD THE COLUMNS FROM THE QUESTION TABLE
       $this->addColumn('question_id', array(
            'header' => Mage::helper('evozon_qa_adminhtml')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'question_id',
        ));

        $this->addColumn('text', array(
            'header' => Mage::helper('evozon_qa_adminhtml')->__('Text'),
            'align' => 'left',
            'index' => 'text',
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('evozon_qa_adminhtml')->__('Status'),
            'align' => 'left',
            'index' => 'status',
        ));

        $this->addColumn('product_id', array(
            'header' => Mage::helper('evozon_qa_adminhtml')->__('Product Id'),
            'align' => 'left',
            'index' => 'product_id',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
