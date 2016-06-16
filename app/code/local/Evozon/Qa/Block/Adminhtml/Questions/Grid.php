<?php

/**
 * questions grid widget
 *
 * @category   Evozon
 * @package    Qa
 * @subpackage adminhtml
 * @author     Haidu Bogdan <bogdan.haidu@evozon.com>
 * @author     Marius Adam <marius.adam@evozon.com>
 */
class Evozon_Qa_Block_Adminhtml_Questions_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('questions_grid'); // Grid id
        $this->setDefaultSort('id');  //sorting by id
        $this->setDefaultDir('desc'); //direction
        $this->setSaveParametersInSession(true); //stores the parameters in session
    }

    /**
     * prepares collection for the grid
     * 
     * @return object
     */
    protected function _prepareCollection()
    {
        //questions collection
        $collection = Mage::getModel('evozon_qa/question')->getCollection();
//            ->getSelect()
//            ->joinLeft(array('answers' => 'evozon_answers'), 'main_table.question_id = answers.question_id', array('answer'))
//            ->joinLeft(array('product' => 'catalog_product_entity'), 'main_table.product_id = product.entity_id', array('sku'))
//            ->joinLeft(array('store'   => 'core_store'), 'main_table.store_id = store.store_id', array('store_name' => 'name'));
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * preparing columns
     * 
     * @return object
     */
    protected function _prepareColumns()
    {
        $this->addColumn('question_id', array(
            'header' => Mage::helper('evozon_qa')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'question_id',
        ));

        $this->addColumn('question', array(
            'header' => Mage::helper('evozon_qa')->__('Question'),
            'align' => 'left',
            'index' => 'text',
        ));

        $this->addColumn('answer', array(
            'header' => Mage::helper('evozon_qa')->__('Answer'),
            'align' => 'left',
            'index' => 'text',
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('evozon_qa')->__('Status'),
            'align' => 'left',
            'width' => '100px',
            'index' => 'status',
            'type'  => 'options',
            'options' => Mage::getModel('evozon_qa/question')->getOptionArray(),
        ));

        $this->addColumn('customer_name', array(
            'header' => Mage::helper('evozon_qa')->__('Customer name'),
            'align' => 'left',
            'width' => '100px',
            'index' => 'customer_name',
        ));

        $this->addColumn('sku', array(
            'header' => Mage::helper('evozon_qa')->__('Product sku'),
            'align' => 'center',
            'width' => '100px',
            'index' => 'product_id',
        ));

        $this->addColumn('store_id', array(
            'header'    => Mage::helper('evozon_qa')->__('Store'),
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'store_id',
            'type'      => 'options',
            'options'   => Mage::getModel('core/store')->getCollection()->toOptionHash(),
        ));

        return parent::_prepareColumns();
    }

    /**
     * sets the row url redirect
     * @param object $row
     * @return 'string'
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/answer', array('id' => $row->getId())); //action controller on row click
    }

    /**
     * Prepares delete, approve and disable mass actions for the selected questions
     * from the grid
     * 
     * @return Evozon_Qa_Block_Adminhtml_Questions_Grid
     * @author Raul Onea <raul.onea@evozon.com>
     * @author Marius Adam <marius.adam@evozon.com>
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('evozon_qa_question_id');
        $this->getMassactionBlock()->setFormFieldName('evozon_qa_questions_id');

        //add mass delete action
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $this->__('Delete'),
            'url' => $this->getUrl('*/*/massDeleteQuestions', array('' => '')),
            'confirm' => $this->__('Are you sure you want to delete the selected questions?')
        ));

        //add mass approove action
        $this->getMassactionBlock()->addItem('approve', array(
            'label' => $this->__('Approve'),
            'url' => $this->getUrl('*/*/massApproveQuestions', array('' => '')),
            'confirm' => $this->__('Are you sure you want to approve the selected questions?')
        ));

        //add mass disabled action
        $this->getMassactionBlock()->addItem('disabled', array(
            'label' => $this->__('Disable'),
            'url' => $this->getUrl('*/*/massDisableQuestions', array('' => '')),
            'confirm' => $this->__('Are you sure you want to disable the selected questions?')
        ));
        return $this;
    }

}
