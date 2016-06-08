<?php
//add virtual product
Mage::log("data-upgrade-0.1.6-0.1.7 started", null, "dataScripts.log");
$date = new DateTime();
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$productModel = Mage::getModel('catalog/product');
if (!$productModel->getIdBySku('sku-virtual')) {
    try {
        $productModel
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(14)
                ->setTypeId('virtual')
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->setSku('sku-virtual')
                ->setName('Something virtual')
                ->setCreatedAt($date->getTimeStamp())
                ->setDescription('virtual option')
                ->setShortDescription('virtual option')
                ->setPrice(20)
                ->setTaxClassId(0)
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 1,
                    'is_in_stock' => 1,
                    'qty' => 10
                ))
                ->setCategoryIds(array(22));
        $images = array(
            'small_image' => 'virtual-001.jpg',
            'image' => 'virtual-001.jpg',
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
        Mage::log("Added virtual diploma!", null, 'dataScripts.log');
    } catch (Exception $e) {
        Mage::log($e->getMessage(), null, 'dataScripts.log');
    }
}