<?php

Mage::log("upgrade-0.1.0 started", null, "sqlScripts.log");
$installer = $this;
$installer->startSetup();
$tableName = $installer->getTable('evozon_catalog/mediator');

if (!$installer->getConnection()->isTableExists($tableName)) {
    $table = $installer->getConnection()
            ->newTable($installer->getTable('evozon_catalog/mediator'))
            ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'auto_increment' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true,
            ), 'ID')
            ->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'unsigned' => true,
                'nullable' => false,
            ),
            'Category Id')
            ->addColumn('banner_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
            array(
                'unsigned' => true,
                'nullable' => false,
            ),
            'Banner Id')
            ->addForeignKey(
                $installer->getFkName(
                    'evozon_catalog/mediator',
                    'category_id',
                    'catalog/category',
                    'entity_id'
                ),
                'category_id', $installer->getTable('catalog/category'), 'entity_id',
                Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
            ->addForeignKey(
            $installer->getFkName(
                    'evozon_catalog/mediator',
                    'banner_id',
                    'evozon_catalog/banner',
                    'banner_id'
                ),
                'banner_id', $installer->getTable('evozon_catalog/banner'), 'banner_id',
                Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
    $installer->getConnection()->createTable($table);
}
$installer->endSetup();