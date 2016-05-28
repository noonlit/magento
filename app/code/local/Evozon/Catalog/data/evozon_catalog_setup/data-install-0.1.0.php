<?php

Mage::log('is this thing on?');

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
    Mage::getModel('evozon_catalog/banner')
            ->setData($banner)
            ->save();
}