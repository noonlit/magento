<?php

// add downloadable product
Mage::log("data-upgrade-0.1.6-0.1.7 started", null, "dataScripts.log");
$date = new DateTime();
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$productModel = Mage::getModel('catalog/product');

if (!$productModel->getIdBySku('download-product#1')) {
    $productModel
            ->setWebsiteIds(array(1))
            ->setStoreId(1)
            ->setAttributeSetId(10)
            ->setTypeId('downloadable')
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setSku('download-product#1')
            ->setName('Donald Trump sounds')
            ->setCreatedAt(strtotime('now'))
            ->setDescription('The many sounds of Donald Trump!')
            ->setShortDescription('The many sounds of Donald Trump!')
            ->setPrice(0)
            ->setTaxClassId(0)
            ->setLinksTitle('Download')
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setStockData(array(
                'use_config_manage_stock' => 1,
                'manage_stock' => 1,
                'min_sale_qty' => 1,
                'max_sale_qty' => 1,
                'is_in_stock' => 1,
                'qty' => 999
            ))
            ->setCategoryIds(array(22));

    $downloadableData = array(
        'has_options' => '1',
        'required_options' => '1',
        'links_title' => 'Download links',
        'links_purchased_separately' => '1',
        'links_exist' => '1'
    );
    foreach ($downloadableData as $key => $value) {
        $productModel->setData($key, $value);
    }

    $images = array(
        'small_image' => 'simple-prod#2-small.jpg',
        'image' => 'grouped-prod#1-image.jpg',
    );

    $dir = Mage::getBaseDir('media') . DS . 'evozon/product/';

    foreach ($images as $imageType => $imageFileName) {
        $path = $dir . $imageFileName;
        if (file_exists($path)) {
            try {
                $productModel->addImageToMediaGallery($path, $imageType, false, false);
            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }
        } else {
            Mage::log("Image does not exist in `{$path}`");
        }
    }
    $productModel->save();
    
    $linkModel = Mage::getModel('downloadable/link')
            ->setProductId($productModel->getId())
            ->setNumberOfDownloads('0')
            ->setIsShareable('0')
            ->setTitle('Download links')
            ->setDefaultTitle('Download links')
            ->setLinkUrl('')
            ->setLinkType('file')
            ->setLinkFile('/evozon/download/trump.mp3')
            ->save();
    Mage::log("Added downloadable product!", null, "dataScripts.log");
}
