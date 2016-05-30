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

$installer->getConnection()->insertMultiple($installer->getTable('evozon_bogdan_catalog/bannertable'), $bannersData);

//TODO CALL THE CATEGORY MODEL AND SELECT CATEGORY ID 

$connectionsData = array(
    array(
        'category_id' => 4,
        'banner_id' => 1
    ),
    array(
        'category_id' => 4,
        'banner_id' => 2
    ),
);

$installer->getConnection()->insertMultiple($installer->getTable('evozon_bogdan_catalog/bannercategoryconnection'), $connectionsData);