<?php

$date = new DateTime();
$banners = array(
    array(
        'created_at' => $date->getTimestamp(),
        'updated_at' => $date->getTimestamp(),
        'text' => 'This will appear only on women page'
    ),
    array(
        'created_at' => $date->getTimestamp(),
        'updated_at' => $date->getTimestamp(),
        'text' => 'This will appera only on men page'
    ),
);
foreach ($banners as $banner) {
    Mage::getModel('evozon_firsttask/banner')
            ->setData($banner)
            ->save();
}

$bannersToCtg = array(
    array(
        'category_id' => 4,
        'banner_id' => 5
    ),
    array(
        'category_id' => 5,
        'banner_id' => 6
    ),
);
foreach ($bannersToCtg as $link) {
    Mage::getModel('evozon_firsttask/link')
            ->setData($link)
            ->save();
}

