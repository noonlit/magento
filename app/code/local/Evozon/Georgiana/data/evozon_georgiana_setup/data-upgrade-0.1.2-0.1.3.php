<?php

$configProduct = Mage::getModel('catalog/product');
try {
$configProduct
//    ->setStoreId(1) //you can set data in store scope
        ->setWebsiteIds(array(1)) //website ID the product is assigned to, as an array
        ->setAttributeSetId(20) //ID of a attribute set named 'default'
        ->setTypeId('configurable') //product type
        ->setCreatedAt(strtotime('now')) //product creation time
//    ->setUpdatedAt(strtotime('now')) //product update time
        ->setSku('mySkuConfig') //SKU
        ->setName('my configurable product') //product name
        ->setWeight(400)
        ->setStatus(1) //product status (1 - enabled, 2 - disabled)
        ->setTaxClassId(4) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
        ->setManufacturer(28) //manufacturer id
        ->setNewsFromDate('06/01/2016') //product set as new from
        ->setNewsToDate('06/30/2016') //product set as new to
        ->setCountryOfManufacture('AF') //country of manufacture (2-letter country code)
        ->setPrice(80) //price in form 11.22
        ->setCost(75) //price in form 11.22
        ->setSpecialPrice(69) //special price in form 11.22
        ->setSpecialFromDate('06/1/2016') //special price from (MM-DD-YYYY)
        ->setSpecialToDate('06/30/2016') //special price to (MM-DD-YYYY)
        ->setMsrpEnabled(1) //enable MAP
        ->setMsrpDisplayActualPriceType(1) //display actual price (1 - on gesture, 2 - in cart, 3 - before order confirmation, 4 - use config)
        ->setMsrp(99.99) //Manufacturer's Suggested Retail Price
        ->setMetaTitle('my config meta title')
        ->setMetaKeyword('meta keyword')
        ->setMetaDescription('my meta description')
        ->setDescription('This is the best description')
        ->setShortDescription('the best description')
        ->setStockData(array(
                'use_config_manage_stock' => 0, //'Use config settings' checkbox
                'manage_stock' => 1, //manage stock
                'is_in_stock' => 1, //Stock Availability
            )
        )
        ->setCategoryIds(array(10)) //assign product to categories
    ;
    /**/
    /** assigning associated product to configurable */
    /**/
    $configProduct->getTypeInstance()->setUsedProductAttributeIds(array(92)); //attribute ID of attribute 'color' in my store
    $configurableAttributesData = $configProduct->getTypeInstance()->getConfigurableAttributesAsArray();
 
    $configProduct->setCanSaveConfigurableAttributes(true);
    $configProduct->setConfigurableAttributesData($configurableAttributesData);
 
    $configurableProductsData = array();
    $configurableProductsData['909'] = array( 
        '0' => array(
            'label' => 'Green', //attribute label
            'attribute_id' => '92', //attribute ID of attribute 'color' in my store
            'value_index' => '24', //value of 'Green' index of the attribute 'color'
            'is_percent' => '0', //fixed/percent price for this option
            'pricing_value' => '21' //value for the pricing
        )
    );
    $configProduct->setConfigurableProductsData($configurableProductsData);
    $configProduct->save();
 
    echo 'success';
} catch (Exception $e) {
    Mage::log($e->getMessage());
    echo $e->getMessage();
}