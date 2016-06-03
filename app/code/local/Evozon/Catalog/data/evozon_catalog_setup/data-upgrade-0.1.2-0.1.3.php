<?php
Mage::log('Started data-install-0.1.3', null, 'scripts.log');

// (invisible) simple product

$date = new DateTime();
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$productRed = Mage::getModel('catalog/product');
if (!$productRed->getIdBySku('sku91-red-compels')) {
    try {
        $productRed
                ->setStoreId(1)
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(13)
                ->setTypeId('simple')
                ->setSku('sku91-red-compels')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())
                ->setName('The reddest of red tops')
                ->setWeight(1)
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setTaxClassId(0) // tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                ->setColor(28) // red
                ->setCountryOfManufacture('RO')
                ->setCost(100) // the cost is what the merchant pays
                ->setPrice(200) // the price is what the customer pays
                ->setDescription('This is the long description of the red top')
                ->setShortDescription('This is the short description of the red top')
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 2,
                    'is_in_stock' => 1,
                    'qty' => 999
                ))
                ->setCategoryIds(array(11));
        $productRed->save();
        Mage::log('Added first product', null, 'scripts.log');
    } catch (Exception $e) {
        Mage::log($e->getMessage(), null, 'scripts.log');
    }
}

// another (invisible) simple product

$productGreen = Mage::getModel('catalog/product');
if (!$productGreen->getIdBySku('sku91-hulk-green')) {
    try {
        $productGreen
                ->setStoreId(1)
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(13)
                ->setTypeId('simple')
                ->setSku('sku91-hulk-green')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())
                ->setName('The greenest of green tops')
                ->setWeight(10)
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setTaxClassId(0) // tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                ->setColor(24) // green (i hope)
                ->setCountryOfManufacture('RO')
                ->setCost(300) // the cost is what the merchant pays
                ->setPrice(500) // the price is what the customer pays
                ->setDescription('This is the long description of the green top')
                ->setShortDescription('This is the short description of the green top')
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 2,
                    'is_in_stock' => 1,
                    'qty' => 999
                ))
                ->setCategoryIds(array(11));
        $productGreen->save();
        Mage::log('Added second product', null, 'scripts.log');
    } catch (Exception $e) {
        Mage::log($e->getMessage(), null, 'scripts.log');
    }
}

// configurable product

$configProduct = Mage::getModel('catalog/product');
if (!$product->getIdBySku('sku91-extremely-trendy-tops')) {
    try {
        $configProduct
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(13) // clothing
                ->setTypeId('configurable')
                ->setSku('sku91-extremely-trendy-tops')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())
                ->setName('Configurable trendy tops')
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setTaxClassId(0) // tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->setCountryOfManufacture('RO')
                ->setCost(100) // the cost is what the merchant pays
                ->setPrice(200) // the price is what the customer pays
                ->setDescription('This is the long description of the trendy tops')
                ->setShortDescription('This is the short description of the trendy tops')
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 2,
                    'is_in_stock' => 1,
                    'qty' => 999
                ))
                ->setCategoryIds(array(11));

        $configProduct->getTypeInstance()->setUsedProductAttributeIds(array(92)); // color  
        $configurableAttributesData = $configProduct->getTypeInstance()->getConfigurableAttributesAsArray();
        $configProduct->setCanSaveConfigurableAttributes(true);
        $configProduct->setConfigurableAttributesData($configurableAttributesData);

        // product data
        $configurableProductsData = array();
        
        // red product data
        $redProductId = Mage::getModel("catalog/product")->getIdBySku('sku91-red-compels');
        $configurableProductsData[$redProductId] = array(
            '0' => array(
                'label' => 'Red', // attribute label
                'attribute_id' => '92', // attribute ID of attribute 'color' in my store
                'value_index' => '28', // value of 'Red' index of the attribute 'color'
                'is_percent' => '0', // fixed/percent price for this option
                'pricing_value' => '200' // value for the pricing
            ),
        );
        
        // green product data
        $greenProductId = Mage::getModel("catalog/product")->getIdBySku('sku91-hulk-green');
        $configurableProductsData[$greenProductId] = array(
            '0' => array(
                'label' => 'Green', //attribute label
                'attribute_id' => '92', // attribute ID of attribute 'color' in my store
                'value_index' => '24', // value of 'Green' index of the attribute 'color'
                'is_percent' => '0', // fixed/percent price for this option
                'pricing_value' => '500' // value for the pricing
            )
        );
        
        $configProduct->setConfigurableProductsData($configurableProductsData);
        $configProduct->save();
        Mage::log('Added configurable product', null, 'scripts.log');
    } catch (Exception $e) {
        Mage::log($e->getMessage(), null, 'scripts.log');
    }
}

Mage::log('Ended data-install-0.1.3', null, 'scripts.log');