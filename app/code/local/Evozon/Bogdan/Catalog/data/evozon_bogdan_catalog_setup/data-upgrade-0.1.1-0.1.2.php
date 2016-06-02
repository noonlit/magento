<?php

$product = Mage::getModel('catalog/product');

$product->setSku("roc10"); //check for duplicate
$product->setName("Rochie");
$product->setDescription("A fost o rochie.");
$product->setShortDescription("este o rochie.");
$product->setPrice(999);
$product->setTypeId('simple');
$product->setAttributeSetId(13); // need to look this up
$product->setCategoryIds("1,5"); // need to look these up
$product->setWeight(1.0);
$product->setTaxClassId(2); // taxable goods
$product->setVisibility(4); // catalog, search
$product->setStatus(1); // enabled

// assign product to the default website
$product->setWebsiteIds(array(Mage::app()->getStore(true)->getWebsite()->getId()));

$stockData = $product->getStockData();
$stockData['qty'] = 10;
$stockData['is_in_stock'] = 1;
$stockData['manage_stock'] = 1;
$stockData['use_config_manage_stock'] = 0;
$product->setStockData($stockData);

$product->save();

