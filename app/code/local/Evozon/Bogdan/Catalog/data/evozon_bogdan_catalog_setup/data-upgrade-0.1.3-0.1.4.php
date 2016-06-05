<?php

/**
 * Add a configurable product
 */

$simple_product = Mage::getModel('catalog/product');

$simple_product->setSku('simplu6');
$simple_product->setName('rochie cu optiuni');
$simple_product->setAttributeSetId(13);
//$simple_product->setSize_general(193); // value id of S size
$simple_product->setDescription("A fost o rochie.");
$simple_product->setShortDescription("este o rochie.");
$simple_product->setStatus(1);
$simple_product->setHasOptions(1);
$simple_product->setTypeId('simple');
$simple_product->setPrice(10);
$simple_product->setWebsiteIds(array(1));
$simple_product->setCategoryIds(array(5, 12, 17));
$simple_product->setStockData(array(
    'use_config_manage_stock' => 0, //'Use config settings' checkbox
    'manage_stock' => 1, //manage stock
    'min_sale_qty' => 1, //Minimum Qty Allowed in Shopping Cart
    'max_sale_qty' => 2, //Maximum Qty Allowed in Shopping Cart
    'is_in_stock' => 1, //Stock Availability
    'qty' => 50 //qty
        )
);

$simple_product->setColor(getOptionId('color', 'Red'));

$simple_product->save();

$configurable_product = Mage::getModel('catalog/product');
$configurable_product->setSku('test-configurable4');
$configurable_product->setName('test name configurable');
$configurable_product->setAttributeSetId(13);
$configurable_product->setStatus(1);
$configurable_product->setTypeId('configurable');
$configurable_product->setPrice(11);
$configurable_product->setWebsiteIds(array(1));
$configurable_product->setCategoryIds(array(5, 12, 17));

$configurable_product->setStockData(array(
    'use_config_manage_stock' => 0, //'Use config settings' checkbox
    'manage_stock' => 1, //manage stock
    'is_in_stock' => 1, //Stock Availability
        )
);


$colorAttributeId = Mage::getModel('eav/entity_attribute')->getIdByCode('catalog_product', 'color');
$configurable_product->getTypeInstance()->setUsedProductAttributeIds(array($colorAttributeId));
$configurableAttributesData = $configurable_product->getTypeInstance()->getConfigurableAttributesAsArray();


$configurableProductsData = array();

$simpleProductsData = array(
    'label' => $simple_product->getAttributeText('color'),
    'attribute_id' => $colorAttributeId,
    'value_index' => (int) $simple_product->getColor(),
    'is_percent' => 0,
    'pricing_value' => $simple_product->getPrice(),
);

$configurableProductsData[$simple_product->getId()] = $simpleProductsData;
$configurableAttributesData[0]['values'][] = $simpleProductsData;

$configurable_product->setConfigurableProductsData($configurableProductsData);
$configurable_product->setConfigurableAttributesData($configurableAttributesData);
$configurable_product->setCanSaveConfigurableAttributes(true);

$configurable_product->save();

//echo "configurable product id: ".$configurable_product->getId()."\n";
function getOptionId($attribute_code, $label)
{
    $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', $attribute_code);
    foreach ($attribute->getSource()->getAllOptions(true) as $option) {
        //echo $option['value'] . ' ' . $option['label'] . "<br>";
        if ($option['label'] == $label) {
            return $option['value'];
        }
    }
}


