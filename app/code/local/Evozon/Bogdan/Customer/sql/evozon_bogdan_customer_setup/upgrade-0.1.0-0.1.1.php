<?php

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


////ADD ATTRIBUTE FOR FORM
//$installer = $this;
//$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
//$installer->startSetup();
//
//$cnpAttributes = array(
//    'group' => 'Customer',
//    'label' => 'CNP',
//    'backend' => '',
//    'type' => 'varchar',
//    'table' => '',
//    'frontend' => '',
//    'input' => 'text',
//    'frontend_class' => '',
//    'source' => '',
//    'required' => '1',
//    'user_defined' => '1',
//    'default' => '',
//    'unique' => '1',
//    'note' => '',
//    'visible_on_front' => '1',
//    'used_for_sort_by' => '8',
//    'position' => '8',
////    'input_renderer' => NULL,
////    'global' => '1',
////    'visible' => '1',
////    'searchable' => '1',
////    'filterable' => '1',
////    'comparable' => '1',
////    'visible_on_front' => '0',
////    'is_html_allowed_on_front' => '0',
////    'is_used_for_price_rules' => '1',
////    'filterable_in_search' => '1',
////    'used_in_product_listing' => '0',
////    'used_for_sort_by' => '0',
////    'is_configurable' => '1',
////    'apply_to' => 'simple',
////    'visible_in_advanced_search' => '1',
////    'position' => '1',
////    'wysiwyg_enabled' => '0',
////    'used_for_promo_rules' => '1',
//        )
//;


//$attrData2 = array(
//    'fieldset_id'=>null,
//    'type_id' => 1,
//    'attribute_id' => $id,
//    'sort_order' => 11,
//);
//$installer->getConnection()->insert('eav_form_element', $attrData2);
//
//
//$installer->endSetup();


