<?php

Mage::log('Started data-upgrade-0.1.3', null, 'scripts.log');

$date = new DateTime();

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);


$model = Mage::getModel('catalog/product');

// configurable product should have 4 attributes - color, size, gender, occasion - with options

$options = array();

// colors
$options['color']['red'] = $model->getResource()->getAttribute('color')->getSource()->getOptionId('Red');
$options['color']['purple'] = $model->getResource()->getAttribute('color')->getSource()->getOptionId('Purple');
$options['color']['black'] = $model->getResource()->getAttribute('color')->getSource()->getOptionId('Black');
$options['color']['indigo'] = $model->getResource()->getAttribute('color')->getSource()->getOptionId('Indigo');
$options['color']['ivory'] = $model->getResource()->getAttribute('color')->getSource()->getOptionId('Ivory');

// sizes
$options['size']['xs'] = $model->getResource()->getAttribute('size')->getSource()->getOptionId('XS');
$options['size']['s'] = $model->getResource()->getAttribute('size')->getSource()->getOptionId('S');
$options['size']['m'] = $model->getResource()->getAttribute('size')->getSource()->getOptionId('M');

// genders
$options['gender']['female'] = $model->getResource()->getAttribute('gender')->getSource()->getOptionId('Female');
$options['gender']['male'] = $model->getResource()->getAttribute('gender')->getSource()->getOptionId('Male');

// occasions
$options['occasion']['casual'] = $model->getResource()->getAttribute('occasion')->getSource()->getOptionId('Casual');
$options['occasion']['evening'] = $model->getResource()->getAttribute('occasion')->getSource()->getOptionId('Evening');
$options['occasion']['career'] = $model->getResource()->getAttribute('occasion')->getSource()->getOptionId('Career');

// build array of simple product configurations
$simpleProductsCfg = array();

foreach ($options['color'] as $colorKey => $color) {
    $simpleProduct = array();
    $simpleProduct['color'] = $color;

    foreach ($options['size'] as $sizeKey => $size) {
        $simpleProduct['size'] = $size;

        foreach ($options['gender'] as $genderKey => $gender) {
            $simpleProduct['gender'] = $gender;

            foreach ($options['occasion'] as $occasionKey => $occasion) {
                $simpleProduct['occasion'] = $occasion;
                $simpleProduct['sku'] = "sku-{$colorKey}-{$sizeKey}-{$genderKey}-{$occasionKey}";
                $simpleProduct['name'] = "The most {$colorKey} of {$colorKey} products";
                $simpleProduct['short_description'] = "This is the short description for a {$colorKey} product for {$genderKey}s, appropriate for {$occasionKey} situations.";
                $simpleProduct['description'] = "This is the long description for a {$colorKey} product for {$genderKey}s, appropriate for {$occasionKey} situations. "
                        . "It suspiciously resembles the short description, but, on close inspection, it becomes apparent that it is, in fact, longer.";
                $simpleProducts[] = $simpleProduct;
            }
        }
    }
}

// set common options for products
$model
        ->setStoreId(1)
        ->setWebsiteIds(array(1))
        ->setAttributeSetId(13)
        ->setTypeId('simple')
        ->setCreatedAt($date->getTimestamp())
        ->setUpdatedAt($date->getTimestamp())
        ->setWeight(1)
        ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
        ->setTaxClassId(0) // tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
        ->setCost(100) // the cost is what the merchant pays
        ->setPrice(200) // the price is what the customer pays
        ->setStockData(array(
            'use_config_manage_stock' => 0,
            'manage_stock' => 1,
            'min_sale_qty' => 1,
            'max_sale_qty' => 2,
            'is_in_stock' => 1,
            'qty' => 999
        ))
        ->setCategoryIds(array(11));


// set configurable options for products
foreach ($simpleProductsCfg as $productCfg) {
    if (!$model->getIdBySku($productCfg['sku'])) {
        try {
            $model
                    ->setSku($productCfg['sku'])
                    ->setColor($productCfg['color'])
                    ->setSize($productCfg['size'])
                    ->setGender($productCfg['gender'])
                    ->setOccasion($productCfg['occasion'])
                    ->setName($productCfg['name'])
                    ->setDescription($productCfg['description'])
                    ->setShortDescription($productCfg['short_description']);
            $model->save();
            Mage::log("Added {$productCfg['sku']}", null, 'scripts.log');
        } catch (Exception $e) {
            Mage::log($e->getMessage(), null, 'scripts.log');
        }
    }
}


/*
  // women, red, XS, casual
  $womenRedXSCasual = Mage::getModel('catalog/product');
  if (!$womenRedXSCasual->getIdBySku('sku91-women-red-xs-casual')) {
  try {
  $womenRedXSCasual
  ->setStoreId(1)
  ->setWebsiteIds(array(1))
  ->setAttributeSetId(13)
  ->setTypeId('simple')
  ->setSku('sku91-women-red-xs-casual')
  ->setCreatedAt($date->getTimestamp())
  ->setUpdatedAt($date->getTimestamp())
  ->setName('The reddest of red tops')
  ->setWeight(1)
  ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
  ->setTaxClassId(0) // tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
  ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
  ->setColor(28) // red
  ->setGender(94) // women
  ->setSize(81) // XS
  ->setOccasion(31) // casual
  ->setCountryOfManufacture('RO')
  ->setCost(100) // the cost is what the merchant pays
  ->setPrice(200) // the price is what the customer pays
  ->setDescription('This is the long description of the red top for women')
  ->setShortDescription('This is the short description of the red top for women')
  ->setStockData(array(
  'use_config_manage_stock' => 0,
  'manage_stock' => 1,
  'min_sale_qty' => 1,
  'max_sale_qty' => 2,
  'is_in_stock' => 1,
  'qty' => 999
  ))
  ->setCategoryIds(array(11));
  $womenRedXSCasual->save();
  Mage::log('Added women, red, XS, casual', null, 'scripts.log');
  } catch (Exception $e) {
  Mage::log($e->getMessage(), null, 'scripts.log');
  }
  }


 */
// configurable product

/* $configProduct = Mage::getModel('catalog/product');
  if (!$product->getIdBySku('sku91-extremely-trendy-top')) {
  try {
  $configProduct
  ->setWebsiteIds(array(1))
  ->setAttributeSetId(13) // clothing
  ->setTypeId('configurable')
  ->setSku('sku91-extremely-trendy-top')
  ->setCreatedAt($date->getTimestamp())
  ->setUpdatedAt($date->getTimestamp())
  ->setName('Configurable trendy top')
  ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
  ->setTaxClassId(0) // tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
  ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
  ->setCountryOfManufacture('RO')
  ->setCost(100) // the cost is what the merchant pays
  ->setPrice(200) // the price is what the customer pays
  ->setDescription('This is the long description of the trendy top')
  ->setShortDescription('This is the short description of the trendy top')
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
  } */

Mage::log('Ended data-upgrade-0.1.3', null, 'scripts.log');
