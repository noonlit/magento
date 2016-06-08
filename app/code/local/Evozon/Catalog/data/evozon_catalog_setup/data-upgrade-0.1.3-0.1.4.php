<?php
Mage::log('Started data-upgrade-0.1.4', null, 'scripts.log');
// add grouped product
$date = new DateTime();
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$simpleProductsCfg = array();
// product 1 
$simpleProductsCfg['something1'] = array(
    'name' => 'something1',
    'sku' => 'sku-something1',
    'price' => '100',
    'description' => 'Description for something1',
    'short_description' => 'Short description for something1'
);
// product 2
$simpleProductsCfg['something2'] = array(
    'name' => 'something2',
    'sku' => 'sku-something2',
    'price' => '200',
    'description' => 'Description for something2',
    'short_description' => 'Short description for something2'
);
$simpleProducts = array();
// build and save the simple products
foreach ($simpleProductsCfg as $productCfg) {
    $productModel = Mage::getModel('catalog/product');
    if (!$productModel->getIdBySku($productCfg['sku'])) {
        try {
            $productModel
                    ->setWebsiteIds(array(1))
                    ->setAttributeSetId(13)
                    ->setTypeId('simple')
                    ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                    ->setSku($productCfg['sku'])
                    ->setName($productCfg['name'])
                    ->setCreatedAt($date->getTimestamp())
                    ->setUpdatedAt($date->getTimestamp())
                    ->setDescription($productCfg['description'])
                    ->setShortDescription($productCfg['short_description'])
                    ->setPrice($productCfg['price'])
                    ->setTaxClassId(0)
                    ->setWeight(1)
                    ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                    ->setStockData(array(
                        'use_config_manage_stock' => 0,
                        'manage_stock' => 1,
                        'min_sale_qty' => 1,
                        'max_sale_qty' => 3,
                        'is_in_stock' => 1,
                        'qty' => 30
                    ))
                    ->setCategoryIds(array(4, 13));
            $productModel->save();
            $simpleProducts[] = $productModel;
            Mage::log("Added {$productCfg['sku']}", null, 'scripts.log');
        } catch (Exception $e) {
            Mage::log($e->getMessage(), null, 'scripts.log');
        }
    }
}
// build and save the grouped product
$groupedProductModel = Mage::getModel('catalog/product');
$sku = 'sku-for-something';
if (!$groupedProductModel->getIdBySku($sku)) {
    try {
        $groupedProductModel
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(19)
                ->setTypeId('grouped')
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->setSku($sku)
                ->setName('something')
                ->setPrice('300')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())
                ->setDescription('something')
                ->setShortDescription('short shomething')
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'is_in_stock' => 1
                ))
                ->setCategoryIds(array(4, 13));
        
    // link simple products to the grouped product
    $groupedProductData = [];
    foreach($simpleProducts as $simpleProduct) {
        $groupedProductData[$simpleProduct->getId()] = array(
            'qty' => $simpleProduct->getQty(),
            'position' => 0
        );
    }
    
    $groupedProductModel->setGroupedLinkData($groupedProductData);
    $groupedProductModel->save();
    Mage::log("Added {$sku}", null, 'scripts.log');
    } catch (Exception $e) {
        Mage::log($e->getMessage(), null, 'scripts.log');
    }
}
Mage::log('Ended data-upgrade-0.1.4', null, 'scripts.log');