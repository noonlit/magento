<?php

require_once 'app/Mage.php';

Mage::app();

$product = Mage::getModel('catalog/product')->load(924);
$product->setName('Rochie Verde S');
$product->setColor(getOptionId('color', 'Green'));
$product->setSize(getOptionId('size', 'S'));
$product->setGender(getOptionId('gender', 'Female'));
$product->setOccasion(getOptionId('occasion', 'Career'));

var_dump($product->getColor());

$product->save();

$productConf = Mage::getModel('catalog/product')->load(930);

$productConf->setName('Rochie configurabila');

$sizeAttributeId = Mage::getModel('eav/entity_attribute')->getIdByCode('catalog_product', 'color');
$productConf->getTypeInstance()->setUsedProductAttributeIds(array($sizeAttributeId));
$configurableAttributesData = $productConf->getTypeInstance()->getConfigurableAttributesAsArray();

$configurableProductsData = array();

$simpleProductsData = array(
    'label' => $product->getAttributeText('color'),
    'attribute_id' => $colorAttributeId,
    'value_index' => (int) $product->getColor(),
    'is_percent' => 0,
    'pricing_value' => $product->getPrice(),
);

$configurableProductsData[919] = $simpleProductsData;
$configurableProductsData[929] = $simpleProductsData;
$configurableProductsData[916] = $simpleProductsData;
$configurableProductsData[924] = $simpleProductsData;

//$configurableAttributesData[0]['values'][] = $simpleProductsData;

$productConf->setConfigurableProductsData($configurableProductsData);
//$productConf->setConfigurableAttributesData($configurableAttributesData);
$productConf->setCanSaveConfigurableAttributes(true);

$productConf->save();



function getOptionId($attribute_name, $value)
{
    $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', $attribute_name);
    foreach ($attribute->getSource()->getAllOptions(true) as $option) {
        //echo $option['value'] . ' ' . $option['label'] . "<br>";
        if ($option['label'] == $value) {
            return $option['value'];
        }
    }
}
