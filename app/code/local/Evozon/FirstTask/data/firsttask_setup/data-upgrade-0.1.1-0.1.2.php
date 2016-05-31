<?php

$date = new DateTime();
$banners = array(
    array(
        'created_at' => $date->getTimestamp(),
        'updated_at' => $date->getTimestamp(),
        'text' => 'This is banner 1'
    ),
    array(
        'created_at' => $date->getTimestamp(),
        'updated_at' => $date->getTimestamp(),
        'text' => 'This is banner 2'
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
        'banner_id' => 1
    ),
    array(
        'category_id' => 4,
        'banner_id' => 2
    ),
);
foreach ($bannersToCtg as $link) {
    Mage::getModel('evozon_firsttask/link')
            ->setData($link)
            ->save();
}