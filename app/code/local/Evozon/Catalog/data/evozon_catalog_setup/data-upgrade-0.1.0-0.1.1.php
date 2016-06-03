<?php

Mage::log('Started data-install-0.1.1', null, 'scripts.log');

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

$model = Mage::getModel('evozon_catalog/link');

foreach ($bannersToCtg as $link) {
    $collection = $model->getCollection()
            ->addFieldToFilter('category_id', $link['category_id'])
            ->addFieldToFilter('banner_id', $link['banner_id']);

    if ($collection->getSize() == 0) {
        $model->setData($link)->save();
        Mage::log('Added link', null, 'scripts.log');
    }
}

Mage::log('Ended data-install-0.1.1', null, 'scripts.log');