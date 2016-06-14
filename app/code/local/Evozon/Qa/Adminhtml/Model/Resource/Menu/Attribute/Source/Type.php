<?php

//JUST A TEST ATTRIBUTE

/**
 * Description of Type
 *
 * @author bogdanhaidu
 */
class Evozon_Qa_Adminhtml_Model_Resource_Menu_Attribute_Source_Type
{
    const LINK_INTERNAL = 1;
    const LINK_EXTERNAL = 2;
    const CATEGORY      = 3;
    const ATTRIBUTE     = 4;
    /**
     * Get Menu Item Type Values
     *
     * @return array
     */
    public static function getValues()
    {
        $helper = Mage::helper('menu');
        return array(
            self::LINK_INTERNAL => $helper->__('Link Internal'),
            self::LINK_EXTERNAL => $helper->__('Link External'),
            self::CATEGORY      => $helper->__('Category'),
            self::ATTRIBUTE     => $helper->__('Attribute Values'),
        );
    }
}
