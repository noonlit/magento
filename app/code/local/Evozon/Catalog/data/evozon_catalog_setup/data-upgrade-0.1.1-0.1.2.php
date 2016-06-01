<?php

$date = new DateTime();

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID); // do we need this?

if (!$product->getIdBySku('sku91-ignivomous-drosophila')) {
    try {
        $product
        ->setWebsiteId(1)
        ->setAttributeSetId(4) // Home & Decor
        ->setTypeId('simple')
        ->setCreatedAt($date->getTimestamp())
        ->setUpdatedAt($date->getTimestamp())
        ->setName('Fire-breathing fruit fly')
        ->setWeight(1)
        ->setStatus(1) // product status (1 - enabled, 2 - disabled)
        ->setTaxClassId(0) // tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
        ->setColor(28) // which is red. to figure out: where all these options are 
        ->setcountryOfManufacture('RO')
        ->setCost(100) // the cost is what the merchant pays
        ->setPrice(200) // the price is what the customer pays
        ->setDescription('This is the long description of the fire-breathing fruit fly')
        ->setShortDescription('This is the short description of the fire-breathing fruit fly')
        ->setStockData(array(
           'use_config_manage_stock' => 0, // 'Use config settings' checkbox - ?
           'manage_stock'=> 1, // manage stock - ?
           'min_sale_qty'=> 1, // Minimum Qty Allowed in Shopping Cart
           'max_sale_qty'=> 2, // Maximum Qty Allowed in Shopping Cart
           'is_in_stock' => 1, // Stock Availability 
           'qty' => 999 // qty
       ))
       ->setCategoryIds(7, 25); // 7 is all Home & Decor, 25 is Decorative Accents
               
        Mage::getModel('catalog/product')
                ->setData($product)
                ->save();
    } catch (Exception $e) {
        Mage::log($e->getMessage());
    }
}
    