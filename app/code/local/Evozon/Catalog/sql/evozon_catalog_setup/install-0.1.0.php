<?php

$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('evozon_catalog/banner');

// check if the table already exists - do we need to at this point?
if ($installer->getConnection()->isTableExists($tableName) != true) {

    $table = $installer->getConnection()
            ->newTable($installer->getTable('evozon_catalog/banner'))
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
