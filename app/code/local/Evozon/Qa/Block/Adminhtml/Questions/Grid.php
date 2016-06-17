<?php

/**
 * Questions grid widget
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
        $this->setId('questions_grid');
        //sort by Id
        $this->setDefaultSort('id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
    }

    /**
     *
     * @return Evozon_Qa_Block_Adminhtml_Questions_Grid
     * @author Marius Adam <marius.adam@evozon.com>
     */
    protected function _prepareCollection()
    {

        $collection = Mage::getModel('evozon_qa/question')->getCollection();
        $this->setCollection($collection);

        $entityTypeId = Mage::getModel('eav/entity')
                ->setType('catalog_product')
                ->getTypeId();

        $prodNameAttrId = Mage::getModel('eav/entity_attribute')
                ->loadByCode($entityTypeId, 'name')
                ->getAttributeId();

        $collection->getSelect()
                ->columns(array('main_table.store_id' => 'store_id'))
                ->columns(array('main_table.question_id' => 'question_id'))
                ->columns(array('main_table.created_at' => 'created_at'))
                ->joinLeft(
                        array('answers' => 'evozon_answers'), 'main_table.question_id = answers.question_id', array('answers.answer' => 'answer'))
                ->joinLeft(
                        array('product' => 'catalog_product_entity'), 'main_table.product_id = product.entity_id', array('product.sku' => 'sku'))
                ->joinLeft(
                        array('cpev' => 'catalog_product_entity_varchar'), 'cpev.entity_id=product.entity_id AND cpev.attribute_id=' . $prodNameAttrId . '', array('cpev.value' => 'value')
        );
        return parent::_prepareCollection();
    }

    /**
     *
     * @return Evozon_Qa_Block_Adminhtml_Questions_Grid
     * @author Marius Adam <marius.adam@evozon.com>
     */
    protected function _prepareColumns()
    {
        $this->addColumn('question_id', array(
            'header' => Mage::helper('evozon_qa')->__('ID'),
            'type' => 'number',
            'width' => '25px',
            'index' => 'main_table.question_id',
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('evozon_qa')->__('Created On'),
            'align' => 'left',
            'type' => 'datetime',
            'width' => '25px',
            'index' => 'main_table.created_at',
        ));

        $this->addColumn('question', array(
            'header' => Mage::helper('evozon_qa')->__('Question'),
            'align' => 'left',
            'width' => '400px',
            'index' => 'question',
        ));

        $this->addColumn('answer', array(
            'header' => Mage::helper('evozon_qa')->__('Answer'),
            'align' => 'left',
            'width' => '400px',
            'index' => 'answers.answer',
        ));

        $this->addColumn('status', array(
            'header' => Mage::helper('evozon_qa')->__('Status'),
            'align' => 'left',
            'width' => '50px',
            'index' => 'status',
            'type' => 'options',
            'options' => Mage::getModel('evozon_qa/question')->getOptionArray(),
        ));

        $this->addColumn('customer_name', array(
            'header' => Mage::helper('evozon_qa')->__('Customer name'),
            'align' => 'left',
            'width' => '100px',
            'index' => 'customer_name',
        ));

        $this->addColumn('product_name', array(
            'header' => Mage::helper('evozon_qa')->__('Product name'),
            'align' => 'left',
            'width' => '50px',
            'index' => 'cpev.value',
        ));

        $this->addColumn('product.sku', array(
            'header' => Mage::helper('evozon_qa')->__('Product sku'),
            'align' => 'left',
            'width' => '25px',
            'index' => 'product.sku',
        ));

        $this->addColumn('store_name', array(
            'header' => Mage::helper('evozon_qa')->__('Store'),
            'align' => 'left',
            'width' => '100px',
            'index' => 'main_table.store_id',
            'type' => 'options',
            'options' => Mage::getModel('core/store')->getCollection()->toOptionHash(),
        ));

        return parent::_prepareColumns();
    }

    /**
     * Configure row click url
     *
     * @param Mage_Catalog_Model_Template|Varien_Object $row
     * @return string
     * @author     Haidu Bogdan <bogdan.haidu@evozon.com>
     */
    public function getRowUrl($row)
    {
        //action controller on row click
        return $this->getUrl('*/*/answer', array('id' => $row->getId()));
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
        $this->setMassactionIdField('main_table.question_id');
        $this->getMassactionBlock()->setFormFieldName('evozon_qa_questions_id');

        //add mass delete action
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $this->__('Delete'),
            'url' => $this->getUrl('*/*/massDeleteQuestions'),
            'confirm' => $this->__('Are you sure you want to delete the selected questions?')
        ));

        //add mass approove action
        $this->getMassactionBlock()->addItem('approve', array(
            'label' => $this->__('Approve'),
            'url' => $this->getUrl('*/*/massApproveQuestions'),
            'confirm' => $this->__('Are you sure you want to approve the selected questions?')
        ));

        //add mass disabled action
        $this->getMassactionBlock()->addItem('disabled', array(
            'label' => $this->__('Disable'),
            'url' => $this->getUrl('*/*/massDisableQuestions'),
            'confirm' => $this->__('Are you sure you want to disable the selected questions?')
        ));
        return $this;
    }

}
