<?php

//FIND ATTRIBUTES NAMES

require_once 'app/Mage.php';

Mage::app();

$product = Mage::getModel('catalog/product');
$product->load(447);
//$product->load(997);

$optionRawData = array();
$optionCollection = array(
    array('id' => '23',
        'position' => '1',
        'title' => 'optiunea1'
    ),
    array('id' => '24',
        'position' => '2',
        'title' => 'optiunea2',
        ));


$optionCollection = $product->getTypeInstance(true)->getOptionsCollection($product);
$selectionCollection = $product->getTypeInstance(true)
        ->getSelectionsCollection($product->getTypeInstance(true)
        ->getOptionsIds($product), $product
);

$optionCollection->appendSelections($selectionCollection);

//$bundled_items = array();
//foreach ($selectionCollection as $selection) {
//    $bundled_items[] = $selection->getSKu();
//}
//var_dump($bundled_items);


//$bundled_items = array();
foreach ($optionCollection as $option) {
    var_dump($option->getOptionId());
}
//var_dump($bundled_items);

$optionRawData = array();
$selectionRawData = array();

$i = 0;
foreach ($optionCollection as $option) {
    $optionRawData[$i] = array(
        'option_id' => $option->getOptionId(), //my addition. important otherwise, options going to be duplicated
        'required' => $option->getData('required'),
        'position' => $option->getData('position'),
        'type' => $option->getData('type'),
        'title' => $option->getData('title') ? $option->getData('title') : $option->getData('default_title'),
        'delete' => ''
    );
    foreach ($option->getSelections() as $selection) {
        $selectionRawData[$i][] = array(
            'product_id' => $selection->getProductId(),
            'position' => $selection->getPosition(),
            'is_default' => $selection->getIsDefault(),
            'selection_price_type' => $selection->getSelectionPriceType(),
            'selection_price_value' => $selection->getSelectionPriceValue(),
            'selection_qty' => $selection->getSelectionQty(),
            'selection_can_change_qty' => $selection->getSelectionCanChangeQty(),
            'delete' => ''
        );
    }
    $i++;
}

var_dump($optionRawData);
var_dump($selectionRawData);

