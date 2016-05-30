<?php

// populate banner table 
$banners = array(
    array(
        'text' => 'Banner for women',
        'created_at' => '2016-05-02',
        'updated_at' => '2016-05-12'
    ),
    array(
        'text' => 'Banner for men',
        'created_at' => '2016-05-06',
        'updated_at' => '2016-05-13'
    ),
    array(
        'text' => 'Banner for dresses & skirts',
        'created_at' => '2016-05-16',
        'updated_at' => '2016-06-02'
    ),
    array(
        'text' => 'Banner for blazers',
        'created_at' => '2016-05-26',
        'updated_at' => '2016-05-30'
    ),
);

foreach ($banners as $banner) {
    Mage::getModel('evozon_catalog/banner')
            ->setData($banner)
            ->save();
}

// populate category_banner table
$category_banners = array(
    array(
        'banner_id' => 1,
        'category_id' => 4
    ),
    array(
        'banner_id' => 1,
        'category_id' => 13
    ),
    array(
        'banner_id' => 2,
        'category_id' => 5
    ),
    array(
        'banner_id' => 3,
        'category_id' => 13
    ),
    array(
        'banner_id' => 4,
        'category_id' => 40
    ),
    array(
        'banner_id' => 2,
        'category_id' => 40
    ),
);

foreach ($category_banners as $category_banner) {
    Mage::getModel('evozon_catalog/categorybanner')
            ->setData($category_banner)
            ->save();
}