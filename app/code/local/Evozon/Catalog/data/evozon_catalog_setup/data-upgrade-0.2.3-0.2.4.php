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
            ->setLinksTitle('Download')
            ->setWeight(60)
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setMetaTitle('ilinca book meta title')
            ->setMetaKeywords('')
            ->setMetaDescription('ilinca book meta description')
            ->setStockData(array(
                'use_config_manage_stock' => 1,
                'use_config_min_sale_qty' => 1,
                'use_config_max_sale_qty' => 1
            ))
            ->setCategoryIds(array(22));

    $mediaArray = array(
        'thumbnail' => 'jose-saramago-cain.jpg',
        'small_image' => 'jose-saramago-cain.jpg',
        'image' => 'jose-saramago-cain.jpg',
    );

    $importDir = Mage::getBaseDir('media') . DS . 'evozon/catalog/product/';

    foreach ($mediaArray as $imageType => $fileName) {
        $filePath = $importDir . $fileName;
        if (file_exists($filePath)) {
            $downloadableProduct->addImageToMediaGallery($filePath, $imageType, false);
        }
    }

    $downloadableProduct->save();

//    $filePath = Mage::getBaseDir('media') . DS . 'evozon/downloadable/files/links/jose_saramago_cain.pdf';
//    $linkModel = Mage::getModel('downloadable/link')->setData(array(
//        'product_id' => $downloadableProduct->getId(),
//        'sort_order' => 0,
//        'number_of_downloads' => 0, 
//        'is_unlimited' => 1,
//        'is_shareable' => 2, 
//        'is_delete' => '',
//        'link_url' => 'download',
//        'link_type' => 'file',
//        'link_file' => $filePath,
//        'sample_url' => '',
//        'sample_file' => '',
//        'sample_type' => 'file',
//        'use_default_title' => false,
//        'title' => 'Downloadable link'      
//    ));
//
//    $linkModel->setLinkFile($filePath)->save();




//    $filePath = Mage::getBaseDir('media') . DS . 'evozon/downloadable/files/links/jose_saramago_cain.pdf';
//    $downloadData['small']['link'] = array(
//        'is_delete' => '',
//        'price' => '',
//        'link_id' => '0',
//        'title' => 'Download',
//        'is_unlimited' => '1',
//        'number_of_downloads' => '10000',
//        'is_shareable' => '0',
//        'sample' => array(
//            'file' => '[]',
//            'type' => 'file',
//            'url' => ''
//        ),
//        'file' => array('name' => 'jose_saramago_cain.pdf', 'base64_content' => base64_encode(file_get_contents($filePath))),
//        'type' => 'file',
//        'link_url' => '',
//        'sample_url' => '',
//        'sort_order' => ''
//    );
//
//    $downloadableProduct->setDownloadableData($downloadData);
}
