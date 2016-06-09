<?php

Mage::log('Started install-0.1.0', null, 'scripts-customer.log');

$installer = $this;
$installer->startSetup();
// $installer->removeAttribute('customer', 'CNP');

// $installer->addAttribute(
$installer->updateAttribute(
    'customer',
    'CNP',
    array(
        'group'                => 'Default',
        'type'                 => 'int',
        'label'                => 'CNP',
        'input'                => 'text',
        'source'               => '',
        'required'             => 1,
        'position'             => 999,
        'visible_on_front'     => 1,
        'user_defined'         => 1,
        'used_for_price_rules' => 0
    )
);

Mage::getSingleton('eav/config')
    ->getAttribute('customer', 'CNP')
    ->setData('used_in_forms', array(
        'adminhtml_customer',
        'checkout_register',
        'customer_account_create',
        'customer_account_edit'))
    ->save();

$installer->endSetup();

Mage::log('Ended install-0.1.0', null, 'scripts-customer.log');