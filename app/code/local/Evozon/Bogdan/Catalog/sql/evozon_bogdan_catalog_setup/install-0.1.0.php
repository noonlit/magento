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
 * evozon_catalog_banners table creation query
 * banner_id type int
 * created_at type Date Time 
 * updated_at type Date Time
 * text type text
 */

$bannersTable = $installer->getTable('evozon_bogdan_catalog/banner');

if ($installer->getConnection()->isTableExists($bannersTable) == true) {
    $installer->getConnection()
            ->dropTable($installer->getTable('evozon_bogdan_catalog/banner'));
}

if ($installer->getConnection()->isTableExists($bannersTable) != true) {
    $table = $installer->getConnection()
            ->newTable($installer->getTable('evozon_bogdan_catalog/banner'))
            ->addColumn('banner_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'auto_increment' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true,
                    ), 'ID')
            ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
                    ), 'Date created')
            ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
                    ), 'Date updated')
            ->addColumn('text', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            ), 'Banner text');
    $installer->getConnection()->createTable($table);
}

/*
 * evozon_catalog_banners_category_connection table creation query
 * connection_id type int
 * category_id type int 
 * banner_id type int
 */

$connectionTable = $installer->getTable('evozon_bogdan_catalog/bannercategoryconnection');

if ($installer->getConnection()->isTableExists($connectionTable) == true) {
    $installer->getConnection()
            ->dropTable($installer->getTable('evozon_bogdan_catalog/bannercategoryconnection'));
}

if ($installer->getConnection()->isTableExists($connectionTable) != true) {
    $table = $installer->getConnection()
            ->newTable($installer->getTable('evozon_bogdan_catalog/bannercategoryconnection'))
            ->addColumn('connection_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'auto_increment' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true,
                    ), 'ID')
            ->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'unsigned' => true,
                'nullable' => false,
                    ), 'Category Id')
            ->addColumn('banner_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
            ), 'Banner Id');
    $installer->getConnection()->createTable($table);
    //TODO FOREIGN KEYS
}

$installer->endSetup();
