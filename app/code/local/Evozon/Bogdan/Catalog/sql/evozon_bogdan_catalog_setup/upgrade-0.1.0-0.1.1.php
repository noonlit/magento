<?php

/**
 * Add Banner options for catalog category
 * 
 * @category Evozon
 * @package Evozon_Bogdan_Catalog
 * @copyright (c) year, Haidu Bogdan
 * @author Haidu Bogdan <branch bogdan of noonlit/magento> git
 */
$installer = $this;
$installer->startSetup();

/*
 * evozon_catalog_banners_category_connection alter table query
 * connection_id type int
 * category_id type int 
 * banner_id type int
 */

$connectionTable = $installer->getTable('evozon_bogdan_catalog/bannercategoryconnection');
$indexName = $installer->getIdxName('evozon_bogdan_catalog/bannercategoryconnection', array('category_id')
);

$installer->getConnection()->addIndex(
    $installer->getTable('evozon_bogdan_catalog/bannercategoryconnection'),
    $installer->getIdxName('evozon_bogdan_catalog/bannercategoryconnection', array('category_id')),
    array('category_id'),
    Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName('evozon_bogdan_catalog/bannercategoryconnection', 'category_id', 'catalog/category', 'entity_id'),
    $installer->getTable('evozon_bogdan_catalog/bannercategoryconnection'),
    'category_id',
    $installer->getTable('catalog/category'),
    'entity_id',Varien_Db_Ddl_Table::ACTION_RESTRICT, Varien_Db_Ddl_Table::ACTION_RESTRICT
);

$installer->getConnection()->addIndex(
    $installer->getTable('evozon_bogdan_catalog/bannercategoryconnection'),
    $installer->getIdxName('evozon_bogdan_catalog/bannercategoryconnection', array('banner_id')),
    array('banner_id'),
    Varien_Db_Adapter_Interface::INDEX_TYPE_INDEX
);

$installer->getConnection()->addForeignKey(
    $installer->getFkName('evozon_bogdan_catalog/bannercategoryconnection', 'banner_id', 'evozon_bogdan_catalog/banner', 'banner_id'),
    $installer->getTable('evozon_bogdan_catalog/bannercategoryconnection'),
    'banner_id',
    $installer->getTable('evozon_bogdan_catalog/banner'),
    'banner_id',Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
);


$installer->endSetup();
