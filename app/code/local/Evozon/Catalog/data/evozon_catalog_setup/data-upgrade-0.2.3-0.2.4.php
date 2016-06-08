<?php

/**
 * add a downloadable product
 */
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$storeId = Mage::app()->getStore('default')->getId();

$downloadableProduct = Mage::getModel('catalog/product');
if (!$downloadableProduct->getIdBySku('ilinca-book-000')) {
    $downloadableProduct
            ->setWebsiteIds(array(Mage::app()->getStore($storeId)->getWebsiteId()))
            ->setStoreId($storeId)
            ->setAttributeSetId(10)
            ->setTypeId('downloadable')
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setSku('ilinca-book-000')
            ->setName('Cain')
            ->setCreatedAt(strtotime('now'))
            ->setDescription('Book long description')
            ->setShortDescription('Jose Saramago: Cain')
            ->setPrice('12.5')
            ->setTaxClassId(2)
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setMetaTitle('ilinca book meta title')
            ->setMetaKeywords('')
            ->setMetaDescription('ilinca book meta description')
            ->setStockData(array(
                'use_config_manage_stock' => 1,
                'qty' => 9999,
                'min_sale_qty' => 1,
                'max_sale_qty' => 5,
                'is_in_stock' => 1
            ))
            ->setCategoryIds(array(22));

    // add image to product
    $mediaArray = array(
        'thumbnail' => 'jose-saramago-cain.png',
        'small_image' => 'jose-saramago-cain.png',
        'image' => 'jose-saramago-cain.png',
    );

    $importDir = Mage::getBaseDir('media') . DS . 'evozon/catalog/product/';

    foreach ($mediaArray as $imageType => $fileName) {
        $filePath = $importDir . $fileName;
        if (file_exists($filePath)) {
            $downloadableProduct->addImageToMediaGallery($filePath, $imageType, false);
        }
    }

    // set purchase links
    $downloadableData = array(
        'has_options' => '1',
        'required_options' => '1',
        'links_title' => 'Download links',
        'links_purchased_separately' => '1',
        'links_exist' => '1'
    );
    foreach($downloadableData as $key => $value) {
        $downloadableProduct->setData($key, $value);
    }               
    $downloadableProduct->save();
    
    $linkModel = Mage::getModel('downloadable/link')
            ->setProductId($downloadableProduct->getId())      
            ->setNumberOfDownloads('0')
            ->setIsShareable('0')
            ->setTitle('Download links')
            ->setDefaultTitle('Download links')
            ->setLinkUrl('')
            ->setLinkType('file')
            ->setLinkFile('/evozon/jose_saramago_cain.pdf')
            ->save();   
}

