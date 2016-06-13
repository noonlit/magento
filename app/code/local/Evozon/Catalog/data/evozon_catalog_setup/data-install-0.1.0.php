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
    Mage::getModel('evozon_catalog/banner')
            ->setData($banner)
            ->save();
}

// this is not the best validation ever
// I will not call Andra in the night for asking validation methods
// because Andra do not ahve the best validation methods in the world
// Make Validation good again
//

$model = Mage::getModel('evozon_catalog/banner');

foreach ($banners as $banner) {
    $collection = $model->getCollection()->addFieldToFilter('text', $banner['text']);
    if ($collection->getSize() == 0) {
        $model->setData($banner)->save();
        Mage::log('Added banner');
    }
}
Mage::log('Ended data-install-0.1.0', null, 'scripts.log');