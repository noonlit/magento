<?php

/**
 * Populate tables with data
 * 
 * @category Evozon
 * @package Evozon_Bogdan_Catalog
 * @copyright (c) year, Haidu Bogdan
 * @author Haidu Bogdan <branch bogdan of noonlit/magento> git
 */
$installer = $this;

$bannersData = array(
    array(
        'created_at' => NOW(),
        'updated_at' => NOW(),
        'text' => 'This is banner 1'
    ),
    array(
        'created_at' => NOW(),
        'updated_at' => NOW(),
        'text' => 'This is banner 2'
    ),
);

$installer->getConnection()->insertMultiple($installer->getTable('evozon_bogdan_catalog/banner'), $bannersData);

$category = Mage::getModel("catalog/category");

$connectionsData = array(
    array(
        'category_id' => $category->load(1)->getId(),
        'banner_id' => 1
    ),
    array(
        'category_id' => $category->load(2)->getId(),
        'banner_id' => 2
    ),
);

$installer->getConnection()->insertMultiple($installer->getTable('evozon_bogdan_catalog/bannercategoryconnection'), $connectionsData);
