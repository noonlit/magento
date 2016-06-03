<?php

$bannersToCtg = array(
    array(
        'category_id' => 4,
        'banner_id' => 1
    ),
    array(
        'category_id' => 4,
        'banner_id' => 2
    ),
);
foreach ($bannersToCtg as $link) {
    Mage::getModel('evozon_georgiana/link')
            ->setData($link);
            //->save();
}