<?php

/**
 * Add a virtual product version 0.1.8
 * 
 * @category Evozon
 * @package Evozon_Bogdan_Catalog
 * @copyright (c) year, Haidu Bogdan
 * @author Haidu Bogdan <branch bogdan of noonlit/magento> git
 */

//calling the attributes helper to get the attributeSetId
$helper = Mage::helper('evozon_bogdan_catalog/attributes');
//find clothing attribute_set_id
$attributeSetId = $helper->getAttributeSetId('Default');

//setting the image name
$image = 'tailoring-01.jpg';
$mediaArray = array(
    'thumbnail' => $image,
    'small_image' => $image,
    'image' => $image
);

//setting the image path
$importDir = Mage::getBaseDir('skin') . DS . 'frontend' .
        DS . 'evozon_bogdan' . DS . 'evozon-theme' . DS .
        'images' . DS . 'media' . DS . 'catalog' . DS . 'product' . DS . 'jobs' . DS;

$sku = "cusatura-01";

$test_product = Mage::getModel('catalog/product');
$product = Mage::getModel('catalog/product');

if ($test_product->getIdBySku($sku)) {
    //Magento settings to allow saving
    Mage::app()->setUpdateMode(false);
    Mage::app()->setCurrentStore(0); //this redirects to the admin page
    $product->load($test_product->getIdBySku($sku));
} else {
    $product->setSku($sku);
}

$categoriesHelper = Mage::helper('evozon_bogdan_catalog/categories');
//finding the subcategory and category ids for women with 'clothing' eav_attribute_set
$categoriesIds []= $categoriesHelper->getCategoriestId('Women', 'New Arrivals');
$categoriesIds []= $categoriesHelper->getCategoriestId('Men', 'New Arrivals');
$categoriesIds []= $categoriesHelper->getCategoriestId('Women', 'Tops & Blouses');
$categoriesIds []= $categoriesHelper->getCategoriestId('Women', 'Pants & Denim');
$categoriesIds []= $categoriesHelper->getCategoriestId('Women', 'Dresses & Skirts');

//check for duplicate
$product->setName("Tailoring");
$product->setDescription("Repairing or adjusting clothings by a professional taylor");
$product->setShortDescription("Repairing or adjusting clothings.");
$product->setTypeId('virtual');
$product->setStoreId(0);
$product->setAttributeSetId($product->getDefaultAttributeSetId()); // need to look this up
$product->setCategoryIds($categoriesIds); // need to look these up
$product->setTaxClassId(2); // taxable goods
$product->setVisibility(4); // catalog, search
$product->setStatus(1); // enabled
//assign the product a color

$product->setPrice(50);
// assign product to the default website
$product->setWebsiteIds(array(1));

//add image to product
foreach ($mediaArray as $imageType => $fileName) {
    $filePath = $importDir . $fileName;
    if (file_exists($filePath)) {
        $product->addImageToMediaGallery($filePath, $imageType, false);
    }
}

$stockData = $product->getStockData();
$stockData['qty'] = 2;
$stockData['is_in_stock'] = 1;
$stockData['manage_stock'] = 1;
$stockData['use_config_manage_stock'] = 0;
$product->setStockData($stockData);

//final save
try {
    $product->save();
    Mage::log('Saved new product', null, 'scripts.log');
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'scripts.log');
}
