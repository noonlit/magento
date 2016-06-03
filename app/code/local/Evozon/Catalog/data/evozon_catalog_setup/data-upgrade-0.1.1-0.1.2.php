<?php

//add simple productscript
$simpleProduct = Mage::getModel('catalog/product');
if (!$simpleProduct->getIdBySku('simple-prod#1')) {
    $simpleProduct->setSku('simple-prod#1')
            ->setTypeId('simple')
            ->setWebsiteIds(array(1))
            ->setAttributeSetId(4)
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setName('Simple object #1')
            ->setCreatedAt(strtotime('now'))
            ->setDescription('mega reducere mare magazinu are')
            ->setShortDescription('reducere mare')
            ->setPrice('39.99')
            ->setTaxClassId(2)
            ->setWeight(10)
            ->setColor(10)
            ->setMetaTitle('Simple object')
            ->setMetaKeywords('simple object')
            ->setMetaDescription('simple object')
            ->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'min_sale_qty' => 1,
                'max_sale_qty' => 10,
                'is_in_stock' => 1,
                'qty' => 50))
            ->setCategoryIds(array(13)); //add on DRESSES & SKIRTS category

    $images = array(
//    'thumbnail' => 'simple-prod#1-small.jpg',
        'small_image' => 'simple-prod#1-small.jpg',
        'image' => 'simple-prod#1-image.jpg',
    );

    $dir = Mage::getBaseDir('media') . DS . 'evozon/product/';

    foreach ($images as $imageType => $imageFileName) {
        $path = $dir . $imageFileName;
        if (file_exists($path)) {
            try {
                $simpleProduct->addImageToMediaGallery($path, $imageType, false, false);
            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }
        } else {
            Mage::log("Image does not exist in `{$path}`");
        }
    }$simpleProduct->save();

}
else {
    Mage::log("Simple product 1 already exists!", null,  'nigga.log');
}