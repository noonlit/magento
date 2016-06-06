<?php

/**
 * Add a new configurable product in category women/dresses 
 * Configurable attributes:
 *      color: red, blue, black 
 *      size: XS, S, M, L
 *      lentgth: knee length, long, short
 */
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

// add simple products
$configuration = array(
    'color' => array('red', 'blue', 'black'),
    'size' => array('XS', 'S', 'M', 'L'),
    'length' => array('knee length', 'long', 'short')
);

$simpleProducts = [];
foreach ($configuration['color'] as $color) {
    foreach ($configuration['size'] as $size) {
            foreach ($configuration['length'] as $length) {
                $simpleProduct = Mage::getModel('catalog/product');
                $sku = 'ilinca-dress' . '-' . $color . '-' . $size . '-' . $length . '-' . '000';
                $name = 'ilinca-dress' . '-' . $color . '-' . $size . '-' . $length;
                $colorId = $simpleProduct->getResource()->getAttribute("color")->getSource()->getOptionId(ucfirst($color));
                $sizeId = $simpleProduct->getResource()->getAttribute("size")->getSource()->getOptionId(strtoupper($size));
                $lengthId = $simpleProduct->getResource()->getAttribute("length")->getSource()->getOptionId(ucwords($length));
                $is_in_stock = 1;
                if ($length === 'long' || $length === 'short' ||  $size === 'L') {
                    $is_in_stock = 0;
                }

                if (!$simpleProduct->getIdBySku($sku)) {
                    $simpleProduct
                            ->setWebsiteIds(array(1))
                            ->setAttributeSetId(13)
                            ->setTypeId('simple')
                            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE)
                            ->setSku($sku)
                            ->setName($name)
                            ->setCreatedAt(strtotime('now'))
                            ->setDescription('Ilinca Dress long description')
                            ->setShortDescription('Ilinca Dress short description')
                            ->setPrice('150')
                            ->setTaxClassId(2)
                            ->setWeight(500)
                            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                            ->setColor($colorId)
                            ->setSize($sizeId)
                            ->setLength($lengthId)
                            ->setMetaTitle('ilinca-dress meta title')
                            ->setMetaKeywords('')
                            ->setMetaDescription('ilinca-dress meta description')
                            ->setStockData(array(
                                'use_config_manage_stock' => 0,
                                'manage_stock' => 1,
                                'min_sale_qty' => 1,
                                'max_sale_qty' => 2,
                                'is_in_stock' => $is_in_stock,
                                'qty' => 5
                            ))
                            ->setCategoryIds(array(4, 13));

                    $image = 'ilinca-dress' . '-' . $color . '.png';
                    $mediaArray = array(
                        'thumbnail' => $image,
                        'small_image' => $image,
                        'image' => $image
                    );
                    $importDir = Mage::getBaseDir('media') . DS . 'evozon/catalog/product/ilinca-dress/';

                    foreach ($mediaArray as $imageType => $fileName) {
                        $filePath = $importDir . $fileName;
                        if (file_exists($filePath)) {
                            $simpleProduct->addImageToMediaGallery($filePath, $imageType, false);
                        }
                    }

                    $simpleProduct->save();
                    $simpleProducts[] = $simpleProduct;
                }
            }
        }
}

//create configurable product
$configurableProduct = Mage::getModel('catalog/product');
if (!$configurableProduct->getIdBySku('ilincadress13')) {
    $configurableProduct
            ->setWebsiteIds(array(1))
            ->setAttributeSetId(13)
            ->setTypeId('configurable')
            ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
            ->setSku('ilincadress13')
            ->setName('ilinca dress')
            ->setPrice('150')            
            ->setCreatedAt(strtotime('now'))
            ->setDescription('Ilinca Dress long description')
            ->setShortDescription('Ilinca Dress short description')
            ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->setStockData(array(
                'use_config_manage_stock' => 0,
                'manage_stock' => 1,
                'is_in_stock' => 1
            ))
            ->setCategoryIds(array(4, 13));

    // assigning associated product to configurable
    $colorAttributeId = Mage::getModel('eav/entity_attribute')->getIdByCode('catalog_product', 'color');
    $sizeAttributeId = Mage::getModel('eav/entity_attribute')->getIdByCode('catalog_product', 'size');
    $lengthAttributeId = Mage::getModel('eav/entity_attribute')->getIdByCode('catalog_product', 'length');  
    

    $configurableProduct->getTypeInstance()->setUsedProductAttributeIds(array($colorAttributeId, $sizeAttributeId, $lengthAttributeId));    
    $configurableAttributesData = $configurableProduct->getTypeInstance()->getConfigurableAttributesAsArray();

    $configurableProduct->setCanSaveConfigurableAttributes(true);
    $configurableProduct->setConfigurableAttributesData($configurableAttributesData);

    $configurableProductsData = [];
    foreach ($simpleProducts as $simpleProduct) {
        $configurableProductsData[$simpleProduct->getId()] = array(
            0 => array(
                'label' => $simpleProduct->getAttributeText('color'),
                'attribute_id' => $colorAttributeId,
                'value_index' => (int) $simpleProduct->getColor(),
                'is_percent' => 0,
                'pricing_value' => $simpleProduct->getPrice()
            ),
            1 => array(
                'label' => $simpleProduct->getAttributeText('size'),
                'attribute_id' => $sizeAttributeId,
                'value_index' => (int) $simpleProduct->getSize(),
                'is_percent' => 0,
                'pricing_value' => $simpleProduct->getPrice()
            ),
            2 => array(
                'label' => $simpleProduct->getAttributeText('length'),
                'attribute_id' => $lengthAttributeId,
                'value_index' => (int) $simpleProduct->getLength(),
                'is_percent' => 0,
                'pricing_value' => $simpleProduct->getPrice()
            )
        );
    }

    $configurableProduct->setConfigurableProductsData($configurableProductsData);    
    $configurableProduct->save();
}


        