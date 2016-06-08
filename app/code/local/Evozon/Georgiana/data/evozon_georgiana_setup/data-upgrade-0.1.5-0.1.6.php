<?php

try {
    Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID); 
    $product = Mage::getModel('catalog/product');
    $rand = rand(1, 9999);
    $product
            ->setTypeId('virtual')
            ->setAttributeSetId(13) 
            ->setSku('virtualSku') 
            ->setWebsiteIDs(array(1))
    ;

    $product
            ->setCategoryIds(array(10))
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) 
    ;

    $product->setStockData(array(
        'use_config_manage_stock' => 0, 
        'manage_stock' => 1, 
        'is_in_stock' => 1,
        'qty' => 100,
    ));

    $product
            ->setName('My virtual product') 
            ->setShortDescription('the best') 
            ->setDescription('the best description')

            ->setPrice(80.0)
            ->setTaxClassId(0)   
    ;

 



    $product->save();
} catch (Exception $ex) {
    
    mage::log($ex->getMessage());
    
}