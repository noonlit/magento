<?php

/**
 * add a bundle product (laptop)
 * Options are:
 *      - processor: Intel Core i3, Intel Core i5, Intel Core i7
 *      - system memory: 2GB, 4GB, 8GB
 *      - HDD: 500GB, 1TB
 *      - display: 12', 15', 17'
 */
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

// add products to associate to bundle product
$productOptions = array(
    'processor' => array('Intel Core i3', 'IntelCore i5', 'IntelCore i7'),
    'memory' => array('2GB', '4GB', '8GB'),
    'hdd' => array('500GB', '1TB'),
    'display' => array('12', '15', '17')
);

// add processor products
$processorProducts = [];
$processorPrice = array(
    $productOptions['processor'][0] => '79.56',
    $productOptions['processor'][1] => '120.9',
    $productOptions['processor'][2] => '245.70');

foreach ($productOptions['processor'] as $processor) {  
    $processorSimpleProduct = Mage::getModel('catalog/product');
    $sku = 'processor' . '-' . $processor;
    $name = $processor;
    $price = $processorPrice[$processor];
    if (!$processorSimpleProduct->getIdBySku($sku)) {
        $processorSimpleProduct
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(14)
                ->setTypeId('simple')
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                ->setSku($sku)
                ->setName($name)
                ->setCreatedAt(strtotime('now'))
                ->setDescription('Processor long description')
                ->setShortDescription('Processor short description')
                ->setPrice($price)
                ->setTaxClassId(2)
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setMetaTitle('processor meta title')
                ->setMetaKeywords('')
                ->setMetaDescription('processor meta description')
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 1,
                    'is_in_stock' => 1,
                    'qty' => 30
                ))
                ->setCategoryIds(array(24));
    }
    $processorSimpleProduct->save();
    $processorProducts[] = $processorSimpleProduct;
}

// add memory products
$memoryProducts = [];
$memoryPrice = array(
    $productOptions['memory'][0] => '53.5',
    $productOptions['memory'][1] => '89.2',
    $productOptions['memory'][2] => '110.6');

foreach ($productOptions['memory'] as $memory) {
    $memorySimpleProduct = Mage::getModel('catalog/product');
    $sku = 'memory' . '-' . $memory;
    $name = 'system memory' . '-' . $memory;
    $price = $memoryPrice[$memory];
    if (!$memorySimpleProduct->getIdBySku($sku)) {
        $memorySimpleProduct
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(14)
                ->setTypeId('simple')
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                ->setSku($sku)
                ->setName($name)
                ->setCreatedAt(strtotime('now'))
                ->setDescription('Memory long description')
                ->setShortDescription('Memory short description')
                ->setPrice($price)
                ->setTaxClassId(2)
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setMetaTitle('memory meta title')
                ->setMetaKeywords('')
                ->setMetaDescription('memory meta description')
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 1,
                    'is_in_stock' => 1,
                    'qty' => 20
                ))
                ->setCategoryIds(array(24));
    }
    $memorySimpleProduct->save();
    $memoryProducts[] = $memorySimpleProduct;
}

// add HDD products
$hddProducts = [];
$hddPrice = array(
    $productOptions['hdd'][0] => '150',
    $productOptions['hdd'][1] => '170'
);

foreach ($productOptions['hdd'] as $hdd) {
    $hddSimpleProduct = Mage::getModel('catalog/product');
    $sku = 'hdd' . '-' . $hdd;
    $name = 'HDD' . '-' . $hdd;
    $price = $hddPrice[$hdd];
    if (!$hddSimpleProduct->getIdBySku($sku)) {
        $hddSimpleProduct
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(14)
                ->setTypeId('simple')
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                ->setSku($sku)
                ->setName($name)
                ->setCreatedAt(strtotime('now'))
                ->setDescription('HDD long description')
                ->setShortDescription('HDD short description')
                ->setPrice($price)
                ->setTaxClassId(2)
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setMetaTitle('HDD meta title')
                ->setMetaKeywords('')
                ->setMetaDescription('HDD meta description')
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 1,
                    'is_in_stock' => 1,
                    'qty' => 10
                ))
                ->setCategoryIds(array(24));
    }
    $hddSimpleProduct->save();
    $hddProducts[] = $hddSimpleProduct;
}

//add display products
$displayProducts = [];
$displayPrice = array(
    $productOptions['display'][0] => '86',
    $productOptions['display'][1] => '150',
    $productOptions['display'][2] => '230');

foreach ($productOptions['display'] as $display) {
    $displaySimpleProduct = Mage::getModel('catalog/product');
    $sku = 'display' . '-' . $display;
    $name = 'display' . '-' . $display . "'";
    $price = $displayPrice[$display];
    if (!$displaySimpleProduct->getIdBySku($sku)) {
        $displaySimpleProduct
                ->setWebsiteIds(array(1))
                ->setAttributeSetId(14)
                ->setTypeId('simple')
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                ->setSku($sku)
                ->setName($name)
                ->setCreatedAt(strtotime('now'))
                ->setDescription('Display long description')
                ->setShortDescription('Display short description')
                ->setPrice($price)
                ->setTaxClassId(2)
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setMetaTitle('display meta title')
                ->setMetaKeywords('')
                ->setMetaDescription('display meta description')
                ->setStockData(array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'min_sale_qty' => 1,
                    'max_sale_qty' => 1,
                    'is_in_stock' => 1,
                    'qty' => 10
                ))
                ->setCategoryIds(array(24));
    }
    $displaySimpleProduct->save();
    $displayProducts[] = $displaySimpleProduct;
}


//create bundle product
$bundleProduct = Mage::getModel('catalog/product');
$sku = 'ilinca-laptop-000';
if (!$bundleProduct->getIdBySku($sku)) {
    $bundleProduct
            ->setWebsiteIds(array(1))
            ->setAttributeSetId(14)
            ->setTypeId('bundle')
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setSkuType(1)
            ->setSku($sku)
            ->setName('ilinca laptop')
            ->setCreatedAt(strtotime('now'))
            ->setDescription('Laptop long description')
            ->setShortDescription('Laptop short description')
            ->setPriceType(0) //dynamic
            ->setPriceView(0) //price range
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setMetaTitle('laptop meta title')
            ->setMetaKeywords('')
            ->setMetaDescription('laptop meta description')
            ->setStockData(array(
                'use_config_manage_stock' => 1,
                'manage_stock' => 1,
                'is_in_stock' => 1
            ))
            ->setCategoryIds(array(24));

    $mediaArray = array(
        'thumbnail' => 'ilinca-laptop.jpg',
        'small_image' => 'ilinca-laptop.jpg',
        'image' => 'ilinca-laptop.jpg',
    );

    $importDir = Mage::getBaseDir('media') . DS . 'evozon/catalog/product/bundle/';

    foreach ($mediaArray as $imageType => $fileName) {
        $filePath = $importDir . $fileName;
        if (file_exists($filePath)) {
            $bundleProduct->addImageToMediaGallery($filePath, $imageType, false);
        }
    }

    $bundleOptions = array(
        0 => array(
            'title' => 'Processor',
            'option_id' => '',
            'delete' => '',
            'type' => 'select',
            'required' => 1,
            'position' => 0
        ),
        1 => array(
            'title' => 'System Memory',
            'option_id' => '',
            'delete' => '',
            'type' => 'select',
            'required' => 1,
            'position' => 1
        ),
        2 => array(
            'title' => 'HDD',
            'option_id' => '',
            'delete' => '',
            'type' => 'select',
            'required' => 1,
            'position' => 2
        ),
        3 => array(
            'title' => 'Display',
            'option_id' => '',
            'delete' => '',
            'type' => 'select',
            'required' => 1,
            'position' => 3
        )
    );

    $bundleSelections = [];
    $optionCount = 0;
    foreach ($productOptions as $optionName => $options) {
        switch ($optionName) {
            case('processor'):
                foreach ($processorProducts as $product) {
                    $bundleSelections[$optionCount][] = array(
                        'product_id' => $product->getId(),
                        'delete' => '',
                        'selection_price_value' => $product->getPrice(),
                        'selection_price_type' => 1,
                        'selection_quantity' => 1,
                        'selection_can_change_qty' => 0,
                        'position' => 0,
                        'is_default' => 1
                    );
                }
                break;
            case('memory'):
                foreach ($memoryProducts as $product) {
                    $bundleSelections[$optionCount][] = array(
                        'product_id' => $product->getId(),
                        'delete' => '',
                        'selection_price_value' => $product->getPrice(),
                        'selection_price_type' => 1,
                        'selection_quantity' => 1,
                        'selection_can_change_qty' => 0,
                        'position' => 1,
                        'is_default' => 1
                    );
                }
                break;
            case('hdd'):
                foreach ($hddProducts as $product) {
                    $bundleSelections[$optionCount][] = array(
                        'product_id' => $product->getId(),
                        'delete' => '',
                        'selection_price_value' => $product->getPrice(),
                        'selection_price_type' => 1,
                        'selection_quantity' => 1,
                        'selection_can_change_qty' => 0,
                        'position' => 2,
                        'is_default' => 1
                    );
                }
                break;
            case('display'):
                foreach ($displayProducts as $product) {
                    $bundleSelections[$optionCount][] = array(
                        'product_id' => $product->getId(),
                        'delete' => '',
                        'selection_price_value' => $product->getPrice(),
                        'selection_price_type' => 1,
                        'selection_quantity' => 1,
                        'selection_can_change_qty' => 0,
                        'position' => 3,
                        'is_default' => 1
                    );
                }
                break;
        }
        $optionCount ++;
    }

    $bundleProduct->setCanSaveCustomOptions(true);
    $bundleProduct->setCanSaveBundleSelections(true);
    $bundleProduct->setAffectBundleProductSelections(true);

    Mage::register('product', $bundleProduct);

    $bundleProduct->setBundleOptionsData($bundleOptions);
    $bundleProduct->setBundleSelectionsData($bundleSelections);

    $bundleProduct->save();
    Mage::log($bundleSelections);
}
