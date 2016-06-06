<?php

Mage::log("data-install-0.1.0 started", null, "dataScripts.log");
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
    if ($product->getSize() == 0) {
        $bannerModel->setData($banner)
                ->save();
        Mage::log("Banner added!", null, "dataScripts.log");
    } else {
        Mage::log("Banner exists!", null, "dataScripts.log");
    }
}