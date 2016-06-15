<?php

$installer = $this;
$installer->startSetup();

//$table = $installer->getTable('evozon_delia/banner');

if (!$installer->getConnection()->isTableExists($tableName)) {
    $table = $installer->getConnection()
            ->newTable($installer->getTable('evozon_delia/banner'))
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

$installer->endSetup();