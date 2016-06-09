<?php

/**
 * Add a new attribute for customer
 */
$installer = $this;
$installer->startSetup();

$setup = Mage::getModel('customer/entity_setup', 'core_setup');
$setup->addAttribute('customer', 'cnp', array(
    'type' => 'varchar',
    'label' => 'CNP',
    'input' => 'text',
    'visible' => true,
    'visible_on_front' => true,
    'required' => false,
    'user_defined' => true,   
    'is_system' => 0,
    'default' => '',
    'unique' => true,
    'note' => '',
    'source' => ''  
));

$attribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'cnp');
$usedInForms = array(
    'adminhtml_checkout',
    'adminhtml_customer',
    'checkout_register',
    'customer_account_create',
    'customer_account_edit'
);
$attribute
        ->setData('used_in_forms', $usedInForms);

$attribute->save();
$installer->endSetup();
