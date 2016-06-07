<?php

/**
 * add a grouped product
 */
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$storeId = Mage::app()->getStore('default')->getId();

// add simple products
$simpleProduct1 = Mage::getModel('catalog/product');
$simpleProduct2 = Mage::getModel('catalog/product');

if (!$simpleProduct1->getIdBySku('ilincajewel1')) {
    $simpleProduct1
            ->setWebsiteIds(array(Mage::app()->getStore($storeId)->getWebsiteId()))
            ->setAttributeSetId(19)
            ->setTypeId('simple')
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setSku('ilincajewel1')
            ->setName('ilinca jewel 1')
            ->setCreatedAt(strtotime('now'))
            ->setDescription('Ilinca Jewel 1 long description')
            ->setShortDescription('Ilinca Jewel 1 short description')
            ->setPrice('56.23')
            ->setTaxClassId(2)
            ->setWeight(50)
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setMetaTitle('ilinca jewel 1 meta title')
            ->setMetaKeywords('')
            ->setMetaDescription('ilinca jewel 1 meta description')
            ->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'min_sale_qty' => 1,
                'max_sale_qty' => 3,
                'is_in_stock' => 1,
                'qty' => 30
            ))
            ->setCategoryIds(array(6, 19));

    $mediaArray = array(
        'thumbnail' => 'ilinca-jewel-1.jpg',
        'small_image' => 'ilinca-jewel-1.jpg',
        'image' => 'ilinca-jewel-1.jpg',
    );

    $importDir = Mage::getBaseDir('media') . DS . 'evozon/catalog/product/grouped/';

    foreach ($mediaArray as $imageType => $fileName) {
        $filePath = $importDir . $fileName;
        if (file_exists($filePath)) {
            $simpleProduct1->addImageToMediaGallery($filePath, $imageType, false);
        }
    }

    $simpleProduct1->save();
}

if (!$simpleProduct2->getIdBySku('ilincajewel2')) {
    $simpleProduct2
            ->setWebsiteIds(array(Mage::app()->getStore($storeId)->getWebsiteId()))
            ->setAttributeSetId(19)
            ->setTypeId('simple')
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setSku('ilincajewel2')
            ->setName('ilinca jewel 2')
            ->setCreatedAt(strtotime('now'))
            ->setDescription('Ilinca Jewel 2 long description')
            ->setShortDescription('Ilinca Jewel 2 short description')
            ->setPrice('85.00')
            ->setTaxClassId(2)
            ->setWeight(50)
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setMetaTitle('ilinca jewel 2 meta title')
            ->setMetaKeywords('')
            ->setMetaDescription('ilinca jewel 2 meta description')
            ->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'min_sale_qty' => 1,
                'max_sale_qty' => 3,
                'is_in_stock' => 1,
                'qty' => 36
            ))
            ->setCategoryIds(array(6, 19));

    $mediaArray = array(
        'thumbnail' => 'ilinca-jewel-2.jpg',
        'small_image' => 'ilinca-jewel-2.jpg',
        'image' => 'ilinca-jewel-2.jpg',
    );

    $importDir = Mage::getBaseDir('media') . DS . 'evozon/catalog/product/grouped/';

    foreach ($mediaArray as $imageType => $fileName) {
        $filePath = $importDir . $fileName;
        if (file_exists($filePath)) {
            $simpleProduct2->addImageToMediaGallery($filePath, $imageType, false);
        }
    }

    $simpleProduct2->save();
}

$simpleProducts = array($simpleProduct1, $simpleProduct2);

//create grouped product
$groupedProduct = Mage::getModel('catalog/product');
if (!$groupedProduct->getIdBySku('ilinca_jewel_group_1')) {
    $groupedProduct
            ->setWebsiteIds(array(Mage::app()->getStore($storeId)->getWebsiteId()))
            ->setAttributeSetId(19)
            ->setTypeId('grouped')
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setSku('ilinca_jewel_group_1')
            ->setName('ilinca jewel set')
            ->setPrice('126')
            ->setCreatedAt(strtotime('now'))
            ->setDescription('Ilinca Jewel Set long description')
            ->setShortDescription('Ilinca Jewel Set short description')
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'is_in_stock' => 1
            ))
            ->setCategoryIds(array(6, 19));

    $mediaArray = array(
        'thumbnail' => 'ilinca-jewel-set.jpg',
        'small_image' => 'ilinca-jewel-set.jpg',
        'image' => 'ilinca-jewel-set.jpg',
    );

    $importDir = Mage::getBaseDir('media') . DS . 'evozon/catalog/product/grouped/';

    foreach ($mediaArray as $imageType => $fileName) {
        $filePath = $importDir . $fileName;
        if (file_exists($filePath)) {
            $groupedProduct->addImageToMediaGallery($filePath, $imageType, false);
        }
    }
    
    //link simple products to the grouped product
    $groupedProductData = [];
    foreach($simpleProducts as $simpleProduct) {
        $groupedProductData[$simpleProduct->getId()] = array(
            'qty' => $simpleProduct->getQty(),
            'position' => 0
        );
    }
    
    $groupedProduct->setGroupedLinkData($groupedProductData);
    $groupedProduct->save();
}