<?php
$bannersToCtg = array(
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
foreach ($bannersToCtg as $mediator) {
    Mage::getModel('evozon_catalog/mediator')
            ->setData($mediator)
            ->save();
}