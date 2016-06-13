<?php
Mage::log('Started data-upgrade-0.1.4', null, 'scripts.log');
// add configurable product - a configurable top
$date = new DateTime();
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
// configurable product should have 4 attributes - color, size, gender, occasion - with option
$model = Mage::getModel('catalog/product');
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
    $simpleProduct['color'] = $color; // id de culoare
    foreach ($options['size'] as $sizeKey => $size) {
        $simpleProduct['size'] = $size; // id de size
        foreach ($options['gender'] as $genderKey => $gender) {
            $simpleProduct['gender'] = $gender; // id de gender
            foreach ($options['occasion'] as $occasionKey => $occasion) {
                $simpleProduct['occasion'] = $occasion; // id de ocazie (= autostop)
                $simpleProduct['sku'] = "sku-{$colorKey}-{$sizeKey}-{$genderKey}-{$occasionKey}";
                $simpleProduct['name'] = "The most {$colorKey} of {$colorKey} products";
                $simpleProduct['short_description'] = "This is the short description for a {$colorKey} product for {$genderKey}s, appropriate for {$occasionKey} situations.";
                $simpleProduct['description'] = "This is the long description for a {$colorKey} product for {$genderKey}s, appropriate for {$occasionKey} situations. "
                        . "It suspiciously resembles the short description, but, on close inspection, it becomes apparent that it is, in fact, longer.";
                $simpleProductsCfg[] = $simpleProduct;
            }
        }
    }
}
// build and save the simple products
foreach ($simpleProductsCfg as $productCfg) {
    $productModel = Mage::getModel('catalog/product');
    if (!$productModel->getIdBySku($productCfg['sku'])) {
        try {
            $productModel
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
                    ->setCost(12) // the cost is what the merchant pays
                    ->setPrice(50) // the price is what the customer pays
                    ->setStockData(array(
                        'use_config_manage_stock' => 0,
                        'manage_stock' => 1,
                        'min_sale_qty' => 1,
                        'max_sale_qty' => 32,
                        'is_in_stock' => 1,
                        'qty' => 51
                    ))
                    ->setCategoryIds(array(11))
                    ->setSku($productCfg['sku'])
                    ->setColor($productCfg['color'])
                    ->setSize($productCfg['size'])
                    ->setGender($productCfg['gender'])
                    ->setOccasion($productCfg['occasion'])
                    ->setName($productCfg['name'])
                    ->setDescription($productCfg['description'])
                    ->setShortDescription($productCfg['short_description']);
            $productModel->save();
            Mage::log("Added {$productCfg['sku']}", null, 'scripts.log');
        } catch (Exception $e) {
            Mage::log($e->getMessage(), null, 'scripts.log');
        }
    }
}
// build and save the configurable product
$cfgProductModel = Mage::getModel('catalog/product');
if (!$cfgProductModel->getIdBySku('sku-trendy-top')) {
    try {
        $cfgProductModel
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(13) // clothing
                ->setTypeId('configurable')
                ->setSku('sku-trendy-top')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())
                ->setName('Yet another configurable trendy top')
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setTaxClassId(0) // tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->setCountryOfManufacture('RO')
                ->setCost(12) // the cost is what the merchant pays
                ->setPrice(50) // the price is what the customer pays
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
        
        // get ids of used attributes and set them as configurable
        $colorId = $model->getResource()->getAttribute('color')->getAttributeId();
        $sizeId = $model->getResource()->getAttribute('size')->getAttributeId();
        $genderId = $model->getResource()->getAttribute('gender')->getAttributeId();
        $occasionId = $model->getResource()->getAttribute('occasion')->getAttributeId();
        $cfgProductModel->getTypeInstance()->setUsedProductAttributeIds(array($colorId, $sizeId, $genderId, $occasionId));
        $cfgAttributesData = $cfgProductModel->getTypeInstance()->getConfigurableAttributesAsArray();
        $cfgProductModel->setCanSaveConfigurableAttributes(true);
        $cfgProductModel->setConfigurableAttributesData($cfgAttributesData);
        // set product data
        $cfgProductsData = array();
        foreach ($simpleProductsCfg as $productCfg) {
            $productId = $model->getIdBySku($productCfg['sku']);
            $price = $model->load($productId)->getPrice();
            
            foreach ($productCfg as $key => $value) {
                if ($key == 'color' || $key == 'size' || $key == 'gender' || $key == 'occasion') {
                    $attributeLabel = $model->getResource()->getAttribute($key)->getSource()->getOptionText($value);
                    $attributeId = $model->getResource()->getAttribute($key)->getId();
                    $cfgProductsData[$productId][] = array(
                        'label' => $attributeLabel,
                        'attribute_id' => $attributeId,
                        'value_index' => $value,
                        'is_percent' => '0',
                        'pricing_value' => $price
                    );
                }
            }
        }
        $cfgProductModel->setConfigurableProductsData($cfgProductsData);
        $cfgProductModel->save();
        Mage::log('Added configurable product', null, 'scripts.log');
    } catch (Exception $e) {
        Mage::log($e->getMessage(), null, 'scripts.log');
    }
}
Mage::log('Ended data-upgrade-0.1.4', null, 'scripts.log');