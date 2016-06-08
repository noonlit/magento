<?php

//add grouped product
Mage::log("data-upgrade-0.1.4-0.1.5 started", null, "dataScripts.log");
$date = new DateTime();
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$storeId = Mage::app()->getStore('default')->getId();

// add two simple products for the grouped product
$simpleProduct1 = Mage::getModel('catalog/product');
if (!$simpleProduct1->getIdBySku('simple-4-gr-#1')) {
    $simpleProduct1
            ->setWebsiteIds(array(Mage::app()->getStore($storeId)->getWebsiteId()))
            ->setAttributeSetId(19)
            ->setTypeId('simple')
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setSku('simple-4-gr-#1')
            ->setName('Simple for grouped #1')
            ->setCreatedAt($date->getTimestamp())
            ->setUpdatedAt($date->getTimestamp())
            ->setDescription('This is a long description.')
            ->setShortDescription('This is a short description.')
            ->setPrice('25')
            ->setTaxClassId(2)
            ->setWeight(2)
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'min_sale_qty' => 1,
                'max_sale_qty' => 3,
                'is_in_stock' => 1,
                'qty' => 100
            ))
            ->setCategoryIds(array(13));
    $images = array(
        'small_image' => 'simple-prod#2-small.jpg',
        'image' => 'simple-prod#2-image.jpg',
    );

    $dir = Mage::getBaseDir('media') . DS . 'evozon/product/';

    foreach ($images as $imageType => $imageFileName) {
        $path = $dir . $imageFileName;
        if (file_exists($path)) {
            try {
                $simpleProduct1->addImageToMediaGallery($path, $imageType, false, false);
            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }
        } else {
            Mage::log("Image does not exist in `{$path}`");
        }
    }
    $simpleProduct1->save();
    Mage::log("Simple product 1 for grouped added!", null, 'dataScripts.log');
}

$simpleProduct2 = Mage::getModel('catalog/product');
if (!$simpleProduct2->getIdBySku('simple-4-gr-#2')) {
    $simpleProduct2
            ->setWebsiteIds(array(Mage::app()->getStore($storeId)->getWebsiteId()))
            ->setAttributeSetId(19)
            ->setTypeId('simple')
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setSku('simple-4-gr-#2')
            ->setName('Simple for grouped #2')
            ->setCreatedAt($date->getTimestamp())
            ->setUpdatedAt($date->getTimestamp())
            ->setDescription('This is a long description.')
            ->setShortDescription('This is a short description.')
            ->setPrice('55.00')
            ->setTaxClassId(2)
            ->setWeight(50)
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'min_sale_qty' => 1,
                'max_sale_qty' => 3,
                'is_in_stock' => 1,
                'qty' => 100
            ))
            ->setCategoryIds(array(13));

    $images = array(
        'small_image' => 'simple-prod#3-small.jpg',
        'image' => 'simple-prod#3-image.jpg',
    );

    $dir = Mage::getBaseDir('media') . DS . 'evozon/product/';

    foreach ($images as $imageType => $imageFileName) {
        $path = $dir . $imageFileName;
        if (file_exists($path)) {
            try {
                $simpleProduct2->addImageToMediaGallery($path, $imageType, false, false);
            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }
        } else {
            Mage::log("Image does not exist in `{$path}`");
        }
    }
    $simpleProduct2->save();
    Mage::log("Simple product 2 for grouped added!", null, 'dataScripts.log');
}
$simpleProducts = array($simpleProduct1, $simpleProduct2);

//create grouped product

$groupedProduct = Mage::getModel('catalog/product');
if (!$groupedProduct->getIdBySku('grouped-prod#1')) {
    $groupedProduct
            ->setWebsiteIds(array(Mage::app()->getStore($storeId)->getWebsiteId()))
            ->setAttributeSetId(19)
            ->setTypeId('grouped')
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setSku('grouped-prod#1')
            ->setName('Grouped product')
            ->setPrice('100')
            ->setCreatedAt($date->getTimestamp())
            ->setUpdatedAt($date->getTimestamp())
            ->setDescription('This is a long description.')
            ->setShortDescription('This is a short description.')
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'is_in_stock' => 1
            ))
            ->setCategoryIds(array(19));
    
    $images = array(
        'small_image' => 'grouped-prod#1-small.jpg',
        'image' => 'grouped-prod#1-image.jpg',
    );

    $dir = Mage::getBaseDir('media') . DS . 'evozon/product/';

    foreach ($images as $imageType => $imageFileName) {
        $path = $dir . $imageFileName;
        if (file_exists($path)) {
            try {
                $groupedProduct->addImageToMediaGallery($path, $imageType, false, false);
            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }
        } else {
            Mage::log("Image does not exist in `{$path}`");
        }
    }
    
    //link simple products to the grouped product
    $groupedProductData = [];
    foreach ($simpleProducts as $simpleProduct) {
        $groupedProductData[$simpleProduct->getId()] = array(
            'qty' => $simpleProduct->getQty(),
            'position' => 0
        );
    }

    $groupedProduct->setGroupedLinkData($groupedProductData);
    $groupedProduct->save();
    Mage::log("Grouped product 1 added!", null, 'dataScripts.log');
}