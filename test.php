<?php

echo "<head>
    <title>Test Magento</title>
  </head>  
";



require_once 'app/Mage.php';

Mage::app();

$attributeHelper = Mage::helper('evozon_bogdan_catalog/attributes');
$attributeId = $attributeHelper->getAttributeSetId('Clothing');

$product = Mage::getModel('catalog/product');
$sku = "roc10";

if ($product->getIdBySku($sku))
{
    //$product->load($product->getIdBySku($sku));
} else
{
    //$product->setSku($sku);
}

//var_dump($product);
$categoriesHelper = Mage::helper('evozon_bogdan_catalog/categories');
$categoriesIds = $categoriesHelper->getCategoriestId('Women', 'Clothing');

//var_dump($categoriesIds);

$attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'apparel_type');

foreach ($attribute->getSource()->getAllOptions(true) as $option)
{
    echo $option['value'] . ' ' . $option['label'] . "<br>";
}

$product2 = Mage::getModel('catalog/product');
$product2->load(448);

var_dump($product2->getTypeInstance());

echo "breackpoint<br>";

$product->load($product->getIdBySku("downd-03"));
var_dump($product->getTypeInstance());
$product->setHasOptions("1");
$product->setRequiredOptions("1");
//$product->setAttributeSetId("10")->save();
$product->setData('links_title',"Ready For Download2")->save();
$product->setData('links_purchased_separately',0);
$product->setData('links_exist',1);
//var_dump($product->getTypeInstance()->getLinks());
$product->save();

//
//
///**
// * Add a configurable product
// */
//
//$simple_product = Mage::getModel('catalog/product');
//
//$simple_product->setSku('simplu5');
//$simple_product->setName('rochie cu optiuni');
//$simple_product->setAttributeSetId(13);
////$simple_product->setSize_general(193); // value id of S size
//$simple_product->setDescription("A fost o rochie.");
//$simple_product->setShortDescription("este o rochie.");
//$simple_product->setStatus(1);
//$simple_product->setHasOptions(1);
//$simple_product->setTypeId('simple');
//$simple_product->setPrice(10);
//$simple_product->setWebsiteIds(array(1));
//$simple_product->setCategoryIds(array(5, 12, 17));
//$simple_product->setStockData(array(
//    'use_config_manage_stock' => 0, //'Use config settings' checkbox
//    'manage_stock' => 1, //manage stock
//    'min_sale_qty' => 1, //Minimum Qty Allowed in Shopping Cart
//    'max_sale_qty' => 2, //Maximum Qty Allowed in Shopping Cart
//    'is_in_stock' => 1, //Stock Availability
//    'qty' => 50 //qty
//        )
//);
//
//$simple_product->setColor(getOptionId('color', 'Red'));
//
//$simple_product->save();
//
//$configurable_product = Mage::getModel('catalog/product');
//$configurable_product->setSku('test-configurable4');
//$configurable_product->setName('test name configurable');
//$configurable_product->setAttributeSetId(13);
//$configurable_product->setStatus(1);
//$configurable_product->setTypeId('configurable');
//$configurable_product->setPrice(11);
//$configurable_product->setWebsiteIds(array(1));
//$configurable_product->setCategoryIds(array(5, 12, 17));
//
//$configurable_product->setStockData(array(
//    'use_config_manage_stock' => 0, //'Use config settings' checkbox
//    'manage_stock' => 1, //manage stock
//    'is_in_stock' => 1, //Stock Availability
//        )
//);
//
//
//$colorAttributeId = Mage::getModel('eav/entity_attribute')->getIdByCode('catalog_product', 'color');
//$configurable_product->getTypeInstance()->setUsedProductAttributeIds(array($colorAttributeId));
//$configurableAttributesData = $configurable_product->getTypeInstance()->getConfigurableAttributesAsArray();
//
//
//$configurableProductsData = array();
//
//$simpleProductsData = array(
//    'label' => $simple_product->getAttributeText('color'),
//    'attribute_id' => $colorAttributeId,
//    'value_index' => (int) $simple_product->getColor(),
//    'is_percent' => 0,
//    'pricing_value' => $simple_product->getPrice(),
//);
//
//$configurableProductsData[$simple_product->getId()] = $simpleProductsData;
//$configurableAttributesData[0]['values'][] = $simpleProductsData;
//
//$configurable_product->setConfigurableProductsData($configurableProductsData);
//$configurable_product->setConfigurableAttributesData($configurableAttributesData);
//$configurable_product->setCanSaveConfigurableAttributes(true);
//
//$configurable_product->save();
//
////echo "configurable product id: ".$configurable_product->getId()."\n";
//function getOptionId($attribute_code, $label)
//{
//    $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', $attribute_code);
//    foreach ($attribute->getSource()->getAllOptions(true) as $option) {
//        //echo $option['value'] . ' ' . $option['label'] . "<br>";
//        if ($option['label'] == $label) {
//            return $option['value'];
//        }
//    }
//}
//$product = Mage::getModel('catalog/product')->load(924);
//$product->setName('Rochie Verde S');
//$product->setColor(getOptionId('color', 'Green'));
//$product->setSize(getOptionId('size', 'S'));
//$product->setGender(getOptionId('gender', 'Female'));
//$product->setOccasion(getOptionId('occasion', 'Career'));
//
//var_dump($product->getColor());
//
//$product->save();
//
//$productConf = Mage::getModel('catalog/product')->load(930);
//
//$productConf->setName('Rochie configurabila');
//
//$sizeAttributeId = Mage::getModel('eav/entity_attribute')->getIdByCode('catalog_product', 'color');
//$productConf->getTypeInstance()->setUsedProductAttributeIds(array($sizeAttributeId));
//$configurableAttributesData = $productConf->getTypeInstance()->getConfigurableAttributesAsArray();
//
//$configurableProductsData = array();
//
//$simpleProductsData = array(
//    'label' => $product->getAttributeText('color'),
//    'attribute_id' => $colorAttributeId,
//    'value_index' => (int) $product->getColor(),
//    'is_percent' => 0,
//    'pricing_value' => $product->getPrice(),
//);
//
//$configurableProductsData[919] = $simpleProductsData;
//$configurableProductsData[929] = $simpleProductsData;
//$configurableProductsData[916] = $simpleProductsData;
//$configurableProductsData[924] = $simpleProductsData;
//
////$configurableAttributesData[0]['values'][] = $simpleProductsData;
//
//$productConf->setConfigurableProductsData($configurableProductsData);
////$productConf->setConfigurableAttributesData($configurableAttributesData);
//$productConf->setCanSaveConfigurableAttributes(true);
//
//$productConf->save();
//
//
//
function getOptionId($attribute_name, $value)
{
    $attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', $attribute_name);
    foreach ($attribute->getSource()->getAllOptions(true) as $option)
    {
        //echo $option['value'] . ' ' . $option['label'] . "<br>";
        if ($option['label'] == $value)
        {
            return $option['value'];
        }
    }
}

//
//echo $_attribute->getProductAttribute()->getAttributeCode();
//
//$entityTypeId = Mage::getModel('eav/entity')
//                ->setType('catalog_product')
//                ->getTypeId();
//
//var_dump($entityTypeId);
//$attributeSetName   = 'Clothing';
//$attributeSetId     = Mage::getModel('eav/entity_attribute_set')->getCollection();
//
//foreach ($attributeSetId as $attribute) {
//    var_dump($attribute);
//}

//
//$attributeSetName   = 'Default';
//$attributeSetId     = Mage::getModel('eav/entity_attribute_set')
//                    ->getCollection()
//                    ->setEntityTypeFilter($entityTypeId)
//                    ->addFieldToFilter('clothing', $attributeSetName)
//                    ->getFirstItem()
//                    ->getAttributeSetId();
//echo $attributeSetId;