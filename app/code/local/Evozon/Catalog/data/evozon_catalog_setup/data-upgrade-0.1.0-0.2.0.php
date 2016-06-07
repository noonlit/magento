<?php

/**
 * add a new simple product
 */

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$storeId = Mage::app()->getStore('default')->getId();

$product = Mage::getModel('catalog/product');
if (!$product->getIdBySku('ilincadecor13')) {
    $product
            ->setWebsiteIds(array(Mage::app()->getStore($storeId)->getWebsiteId()))
            ->setAttributeSetId(4)
            ->setTypeId('simple')
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setSku('ilincadecor13')
            ->setName('ilinca decor')
            ->setCreatedAt(strtotime('now'))
            ->setDescription('Ilinca Decor long description')
            ->setShortDescription('Ilinca Decor short description')
            ->setPrice('124.56')
            ->setTaxClassId(2)
            ->setWeight(50)
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setColor(24)
            ->setMetaTitle('ilinca-decor home decor')
            ->setMetaKeywords('')
            ->setMetaDescription('ilinca-decor meta description')
            ->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'min_sale_qty' => 1,
                'max_sale_qty' => 10,
                'is_in_stock' => 1,
                'qty' => 100
            ))
            ->setCategoryIds(array(7, 23));

    $mediaArray = array(
        'thumbnail' => 'ilinca-decor-13.png',
        'small_image' => 'ilinca-decor-13.png',
        'image' => 'ilinca-decor-13.png',
    );

    // Remove unset images, add image to gallery if exists
    $importDir = Mage::getBaseDir('media') . DS . 'evozon/catalog/product/';

    foreach ($mediaArray as $imageType => $fileName) {
        $filePath = $importDir . $fileName;
        if (file_exists($filePath)) {
            try {
                $product->addImageToMediaGallery($filePath, $imageType, false);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            echo "Product does not have an image or the path is incorrect. Path was: {$filePath}<br/>";
        }
    }
    
    $product->setIsMassupdate(true)->setExcludeUrlRewrite(true);

    $product->save();
}
