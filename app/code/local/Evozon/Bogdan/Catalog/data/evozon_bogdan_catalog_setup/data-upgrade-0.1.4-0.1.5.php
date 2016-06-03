<?php

/**
 * ADDING GROUPED PRODUCTS
 */
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
        $product = Mage::getModel('catalog/product');
        $product->setSku($productValues['sku']); //check for the sku to avoid duplicates
        $product->setName($productValues['name']);
        $product->setDescription($productValues['description']);
        $product->setShortDescription($productValues['short_description']);
        $product->setPrice(999);
        $product->setTypeId('simple');
        $product->setAttributeSetId(11); // need to look this up
        $product->setCategoryIds(array(6, 19)); // need to look these up
        $product->setWeight(1.0);
        $product->setTaxClassId(2); // taxable goods
        $product->setVisibility(4); // catalog, search
        $product->setStatus(1); // enabled
        // assign product to the default website
        $product->setWebsiteIds(array(Mage::app()->getStore(true)->getWebsite()->getId()));

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

$product->setSku($sku . '-grouped');
$product->setAttributeSetId(11); // put your attribute set id here.
$product->setTypeId('grouped');
$product->setName($title);
$product->setCategoryIds(array(6, 19)); // put your category ids here
$product->setWebsiteIds(array(Mage::app()->getStore(true)->getWebsite()->getId()));
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

// You need to create an array which contains the associate product ids.
//    $simpleProductId[0] = 1483;
//    $simpleProductId[1] = 1484;
//    $simpleProductId[2] = 1485;
//    $simpleProductId[3] = 1486;
//    $simpleProductId[4] = 1487;

    $products_links = Mage::getModel('catalog/product_link_api');

// Map each associate product with the grouped product.
    foreach ($simpleProductId as $id) {
        $products_links->assign("grouped", $group_product_id, $id);
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
