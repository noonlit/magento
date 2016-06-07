<?php

/**
 * Add a grouped product version 0.1.6
 * 
 * @category Evozon
 * @package Evozon_Bogdan_Catalog
 * @copyright (c) year, Haidu Bogdan
 * @author Haidu Bogdan <branch bogdan of noonlit/magento> git
 */

//calling the attributes helper to get the attributeSetId
$helper = Mage::helper('evozon_bogdan_catalog/attributes');
//find clothing attribute_set_id
$attributeSetId = $helper->getAttributeSetId('Accessories');

$categoriesHelper = Mage::helper('evozon_bogdan_catalog/categories');
//finding the subcategory and category ids for women with 'clothing' eav_attribute_set
$categoriesIds = $categoriesHelper->getCategoriestId('Accessories', 'Accessories');

//values for simple products
$groupedProduct = array(
    "furculita" => array("name" => "Furculita",
        "sku" => "furc1",
        "description" => "Este din argint adus din Spania",
        "short_description" => "furculita clasica"),
    "lingura" => array("name" => "Lingura",
        "sku" => "ling1",
        "description" => "Este din argint adus din Spania",
        "short_description" => "lingura clasica"),
    "cutit" => array("name" => "Cutit",
        "sku" => "cutit1",
        "description" => "Este din argint adus din Spania",
        "short_description" => "cutit clasic"),
);

$simpleProductId = array();

foreach ($groupedProduct as $productElement => $productValues) {

    if (is_array($productValues)) {
        $test_product = Mage::getModel('catalog/product');
        $product = Mage::getModel('catalog/product');

        if ($test_product->getIdBySku($productValues['sku'])) {
            //Magento settings to allow saving
            Mage::app()->setUpdateMode(false);
            Mage::app()->setCurrentStore(0); //this redirects to the admin page
            $product->load($test_product->getIdBySku($productValues['sku']));
        } else {
            $product->setSku($productValues['sku']);
        }
        $product->setName($productValues['name']);
        $product->setDescription($productValues['description']);
        $product->setShortDescription($productValues['short_description']);
        $product->setPrice(999);
        $product->setTypeId('simple');
        $product->setAttributeSetId($attributeSetId[0]); // need to look this up
        $product->setCategoryIds($categoriesIds); // need to look these up
        $product->setWeight(1.0);
        $product->setTaxClassId(2); // taxable goods
        $product->setVisibility(2); // catalog, search
        $product->setStatus(1); // enabled
        // assign product to the default website
        $product->setWebsiteIds(array(1));

        $stockData = $product->getStockData();
        $stockData['qty'] = 5;
        $stockData['is_in_stock'] = 1;
        $stockData['manage_stock'] = 1;
        $stockData['use_config_manage_stock'] = 0;
        $product->setStockData($stockData);

        $product->save();
        $simpleProductId[] = $product->getId();
    }
}

$sku = 'tacamuri1-grouped';
$title = 'Tacamuri';
$description = 'Set grupat de tacamuri';

$product = Mage::getModel('catalog/product');

if ($test_product->getIdBySku($sku)) {
    //Magento settings to allow saving
    Mage::app()->setUpdateMode(false);
    Mage::app()->setCurrentStore(0); //this redirects to the admin page
    $product->load($test_product->getIdBySku($sku));
} else {
    $product->setSku($sku);
}
$product->setAttributeSetId($attributeSetId[0]); // put your attribute set id here.
$product->setTypeId('grouped');
$product->setName($title);
$product->setCategoryIds($categoriesIds); // put your category ids here
$product->setWebsiteIds(array(1));
$product->setDescription($description);
$product->setShortDescription($description);
$product->setPrice(1000);
$product->setWeight(200);
$product->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH);
$product->setStatus(1);
$product->setTaxClassId(0);
$product->setStockData(array(
    'is_in_stock' => 1,
    'manage_stock' => 0,
    'use_config_manage_stock' => 1
));

try {
// Save the grouped product.
    $product->save();
    $group_product_id = $product->getId();

    $products_links = Mage::getModel('catalog/product_link_api');

// Map each associate product with the grouped product.
    foreach ($simpleProductId as $id) {
        $products_links->assign("grouped", $group_product_id, $id);
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
