<?php

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$tableName = $installer->getTable('evozon_qa/answer');
if($installer->getConnection()->isTableExists($tableName) != true) {
    $table-> $installer->getConnection()
        ->newTable($tableName)
        ->addColumn('answer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'primary' => true,
            'nullable' => false,
            'unsigned' => true,
            'identity' => true,
            'auto_increment' => true    
        ))
         ->addColumn('question_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
            'unsigned' => true,
        ))
        ->addForeignKey($installer->getFkName('evozon_qa/answer', 'question_id', 'evozon_qa/question','question_id'),
            'question_id',
            $installer->getTable('evozon_qa/question'), 
            'question_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, 
            Varien_Db_Ddl_Table::ACTION_CASCADE
        )
        ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
            'unsigned' => true,
        ))  
        ->addForeignKey($installer->getFkName('evozon_qa/answer', 'user_id', 'admin/user','user_id'),
            'user_id',
            $installer->getTable('admin/user'), 
            'user_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, 
            Varien_Db_Ddl_Table::ACTION_CASCADE
        ) 
        ->addColumn('answer', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false
        ))
        ->setComment("Answer Tables!");

        $installer->getConnection()->createTable($table);
        $installer->endSetup();
}