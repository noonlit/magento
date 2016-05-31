<?php

/**
 * Populate tables with data version 0.1.1
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
        'text' => 'Look TV'
    ),
    array(
        'created_at' => NOW(),
        'updated_at' => NOW(),
        'text' => 'Animal Planet'
    ),
    array(
        'created_at' => NOW(),
        'updated_at' => NOW(),
        'text' => 'Discovery'
    ),
);

$installer->getConnection()->insertMultiple($installer->getTable('evozon_bogdan_catalog/bannertable'), $bannersData);

$category = Mage::getModel("catalog/category");

$connectionsData = array(
    array(
        'category_id' => $category->load(4)->getId(),
        'banner_id' => 3
    ),
    array(
        'category_id' => $category->load(5)->getId(),
        'banner_id' => 3
    ),
    array(
        'category_id' => $category->load(5)->getId(),
        'banner_id' => 4
    ),
    array(
        'category_id' => $category->load(5)->getId(),
        'banner_id' => 5
    ),
    array(
        'category_id' => $category->load(6)->getId(),
        'banner_id' => 5
    ),
);

$installer->getConnection()->insertMultiple($installer->getTable('evozon_bogdan_catalog/bannercategoryconnection'), $connectionsData);
