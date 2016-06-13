<?php
/**
 * @package    Evozon_Qa
 */

/* @var $installer Mage_Customer_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/**
 * Create table 'evozon_qa/questions'
 */

Mage::log('Started install-0.1.0', null, 'scripts.log');

$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('evozon_qa/questions');
if ($installer->getConnection()->isTableExists($tableName) != true) {
    $table = $installer->getConnection()->newTable($installer->getTable('evozon_qa/questions'))
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
            ->addForeignKey(
                $installer->getFkName(
                    'evozon_qa/questions', 'product_id', 'catalog/product', 'entity_id'
                ), 'product_id', $installer->getTable('catalog/product'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
            ->addForeignKey(
                $installer->getFkName(
                    'evozon_qa/questions', 'customer_id', 'customer/entity', 'entity_id'
                ), 'customer_id', $installer->getTable('customer/entity'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
        
    $installer->getConnection()->createTable($table);
}
$installer->endSetup();
 
Mage::log('Ended install-0.1.0', null, 'scripts.log');