<?php

$installer = $this;
$installer->startSetup();
$tableName = $installer->getTable('evozon_georgiana/link');
// check if the table already exists
if ($installer->getConnection()->isTableExists($tableName) != true) {
    $table = $installer->getConnection()
            ->newTable($installer->getTable('evozon_georgiana/link'))
            ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'auto_increment' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true,
            ), 'ID') // only because the resource _init wants a primary id, can we circumvent this?
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
                    'evozon_georgiana/link',
                    'category_id',
                    'catalog/category',
                    'entity_id'
                ),
                'category_id', $installer->getTable('catalog/category'), 'entity_id',
                Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
            ->addForeignKey(
            $installer->getFkName(
                    'evozon_georgiana/link',
                    'banner_id',
                    'evozon_georgiana/banner',
                    'banner_id'
                ),
                'banner_id', $installer->getTable('evozon_georgiana/banner'), 'banner_id',
                Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
    $installer->getConnection()->createTable($table);
}
$installer->endSetup();