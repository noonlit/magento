<?php

/**
 * Add a downloadable product data version 0.2.0
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

$sku = "cusatura-02";
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
$categoriesIds = $categoriesHelper->getCategoriestId('Home & Decor', 'Books & Music');

//check for duplicate
$product->setName("Downloadable");
$product->setDescription("reparatii haine");
$product->setShortDescription("reparam haine.");
$product->setTypeId('downloadable');
$product->setStoreId(0);
$product->setAttributeSetId($product->getDefaultAttributeSetId()); // need to look this up
$product->setCategoryIds($categoriesIds); // need to look these up
$product->setWeight(1.0);
$product->setTaxClassId(2); // taxable goods
$product->setVisibility(4); // catalog, search
$product->setStatus(1); // enabled
//assign the product a color

$product->setPrice(10);
// assign product to the default website
$product->setWebsiteIds(array(1));

$stockData = $product->getStockData();
$stockData['qty'] = 2;
$stockData['is_in_stock'] = 1;
$stockData['manage_stock'] = 1;
$stockData['use_config_manage_stock'] = 0;
$product->setStockData($stockData);

$linkModel = Mage::getModel('downloadable/link');


$linkModel ->setProductId($product->getId())
        ->setStoreId('0')
        ->setNumberOfDownloads('0')
        ->setLinkUrl('null')
        ->setIsShareable('2')
        ->setLinkType('file')
        ->setTitle('Ready For Download2')
        ->setStoreTitle('Ready For Download2')
        ->setDefaultTitle('Ready For Download2')
        ->setLinkTitle("Ready For Download2")
        ->setLinkFile('/h/b/hbm-a_tale_of_two_cities.pdf')
        ->setProduct($product)
        ->save()
        ;


//try settings
$product->save();
