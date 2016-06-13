<?php
Mage::log('Started data-upgrade-0.1.5', null, 'scripts.log');
// add bundle product - a spellbook
$date = new DateTime();
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
// options for the bundle
$options = array(
    'cover' => array('dragonhide', 'paper', 'iron'),
    'specialization' => array('fire', 'healing', 'necromancy'),
    'language' => array('orcish', 'elvish', 'common')
);
// add covers
$covers = array();
$coverPrice = array(
    $options['cover'][0] => '100',
    $options['cover'][1] => '50',
    $options['cover'][2] => '80');
foreach ($options['cover'] as $cover) {
    $model = Mage::getModel('catalog/product');
    $sku = 'sku-just-witchy-things-' . $cover;
    if (!$model->getIdBySku($sku)) {
        $model
                ->setStoreId(1)
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(16) // home and decor 
                ->setTypeId('simple')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())              
                ->setSku($sku)
                ->setName($cover)
                ->setDescription("Let me explain at length how $cover type is the BEST cover type")
                ->setShortDescription("Let me explain briefly how $cover type is the BEST cover type")
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setTaxClassId(0) 
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                ->setCost($coverPrice[$cover] - 5)
                ->setPrice($coverPrice[$cover])
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 2,
                    'is_in_stock' => 1,
                    'qty' => 999
                ))
                ->setCategoryIds(array(22)); // books and music
    }
    $model->save();
    Mage::log("Added {$sku}", null, 'scripts.log');
    $covers[] = $model;
}
// add specializations
$specializations = array();
$specializationPrice = array(
    $options['specialization'][0] => '90',
    $options['specialization'][1] => '50',
    $options['specialization'][2] => '400');
foreach ($options['specialization'] as $specialization) {
    $model = Mage::getModel('catalog/product');
    $sku = 'sku-just-witchy-things-' . $specialization;
    if (!$model->getIdBySku($sku)) {
        $model
                ->setStoreId(1)
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(16) // home and decor 
                ->setTypeId('simple')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())              
                ->setSku($sku)
                ->setName($specialization)
                ->setDescription("Let me explain at length how $cover type is the BEST cover type")
                ->setShortDescription("Let me explain briefly how $cover type is the BEST cover type")
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setTaxClassId(0) 
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                ->setCost($specializationPrice[$specialization] - 5)
                ->setPrice($specializationPrice[$specialization])
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 2,
                    'is_in_stock' => 1,
                    'qty' => 999
                ))
                ->setCategoryIds(array(22)); // books and musi
    }
    $model->save();
    Mage::log("Added {$sku}", null, 'scripts.log');
    $specializations[] = $model;
}
// add languages
$languages = array();
$languagePrice = array(
    $options['language'][0] => '100',
    $options['language'][1] => '120',
    $options['language'][2] => '30');
foreach ($options['language'] as $language) {
    $model = Mage::getModel('catalog/product');
    $sku = 'sku-just-witchy-things-' . $language;
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
                ->setDescription("Let me explain at length how $cover type is the BEST cover type")
                ->setShortDescription("Let me explain briefly how $cover type is the BEST cover type")
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
                    'qty' => 999
                ))
                ->setCategoryIds(array(22)); // books and musi
    }
    $model->save();
    Mage::log("Added {$sku}", null, 'scripts.log');
    $languages[] = $model;
}
// create bundle product
$bundleProduct = Mage::getModel('catalog/product');
$sku = 'sku-bundle-of-witchy-things';
if (!$bundleProduct->getIdBySku($sku)) {
    try {
        $bundleProduct
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(16)
                ->setTypeId('bundle')
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                ->setSkuType(1)
                ->setSku($sku)
                ->setName('Your first book of spells')
                ->setCreatedAt($date->getTimestamp())
                ->setUpdatedAt($date->getTimestamp())
                ->setDescription('It\'s a book of spells. For casting. At others.')
                ->setShortDescription('Boom.')
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
                'title' => 'Specialization',
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
                case('specialization'):
                    foreach ($specializations as $specialization) {
                        $bundleSelections[$optionCount][] = array(
                            'product_id' => $specialization->getId(),
                            'delete' => '',
                            'selection_price_value' => $specialization->getPrice(),
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
            $optionCount += 1;
        }
        $bundleProduct->setCanSaveCustomOptions(true);
        $bundleProduct->setCanSaveBundleSelections(true);
        $bundleProduct->setAffectBundleProductSelections(true);
        Mage::register('product', $bundleProduct);
        $bundleProduct->setBundleOptionsData($bundleOptions);
        $bundleProduct->setBundleSelectionsData($bundleSelections);
        $bundleProduct->save();
    } catch (Exception $e) {
        Mage::log($e->getMessage(), null, 'scripts.log');
    }
}
Mage::log('Ended data-upgrade-0.1.5', null, 'scripts.log');