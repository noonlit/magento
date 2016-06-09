<?php

Mage::log('Started data-install-0.1.0', null, 'scripts-customer.log');

$installer = $this;

$cnp = Mage::getModel('eav/config')->getAttribute('customer', 'CNP');
$id = $cnp->getId();

$attrData = array(
    'attribute_id' => $id,
    'website_id' => 1,
    'is_visible' => 1,
    'is_required' => 1,
    'default_value' => null,
    'multiline_count' => null
);

$installer->getConnection()->insert('customer_eav_attribute_website', $attrData);

Mage::log('Ended data-install-0.1.0', null, 'scripts-customer.log');