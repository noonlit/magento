<?php
Mage::log('Started data-install-0.1.2', null, 'scripts.log');

$date = new DateTime();

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$product = Mage::getModel('catalog/product');

if (!$product->getIdBySku('sku91-ignivomous-drosophila')) {
    try {
        $product
                ->setStoreId(1)
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(16)
                ->setTypeId('simple')
                ->setSku('sku91-ignivomous-drosophila')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())
                ->setName('Fire-breathing fruit fly')
                ->setWeight(1)
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setTaxClassId(0) // tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->setColor(28) // which is red. to figure out: where all these options are 
                ->setCountryOfManufacture('RO')
                ->setCost(100) // the cost is what the merchant pays
                ->setPrice(200) // the price is what the customer pays
                ->setDescription('This is the long description of the fire-breathing fruit fly')
                ->setShortDescription('This is the short description of the fire-breathing fruit fly')
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 2,
                    'is_in_stock' => 1,
                    'qty' => 999
                ))
                ->setCategoryIds(array(7, 25));
        $product->save();
        Mage::log('Saved new product', null, 'scripts.log');
    } catch (Exception $e) {
        Mage::log($e->getMessage(), null, 'scripts.log');  
    }
}

Mage::log('Ended data-install-0.1.2', null, 'scripts.log');