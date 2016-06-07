<?php

Mage::log('Started data-upgrade-0.1.5', null, 'scripts.log');

// add grouped product - jewellery

$date = new DateTime();

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$simpleProductsCfg = array();

// product 1 - a ring
$simpleProductsCfg['ring'] = array(
    'name' => 'The one ring. No, not that one.',
    'sku' => 'sku-jewel-ring-one',
    'price' => '5000',
    'description' => 'The one ring requires no long description.',
    'short_description' => 'The one ring requires no short description either.'
);

// product 2 - a necklace
$simpleProductsCfg['necklace'] = array(
    'name' => 'Totally nobody\'s phylactery.',
    'sku' => 'sku-jewel-certainly-not-blood-magic',
    'price' => '2000',
    'description' => 'This is a very pretty and entirely decorative necklace',
    'short_description' => 'Necklace made of pretty.'
);

$simpleProducts = array();

// build and save the simple products
foreach ($simpleProductsCfg as $productCfg) {
    $productModel = Mage::getModel('catalog/product');

    if (!$productModel->getIdBySku($productCfg['sku'])) {
        try {
            $productModel
                    ->setWebsiteIds(array(1))
                    ->setAttributeSetId(19)
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
                    ->setCategoryIds(array(6, 19));

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
$sku = 'sku-entirely-harmless-trinkets';
if (!$groupedProductModel->getIdBySku($sku)) {
    try {
        $groupedProductModel
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(19)
                ->setTypeId('grouped')
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->setSku($sku)
                ->setName('Entirely harmless trinkets')
                ->setPrice('7000')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())
                ->setDescription('In a big nutshell, nothing to see here.')
                ->setShortDescription('In a small nutshell, nothing to see here.')
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'is_in_stock' => 1
                ))
                ->setCategoryIds(array(6, 19));
        
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

Mage::log('Ended data-upgrade-0.1.5', null, 'scripts.log');
