<?php

//Mage::log('Started data-install-0.1.0.', null, 'scripts.log');
//
//$banners = array (
//    
//    array (
//        'created_at' => $date->getTimestamp(),
//        'updated_at' => $date->getTimestamp(),
//        'text' => 'Floricele'
//    ),
//    
//    array (
//        'created_at' => $date->getTimestamp(),
//        'updated_at' => $date->getTimestamp(),
//        'text' => 'Sf. Zebedeu'
//    ),
//    
//    array (
//        'created_at' => $date->getTimestamp(),
//        'updated_at' => $date->getTimestamp(),
//        'text' => 'Kana kana kana kana jambe'
//    )
//    
//);
//
//$bannerModel = Mage::getModel('evozon_delia/banner');
//
//foreach ($banners as $banner) {
//    $bannerCollection = $bannerModel->getCollection()->addFieldToFilter('text', $banner['text']);
//    if ($collection->getSize() == 0) {
//        $bannerModel->setData($banner)->save();
//        Mage::log('A new banner was added.');
//    }
//}

Mage::log('Finished data-install-0.1.0', null, 'scripts.log');
