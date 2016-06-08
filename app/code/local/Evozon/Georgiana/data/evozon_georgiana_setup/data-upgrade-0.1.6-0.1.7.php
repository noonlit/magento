<?php



$date = new DateTime();

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$productModel = Mage::getModel('catalog/product');

    $productModel
            ->setWebsiteIds(array(1))
            ->setStoreId(1)
            ->setAttributeSetId(10)
            ->setTypeId('downloadable')
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setSku('downloadableSku')
            ->setName('My downloadable product')
            ->setCreatedAt(strtotime('now'))
            ->setDescription('the best description')
            ->setShortDescription('wow')
            ->setPrice(30)
            ->setTaxClassId(0)
            ->setLinksTitle('Download')
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setStockData(array(
                'use_config_manage_stock' => 1,
                'manage_stock' => 1,
                'min_sale_qty' => 1,
                'max_sale_qty' => 1,
                'is_in_stock' => 1,
                'qty' => 100
            ))
            ->setCategoryIds(array(10));
    
    $downloadableData = array(
        'has_options' => '1',
        'required_options' => '1',
        'links_title' => 'Download links',
        'links_purchased_separately' => '1',
        'links_exist' => '1'
    );
    
    foreach($downloadableData as $key => $value) {
        $productModel->setData($key, $value);
    } 
    
    $productModel->save();
    
    $linkModel = Mage::getModel('downloadable/link')
            ->setProductId($productModel->getId())      
            ->setNumberOfDownloads('0')
            ->setIsShareable('0')
            ->setTitle('Download links')
            ->setDefaultTitle('Download links')
            ->setLinkUrl('')
            ->setLinkType('file')
            ->setLinkFile('/evozon/product.txt')
            ->save();



