<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Info
 *
 * @author bogdanhaidu
 */
class Evozon_Qa_Adminhtml_Block_Answers_Grid_Renderer_Info
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Render information about menu item
     *
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        //LOOOK THIS UP
        $helper = Mage::helper('evozon_qa');
        switch ($row->getType()) {
            case VF_CustomMenu_Model_Resource_Menu_Attribute_Source_Type::LINK_INTERNAL:
                return '<strong>' . $helper->__('Path') . ':</strong> ' . $row->getUrl();
                break;
            case VF_CustomMenu_Model_Resource_Menu_Attribute_Source_Type::LINK_EXTERNAL:
                return '<strong>' . $helper->__('Link') . ':</strong> ' . $row->getUrl();
                break;
            case VF_CustomMenu_Model_Resource_Menu_Attribute_Source_Type::CATEGORY:
                return '<strong>' . $helper->__('Category') . ':</strong> '
                    . Mage::getModel('catalog/category')->load($row->getDefaultCategory(), array('name'))->getName()
                    . ' <strong>' . $helper->__('Show Children') . ':</strong> '
                    . ($row->getShowChildren() ? $helper->__('Yes') : $helper->__('No'));
                break;
            case VF_CustomMenu_Model_Resource_Menu_Attribute_Source_Type::ATTRIBUTE:
                return '<strong>' . $helper->__('Attribute code') . ':</strong> '
                    . $row->getSourceAttribute()
                    . ' <strong>' . $helper->__('Category') . ':</strong> '
                    . Mage::getModel('catalog/category')->load($row->getDefaultCategory(), array('name'))->getName();
                break;
            default:
                return '';
        }
    }
}
