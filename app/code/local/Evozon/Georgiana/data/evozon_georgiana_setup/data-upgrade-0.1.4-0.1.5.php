<?php


        $product = new Mage_Catalog_Model_Product();

        $product->setSku('GroupedSku');
        $product->setAttributeSetId(13); 
        $product->setTypeId('grouped');
        $product->setName('My Grouped Product');
        $product->setCategoryIds(array(10)); 
        $product->setWebsiteIDs(array(1));
        $product->setDescription('the best description');
        $product->setShortDescription('wow');
        $product->setPrice(800);
        $product->setWeight(200);
        $product->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH);
        $product->setStatus(1);
        $product->setTaxClassId(0); 
        $product->setStockData(array(
                                    'is_in_stock'             => 1,
                                    'manage_stock'            => 0,
                                    'use_config_manage_stock' => 1
                                    ));

        try {

            $product->save();       
            $group_product_id = $product->getId();


            $simpleProductId[0] = 373;
            $simpleProductId[1] = 374;
            $simpleProductId[2] = 375;
            $simpleProductId[3] = 376;


            $products_links = Mage::getModel('catalog/product_link_api');


            $group_product_id = $product->getId();


            foreach($simpleProductId as $id){
                $products_links->assign ("grouped",$group_product_id,$id);
            }

        } catch (Exception $ex) {
            echo $ex->getMessage();
        }

