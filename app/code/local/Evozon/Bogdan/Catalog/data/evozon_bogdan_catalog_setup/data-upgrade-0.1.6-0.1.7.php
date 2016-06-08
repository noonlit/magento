<?php

/**
 * Add a bundled product version 0.1.7
 * 
 * @category Evozon
 * @package Evozon_Bogdan_Catalog
 * @copyright (c) year, Haidu Bogdan
 * @author Haidu Bogdan <branch bogdan of noonlit/magento> git
 */
//calling the attributes helper to get the attributeSetId
$helper = Mage::helper('evozon_bogdan_catalog/attributes');
$attributeSetId = $helper->getAttributeSetId('Electronics');

//finding the subcategory and category ids for women with 'clothing' eav_attribute_set
$categoriesHelper = Mage::helper('evozon_bogdan_catalog/categories');
$categoriesIds = $categoriesHelper->getCategoriestId('Home & Decor', 'Electronics');

//setting the image name
$image = 'laptop-bundle-01.jpg';
$mediaArray = array(
    'thumbnail' => $image,
    'small_image' => $image,
    'image' => $image
);

$test_product = Mage::getModel('catalog/product');

$laptopId=Mage::getModel('catalog/product')->load($test_product->getIdBySku('laptop-01'))->getId();
$standardMouseId=Mage::getModel('catalog/product')->load($test_product->getIdBySku('comp-mouse-01'))->getId();
$wirelessMouseId=Mage::getModel('catalog/product')->load($test_product->getIdBySku('comp-mouse-02'))->getId();

//setting the image path
$importDir = Mage::getBaseDir('skin') . DS . 'frontend' .
        DS . 'evozon_bogdan' . DS . 'evozon-theme' . DS .
        'images' . DS . 'media' . DS . 'catalog' . DS . 'product' . DS . 'laptop' . DS;


$bundleProduct = Mage::getModel('catalog/product');


$sku = 'laptop-bundle-01';

if ($test_product->getIdBySku($sku)) {
    //Magento settings to allow saving
    Mage::app()->setUpdateMode(false);
    Mage::app()->setCurrentStore(0); //this redirects to the admin page
    $bundleProduct->load($test_product->getIdBySku($sku));
} else {
    $bundleProduct->setSku($sku);
}

$bundleProduct
        ->setStoreId(Mage_Core_Model_App::ADMIN_STORE_ID) //you can set data in store scope
        ->setWebsiteIds(array(1)) //website ID the product is assigned to, as an array
        ->setTypeId('bundle') //product type
        ->setAttributeSetId($attributeSetId[0])
        ->setCategoryIds($categoriesIds)
        ->setCreatedAt(strtotime('now')) //product creation time
//    ->setUpdatedAt(strtotime('now')) //product update time
        ->setSkuType(1) //SKU type (0 - dynamic, 1 - fixed)
        ->setName('Laptop Bundle') //product name
        ->setWeightType(0) //weight type (0 - dynamic, 1 - fixed)
//        ->setWeight(4.0000)
        ->setShipmentType(0) //shipment type (0 - together, 1 - separately)
        ->setStatus(1) //product status (1 - enabled, 2 - disabled)
        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
        ->setManufacturer(28) //manufacturer id
        //->setNewsFromDate('06/26/2014') //product set as new from
        // ->setNewsToDate('06/30/2014') //product set as new to
        ->setCountryOfManufacture('AF') //country of manufacture (2-letter country code)
        ->setPriceType(1) //price type (0 - dynamic, 1 - fixed)
        ->setPriceView(0) //price view (0 - price range, 1 - as low as)
        //->setSpecialPrice(0) //special price in form 11.22
        //->setSpecialFromDate('06/1/2014') //special price from (MM-DD-YYYY)
        //->setSpecialToDate('06/30/2014') //special price to (MM-DD-YYYY)
        /* only available if price type is 'fixed' */
       ->setPrice(0) //price, works only if price type is fixed
//        ->setCost(22.33) //price in form 11.22
//        ->setMsrpEnabled(1) //enable MAP
//        ->setMsrpDisplayActualPriceType(1) //display actual price (1 - on gesture, 2 - in cart, 3 - before order confirmation, 4 - use config)
//        ->setMsrp(99.99) //Manufacturer's Suggested Retail Price
        ->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
        /* only available if price type is 'fixed' */
        ->setMetaTitle('test meta title 2')
        ->setMetaKeyword('test meta keyword 2')
        ->setMetaDescription('test meta description 2')
        ->setDescription('A Great Set of Laptop with mouse')
        ->setShortDescription('laptop and mouse')
        ->setStockData(array(
            'use_config_manage_stock' => 1, //'Use config settings' checkbox
            'manage_stock' => 1, //manage stock
            'is_in_stock' => 1, //Stock Availability
                )
);

//add image to product
foreach ($mediaArray as $imageType => $fileName) {
    $filePath = $importDir . $fileName;
    if (file_exists($filePath)) {
        $bundleProduct->addImageToMediaGallery($filePath, $imageType, false);
    }
}

$bundleOptions = array(
    '0' => array(//option id (0, 1, 2, etc)
        'title' => 'item01', //option title
        'option_id' => '',
        'delete' => '',
        'type' => 'select', //option type
        'required' => '1', //is option required
        'position' => '1' //option position
    ),
    '1' => array(
        'title' => 'item02',
        'option_id' => '',
        'delete' => '',
        'type' => 'multi',
        'required' => '1',
        'position' => '1'
    )
);

$bundleSelections = array(
    '0' => array(//option ID
        '0' => array(//selection ID of the option (first product under this option (option ID) would have ID of 0, second an ID of 1, etc)
            'product_id' => $standardMouseId, //if of a product in selection
            'delete' => '',
            'selection_price_value' => 150,
            'selection_price_type' => 0,
            'selection_qty' => 1,
            'selection_can_change_qty' => 0,
            'position' => 0,
            'is_default' => 1
        ),
        '1' => array(
            'product_id' => $wirelessMouseId,
            'delete' => '',
            'selection_price_value' => 200,
            'selection_price_type' => 0,
            'selection_qty' => 1,
            'selection_can_change_qty' => 0,
            'position' => 0,
            'is_default' => 1
        )
    ),
    '1' => array(//option ID
        '0' => array(
            'product_id' => $laptopId,
            'delete' => '',
            'selection_price_value' => 1000,
            'selection_price_type' => 0,
            'selection_qty' => 1,
            'selection_can_change_qty' => 0,
            'position' => 0,
            'is_default' => 1
        ),
    )
);
//flags for saving custom options/selections
$bundleProduct->setCanSaveCustomOptions(true);
$bundleProduct->setCanSaveBundleSelections(true);
$bundleProduct->setAffectBundleProductSelections(true);

//registering a product because of Mage_Bundle_Model_Selection::_beforeSave
if (!$test_product->getIdBySku($sku)) {
    Mage::register('product', $bundleProduct);
    $bundleProduct->setBundleOptionsData($bundleOptions);
    //ADDING BUNDLE SELECTIONS
    $bundleProduct->setBundleSelectionsData($bundleSelections);
}

//final save
try {
    $bundleProduct->save();
    Mage::log('Saved new product', null, 'scripts.log');
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'scripts.log');
}
