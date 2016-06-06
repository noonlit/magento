<?php

/**
 * Add a simple product and a configurable data version 0.1.4
 * 
 * @category Evozon
 * @package Evozon_Bogdan_Catalog
 * @copyright (c) year, Haidu Bogdan
 * @author Haidu Bogdan <branch bogdan of noonlit/magento> git
 */
//calling the attributes helper to get the attributeSetId
$helper = Mage::helper('evozon_bogdan_catalog/attributes');
//find clothing attribute_set_id
$attributeSetId = $helper->getAttributeSetId('Clothing');

$sku = "roc13";
$test_product = Mage::getModel('catalog/product');
$product = Mage::getModel('catalog/product');

if ($test_product->getIdBySku($sku))
{
    //Magento settings to allow saving
    Mage::app()->setUpdateMode(false);
    Mage::app()->setCurrentStore(0); //this redirects to the admin page
    $product->load($test_product->getIdBySku($sku));
} else
{
    $product->setSku($sku);
}

$categoriesHelper = Mage::helper('evozon_bogdan_catalog/categories');
//finding the subcategory and category ids for women with 'clothing' eav_attribute_set
$categoriesIds = $categoriesHelper->getCategoriestId('Women', 'Clothing');

//check for duplicate
$product->setName("Rochie Black S");
$product->setDescription("A fost o rochie neagra.");
$product->setShortDescription("este o rochie neagra.");
$product->setTypeId('simple');
$product->setAttributeSetId($attributeSetId[0]); // need to look this up
$product->setCategoryIds($categoriesIds); // need to look these up
$product->setWeight(1.0);
$product->setTaxClassId(2); // taxable goods
$product->setVisibility(4); // catalog, search
$product->setStatus(1); // enabled
//assign the product a color
$product->setColor($helper->getProductAttributeId('color', 'Black'));

//assign the product a type ??apparel_type
$product->setApparelType($helper->getProductAttributeId('apparel_type', 'Skirts'));

//assign the product a size
$product->setSize($helper->getProductAttributeId('size', 'S'));

//assign the product a gender
$product->setGender($helper->getProductAttributeId('gender', 'Female'));

$product->setPrice(600);
// assign product to the default website
$product->setWebsiteIds(array(1));

$stockData = $product->getStockData();
$stockData['qty'] = 10;
$stockData['is_in_stock'] = 1;
$stockData['manage_stock'] = 1;
$stockData['use_config_manage_stock'] = 0;
$product->setStockData($stockData);

//try settings
$product->save();


$configurable_product = Mage::getModel('catalog/product');
$test_conf_product = Mage::getModel('catalog/product');

$simpleProductsIds = array(
    $test_conf_product->getIdBySku('roc10'),
    $test_conf_product->getIdBySku('roc11'),
    $test_conf_product->getIdBySku('roc12'),
);

$confSku = "roc-config1";

if ($test_conf_product->getIdBySku($confSku))
{
    //Magento settings to allow saving
    Mage::app()->setUpdateMode(false);
    Mage::app()->setCurrentStore(0); //this redirects to the admin page
    $configurable_product->load($test_conf_product->getIdBySku($confSku));
} else
{

    $configurable_product->setSku($confSku);
    $configurable_product->setName('Rochie configurabila');

    $configurable_product->setAttributeSetId($attributeSetId[0]); // need to look this up
    $configurable_product->setCategoryIds($categoriesIds); // need to look these up
    $configurable_product->setStatus(1);
    $configurable_product->setTypeId('configurable');
    $configurable_product->setPrice(800);
    $configurable_product->setWebsiteIds(array(1));

    $configurable_product->setStockData(array(
        'use_config_manage_stock' => 0, //'Use config settings' checkbox
        'manage_stock' => 1, //manage stock
        'is_in_stock' => 1, //Stock Availability
            )
    );
    
}

$colorAttributeId = Mage::getModel('eav/entity_attribute')->getIdByCode('catalog_product', 'color');
$apparelTypeAttributeId = Mage::getModel('eav/entity_attribute')->getIdByCode('catalog_product', 'apparel_type');
$sizeAttributeId = Mage::getModel('eav/entity_attribute')->getIdByCode('catalog_product', 'size');
$configurable_product->getTypeInstance()->setUsedProductAttributeIds(array($colorAttributeId,$apparelTypeAttributeId,$sizeAttributeId));
$configurableAttributesData = $configurable_product->getTypeInstance()->getConfigurableAttributesAsArray();

$configurableProductsData = array();
$simpleProduct = Mage::getModel('catalog/product');

$simpleProduct->load($test_product->getIdBySku('roc12'));
$simpleProductsData [] = array(
    'label' => $simpleProduct->getAttributeText('color'),
    'attribute_id' => $colorAttributeId,
    'value_index' => (int) $simpleProduct->getColor(),
    'is_percent' => 0,
    'pricing_value' => $simpleProduct->getPrice(),
);

$configurableProductsData[$test_product->getIdBySku('roc11')] = $simpleProductsData;
$configurableProductsData[$test_product->getIdBySku('roc12')] = $simpleProductsData;
$configurableProductsData[$test_product->getIdBySku('roc13')] = $simpleProductsData;


$configurableAttributesData[0]['values'][] = $simpleProductsData;
$configurable_product->setConfigurableProductsData($configurableProductsData);
$configurable_product->setConfigurableAttributesData($configurableAttributesData);


$configurable_product->setCanSaveConfigurableAttributes(true);

$configurable_product->save();
