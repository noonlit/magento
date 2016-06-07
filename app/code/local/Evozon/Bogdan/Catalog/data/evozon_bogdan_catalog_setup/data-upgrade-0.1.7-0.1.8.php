<?php

//RECREATE CODE AND SIMPLE PRODUCTS SAMPLE

/**
 * Add a bundled product version 0.1.8
 * 
 * @category Evozon
 * @package Evozon_Bogdan_Catalog
 * @copyright (c) year, Haidu Bogdan
 * @author Haidu Bogdan <branch bogdan of noonlit/magento> git
 */


$bundleProduct = Mage::getModel('catalog/product');
$test_product = Mage::getModel('catalog/product');

$sku = 'bundlexx1';

if ($test_product->getIdBySku($sku)) {
    //Magento settings to allow saving
    Mage::app()->setUpdateMode(false);
    Mage::app()->setCurrentStore(0); //this redirects to the admin page
    $bundleProduct->load($test_product->getIdBySku($sku));
} else {
    $bundleProduct->setSku($sku);
}

$bundleProduct->setStoreId(Mage_Core_Model_App::ADMIN_STORE_ID) //you can set data in store scope
        ->setWebsiteIds(array(1)) //website ID the product is assigned to, as an array
        ->setAttributeSetId(14) //ID of a attribute set named 'default'
        ->setTypeId('bundle') //product type
        ->setCreatedAt(strtotime('now')) //product creation time
//    ->setUpdatedAt(strtotime('now')) //product update time
        ->setSkuType(0) //SKU type (0 - dynamic, 1 - fixed)
        ->setName('test bundle product96') //product name
        ->setWeightType(0) //weight type (0 - dynamic, 1 - fixed)
//        ->setWeight(4.0000)
        ->setShipmentType(0) //shipment type (0 - together, 1 - separately)
        ->setStatus(1) //product status (1 - enabled, 2 - disabled)
        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
        ->setManufacturer(28) //manufacturer id
        ->setColor(24)
        //->setNewsFromDate('06/26/2014') //product set as new from
        // ->setNewsToDate('06/30/2014') //product set as new to
        ->setCountryOfManufacture('AF') //country of manufacture (2-letter country code)
        ->setPriceType(0) //price type (0 - dynamic, 1 - fixed)
        ->setPriceView(0) //price view (0 - price range, 1 - as low as)
        ->setSpecialPrice(00.44) //special price in form 11.22
        //->setSpecialFromDate('06/1/2014') //special price from (MM-DD-YYYY)
        //->setSpecialToDate('06/30/2014') //special price to (MM-DD-YYYY)
        /* only available if price type is 'fixed' */
//        ->setPrice(11.22) //price, works only if price type is fixed
//        ->setCost(22.33) //price in form 11.22
//        ->setMsrpEnabled(1) //enable MAP
//        ->setMsrpDisplayActualPriceType(1) //display actual price (1 - on gesture, 2 - in cart, 3 - before order confirmation, 4 - use config)
//        ->setMsrp(99.99) //Manufacturer's Suggested Retail Price
//        ->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
        /* only available if price type is 'fixed' */
        ->setMetaTitle('test meta title 2')
        ->setMetaKeyword('test meta keyword 2')
        ->setMetaDescription('test meta description 2')
        ->setDescription('This is a long description')
        ->setShortDescription('This is a short description')
        ->setMediaGallery(array('images' => array(), 'values' => array())) //media gallery initialization
        ->setStockData(array(
            'use_config_manage_stock' => 1, //'Use config settings' checkbox
            'manage_stock' => 1, //manage stock
            'is_in_stock' => 1, //Stock Availability
                )
        )
        ->setCategoryIds(array(4, 10)); //assign product to categories

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
            'product_id' => '955', //if of a product in selection
            'delete' => '',
            'selection_price_value' => '10',
            'selection_price_type' => 0,
            'selection_qty' => 1,
            'selection_can_change_qty' => 0,
            'position' => 0,
            'is_default' => 1
        ),
        '1' => array(
            'product_id' => '956',
            'delete' => '',
            'selection_price_value' => '10',
            'selection_price_type' => 0,
            'selection_qty' => 1,
            'selection_can_change_qty' => 0,
            'position' => 0,
            'is_default' => 1
        )
    ),
    '1' => array(//option ID
        '0' => array(
            'product_id' => '955',
            'delete' => '',
            'selection_price_value' => '10',
            'selection_price_type' => 0,
            'selection_qty' => 1,
            'selection_can_change_qty' => 0,
            'position' => 0,
            'is_default' => 1
        ),
        '1' => array(
            'product_id' => '956',
            'delete' => '',
            'selection_price_value' => '10',
            'selection_price_type' => 0,
            'selection_qty' => 1,
            'selection_can_change_qty' => 0,
            'position' => 0,
            'is_default' => 1
        )
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
    $bundleProduct->setBundleSelectionsData($bundleSelections);
}
//setting the bundle options and selection data


$bundleProduct->save();
