<?php
Mage::log("data-upgrade-0.1.2-0.1.3 started", null, "dataScripts.log");
$date = new DateTime();
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
//Mage::registry('current_category')->getId();
$cfgProductModel = Mage::getModel('catalog/product');
if (!$cfgProductModel->getIdBySku('Ionicaa')) {
    $model = Mage::getModel('catalog/product');
    $options = array();
    $options['color']['pink'] = $model->getResource()->getAttribute('color')->getSource()->getOptionId('Pink');
    $options['color']['taupe'] = $model->getResource()->getAttribute('color')->getSource()->getOptionId('Taupe');
    $options['color']['khaki'] = $model->getResource()->getAttribute('color')->getSource()->getOptionId('Khaki');
    $options['color']['purple'] = $model->getResource()->getAttribute('color')->getSource()->getOptionId('Purple');
    $options['color']['oatmeal'] = $model->getResource()->getAttribute('color')->getSource()->getOptionId('Oatmeal');
    
    $options['size']['s'] = $model->getResource()->getAttribute('size')->getSource()->getOptionId('S');
    $options['size']['m'] = $model->getResource()->getAttribute('size')->getSource()->getOptionId('M');
    $options['size']['l'] = $model->getResource()->getAttribute('size')->getSource()->getOptionId('L');
    
    $options['gender']['female'] = $model->getResource()->getAttribute('gender')->getSource()->getOptionId('Female');
    $options['gender']['male'] = $model->getResource()->getAttribute('gender')->getSource()->getOptionId('Male');
    
    $options['occasion']['casual'] = $model->getResource()->getAttribute('occasion')->getSource()->getOptionId('Casual');
    $options['occasion']['evening'] = $model->getResource()->getAttribute('occasion')->getSource()->getOptionId('Evening');
    $options['occasion']['career'] = $model->getResource()->getAttribute('occasion')->getSource()->getOptionId('Career');
    // make every combination between attributes
    $simpleProductsCfg = array();
    foreach ($options['color'] as $colorKey => $color) {
        $simpleProduct = array();
        $simpleProduct['short_description'] = "Fistica";
        $simpleProduct['description'] = "This is the long description.";
        $simpleProduct['color'] = $color;
        foreach ($options['size'] as $sizeKey => $size) {
            $simpleProduct['size'] = $size;
            foreach ($options['gender'] as $genderKey => $gender) {
                $simpleProduct['gender'] = $gender;
                foreach ($options['occasion'] as $occasionKey => $occasion) {
                    $simpleProduct['occasion'] = $occasion;
                    //set unique attributes
                    $simpleProduct['sku'] = "shirt-{$colorKey}-{$sizeKey}-{$genderKey}-{$occasionKey}";
                    $simpleProduct['name'] = "{$colorKey}-{$sizeKey}-{$genderKey}-{$occasionKey}";
                    //store new simple product
                    $simpleProductsCfg[] = $simpleProduct;
                }
            }
        }
    }
    //save all combinations of simple products
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
                        ->setCost(50)
                        ->setPrice(10)
                        ->setStockData(array(
                            'use_config_manage_stock' => 0,
                            'manage_stock' => 1,
                            'min_sale_qty' => 1,
                            'max_sale_qty' => 2,
                            'is_in_stock' => 1,
                            'qty' => 100
                        ))
                        ->setCategoryIds(array(4))
                        ->setSku($productCfg['sku'])
                        ->setColor($productCfg['color'])
                        ->setSize($productCfg['size'])
                        ->setGender($productCfg['gender'])
                        ->setOccasion($productCfg['occasion'])
                        ->setName($productCfg['name'])
                        ->setDescription($productCfg['description'])
                        ->setShortDescription($productCfg['short_description']);
                $productModel->save();
                Mage::log("{$productCfg['sku']} added!", null, 'dataScripts.log');
            } catch (Exception $e) {
                Mage::log($e->getMessage(), null, 'dataScripts.log');
            }
        }
    }
    //save configurable product
    try {
        $cfgProductModel
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(13) // clothing
                ->setTypeId('configurable')
                ->setSku('Ionicaa')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())
                ->setName('Pistica')
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setTaxClassId(0)
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->setCountryOfManufacture('RO')
                ->setCost(100)
                ->setPrice(200)
                ->setDescription('This is the long description.')
                ->setShortDescription('Fistica')
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 2,
                    'is_in_stock' => 1,
                    'qty' => 100
                ))
                ->setCategoryIds(array(4));
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
        Mage::log('Configurable product added!', null, 'dataScripts.log');
    } catch (Exception $e) {
        Mage::log($e->getMessage(), null, "dataScripts.log");
    }
}