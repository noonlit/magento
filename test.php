<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'app/Mage.php';

Mage::app();


$products = Mage::getModel("evozon_bogdan_catalog/bannertable")->getCollection();
var_dump($products);

foreach ($products as $product) {
    //var_dump($product) . "<br>";
    //die();
    //echo $product->getData('created_at')."<br>";
}

//$myVariable = 3;
//$myArray = arrary();
//$myObject = $myArray;
//$e = 0;
//Mage::log('My log entry');
//Mage::log('My log message: ' . $myVariable);
//Mage::log($myArray);
//Mage::log($myObject);
//Mage::logException($e);
