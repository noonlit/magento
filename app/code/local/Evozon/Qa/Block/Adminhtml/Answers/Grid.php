<?php

/**
 * Questions and Answers extension for Magento
 *
 * answer grid widget
 *
 * @category   Evozon
 * @package    Qa
 * @subpackage adminhtml
 * @author     Haidu Bogdan <bogdan.haidu@evozon.com>
 * @author     Marius Adam
 */
class Evozon_Qa_Block_Adminhtml_Answers_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('answer_grid'); // Grid id
        $this->setDefaultSort('id'); //sorting by id
        $this->setDefaultDir('desc'); //direction
        $this->setSaveParametersInSession(true); //stores the parameters in session
    }

    /**
     * preparing collection
     * prepares collection for the grid

     * 
     * @return object
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('evozon_qa/answer')->getCollection();
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
        $this->addColumn('answer_id', array(
            'header' => Mage::helper('evozon_qa')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'answer_id',
        ));

        $this->addColumn('question_id', array(
            'header' => Mage::helper('evozon_qa')->__('Question Id'),
            'align' => 'left',
            'index' => 'question_id',
        ));

        $this->addColumn('answer', array(
            'header' => Mage::helper('evozon_qa')->__('Answer'),
            'align' => 'left',
            'index' => 'answer',
        ));

        $this->addColumn('user_id', array(
            'header' => Mage::helper('evozon_qa')->__('User Id'),
            'align' => 'left',
            'index' => 'user_id',
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
        return $this->getUrl('*/*/editanswer', array('id' => $row->getId()));
    }

    /**
     * Prepare the delete mass action for the answers grid
     * 
     * @return Evozon_Qa_Block_Adminhtml_Answers_Grid
     * @author Raul Onea <raul.onea@evozon.com>
     * @author Marius Adam <marius.adam@evozon.com>
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('evozon_qa_answer_id');
        $this->getMassactionBlock()->setFormFieldName('evozon_qa_answers_id');

        //add mass delete action
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $this->__('Delete'),
            'url' => $this->getUrl('*/*/massDeleteAnswers', array('' => '')),
            'confirm' => $this->__('Are you sure you want to delete the selected answers?')
        ));

        return $this;
    }

}
