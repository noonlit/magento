<?php

$product = Mage::getModel('catalog/product');

$product
->setSku('simple-prod#1')
->setTypeId('simple')
->setWebsiteIds(array(1))
->setAttributeSetId(4)
->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
->setName('Simple object #1')
->setCreatedAt(strtotime('now'))
->setDescription('mega reducere mare')
->setShortDescription('reducere mare')
->setPrice('39.99')
->setTaxClassId(2)
->setWeight(10)
->setColor(10)
->setMetaTitle('simple object')
->setMetaKeywords('simple object')
->setMetaDescription('simple object')
->setStockData(array(
'use_config_manage_stock' => 0,
 'manage_stock' => 1,
 'min_sale_qty' => 1,
 'max_sale_qty' => 10,
 'is_in_stock' => 1,
 'qty' => 50))
->setCategoryIds(array(13))
; //add on DRESSES & SKIRTS category

$images = array(
    'small_image' => 'simple-prod#1-small.jpg',
    'image' => 'simple-prod#1-image.jpg',
);
$dir = Mage::getBaseDir('media') . DS . 'evozon/product/';
foreach ($images as $imageType => $imageFileName) {
    $path = $dir . $imageFileName;
    if (file_exists($path)) {
        try {
            $product->addImageToMediaGallery($path, $imageType, false, false);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } else {
        echo "Can not find image by path: `{$path}`<br/>";
    }
}


$product->save();
