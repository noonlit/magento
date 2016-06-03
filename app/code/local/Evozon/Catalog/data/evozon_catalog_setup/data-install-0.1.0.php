<?php

Mage::log("data-install-0.1.0 started");
$date = new DateTime();
$banners = array(
    array(
        'created_at' => $date->getTimestamp(),
        'updated_at' => $date->getTimestamp(),
        'text' => 'Is this a banner'
    ),
    array(
        'created_at' => $date->getTimestamp(),
        'updated_at' => $date->getTimestamp(),
        'text' => 'Yes, yes it is'
    ),
    array(
        'created_at' => $date->getTimestamp(),
        'updated_at' => $date->getTimestamp(),
        'text' => 'Why is this a banner'
    ),
    array(
        'created_at' => $date->getTimestamp(),
        'updated_at' => $date->getTimestamp(),
        'text' => 'Potato'
    )
);
$bannerModel = Mage::getModel('evozon_catalog/banner');
foreach ($banners as $banner) {
    $product = $bannerModel->getCollection()->addFieldToFilter('text', $banner['text']);
    if (!$product->count()) {
        $bannerModel->setData($banner)
                ->save();
        Mage::log("Banner added!\n");
    } else {
        Mage::log("Banner exists!\n");
    }
}
die;