<?php

$installer = $this;
$installer->startSetup();

// create banner table
$table = $installer->getConnection()->newTable("evozon_banner")
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true,
        ), 'id')
    ->addColumn('text', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false,
        ), 'text')    
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'created_at')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        ), 'updated_at')
    ->setComment('Evozon catalog/banner entity table');
$installer->getConnection()->createTable($table);

// create association table between banner and category
$table = $installer->getConnection()->newTable("evozon_banner_to_category")
    ->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        ), 'category_id')
    ->addColumn('banner_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        ), 'banner_id')   
    ->setComment('Evozon catalog/banner_to_category table');
$installer->getConnection()->createTable($table);


$installer->endSetup();
