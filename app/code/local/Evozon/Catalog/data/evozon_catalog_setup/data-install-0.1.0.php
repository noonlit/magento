<?php
$date = new DateTime();
$banners = array(
    array(
        'created_at' => $date->getTimestamp(),
        'updated_at' => $date->getTimestamp(),
        'text' => 'Is this a banner?'
    ),
    array(
        'created_at' => $date->getTimestamp(),
        'updated_at' => $date->getTimestamp(),
        'text' => 'Yes, yes it is'
    ),
    array(
        'created_at' => $date->getTimestamp(),
        'updated_at' => $date->getTimestamp(),
        'text' => 'Why is this a banner?'
    ),
    array(
        'created_at' => $date->getTimestamp(),
        'updated_at' => $date->getTimestamp(),
        'text' => 'Potato'
    )
);
foreach ($banners as $banner) {
    Mage::getModel('evozon_catalog/banner')
            ->setData($banner)
            ->save();
}