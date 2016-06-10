<?php
/**
 * Created by PhpStorm.
 * User: marius
 * Date: 6/10/16
 * Time: 11:11 AM
 */
Mage::log('==========================================================================', null, 'scripts.log');
Mage::log('Started data-upgrade-0.1.6-0.1.7 (adding a virtual product)', null, 'scripts.log');

// add virtual product - warranty

$date = new DateTime();

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$productModel = Mage::getModel('catalog/product');
if (!$productModel->getIdBySku('sku-virtually-guaranteed')) {
    try {
        $productModel
            ->setWebsiteIds(array(1))
            ->setAttributeSetId(14)
            ->setTypeId('virtual')
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setSku('sku-virtually-guaranteed')
            ->setName('Pre & Post-Mortem Warranty')
            ->setCreatedAt($date->getTimeStamp())
            ->setDescription('Warranty long description')
            ->setShortDescription('Warranty short description')
            ->setPrice(100)
            ->setTaxClassId(0)
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'min_sale_qty' => 1,
                'max_sale_qty' => 1,
                'is_in_stock' => 1,
                'qty' => 100
            ))
            ->setCategoryIds(array(24));

        $productModel->save();
        Mage::log('Added virtual product', null, 'scripts.log');
    } catch (Exception $e) {
        Mage::log($e->getMessage(), null, 'scripts.log');
    }
}

Mage::log('Ended data-upgrade-0.1.6-0.1.7 (adding a virtual product)', null, 'scripts.log');
Mage::log('==========================================================================', null, 'scripts.log');