<?php

$date = new DateTime();
$banners = array(
    array(
        'created_at' => $date->getTimestamp(),
        'updated_at' => $date->getTimestamp(),
        'text' => 'My first banner'
    ),
    array(
        'created_at' => $date->getTimestamp(),
        'updated_at' => $date->getTimestamp(),
        'text' => 'The best banner'
    ),
);
foreach ($banners as $banner) {
    Mage::getModel('evozon_georgiana/banner')
            ->setData($banner);
            //->save();
}