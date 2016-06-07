<?php

/**
 * Add simple products data version 0.1.4
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

$productData = array(
    array(
        'sku' => 'roc11',
        'name' => 'Rochie Blue S Slim',
        'price' => 100,
        'attributes' => array(
            'color' => 'Blue',
            'size' => 'S',
            'fit' => 'Slim',
            'length' => 'Long',
            'apparel_type' => 'Outerwear')
    ),
    array(
        'sku' => 'roc12',
        'name' => 'Rochie Blue S Regular',
        'price' => 200,
        'attributes' => array(
            'color' => 'Blue',
            'size' => 'S',
            'fit' => 'Regular',
            'length' => 'Short',
            'apparel_type' => 'Knits')
    ),
    array(
        'sku' => 'roc13',
        'name' => 'Rochie Black S',
        'price' => 100,
        'attributes' => array(
            'color' => 'Black',
            'size' => 'S',
            'fit' => 'Regular',
            'length' => 'Long',
            'apparel_type' => 'Knits')
    ),
    array(
        'sku' => 'roc14',
        'name' => 'Rochie Green M',
        'price' => 100,
        'attributes' => array(
            'color' => 'Green',
            'size' => 'M',
            'fit' => 'Slim',
            'length' => 'Long',
            'apparel_type' => 'Skirts')
    ),
    array(
        'sku' => 'roc15',
        'name' => 'Rochie Red L',
        'price' => 200,
        'attributes' => array(
            'color' => 'Red',
            'size' => 'L',
            'fit' => 'Jeans',
            'length' => 'Knee Length',
            'apparel_type' => 'Skirts')
    ),
    array(
        'sku' => 'roc16',
        'name' => 'Rochie Red L',
        'price' => 250,
        'attributes' => array(
            'color' => 'Green',
            'size' => 'L',
            'fit' => 'Skinny',
            'length' => 'Short',
            'apparel_type' => 'Dresses')
    ),
);

//Saving a product
foreach ($productData as $data) {

    saveProduct($data, $helper, $attributeSetId, $categoriesIds);
}

//Functions

function saveProduct($data, $helper, $attributeSetId, $categoriesIds)
{
    $sku = $data['sku'];
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

    $product->setAttributeSetId($attributeSetId[0]); // need to look this up
    $product->setCategoryIds($categoriesIds); // need to look these up
// assign product to the default website
    $product->setWebsiteIds(array(1));
    $product->setVisibility(3); // search
    $product->setStatus(1); // enabled

    setBasicData($product, $data);

    setAttributes($product, $helper, $data);

    setStockData($product);

    //TODO try settings
    $product->save();
}

function setBasicData($product, $data)
{
    $product->setName($data['name']);
    $product->setDescription("A fost o rochie editata.");
    $product->setShortDescription("este o rochie.");
    $product->setTypeId('simple');
    $product->setWeight(1.0);
    $product->setTaxClassId(2); // taxable goods
    $product->setPrice($data['price']);
    return $product;
}

function setAttributes($product, $helper, $data)
{
    //assign the product a color
    $product->setColor($helper->getProductAttributeId('color', $data['attributes']['color']));

//assign the product a type ??apparel_type
    $product->setApparelType($helper->getProductAttributeId('apparel_type', $data['attributes']['apparel_type']));

//assign the product a size
    $product->setSize($helper->getProductAttributeId('size', $data['attributes']['size']));

    //assign the product a fit
    $product->setFit($helper->getProductAttributeId('fit', $data['attributes']['fit']));

    //assign the product a fit
    $product->setLength($helper->getProductAttributeId('length', $data['attributes']['length']));

//assign the product a gender
    $product->setGender($helper->getProductAttributeId('gender', 'Female'));
    return $product;
}

function setStockData($product)
{
    $stockData = $product->getStockData();
    $stockData['qty'] = 10;
    $stockData['is_in_stock'] = 1;
    $stockData['manage_stock'] = 1;
    $stockData['use_config_manage_stock'] = 0;
    $product->setStockData($stockData);

    return $product;
}
