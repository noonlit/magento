<?php

/**
 * Created by PhpStorm.
 * User: marius
 * Date: 6/14/16
 * Time: 4:54 PM
 */
class Evozon_Qa_Block_Adminhtml_Question_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('evozon_qa_question_grid');
        $this->setDefaultSort('question_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('evozon_qa/question')->getCollection()->getSelect();

        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('evozon_qa');

        $this->addColumn('question_id', array(
            'header' => $helper->__('Question #'),
            'index'  => 'question_id'
        ));

        $this->addColumn('status', array(
            'header' => $helper->__('Status'),
            'index'  => 'status'
        ));


        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

}