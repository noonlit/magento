<?php

try {
    Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID); //
    $product = Mage::getModel('catalog/product');
    $rand = rand(1, 9999);
    $product
            ->setTypeId('simple')
            ->setAttributeSetId(4) 
            ->setSku('firstSku') 
            ->setWebsiteIDs(array(1))
    ;

    $product
            ->setCategoryIds(array(10))
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) // visible in catalog and search
    ;

    $product->setStockData(array(
        'use_config_manage_stock' => 0, 
        'manage_stock' => 1, 
        'is_in_stock' => 1,
        'qty' => 5,
    ));

    $product
            ->setName('My first product') 
            ->setShortDescription('the best') // add text attribute

            ->setPrice(80.0)
            ->setSpecialPrice(79.0)
            ->setTaxClassId(2)   
            ->setWeight(40)
    ;

 
    $product->setColor(24);

    mage::log($product);
    $product->save();
} catch (Exception $ex) {
    
    mage::log($ex->getMessage());
    
}