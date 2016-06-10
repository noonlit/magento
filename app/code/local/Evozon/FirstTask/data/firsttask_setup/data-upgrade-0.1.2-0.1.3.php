<?php

Mage::log('==========================================================================', null, 'scripts_banners.log');
Mage::log('Started data-upgrade-0.1.2-0.1.3', null, 'scripts_banners.log');

$date = new DateTime();
$banners = array(
    array(
        'created_at' => $date->getTimestamp(),
        'updated_at' => $date->getTimestamp(),
        'text' => 'Some other text 4'
    ),
    array(
        'created_at' => $date->getTimestamp(),
        'updated_at' => $date->getTimestamp(),
        'text' => 'Some other text 3'
    ),
);

$model = Mage::getModel('evozon_firsttask/banner');

foreach ($banners as $banner) {
    $collection = $model->getCollection()->addFieldToFilter('text', $banner['text']);
    if($collection->getSize() == 0) {
        $model
            ->setData($banner)
            ->save();
        Mage::log('Added a banner', null, 'scripts_banners.log');
    }
}

$bannersToCtg = array(
    array(
        'category_id' => 5,
        'banner_id' => 3
    ),
    array(
        'category_id' => 5,
        'banner_id' => 4
    ),
    array(
        'category_id' => 5,
        'banner_id' => 1
    ),
    array(
        'category_id' => 5,
        'banner_id' => 2
    ),
    array(
        'category_id' => 4,
        'banner_id' => 3
    ),
    array(
        'category_id' => 4,
        'banner_id' => 4
    ),
);

$modelLink = Mage::getModel('evozon_firsttask/link');

foreach ($bannersToCtg as $link) {
    $collection = $modelLink->getCollection()
        ->addFieldToFilter('category_id', $link['category_id'])
        ->addFieldToFilter('banner_id', $link['banner_id']);
    if($collection->getSize() == 0) {
        $modelLink
            ->setData($link)
            ->save();
        Mage::log('Added link', null, 'scripts_banners.log');
    }
}

Mage::log('Ended data-upgrade-0.1.2-0.1.3', null, 'scripts_banners.log');
Mage::log('==========================================================================', null, 'scripts_banners.log');