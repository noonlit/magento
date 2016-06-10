<?php
/**
 * Created by PhpStorm.
 * User: marius
 * Date: 6/10/16
 * Time: 11:19 AM
 */
Mage::log('==========================================================================', null, 'scripts.log');
Mage::log('Started data-upgrade-0.1.7-0.1.8 (adding a downloadable product)', null, 'scripts.log');

// add downloadable product

$date = new DateTime();

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$productModel = Mage::getModel('catalog/product');
if (!$productModel->getIdBySku('sku-on-the-properties-of-rocks')) {
    $productModel
        ->setWebsiteIds(array(1))
        ->setStoreId(1)
        ->setAttributeSetId(10)
        ->setTypeId('downloadable')
        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
        ->setSku('sku-on-the-properties-of-rocks')
        ->setName('In Which Rocks Fall, Everyone Dies')
        ->setCreatedAt(strtotime('now'))
        ->setDescription('So many rocks. They all fall. Absolutely everyone dies.')
        ->setShortDescription('There are rocks, gravity, and deaths')
        ->setPrice(30)
        ->setTaxClassId(0)
        ->setLinksTitle('Download')
        ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
        ->setStockData(array(
            'use_config_manage_stock' => 1,
            'manage_stock' => 1,
            'min_sale_qty' => 1,
            'max_sale_qty' => 1,
            'is_in_stock' => 1,
            'qty' => 100
        ))
        ->setCategoryIds(array(22));

    $downloadableData = array(
        'has_options' => '1',
        'required_options' => '1',
        'links_title' => 'Download links',
        'links_purchased_separately' => '1',
        'links_exist' => '1'
    );

    foreach($downloadableData as $key => $value) {
        $productModel->setData($key, $value);
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
        ->setLinkFile('/evozon/rocks.jpg')
        ->save();
}

Mage::log('Ended data-upgrade-0.1.7-0.1.8 (adding a downloadable product)', null, 'scripts.log');
Mage::log('==========================================================================', null, 'scripts.log');
