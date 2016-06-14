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
        $this->addColumn('id', array(
            'header'    => Mage::helper('evozon_qa_adminhtml')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'id',
        ));
 
        $this->addColumn('name', array(
            'header'    => Mage::helper('evozon_qa_adminhtml')->__('Name'),
            'align'     =>'left',
            'index'     => 'name',
        ));
 
        $this->addColumn('description', array(
            'header'    => Mage::helper('evozon_qa_adminhtml')->__('Description'),
            'align'     =>'left',
            'index'     => 'description',
        ));
 
        $this->addColumn('other', array(
            'header'    => Mage::helper('evozon_qa_adminhtml')->__('Other'),
            'align'     => 'left',
            'index'     => 'other',
        ));
 
        return parent::_prepareColumns();
    }
 
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
