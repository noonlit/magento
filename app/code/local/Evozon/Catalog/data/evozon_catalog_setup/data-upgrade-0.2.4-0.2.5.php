<?php

/**
 * add a virtual product
 */
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$storeId = Mage::app()->getStore('default')->getId();

$product = Mage::getModel('catalog/product');
if (!$product->getIdBySku('ilincavirtual13')) {
    $product
            ->setWebsiteIds(array(Mage::app()->getStore($storeId)->getWebsiteId()))
            ->setAttributeSetId(14)
            ->setTypeId('virtual')
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setSku('ilincavirtual13')
            ->setName('Lifetime Warranty')
            ->setCreatedAt(strtotime('now'))
            ->setDescription('lifetime warranty long description')
            ->setShortDescription('lifetime warranty short description')
            ->setPrice('500')
            ->setTaxClassId(2)
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setMetaTitle('ilinca virtual meta tile')
            ->setMetaKeywords('')
            ->setMetaDescription('ilinca virtual meta description')
            ->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'min_sale_qty' => 1,
                'max_sale_qty' => 1,
                'is_in_stock' => 1,
                'qty' => 100
            ))
            ->setCategoryIds(array(24));

    $mediaArray = array(
        'thumbnail' => 'ilinca-virtual.jpg',
        'small_image' => 'ilinca-virtual.jpgg',
        'image' => 'ilinca-virtual.jpg',
    );

    // Remove unset images, add image to gallery if exists
    $importDir = Mage::getBaseDir('media') . DS . 'evozon/catalog/product/';

    foreach ($mediaArray as $imageType => $fileName) {
        $filePath = $importDir . $fileName;
        if (file_exists($filePath)) {
            $product->addImageToMediaGallery($filePath, $imageType, false);
        }
    }

    $product->save();
}

