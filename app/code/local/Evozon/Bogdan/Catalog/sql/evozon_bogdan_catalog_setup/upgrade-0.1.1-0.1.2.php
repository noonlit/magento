<?php

$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();

$classicAttributes = array(
    'backend' => '',
    'type' => 'int',
    'table' => '',
    'frontend' => '',
    'input' => 'select',
    'frontend_class' => '',
    'source' => '',
    'required' => '0',
    'user_defined' => '1',
    'default' => '',
    'unique' => '0',
    'note' => '',
    'input_renderer' => NULL,
    'global' => '1',
    'visible' => '1',
    'searchable' => '1',
    'filterable' => '1',
    'comparable' => '1',
    'visible_on_front' => '0',
    'is_html_allowed_on_front' => '0',
    'is_used_for_price_rules' => '1',
    'filterable_in_search' => '1',
    'used_in_product_listing' => '0',
    'used_for_sort_by' => '0',
    'is_configurable' => '1',
    'apply_to' => 'simple',
    'visible_in_advanced_search' => '1',
    'position' => '1',
    'wysiwyg_enabled' => '0',
    'used_for_promo_rules' => '1',
        )
;

//ADDING A NEW ATTRIBUTE
$laptopTytpeAttribute = $classicAttributes + array(
    'group' => 'Electronics',
    'attribute_set' => 'Electronics',
    'label' => 'Laptop Type',
    'option' =>
    array(
        'values' =>
        array(
            0 => 'Gaming',
            1 => 'Studio',
            2 => 'Standard',
        ),
    ),
);
$setup->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'laptop_type', $laptopTytpeAttribute);

//ADDING A NEW ATTRIBUTE
$diagonalAttribute = $classicAttributes + array(
    'group' => 'Electronics',
    'attribute_set' => 'Electronics',
    'label' => 'Screen Size',
    'option' =>
    array(
        'values' =>
        array(
            0 => '13 inches',
            1 => '15.6 inches',
            2 => '17 inches',
        ),
    ),
);
$setup->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'screen_size', $diagonalAttribute);

//ADDING A NEW ATTRIBUTE
$connectionAttribute = $classicAttributes + array(
    'group' => 'Electronics',
    'attribute_set' => 'Electronics',
    'label' => 'Connection Type',
    'option' =>
    array(
        'values' =>
        array(
            0 => 'Cable',
            1 => 'Wireless'
        ),
    ),
);

$setup->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'connection_type', $connectionAttribute);

//ADDING A NEW ATTRIBUTE
$mouseTypeAttribute = $classicAttributes + array(
    'group' => 'Electronics',
    'attribute_set' => 'Electronics',
    'label' => 'Mouse Type',
    'option' =>
    array(
        'values' =>
        array(
            0 => 'Standard',
            1 => 'Gaming'
        ),
    ),
);

$setup->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'mouse_type', $mouseTypeAttribute);


$installer->endSetup();
