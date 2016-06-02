<?php

try {
    Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID); //
    $product = Mage::getModel('catalog/product');
    $rand = rand(1, 9999);
    $product
            ->setTypeId('simple')
            ->setAttributeSetId(4) // default attribute set
            ->setSku('example_sku' . $rand) // generate a random SKU
            ->setWebsiteIDs(array(1))
    ;

    $product
            ->setCategoryIds(array(10))
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) // visible in catalog and search
    ;

    $product->setStockData(array(
        'use_config_manage_stock' => 0, // use global config?
        'manage_stock' => 1, // should we manage stock or not?
        'is_in_stock' => 1,
        'qty' => 5,
    ));

    $product
            ->setName('Test Product #' . $rand) // add string attribute
            ->setShortDescription('Description') // add text attribute
            // set up prices
            ->setPrice(24.50)
            ->setSpecialPrice(19.99)
            ->setTaxClassId(2)    // Taxable Goods by default
            ->setWeight(87)
    ;

 
    $product->setColor(24);

    mage::log($product);
    $product->save();
} catch (Exception $ex) {
    
    mage::log($ex->getMessage());
    
}