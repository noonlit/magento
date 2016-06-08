<?php

/**
 * Add a configurable product version 0.1.5
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
$categoriesIds = $categoriesHelper->getCategoriestId('Women', 'New Arrivals');

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
$confSku = "roc-config1";

//setting the image name
$image = 'dresses.png';
$mediaArray = array(
    'thumbnail' => $image,
    'small_image' => $image,
    'image' => $image
);

//setting the image path
    $importDir = Mage::getBaseDir('skin') . DS . 'frontend' .
            DS . 'evozon_bogdan' . DS . 'evozon-theme' . DS .
            'images' . DS . 'media' . DS . 'catalog' . DS . 'product' . DS . 'dresses' . DS;

// testing if the product with the specified sku exists
$test_conf_product = Mage::getModel('catalog/product');

if ($test_conf_product->getIdBySku($confSku)) { //SKU EXISTS
    //Magento settings to allow saving
    Mage::app()->setUpdateMode(false);
    Mage::app()->setCurrentStore(0); //this redirects to the admin page

    //for the rest of the operations we will load the existing configurable product
    $configurable_product->load($test_conf_product->getIdBySku($confSku));

    $configurable_product->setAttributeSetId($attributeSetId[0]); // need to look this up
    $configurable_product->setCategoryIds($categoriesIds); // need to look these up
    //setting basic Data
    
    setBasicData2($configurable_product);

    $configurableAttributesData = $configurable_product->getTypeInstance()->getConfigurableAttributesAsArray($configurable_product);

    $configurable_product->setCanSaveConfigurableAttributes(true);
    $configurable_product->setCanSaveConfigurableAttributes($configurableAttributesData);

    $simpleProductsData = array();
} else { //NEW PRODUCT
    $configurable_product->setSku($confSku);
    //setting the attributes Ids of the configurable product
    $configurable_product->setAttributeSetId($attributeSetId[0]); // need to look this up
    $configurable_product->setCategoryIds($categoriesIds); // need to look these up
    $configurable_product->setTypeId('configurable');
    setBasicData2($configurable_product);

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
    if ($test_product->getIdBySku($sku) != 0) {
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
}

//ADD THE DATAS
$configurable_product->setConfigurableProductsData($configurableProductsData);

//add image to product
foreach ($mediaArray as $imageType => $fileName) {
    $filePath = $importDir . $fileName;
    if (file_exists($filePath)) {
        $configurable_product->addImageToMediaGallery($filePath, $imageType, false);
    }
}



//final save
try {
    $configurable_product->save();
    Mage::log('Saved new product', null, 'scripts.log');
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'scripts.log');
}

//FUNCTIONS

function setBasicData2($configurable_product)
{
    $configurable_product->setName('Configurable Dress');
    $configurable_product->setDescription("This is a configurable dress, choose between 4 colours.");
    $configurable_product->setShortDescription("configurable dress.");
    $configurable_product->setStatus(1);
    $configurable_product->setTaxClassId(2);
    $configurable_product->setVisibility(4); // catalog, search
    
//$configurable_product->setPrice(800);
    $configurable_product->setWebsiteIds(array(1));

    $configurable_product->setStockData(array(
        'use_config_manage_stock' => 0, //'Use config settings' checkbox
        'manage_stock' => 1, //manage stock
        'is_in_stock' => 1, //Stock Availability
            )
    );
}
