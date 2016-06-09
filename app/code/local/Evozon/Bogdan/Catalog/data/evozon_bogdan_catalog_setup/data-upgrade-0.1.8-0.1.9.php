<?php

/**
 * Add a downloadable product data version 0.1.9
 * 
 * @category Evozon
 * @package Evozon_Bogdan_Catalog
 * @copyright (c) year, Haidu Bogdan
 * @author Haidu Bogdan <branch bogdan of noonlit/magento> git
 */
//calling the attributes helper to get the attributeSetId
$helper = Mage::helper('evozon_bogdan_catalog/attributes');
//find clothing attribute_set_id
$attributeSetId = $helper->getAttributeSetId('Default');

//setting the image name
$image = 'book-01.png';
$mediaArray = array(
    'thumbnail' => $image,
    'small_image' => $image,
    'image' => $image
);

//setting the image path
$importDir = Mage::getBaseDir('skin') . DS . 'frontend' .
        DS . 'evozon_bogdan' . DS . 'evozon-theme' . DS .
        'images' . DS . 'media' . DS . 'catalog' . DS . 'product' . DS . 'books' . DS;


$sku = "bk-mage-down-01";
//link title
$linkTitle = 'PHP Magento';
$test_product = Mage::getModel('catalog/product');
$product = Mage::getModel('catalog/product');

if ($test_product->getIdBySku($sku)) {
    //Magento settings to allow saving changes
    Mage::app()->setUpdateMode(false);
    Mage::app()->setCurrentStore(0); //this redirects to the admin page
    $product->load($test_product->getIdBySku($sku));
} else {
    $product->setSku($sku);
}

$categoriesHelper = Mage::helper('evozon_bogdan_catalog/categories');
//finding the subcategory and category ids for women with 'clothing' eav_attribute_set
$categoriesIds = $categoriesHelper->getCategoriestId('Home & Decor', 'Books & Music');

//check for duplicate
$product->setName("Magento Book");
$product->setDescription("a good PHP Magento Developer Book");
$product->setShortDescription("php magento developer book.");
$product->setTypeId('downloadable');
$product->setStoreId(0);
$product->setAttributeSetId($product->getDefaultAttributeSetId()); // need to look this up
$product->setCategoryIds($categoriesIds); // need to look these up
$product->setWeight(1.0);
$product->setTaxClassId(2); // taxable goods
$product->setVisibility(4); // catalog, search
$product->setStatus(1); // enabled
$product->setHasOptions("1");
$product->setRequiredOptions("1");
$product->setData('links_title', $linkTitle);
$product->setData('links_purchased_separately', 1);
$product->setData('links_exist', 1);
//assign the product a color

$product->setPrice(10);
// assign product to the default website
$product->setWebsiteIds(array(1));

//add image to product
foreach ($mediaArray as $imageType => $fileName) {
    $filePath = $importDir . $fileName;
    if (file_exists($filePath)) {
        $product->addImageToMediaGallery($filePath, $imageType, false);
    }
}

$stockData = $product->getStockData();
$stockData['qty'] = 2;
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


//setting downloadable link path
$fileName = 'Magento PHP Developer\'s Guide.pdf';

$linkImportDir = Mage::getBaseDir('skin') . DS . 'frontend' .
        DS . 'evozon_bogdan' . DS . 'evozon-theme' . DS .
        'downloadable' . DS . 'files' . DS . 'links' . DS . 'magento';

$newLinkDir = Mage::getBaseDir('media') . DS . 'downloadable' .
        DS . 'files' . DS . 'links' . DS . 'magento';

//copying the file we need to link with in the original magento media file folder
if (!file_exists($newLinkDir . DS . $fileName)) {
    mkdir($newLinkDir, 0777);
    if (!copy($linkImportDir . DS . $fileName, $newLinkDir . DS . $fileName)) {
        echo "failed to copy $fileName...\n";
    }
}

//check if the product already has links, we admit only one link
$links = $product->getTypeInstance(true)->getLinks($product);
if ($links) {
    foreach ($product->getTypeInstance(true)->getLinks($product) as $link) {
        $link->setProductId($product->getId());
        linkSettings($link, $linkTitle, $fileName); //sets the link attributes
        $link->save();
    }
} else {//check if there already is a link 
    $linkTitleExists = false;
    $linkModel = Mage::getModel('downloadable/link');
    $allLinks = $linkModel->getCollection()->addTitleToResult();

    foreach ($allLinks as $link) {
        if ($link->getTitle() == $linkTitle) {
            $linkTitleExists = true;
            $link->setProductId($product->getId());
            $link->save();
        }
    }
    if (!$linkTitleExists) {
        $newLinkModel = Mage::getModel('downloadable/link');
        $newLinkModel->setProductId($product->getId());
        linkSettings($newLinkModel, $linkTitle, $fileName); //sets the link attributes
        $newLinkModel->save();
    }
}

//sets the link attributes
function linkSettings($linkModel, $linkTitle, $fileName)
{
    $linkModel
            ->setStoreId('0')
            ->setNumberOfDownloads('0')
            ->setLinkUrl('null')
            ->setIsShareable('2')
            ->setLinkType('file')
            ->setTitle($linkTitle)
            ->setStoreTitle($linkTitle)
            ->setDefaultTitle($linkTitle)
            ->setLinkTitle($linkTitle)
            ->setLinkFile(DS . 'magento' . DS . $fileName);
}
