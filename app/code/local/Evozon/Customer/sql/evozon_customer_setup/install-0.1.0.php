<?php
/**
 * Created by PhpStorm.
 * User: marius
 * Date: 6/10/16
 * Time: 1:00 PM
 */
Mage::log('==========================================================================', null, 'scripts-cnp.log');
Mage::log('Started install-0.1.0 (adding CNP attribute to customer)',  null, 'scripts-cnp.log');
$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Setup */

$installer->startSetup();

$entityTypeId = $installer->getEntityTypeId('customer');
$attributeSetId = $installer->getDefaultAttributeSetId(($entityTypeId));
$attributeGroupId = $installer->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);

$installer->addAttribute(
    'customer', //entity
    'CNP',      //the custom attribute
    array(
        'type'                 => 'varchar',
        'label'                => 'CNP',
        'input'                => 'text',
        'visible'              =>  true,
        'frontend'             => '',
        'backend'              => '',
        'source'               => '',
        'unique'               => true,
        'required'             => true,
        'visible_on_front'     => 1,
        'user_defined'         => 1,
        'used_for_price_rules' => 0
    )
);

$installer->addAttributeToGroup(
    $entityTypeId,
    $attributeSetId,
    $attributeGroupId,
    'CNP',
    '999' //sort order
);

$userInForms = array(
    'adminhtml_customer',
    'adminhtml_checkout',
    'checkout_register',
    'customer_account_create',
    'customer_account_edit',
);

try {
    $attribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'CNP');
}catch (Exception $ex) {
    Mage::log($ex->getMessage(), null, 'scripts-cnp.log');
}


$attribute
    ->setData(
        'used_in_forms', $userInForms
    )
    ->setData(
        'is_used_for_customer_segment', true
    )
    ->setData(
        'is_system', false
    )
    ->setData(
        'is_user_defined', true
    )
    ->setData(
        'is_visible', true
    )
    ;

try {
    $attribute->save();
    Mage::log('CNP attribute added', null, 'scripts-cnp.log');
}catch (Exception $ex) {
    Mage::log($ex->getMessage(), null, 'scripts-cnp.log');
}

$installer->endSetup();

Mage::log('Ended install-0.1.0 (adding CNP attribute to customer)',  null, 'scripts-cnp.log');
Mage::log('==========================================================================', null, 'scripts-cnp.log');