<?php

//add bundle product script
$date = new DateTime();
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

//bundle options
$options = array(
    'cover' => array('simple', 'hard', 'leather'),
    'difficulty' => array('beginner', 'normal', 'hard'),
    'language' => array('english', 'romanian', 'klingon')
);

//add covers
$covers = array();
$coverPrice = array(
    $options['cover'][0] => '10',
    $options['cover'][1] => '30',
    $options['cover'][2] => '50');
foreach ($options['cover'] as $cover) {
    $model = Mage::getModel('catalog/product');
    $sku = 'book-cover-' . $cover;
    if (!$model->getIdBySku($sku)) {
        $model
                ->setStoreId(1)
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(16)
                ->setTypeId('simple')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())              
                ->setSku($sku)
                ->setName($cover)
                ->setDescription("This is the long description.")
                ->setShortDescription("This is the long description.")
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setTaxClassId(0) 
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                ->setCost($coverPrice[$cover])
                ->setPrice($coverPrice[$cover])
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 2,
                    'is_in_stock' => 1,
                    'qty' => 100
                ))
                ->setCategoryIds(array(22));//books
    }
    $model->save();
    Mage::log("{$sku} added!", null, 'dataScripts.log');
    $covers[] = $model;
}

// add difficulties
$difficulties = array();
$difficultyPrice = array(
    $options['difficulty'][0] => '25',
    $options['difficulty'][1] => '50',
    $options['difficulty'][2] => '50');
foreach ($options['difficulty'] as $difficulty) {
    $model = Mage::getModel('catalog/product');
    $sku = 'book-difficulty-' . $difficulty;
    if (!$model->getIdBySku($sku)) {
        $model
                ->setStoreId(1)
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(16)
                ->setTypeId('simple')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())              
                ->setSku($sku)
                ->setName($difficulty)
                ->setDescription("Let me explain at length how $cover type is the best cover type")
                ->setShortDescription("Let me explain briefly how $cover type is the best cover type")
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setTaxClassId(0) 
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                ->setCost($difficultyPrice[$difficulty])
                ->setPrice($difficultyPrice[$difficulty])
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 2,
                    'is_in_stock' => 1,
                    'qty' => 100
                ))
                ->setCategoryIds(array(22));//books
    }
    $model->save();
    Mage::log("{$sku} added!", null, 'dataScripts.log');
    $difficulties[] = $model;
}

//add languages
$languages = array();
$languagePrice = array(
    $options['language'][0] => '15',
    $options['language'][1] => '30',
    $options['language'][2] => '100');
foreach ($options['language'] as $language) {
    $model = Mage::getModel('catalog/product');
    $sku = 'book-language-' . $language;
    if (!$model->getIdBySku($sku)) {
        $model
                ->setStoreId(1)
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(16) // home and decor 
                ->setTypeId('simple')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())              
                ->setSku($sku)
                ->setName($language)
                ->setDescription("Let me explain at length how $cover type is the best cover type")
                ->setShortDescription("Let me explain briefly how $cover type is the best cover type")
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setTaxClassId(0) 
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                ->setCost($languagePrice[$language] - 5)
                ->setPrice($languagePrice[$language])
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 2,
                    'is_in_stock' => 1,
                    'qty' => 100
                ))
                ->setCategoryIds(array(22));//books
    }
    $model->save();
    Mage::log("{$sku} added!", null, 'dataScripts.log');
    $languages[] = $model;
}

//create bundle product
$bundleProduct = Mage::getModel('catalog/product');
$sku = 'book-';
if (!$bundleProduct->getIdBySku($sku)) {
    try {
        $bundleProduct
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(16)
                ->setTypeId('bundle')
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->setSkuType(1)
                ->setSku($sku)
                ->setName('Random book')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())
                ->setDescription('Loooong description')
                ->setShortDescription('Short description')
                ->setPriceType(0) //dynamic
                ->setPriceView(0) //price range
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setStockData(array(
                    'use_config_manage_stock' => 1,
                    'manage_stock' => 1,
                    'is_in_stock' => 1
                ))
                ->setCategoryIds(array(22));
        $bundleOptions = array(
            0 => array(
                'title' => 'Cover',
                'option_id' => '',
                'delete' => '',
                'type' => 'select',
                'required' => 1,
                'position' => 0
            ),
            1 => array(
                'title' => 'Difficulty',
                'option_id' => '',
                'delete' => '',
                'type' => 'select',
                'required' => 1,
                'position' => 1
            ),
            2 => array(
                'title' => 'Language',
                'option_id' => '',
                'delete' => '',
                'type' => 'select',
                'required' => 1,
                'position' => 2
            ),
        );
        $bundleSelections = [];
        $optionCount = 0;
        foreach ($options as $optionName => $option) {
            switch ($optionName) {
                case('cover'):
                    foreach ($covers as $cover) {
                        $bundleSelections[$optionCount][] = array(
                            'product_id' => $cover->getId(),
                            'delete' => '',
                            'selection_price_value' => $cover->getPrice(),
                            'selection_price_type' => 1,
                            'selection_quantity' => 1,
                            'selection_can_change_qty' => 0,
                            'position' => 0,
                            'is_default' => 1
                        );
                    }
                    break;
                case('difficulty'):
                    foreach ($difficulties as $difficulty) {
                        $bundleSelections[$optionCount][] = array(
                            'product_id' => $difficulty->getId(),
                            'delete' => '',
                            'selection_price_value' => $difficulty->getPrice(),
                            'selection_price_type' => 1,
                            'selection_quantity' => 1,
                            'selection_can_change_qty' => 0,
                            'position' => 0,
                            'is_default' => 1
                        );
                    }
                    break;
                case('language'):
                    foreach ($languages as $language) {
                        $bundleSelections[$optionCount][] = array(
                            'product_id' => $language->getId(),
                            'delete' => '',
                            'selection_price_value' => $language->getPrice(),
                            'selection_price_type' => 1,
                            'selection_quantity' => 1,
                            'selection_can_change_qty' => 0,
                            'position' => 0,
                            'is_default' => 1
                        );
                    }
                    break;
            }
            $optionCount++;
        }
        $bundleProduct->setCanSaveCustomOptions(true);
        $bundleProduct->setCanSaveBundleSelections(true);
        $bundleProduct->setAffectBundleProductSelections(true);
        Mage::register('product', $bundleProduct);
        $bundleProduct->setBundleOptionsData($bundleOptions);
        $bundleProduct->setBundleSelectionsData($bundleSelections);
        $bundleProduct->save();
    } catch (Exception $e) {
        Mage::log($e->getMessage(), null, 'dataScripts.log');
    }
}