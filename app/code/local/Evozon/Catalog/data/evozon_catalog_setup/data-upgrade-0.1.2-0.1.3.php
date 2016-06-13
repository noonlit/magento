<?php
Mage::log('Started data-upgrade-0.1.3', null, 'scripts.log');
// add simple product - a cuvinteComplicate product
$date = new DateTime();
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$product = Mage::getModel('catalog/product');
if (!$product->getIdBySku('sku32-cuvinte-complicate')) {
    try {
        $product
                ->setStoreId(1)
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(16)// home and decor - cuvinte
                ->setTypeId('simple')
                ->setSku('sku32-cuvinte-complicate')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())
                ->setName('lampa')
                ->setWeight(32)
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setTaxClassId(2) // tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->setColor(32) // which is red. to figure out: where all these options are 
                ->setCountryOfManufacture('ES')
                ->setCost(32) // the cost is what the merchant pays
                ->setPrice(100) // the price is what the customer pays
                ->setDescription('Lampa mea a calatorit mult prin lume! Fii mandru ca o poti cumpara!')
                ->setShortDescription('Captain bean')
                ->setStockData(array(
                    'use_config_manage_stock' => 0,// manage stock din admin
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 1,
                    'is_in_stock' => 1,
                    'qty' => 1
                ))
                ->setCategoryIds(array(7, 25));
        $product->save();
        Mage::log('Saved new product', null, 'scripts.log');
    } catch (Exception $e) {
        Mage::log($e->getMessage(), null, 'scripts.log');  
    }
}
Mage::log('Ended data-upgrade-0.1.3', null, 'scripts.log');