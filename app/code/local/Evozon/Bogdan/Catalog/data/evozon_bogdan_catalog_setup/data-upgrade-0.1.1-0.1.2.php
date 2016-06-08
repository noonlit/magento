<?php

/**
 * Add a simple product data version 0.1.2
 * 
 * @category Evozon
 * @package Evozon_Bogdan_Catalog
 * @copyright (c) year, Haidu Bogdan
 * @author Haidu Bogdan <branch bogdan of noonlit/magento> git
 */
//calling the attributes helper to get the attributeSetId
$helper = Mage::helper('evozon_bogdan_catalog/attributes');
$attributeSetId = $helper->getAttributeSetId('Accessories');

//finding the subcategory and category ids for women with 'clothing' eav_attribute_set
$categoriesHelper = Mage::helper('evozon_bogdan_catalog/categories');
$categoriesIds = $categoriesHelper->getCategoriestId('Accessories', 'Eyewear');

//setting the product sku
$sku = "och01";

//setting the image name
$image = 'och01-eyeglass.png';
$mediaArray = array(
    'thumbnail' => $image,
    'small_image' => $image,
    'image' => $image
);

//setting the image path
$importDir = Mage::getBaseDir('skin') . DS . 'frontend' .
        DS . 'evozon_bogdan' . DS . 'evozon-theme' . DS .
        'images' . DS . 'media' . DS . 'catalog' . DS . 'product' . DS . 'eyeglass' . DS;

$test_product = Mage::getModel('catalog/product');
$product = Mage::getModel('catalog/product');

//check for duplicate sku
if ($test_product->getIdBySku($sku)) { //IF SKU EXISTS
    //Magento settings to allow saving
    Mage::app()->setUpdateMode(false);
    Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID); //this redirects to the admin page
    $product->load($test_product->getIdBySku($sku));
} else { //IF SKU IS NEW
    $product->setSku($sku);
}

//assign basic settings
$product
        ->setName("Cool Eyeglass")
        ->setDescription("Eyeglass made of adamantium.")
        ->setShortDescription("Cool Eyeglass")
        ->setTypeId('simple')
        ->setAttributeSetId($attributeSetId[0])
        ->setCategoryIds($categoriesIds)
        ->setTaxClassId(2) // taxable goods
        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) // catalog, search
        ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED) // enabled
        ->setCountryOfManufacture('RO')
        ->setWeight(1.0)
;
//assign the product a color
$product->setColor($helper->getProductAttributeId('color', 'Red'));

//assign the product a gender
$product->setGender($helper->getProductAttributeId('gender', 'Female'));

//assign the product a gender
$product->setMaterial($helper->getProductAttributeId('material', 'Metal'));

$product->setPrice(230);
// assign product to the default website
$product->setWebsiteIds(array(1));

//add image to product
foreach ($mediaArray as $imageType => $fileName) {
    $filePath = $importDir . $fileName;
    if (file_exists($filePath)) {
        $product->addImageToMediaGallery($filePath, $imageType, false);
    }
}

//stock values
$stockData = $product->getStockData();
$stockData['qty'] = 10;
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

