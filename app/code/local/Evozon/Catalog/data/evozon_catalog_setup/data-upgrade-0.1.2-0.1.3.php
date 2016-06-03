<?php

//add configurable product script
//add simple product 1 for the configurable product
$simpleProduct1 = Mage::getModel('catalog/product');
if (!$simpleProduct1->getIdBySku('simple-prod#2')) {
    $simpleProduct1->setSku('simple-prod#2')
            ->setTypeId('simple')
            ->setWebsiteIds(array(1))
            ->setAttributeSetId(4)
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setName('Simple object #2')
            ->setCreatedAt(strtotime('now'))
            ->setDescription('product 1 for configurable product')
            ->setShortDescription('1 4 conf prod')
            ->setPrice('5.99')
            ->setTaxClassId(2)
            ->setWeight(10)
            ->setColor(10)
            ->setMetaTitle('Simple object 4 conf')
            ->setMetaKeywords('simple object 4 conf')
            ->setMetaDescription('simple object 4 conf')
            ->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'min_sale_qty' => 1,
                'max_sale_qty' => 10,
                'is_in_stock' => 1,
                'qty' => 40))
            ->setCategoryIds(array(13)); //add on DRESSES & SKIRTS category
    $simpleProduct1->save();
} else {
    Mage::log("Simple product 1 for configurable product already exists!", null, 'nigga.log');
}

//add simple product 2 for the configurable product
$simpleProduct2 = Mage::getModel('catalog/product');
if (!$simpleProduct1->getIdBySku('simple-prod#3')) {
    $simpleProduct2->setSku('simple-prod#3')
            ->setTypeId('simple')
            ->setWebsiteIds(array(1))
            ->setAttributeSetId(4)
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setName('Simple object #3')
            ->setCreatedAt(strtotime('now'))
            ->setDescription('product 2 for configurable product')
            ->setShortDescription('2 4 conf prod')
            ->setPrice('9.99')
            ->setTaxClassId(2)
            ->setWeight(10)
            ->setColor(10)
            ->setMetaTitle('Simple object 4 conf')
            ->setMetaKeywords('simple object 4 conf')
            ->setMetaDescription('simple object 4 conf')
            ->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'min_sale_qty' => 1,
                'max_sale_qty' => 10,
                'is_in_stock' => 1,
                'qty' => 40))
            ->setCategoryIds(array(13)); //add on DRESSES & SKIRTS category
    $simpleProduct2->save();
} else {
    Mage::log("Simple product 2 for configurable product already exists!", null, 'nigga.log');
}

$date = new DateTime();
$confProduct = Mage::getModel('catalog/product');
if (!$confProduct->getIdBySku('conf-prod#1')) {
    $confProduct->setSku('conf-prod#1')
            ->setTypeId('configurable')
            ->setWebsiteIds(array(1))
            ->setAttributeSetId(13)
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setName('Configurable product #1')
            ->setCreatedAt(strtotime('now'))
            ->setDescription('Long description')
            ->setShortDescription('Short desc')
            ->setPrice('59.99')
            ->setTaxClassId(4)
            ->setWeight(3)
            ->setColor(10)
            ->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'min_sale_qty' => 1,
                'max_sale_qty' => 5,
                'is_in_stock' => 1))
            ->setCategoryIds(array(13)); //add on DRESSES & SKIRTS category
    
    $confProduct->getTypeInstance()->setUsedProductAttributeIds(array(92));
    $configurableAttributesData = $confProduct->getTypeInstance()->getConfigurableAttributesAsArray();

    $confProduct->setCanSaveConfigurableAttributes(true);
    $confProduct->setConfigurableAttributesData($configurableAttributesData);

    $configurableProductsData = array();
    $simpleProductId = Mage::getModel("catalog/product")->getIdBySku('simple-prod#2');
    $configurableProductsData[$simpleProductId] = array(
        '0' => array(
            'label' => 'Green',
            'attribute_id' => '92',
            'value_index' => '24',
            'is_percent' => '0',
            'pricing_value' => '50'
        )
    );
    $confProduct->setConfigurableProductsData($configurableProductsData);
    $confProduct->save();
} else {
    Mage::log("Configurable product already exists!", null, 'nigga.log');
}