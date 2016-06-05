<?php

/**
 * helper for Finding Attribues Values
 *
 * @category   Evozon
 * @package    Evozon_Bogdan_Catalog
 * @author     Haidu Bogdan <https://github.com/noonlit/magento.git> bogdan branch
 */

class Evozon_Bogdan_Catalog_Helper_Attributes extends Mage_Core_Helper_Abstract
{
    /**
     * function which returns the Eav Attribute Set Name
     * @param string $attriubetSetName /ex: Clothing
     * @return int
     */
    
    public function getAttributeSetId($attriubetSetName)
    {
        $attributeSet = Mage::getModel('eav/entity_attribute_set')->getCollection();
        $attributeId = array();
        foreach ($attributeSet as $attribute)
        {
            if ($attriubetSetName == $attribute->getData('attribute_set_name'))
            {
                $attributeId[] = (int) $attribute->getData('attribute_set_id');
            }
        }
        return $attributeId;
    }
    /**
     * 
     * @param string $attribute /ex: 'color'
     * @param string $label /ex: 'Red'
     * @return int
     */

    function getProductAttributeId($attribute, $label)
    {
        $attributes = Mage::getModel('eav/config')->getAttribute('catalog_product', $attribute);
        foreach ($attributes->getSource()->getAllOptions(true) as $option)
        {
            if ($option['label'] == $label)
            {
                return $option['value'];
            }
        }
    }

}
