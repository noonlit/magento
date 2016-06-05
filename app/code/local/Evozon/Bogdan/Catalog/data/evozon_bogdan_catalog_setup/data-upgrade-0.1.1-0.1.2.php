<?php

//Magento settings to allow saving
Mage::app()->setUpdateMode(false);
Mage::app()->setCurrentStore(0); //this redirects to the admin page
//calling the attributes helper to get the attributeSetId
$helper = Mage::helper('evozon_bogdan_catalog/attributes');
//find clothing attribute_set_id
$attributeSetId = $helper->getAttributeSetId('Clothing');

$sku = "roc11";
$test_product = Mage::getModel('catalog/product');
$product = Mage::getModel('catalog/product');

if ($test_product->getIdBySku($sku))
{
    $product->load($test_product->getIdBySku($sku));
} else
{
    $product->setSku($sku);
    echo "seettt";
}

$categoriesHelper = Mage::helper('evozon_bogdan_catalog/categories');
//finding the subcategory and category ids for women with 'clothing' eav_attribute_set
$categoriesIds = $categoriesHelper->getCategoriestId('Women', 'Clothing');

//check for duplicate
$product->setName("Rochie Red S");
$product->setDescription("A fost o rochie editata.");
$product->setShortDescription("este o rochie.");
$product->setTypeId('simple');
$product->setAttributeSetId($attributeSetId[0]); // need to look this up
$product->setCategoryIds($categoriesIds); // need to look these up
$product->setWeight(1.0);
$product->setTaxClassId(2); // taxable goods
$product->setVisibility(4); // catalog, search
$product->setStatus(1); // enabled
//assign the product a color
$product->setColor($helper->getProductAttributeId('color', 'Red'));

//assign the product a type ??apparel_type
$product->setApparelType($helper->getProductAttributeId('apparel_type', 'Skirts'));

//assign the product a size
$product->setSize($helper->getProductAttributeId('size', 'S'));

//assign the product a gender
$product->setGender($helper->getProductAttributeId('gender', 'Female'));

$product->setPrice(999);
// assign product to the default website
$product->setWebsiteIds(array(Mage::app()->getStore(true)->getWebsite()->getId()));

$stockData = $product->getStockData();
$stockData['qty'] = 10;
$stockData['is_in_stock'] = 1;
$stockData['manage_stock'] = 1;
$stockData['use_config_manage_stock'] = 0;
$product->setStockData($stockData);

//$product->save();
// Save the grouped product.
$product->save();

