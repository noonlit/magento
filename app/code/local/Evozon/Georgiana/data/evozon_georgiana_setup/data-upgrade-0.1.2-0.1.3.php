<?php



$date = new DateTime();

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);


$model = Mage::getModel('catalog/product');
$options = array();


$options['color']['green'] = $model->getResource()->getAttribute('color')->getSource()->getOptionId('Green');
$options['color']['blue'] = $model->getResource()->getAttribute('color')->getSource()->getOptionId('Blue');
$options['color']['black'] = $model->getResource()->getAttribute('color')->getSource()->getOptionId('Black');



$options['size']['s'] = $model->getResource()->getAttribute('size')->getSource()->getOptionId('S');
$options['size']['m'] = $model->getResource()->getAttribute('size')->getSource()->getOptionId('M');
$options['size']['l'] = $model->getResource()->getAttribute('size')->getSource()->getOptionId('L');


$options['gender']['female'] = $model->getResource()->getAttribute('gender')->getSource()->getOptionId('Female');
$options['gender']['male'] = $model->getResource()->getAttribute('gender')->getSource()->getOptionId('Male');


$options['occasion']['casual'] = $model->getResource()->getAttribute('occasion')->getSource()->getOptionId('Casual');
$options['occasion']['evening'] = $model->getResource()->getAttribute('occasion')->getSource()->getOptionId('Evening');
$options['occasion']['career'] = $model->getResource()->getAttribute('occasion')->getSource()->getOptionId('Career');


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
                $simpleProduct['sku'] = "SimpleSku-{$colorKey}-{$sizeKey}-{$genderKey}-{$occasionKey}";
                $simpleProduct['name'] = "My new {$colorKey} product ";
                $simpleProduct['short_description'] = "wow";
                $simpleProduct['description'] = "The best product";
                $simpleProductsCfg[] = $simpleProduct;
            }
        }
    }
}


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
                    ->setTaxClassId(0) 
                    ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                    ->setCost(100) 
                    ->setPrice(200) 
                    ->setStockData(array(
                        'use_config_manage_stock' => 0,
                        'manage_stock' => 1,
                        'min_sale_qty' => 1,
                        'max_sale_qty' => 2,
                        'is_in_stock' => 1,
                        'qty' => 100
                    ))
                    ->setCategoryIds(array(10))
                    ->setSku($productCfg['sku'])
                    ->setColor($productCfg['color'])
                    ->setSize($productCfg['size'])
                    ->setGender($productCfg['gender'])
                    ->setOccasion($productCfg['occasion'])
                    ->setName($productCfg['name'])
                    ->setDescription($productCfg['description'])
                    ->setShortDescription($productCfg['short_description']);
            $productModel->save();

        } catch (Exception $e) {
            Mage::log($e->getMessage());
        }
    }
}



$cfgProductModel = Mage::getModel('catalog/product');
if (!$cfgProductModel->getIdBySku('ConfigSku')) {
    try {
        $cfgProductModel
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(13) // clothing
                ->setTypeId('configurable')
                ->setSku('ConfigSku')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())
                ->setName('My config Product')
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setTaxClassId(0) 
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->setCountryOfManufacture('RO')
                ->setCost(80) 
                ->setPrice(480) 
                ->setDescription('This is the best description')
                ->setShortDescription('wow')
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 2,
                    'is_in_stock' => 1,
                    'qty' => 100
                ))
                ->setCategoryIds(array(10));


        $colorId = $model->getResource()->getAttribute('color')->getAttributeId();
        $sizeId = $model->getResource()->getAttribute('size')->getAttributeId();
        $genderId = $model->getResource()->getAttribute('gender')->getAttributeId();
        $occasionId = $model->getResource()->getAttribute('occasion')->getAttributeId();
        $cfgProductModel->getTypeInstance()->setUsedProductAttributeIds(array($colorId, $sizeId, $genderId, $occasionId));
        $cfgAttributesData = $cfgProductModel->getTypeInstance()->getConfigurableAttributesAsArray();
        $cfgProductModel->setCanSaveConfigurableAttributes(true);
        $cfgProductModel->setConfigurableAttributesData($cfgAttributesData);

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

    } catch (Exception $e) {
        Mage::log($e->getMessage());
    }
}

