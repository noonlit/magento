<?php
$bannersToCtg = array(
    array(
        'category_id' => 5,
        'banner_id' => 1
    ),
    array(
        'category_id' => 5,
        'banner_id' => 2
    ),
);
foreach ($bannersToCtg as $link) {
    Mage::getModel('evozon_catalog/link')
            ->setData($link)
            ->save();
}