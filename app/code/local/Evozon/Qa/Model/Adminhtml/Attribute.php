<?php

/**
 * Questions and Answers extension for Magento
 *
 * attribute class 
 *
 * @category   Evozon
 * @package    Evozon Qa
 * @subpackage adminhtml
 * @author     Haidu Bogdan <bogdan.haidu@evozon.com>
 */
class Evozon_Qa_Model_Adminhtml_Attribute
{
    /**
     * get ln attributes
     *
     * @return array
     */
    public function getSourceAttributes()
    {
        $values = array(array('label' => '', 'value' => ''));
        /** @var $layer Mage_Catalog_Model_Layer */
        $appEmulation = Mage::getSingleton('core/app_emulation');
        $defaultFrontendStore = Mage::app()->getDefaultStoreView();
        $initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($defaultFrontendStore->getId());
        $layer = Mage::getModel('catalog/layer');
        $attributes = $layer->getFilterableAttributes();
        $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
        foreach ($attributes as $_attribute) {
            $values[$_attribute->getAttributeCode()] = array(
                'label' => $_attribute->getFrontendLabel(),
                'value' => $_attribute->getAttributeCode()
            );
        }
        ksort($values);
        return array_values($values);
    }
    /**
     * get as options
     *
     * @return array
     */
    public function getOptions()
    {
        $options = array();
        foreach ($this->getSourceAttributes() as $_attribute) {
            $options[$_attribute['value']] = $_attribute['label'];
        }
        unset($options['']);
        return $options;
    }
}
