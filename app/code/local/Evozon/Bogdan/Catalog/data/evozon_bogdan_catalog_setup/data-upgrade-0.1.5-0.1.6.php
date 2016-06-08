<?php

/**
 * Add a grouped product version 0.1.6
 * 
 * @category Evozon
 * @package Evozon_Bogdan_Catalog
 * @copyright (c) year, Haidu Bogdan
 * @author Haidu Bogdan <branch bogdan of noonlit/magento> git
 */
//calling the attributes helper to get the attributeSetId
$helper = Mage::helper('evozon_bogdan_catalog/attributes');
//find clothing attribute_set_id
$attributeSetId = $helper->getAttributeSetId('Accessories');

$categoriesHelper = Mage::helper('evozon_bogdan_catalog/categories');
//finding the subcategory and category ids for women with 'clothing' eav_attribute_set
$categoriesIds = $categoriesHelper->getCategoriestId('Accessories', 'Jewelry');

//values for simple products
$groupedProduct = array(
    "furculita" => array("name" => "Fork",
        "sku" => "furc1",
        "description" => "Fork made from silver from Spain",
        "short_description" => "classic fork",
        "image" => 'fork-01.png',
        "url_key" => 'fork',
        "price" => 100,
    ),
    "lingura" => array("name" => "Spoun",
        "sku" => "ling1",
        "description" => "Spoun made from silver from Spain",
        "short_description" => "classic spoun",
        "image" => 'spoun-01.jpeg',
        "url_key" => 'spoun',
        "price" => 100,
    ),
    "cutit" => array("name" => "Eating knife",
        "sku" => "cutit1",
        "description" => "Knife made from silver from Spain",
        "short_description" => "classic eating knife",
        "image" => 'knife-01.jpeg',
        "url_key" => 'knife',
        "price" => 150,
    ),
);

$simpleProductId = array();

//setting the image path
$importDir = Mage::getBaseDir('skin') . DS . 'frontend' .
        DS . 'evozon_bogdan' . DS . 'evozon-theme' . DS .
        'images' . DS . 'media' . DS . 'catalog' . DS . 'product' . DS . 'cutlery' . DS;

foreach ($groupedProduct as $productElement => $productValues) {

    if (is_array($productValues)) {
        $test_product = Mage::getModel('catalog/product');
        $product = Mage::getModel('catalog/product');

        if ($test_product->getIdBySku($productValues['sku'])) {
            //Magento settings to allow saving
            Mage::app()->setUpdateMode(false);
            Mage::app()->setCurrentStore(0); //this redirects to the admin page
            $product->load($test_product->getIdBySku($productValues['sku']));
        } else {
            $product->setSku($productValues['sku']);
        }
        $product->setName($productValues['name']);
        $product->setDescription($productValues['description']);
        $product->setShortDescription($productValues['short_description']);
        $product->setPrice($productValues['price']);
        $product->setTypeId('simple');
        $product->setAttributeSetId($attributeSetId[0]); // need to look this up
        $product->setCategoryIds($categoriesIds); // need to look these up
        $product->setWeight(1.0);
        $product->setTaxClassId(2); // taxable goods
        $product->setVisibility(4); // search
        $product->setStatus(1); // enabled
        //assign the product a material
        $product->setMaterial($helper->getProductAttributeId('material', 'Sterling Silver'));
        // assign product to the default website
        $product->setWebsiteIds(array(1));
        $urlKey = $productValues['url_key'];
        $product->setData('url_key', $urlKey);
        $product->setData('url_path', $urlKey . '.html');
        //setting the image name
        $image = $productValues['image'];
        $mediaArray = array(
            'thumbnail' => $image,
            'small_image' => $image,
            'image' => $image
        );

        //add image to product
        foreach ($mediaArray as $imageType => $fileName) {
            $filePath = $importDir . $fileName;
            if (file_exists($filePath)) {
                $product->addImageToMediaGallery($filePath, $imageType, false);
            }
        }

        $stockData = $product->getStockData();
        $stockData['qty'] = 5;
        $stockData['is_in_stock'] = 1;
        $stockData['manage_stock'] = 1;
        $stockData['use_config_manage_stock'] = 0;
        $product->setStockData($stockData);

        $product->save();
        $simpleProductId[] = $product->getId();
    }
}

$sku = 'cutlery-grouped';
$title = 'Cutlery';
$description = 'Set of silver knife,fork and spoun';

$product = Mage::getModel('catalog/product');

if ($test_product->getIdBySku($sku)) {
    //Magento settings to allow saving
    Mage::app()->setUpdateMode(false);
    Mage::app()->setCurrentStore(0); //this redirects to the admin page
    $product->load($test_product->getIdBySku($sku));
} else {
    $product->setSku($sku);
}
$product->setAttributeSetId($attributeSetId[0]); // put your attribute set id here.
$product->setTypeId('grouped');
$product->setName($title);
$product->setCategoryIds($categoriesIds); // put your category ids here
$product->setWebsiteIds(array(1));
$product->setDescription($description);
$product->setShortDescription($description);
//$product->setPrice(1000);
$product->setWeight(200);
$product->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH);
$product->setStatus(1);
$product->setTaxClassId(0);

//setting the image name
$image = 'cutlery-01.jpg';
$mediaArray = array(
    'thumbnail' => $image,
    'small_image' => $image,
    'image' => $image
);

//add image to product
foreach ($mediaArray as $imageType => $fileName) {
    $filePath = $importDir . $fileName;
    if (file_exists($filePath)) {
        $product->addImageToMediaGallery($filePath, $imageType, false);
    }
}

$product->setStockData(array(
    'is_in_stock' => 1,
    'manage_stock' => 0,
    'use_config_manage_stock' => 1
));

try {
// Save the grouped product.
    $product->save();
    $group_product_id = $product->getId();

    $products_links = Mage::getModel('catalog/product_link_api');

// Map each associate product with the grouped product.
    foreach ($simpleProductId as $id) {
        $products_links->assign("grouped", $group_product_id, $id);
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
