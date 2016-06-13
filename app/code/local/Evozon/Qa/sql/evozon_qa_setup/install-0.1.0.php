<?php
/**
 * @package    Evozon_Qa
 */

/**
 * Create table 'evozon_qa/question'
 */

Mage::log('Started install-0.1.0', null, 'scripts.log');

$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('evozon_qa/question');
if ($installer->getConnection()->isTableExists($tableName) != true) {
    $table = $installer->getConnection()
            ->newTable($tableName)
            ->addColumn('question_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'auto_increment' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true,
                ), 'Question ID')
            ->addColumn('text', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'Question text')
            ->addColumn('status', Varien_Db_Ddl_Table::TYPE_TEXT, 50, array(
                'nullable' => false
            ), 'Question status')
           ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'unsigned' => true,
                'nullable' => false,
                    ), 'Product Id')
            ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'unsigned' => true,
                'nullable' => false,
                    ), 'Customer Id')
            ->addForeignKey(
                $installer->getFkName(
                    'evozon_qa/question', 'product_id', 'catalog/product', 'entity_id'
                ), 'product_id', $installer->getTable('catalog/product'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
            ->addForeignKey(
                $installer->getFkName(
                    'evozon_qa/question', 'customer_id', 'customer/entity', 'entity_id'
                ), 'customer_id', $installer->getTable('customer/entity'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
        
    $installer->getConnection()->createTable($table);
}
$installer->endSetup();
 
Mage::log('Ended install-0.1.0', null, 'scripts.log');