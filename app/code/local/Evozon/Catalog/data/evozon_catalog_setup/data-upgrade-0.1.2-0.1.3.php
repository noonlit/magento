<?php

$date = new DateTime();

$configProduct = Mage::getModel('catalog/product');

try {
    $configProduct
            ->setWebsiteIds(array(1))
            ->setAttributeSetId(16)
            ->setTypeId('configurable')
            ->setSku('sku999-ignivomous-miscellanea')
            ->setCreatedAt($date->getTimestamp())
            ->setUpdatedAt($date->getTimestamp())
            ->setName('Configurable fire-breathing miscellanea')
            ->setWeight(1)
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setTaxClassId(0) // tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setColor(28) // which is red. to figure out: where all these options are 
            ->setcountryOfManufacture('RO')
            ->setCost(100) // the cost is what the merchant pays
            ->setPrice(200) // the price is what the customer pays
            ->setDescription('This is the long description of the fire-breathing item')
            ->setShortDescription('This is the short description of the fire-breathing item')
            ->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'min_sale_qty' => 1,
                'max_sale_qty' => 2,
                'is_in_stock' => 1,
                'qty' => 999
            ))
            ->setCategoryIds(array(7, 25));


    $configProduct->getTypeInstance()->setUsedProductAttributeIds(array(92)); // color   
    $configurableAttributesData = $configProduct->getTypeInstance()->getConfigurableAttributesAsArray();
    $configProduct->setCanSaveConfigurableAttributes(true);
    $configProduct->setConfigurableAttributesData($configurableAttributesData);

    $configurableProductsData = array();
    $configurableProductsData['910'] = array(//['910'] = id of a simple product associated with this configurable - the fire-breathing fruit fly
        '0' => array(
            'label' => 'Red', //attribute label
            'attribute_id' => '92', // attribute ID of attribute 'color' in my store
            'value_index' => '28', // value of 'Red' index of the attribute 'color'
            'is_percent' => '0', // fixed/percent price for this option
            'pricing_value' => '200' // value for the pricing
        )
    );
    $configProduct->setConfigurableProductsData($configurableProductsData);
    $configProduct->save();
} catch (Exception $e) {
    Mage::log($e->getMessage());
}