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
class Evozon_Qa_Adminhtml_Block_Menu_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
        $collection = Mage::getModel('evozon_qa_adminhtml/menu')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    {
        //NEED TO ADD THE COLUMNS FROM THE QUESTION TABLE
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('evozon_qa_adminhtml')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'entity_id',
        ));
 
        $this->addColumn('email', array(
            'header'    => Mage::helper('evozon_qa_adminhtml')->__('Email'),
            'align'     =>'left',
            'index'     => 'email',
        ));
 
        return parent::_prepareColumns();
    }
 
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
