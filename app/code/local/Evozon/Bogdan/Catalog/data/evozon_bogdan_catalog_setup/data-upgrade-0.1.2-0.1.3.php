<?php

/**
 * Add simple products for a future bundle product data version 0.1.3
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

//setting the products data
$productsData = array(
    array(
        'sku' => "laptop-01",
        'name' => "Super Laptop",
        'description' => "The best laptop there is",
        'short_description' => "super laptop",
        'price' => '1000',
        'qty' => 3,
        'image' => 'laptop-01.jpg',
    ),
    array(
        'sku' => "comp-mouse-01",
        'name' => "Standard Mouse",
        'description' => "Basic USB Cable Mouse",
        'short_description' => "USB mouse",
        'price' => '100',
        'qty' => 10,
        'image' => 'comp-mouse-01.png',
    ),
    array(
        'sku' => "comp-mouse-02",
        'name' => "Gaming Mouse",
        'description' => "Gaming Wireless Mouse",
        'short_description' => "wireless mouse",
        'price' => '200',
        'qty' => 5,
        'image' => 'comp-mouse-02.png',
    ),
        )
;


//ADDING THE SIMPLE PRODUCTS
foreach ($productsData as $productData) {

//setting the image name
    $image = $productData['image'];
    $mediaArray = array(
        'thumbnail' => $image,
        'small_image' => $image,
        'image' => $image
    );

//setting the image path
    $importDir = Mage::getBaseDir('skin') . DS . 'frontend' .
            DS . 'evozon_bogdan' . DS . 'evozon-theme' . DS .
            'images' . DS . 'media' . DS . 'catalog' . DS . 'product' . DS . 'laptop' . DS;

    $test_product = Mage::getModel('catalog/product');
    $product = Mage::getModel('catalog/product');

//check for duplicate sku
    if ($test_product->getIdBySku($productData['sku'])) { //IF SKU EXISTS
        //Magento settings to allow saving
        Mage::app()->setUpdateMode(false);
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID); //this redirects to the admin page
        $product->load($test_product->getIdBySku($productData['sku']));
    } else { //IF SKU IS NEW
        $product->setSku($productData['sku']);
    }

//assign basic settings
    $product
            ->setName($productData['name'])
            ->setDescription($productData['description'])
            ->setShortDescription($productData['short_description'])
            ->setTypeId('simple')
            ->setAttributeSetId($attributeSetId[0])
            ->setCategoryIds($categoriesIds)
            ->setTaxClassId(2) // taxable goods
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) // catalog, search
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED) // enabled
            ->setCountryOfManufacture('RO')
            ->setWeight(1.0)
    ;
//assign the product a color
    $product->setColor($helper->getProductAttributeId('color', 'Grey'));

    if ($productData['sku'] == 'laptop-01') {
//assign the product laptop type ADDED IN THE INSTALL SCRIPT
        $product->setLaptopType($helper->getProductAttributeId('laptop_type', 'Gaming'));

//assign the product laptop screen size ADDED IN THE INSTALL SCRIPT
        $product->setScreenSize($helper->getProductAttributeId('screen_size', '17 inches'));
    }

    if ($productData['sku'] == 'comp-mouse-01') {
//assign the product mouse type ADDED IN THE INSTALL SCRIPT
        $product->setMouseType($helper->getProductAttributeId('mouse_type', 'Standard'));

//assign the product mouse connection type ADDED IN THE INSTALL SCRIPT
        $product->setConnectionType($helper->getProductAttributeId('connection_type', 'Cable'));
    }

    if ($productData['sku'] == 'comp-mouse-02') {
//assign the product laptop type ADDED IN THE INSTALL SCRIPT
        $product->setMouseType($helper->getProductAttributeId('mouse_type', 'Gaming'));

//assign the product laptop screen size ADDED IN THE INSTALL SCRIPT
        $product->setConnectionType($helper->getProductAttributeId('connection_type', 'Wireless'));
    }


    $product->setPrice($productData['price']);
// assign product to the default website
    $product->setWebsiteIds(array(1));

//add image to product
    foreach ($mediaArray as $imageType => $fileName) {
        $filePath = $importDir . $fileName;
        if (file_exists($filePath)) {
            $product->addImageToMediaGallery($filePath, $imageType, false);
        }
    }

//stock values
    $stockData = $product->getStockData();
    $stockData['qty'] = $productData['qty'];
    $stockData['is_in_stock'] = 1;
    $stockData['manage_stock'] = 1;
    $stockData['use_config_manage_stock'] = 0;
    $product->setStockData($stockData);

//final save
    try {
        $product->save();
        Mage::log('Saved new product', null, 'scripts.log');
    } catch (Exception $e) {
        Mage::log($e->getMessage(), null, 'scripts.log');
    }
}
