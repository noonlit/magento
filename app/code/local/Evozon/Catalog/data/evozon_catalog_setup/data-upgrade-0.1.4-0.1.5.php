<?php
/**
 * add a bundle product (Nikon)
 * Options are:
 *      - resolution: 20 MP, 25 MP
 *      - memory: 1GB, 1.5GB
 *      - shutter 4 fps , 6 fps
 *      - display: 3', 4'
 */


Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
$storeId = Mage::app()->getStore('default')->getId();
// add products to associate to bundle product
$productOptions = array(
    'resolution' => array('20MP', '25MP'),
    'memory' => array('1GB', '1.5GB'),
    'shutter' => array('4fps', '6fps'),
    'display' => array('3', '4')
);
// add resolution products
$resolutionProducts = [];
$resolutionPrice = array(
    $productOptions['resolution'][0] => '100',
    $productOptions['resolution'][1] => '120',);
   
foreach ($productOptions['resolution'] as $resolution) {  
    $resolutionSimpleProduct = Mage::getModel('catalog/product');
    $sku = 'resolution' . '-' . $resolution;
    $name = $resolution;
    $price = $resolutionPrice[$resolution];
    if (!$resolutionSimpleProduct->getIdBySku($sku)) {
        $resolutionSimpleProduct
                ->setWebsiteIds(array(Mage::app()->getStore($storeId)->getWebsiteId()))
                ->setAttributeSetId(14)
                ->setTypeId('simple')
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                ->setSku($sku)
                ->setName($name)
                ->setCreatedAt(strtotime('now'))
                ->setDescription('resolution long description')
                ->setShortDescription('resolution short description')
                ->setPrice($price)
                ->setTaxClassId(2)
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setMetaTitle('resolution meta title')
                ->setMetaKeywords('')
                ->setMetaDescription('resolution meta description')
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
    $resolutionSimpleProduct->save();
    $processorProducts[] = $resolutionSimpleProduct;
}
// add memory products
$memoryProducts = [];
$memoryPrice = array(
    $productOptions['memory'][0] => '50',
    $productOptions['memory'][1] => '25',);
  
foreach ($productOptions['memory'] as $memory) {
    $memorySimpleProduct = Mage::getModel('catalog/product');
    $sku = 'memory' . '-' . $memory;
    $name = 'system memory' . '-' . $memory;
    $price = $memoryPrice[$memory];
    if (!$memorySimpleProduct->getIdBySku($sku)) {
        $memorySimpleProduct
                ->setWebsiteIds(array(Mage::app()->getStore($storeId)->getWebsiteId()))
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
// add shutter products
$shutterProducts = [];
$shutterPrice = array(
    $productOptions['shutter'][0] => '40',
    $productOptions['shutter'][1] => '60'
);
foreach ($productOptions['shutter'] as $shutter) {
    $shutterSimpleProduct = Mage::getModel('catalog/product');
    $sku = 'shutter' . '-' . $shutter;
    $name = 'shutter' . '-' . $shutter;
    $price = $shutterPrice[$shutter];
    if (!$shutterSimpleProduct->getIdBySku($sku)) {
        $shutterSimpleProduct
                ->setWebsiteIds(array(Mage::app()->getStore($storeId)->getWebsiteId()))
                ->setAttributeSetId(14)
                ->setTypeId('simple')
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                ->setSku($sku)
                ->setName($name)
                ->setCreatedAt(strtotime('now'))
                ->setDescription('shutter long description')
                ->setShortDescription('shutter short description')
                ->setPrice($price)
                ->setTaxClassId(2)
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->setMetaTitle('shutter meta title')
                ->setMetaKeywords('')
                ->setMetaDescription('shutter meta description')
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
    $shutterSimpleProduct->save();
    $shutterProducts[] = $shutterSimpleProduct;
}
//add display products
$displayProducts = [];
$displayPrice = array(
    $productOptions['display'][0] => '30',
    $productOptions['display'][1] => '40',);
    
foreach ($productOptions['display'] as $display) {
    $displaySimpleProduct = Mage::getModel('catalog/product');
    $sku = 'display' . '-' . $display;
    $name = 'display' . '-' . $display . "'";
    $price = $displayPrice[$display];
    if (!$displaySimpleProduct->getIdBySku($sku)) {
        $displaySimpleProduct
                ->setWebsiteIds(array(Mage::app()->getStore($storeId)->getWebsiteId()))
                ->setAttributeSetId(14)
                ->setTypeId('simple')
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                ->setSku($sku)
                ->setName($name)
                ->setCreatedAt(strtotime('now'))
                ->setDescription('display long description')
                ->setShortDescription('display short description')
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
$sku = 'Onea raul photography';
if (!$bundleProduct->getIdBySku($sku)) {
    $bundleProduct
            ->setWebsiteIds(array(Mage::app()->getStore($storeId)->getWebsiteId()))
            ->setAttributeSetId(14)
            ->setTypeId('bundle')
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setSkuType(1)
            ->setSku($sku)
            ->setName('Onea Raul photo')
            ->setCreatedAt(strtotime('now'))
            ->setDescription('Laptop long description')
            ->setShortDescription('Laptop short description')
            ->setPriceType(0) //dynamic
            ->setPriceView(0) //price range
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setMetaTitle('Photo meta title')
            ->setMetaKeywords('')
            ->setMetaDescription('Photo meta description')
            ->setStockData(array(
                'use_config_manage_stock' => 1,
                'manage_stock' => 1,
                'is_in_stock' => 1
            ))
            ->setCategoryIds(array(24));
    
    $bundleOptions = array(
        0 => array(
            'title' => 'resolution',
            'option_id' => '',
            'delete' => '',
            'type' => 'select',
            'required' => 1,
            'position' => 0
        ),
        1 => array(
            'title' => 'memory',
            'option_id' => '',
            'delete' => '',
            'type' => 'select',
            'required' => 1,
            'position' => 1
        ),
        2 => array(
            'title' => 'shutter',
            'option_id' => '',
            'delete' => '',
            'type' => 'select',
            'required' => 1,
            'position' => 2
        ),
        3 => array(
            'title' => 'display',
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
            case('resolution'):
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
            case('shutter'):
                foreach ($shutterProducts as $product) {
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