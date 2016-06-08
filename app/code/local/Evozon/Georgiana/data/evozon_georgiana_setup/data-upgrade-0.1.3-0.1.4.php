<?php
try{
 $bundleProduct = Mage::getModel('catalog/product');
    $bundleProduct
    ->setStoreId(Mage_Core_Model_App::ADMIN_STORE_ID) 
        ->setWebsiteIds(array(1)) 
        ->setAttributeSetId(20) 
        ->setTypeId('bundle') 
        ->setCreatedAt(strtotime('now'))
        ->setSkuType(0) 
        ->setSku('BundleSku') //SKU
        ->setName('My Bundle Product') 
        ->setWeightType(0) 
        ->setShipmentType(0) 
        ->setStatus(1) 
        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) 
        ->setManufacturer(28)
        ->setColor(24)
        ->setNewsFromDate('06/01/2016') 
        ->setNewsToDate('06/30/2016') 
        ->setPriceType(0) 
        ->setPriceView(0) 
        ->setSpecialPrice(80.00) 
        ->setSpecialFromDate('06/1/2016') 
        ->setSpecialToDate('06/15/2016') 
        ->setDescription('This is the best description')
        ->setShortDescription('wow')
        ->setStockData(array(
                'use_config_manage_stock' => 1, 
                'manage_stock' => 1, 
                'is_in_stock' => 1, 
            )
        )
        ->setCategoryIds(array(10)); //assign product to categories
 
    $bundleOptions = array();
    $bundleOptions = array(
        '0' => array( 
            'title' => 'first option', //option title
            'option_id' => '',
            'delete' => '',
            'type' => 'select', 
            'required' => '1', 
            'position' => '1' 
        ),
        '1' => array(
            'title' => 'second option',
            'option_id' => '',
            'delete' => '',
            'type' => 'select',
            'required' => '1',
            'position' => '1'
        )
        

    );
 
    $bundleSelections = array();
    $bundleSelections = array(
        '0' => array( 
            '0' => array( 
                'product_id' => '554', 
                'delete' => '',
                'selection_price_value' => '10',
                'selection_price_type' => 0,
                'selection_qty' => 1,
                'selection_can_change_qty' => 0,
                'position' => 0,
                'is_default' => 1
            ),
 
            '1' => array(
                'product_id' => '553',
                'delete' => '',
                'selection_price_value' => '10',
                'selection_price_type' => 0,
                'selection_qty' => 1,
                'selection_can_change_qty' => 0,
                'position' => 0,
                'is_default' => 1
            )
        ),
        '1' => array( //option ID
            '0' => array(
                'product_id' => '552',
                'delete' => '',
                'selection_price_value' => '10',
                'selection_price_type' => 0,
                'selection_qty' => 1,
                'selection_can_change_qty' => 0,
                'position' => 0,
                'is_default' => 1
            ),
 
            '1' => array(
                'product_id' => '551',
                'delete' => '',
                'selection_price_value' => '10',
                'selection_price_type' => 0,
                'selection_qty' => 1,
                'selection_can_change_qty' => 0,
                'position' => 0,
                'is_default' => 1
            ),
            '2' => array(
                'product_id' => '549',
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
    Mage::register('product', $bundleProduct);
 
    //setting the bundle options and selection data
    $bundleProduct->setBundleOptionsData($bundleOptions);
    $bundleProduct->setBundleSelectionsData($bundleSelections);
 
    $bundleProduct->save();
    echo 'success';
}
catch (Exception $e) {
    Mage::log($e->getMessage());
    echo $e->getMessage();
}