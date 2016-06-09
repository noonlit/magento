<?php



$installer = $this;
$installer->startSetup();

echo "Hey";
die();

//$customerTable = $installer->getTable('customer/entity');
//
//$installer->getConnection()->addColumn('cnp', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'CNP')
//        //->addIndex($installer->getIdxName('customer/entity', array('cnp')), array('cnp'))
//;
//$installer->endSetup();
//
//
//
//$installer = $this;
//$installer->startSetup();
 
$installer->getConnection()
    ->addColumn($installer->getTable('customer/entity'),
        'cnp',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'length' => 255,
            'nullable' => false,
            'default' => 0,
            'comment' => 'numar de identificare'
        )
    );
 
$installer->endSetup();