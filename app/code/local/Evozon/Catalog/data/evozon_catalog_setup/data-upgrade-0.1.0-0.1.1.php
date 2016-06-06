<?php

Mage::log("data-upgrade-0.1.0-0.1.1 started", null, "dataScripts.log");
$bannersCateg = array(
    array(
        'category_id' => 13,
        'banner_id' => 1
    ),
    array(
        'category_id' => 13,
        'banner_id' => 2
    ),
    array(
        'category_id' => 13,
        'banner_id' => 3
    ),
    array(
        'category_id' => 13,
        'banner_id' => 4
    )
);
$mediatorModel = Mage::getModel('evozon_catalog/mediator');
foreach ($bannersCateg as $mediator) {
    $product = $mediatorModel->getCollection()->addFieldToFilter('banner_id', $mediator['banner_id']);
    
    if ($product->getSize() == 0) {
        $mediatorModel->setData($mediator)
                ->save();
        Mage::log("Banner category added!", null, "dataScripts.log");
    } else {
        Mage::log("Banner category exists!", null, "dataScripts.log");
    }
}