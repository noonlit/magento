<?php

Mage::log('Started install-0.1.1', null, 'scripts.log');

$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('evozon_catalog/link');

if ($installer->getConnection()->isTableExists($tableName) != true) {

    $table = $installer->getConnection()
            ->newTable($installer->getTable('evozon_catalog/link'))
            ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
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
                    ), 'Banner Id')
            ->addForeignKey(
                    $installer->getFkName(
                            'evozon_catalog/link', 'category_id', 'catalog/category', 'entity_id'
                    ), 'category_id', $installer->getTable('catalog/category'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
            ->addForeignKey(
            $installer->getFkName(
                    'evozon_catalog/link', 'banner_id', 'evozon_catalog/banner', 'banner_id'
            ), 'banner_id', $installer->getTable('evozon_catalog/banner'), 'banner_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);

    $installer->getConnection()->createTable($table);
}

$installer->endSetup();

Mage::log('Ended install-0.1.1', null, 'scripts.log');
