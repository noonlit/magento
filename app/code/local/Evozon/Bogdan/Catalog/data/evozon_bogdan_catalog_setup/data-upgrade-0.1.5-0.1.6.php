<?php

/**
 * Add a simple product and a configurable data version 0.1.6
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

$categoriesHelper = Mage::helper('evozon_bogdan_catalog/categories');
//finding the subcategory and category ids for women with 'clothing' eav_attribute_set
$categoriesIds = $categoriesHelper->getCategoriestId('Women', 'Clothing');

$configurable_product = Mage::getModel('catalog/product');

//choosing which products will make the part of the configurable product
$simpleProducts = array(
    'roc11',
    'roc12',
    'roc13',
    'roc14',
    'roc15',
    'roc16',
);

//attributes Ids
$configurableProductAttributesIds = array(
    $helper->getAttributeId('color'),
    $helper->getAttributeId('apparel_type'),
    $helper->getAttributeId('size'),
    $helper->getAttributeId('fit'),
    $helper->getAttributeId('length'),
);

//sku set to save or update
$confSku = "roc-config2";
// testing if the product with the specified sku exists
$test_conf_product = Mage::getModel('catalog/product');

if ($test_conf_product->getIdBySku($confSku)) { //SKU EXISTS
    //Magento settings to allow saving
    Mage::app()->setUpdateMode(false);
    Mage::app()->setCurrentStore(0); //this redirects to the admin page
    //
    //for the rest of the operations we will load the existing configurable product
    $configurable_product->load($test_conf_product->getIdBySku($confSku));
    //$configurable_product->load(1008);

    $configurable_product->setAttributeSetId($attributeSetId[0]); // need to look this up
    $configurable_product->setCategoryIds($categoriesIds); // need to look these up
    //setting basic Data
    setBasicData($configurable_product);
   
    $configurableAttributesData = $configurable_product->getTypeInstance()->getConfigurableAttributesAsArray($configurable_product);

    $configurable_product->setCanSaveConfigurableAttributes(true);
    $configurable_product->setCanSaveConfigurableAttributes($configurableAttributesData);

    $simpleProductsData = array();
} else { //NEW PRODUCT
    $configurable_product->setSku($confSku);
    //setting the attributes Ids of the configurable product
    $configurable_product->setAttributeSetId($attributeSetId[0]); // need to look this up
    $configurable_product->setCategoryIds($categoriesIds); // need to look these up
    setBasicData($configurable_product); 

    //before you should have the type of the product set ('configurable')
    //setting the attributesIds
    $configurable_product->getTypeInstance()->setUsedProductAttributeIds($configurableProductAttributesIds);
    //configurableAttributeData creation which will be used for storing attributes values
    $configurableAttributesData = $configurable_product->getTypeInstance()->getConfigurableAttributesAsArray();
    $configurable_product->setCanSaveConfigurableAttributes(true);
    $configurable_product->setCanSaveConfigurableAttributes($configurableAttributesData);
}

$configurableProductsData = array();
$simpleProduct = Mage::getModel('catalog/product');
$test_product = Mage::getModel('catalog/product');

foreach ($simpleProducts as $sku) {
    $simpleProduct->load($test_product->getIdBySku($sku));
    $simpleProductsData = array(
        'label' => $simpleProduct->getAttributeText('color'),
        'attribute_id' => $helper->getProductAttributeId('color', $simpleProduct->getAttributeText('color')),
        'value_index' => $simpleProduct->getColor(),
        'is_percent' => 0,
        'pricing_value' => '80', //in this version we set a equal price value for all colors
    );

    $configurableProductsData[$test_product->getIdBySku($sku)] = $simpleProductsData;
    $configurableAttributesData[0]['values'][] = $simpleProductsData;
    $configurable_product->setConfigurableAttributesData($configurableAttributesData);
}

$configurable_product->setConfigurableProductsData($configurableProductsData);

$configurable_product->save();

//FUNCTIONS

function setBasicData($configurable_product)
{
    $configurable_product->setName('Rochii configurabile');
    $configurable_product->setDescription("A fost o rochie configurabila.");
    $configurable_product->setShortDescription("este o rochie.");
    $configurable_product->setStatus(1);
    $configurable_product->setTaxClassId(2);
    $configurable_product->setVisibility(4); // catalog, search
    $configurable_product->setTypeId('configurable');
//$configurable_product->setPrice(800);
    $configurable_product->setWebsiteIds(array(1));

    $configurable_product->setStockData(array(
        'use_config_manage_stock' => 0, //'Use config settings' checkbox
        'manage_stock' => 1, //manage stock
        'is_in_stock' => 1, //Stock Availability
            )
    );
}
