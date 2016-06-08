<?php

class Evozon_Bogdan_Catalog_Helper_Categories extends Mage_Core_Helper_Abstract
{

    public function getCategoriestId($rootCategory, $attributeSetName)
    {
        //$attributesToFilter = explode(',', $attributeSetName);
        $sortedCategories = array();
        $categories = Mage::getResourceModel('catalog/category_collection')
                ->addFieldToFilter('name', $rootCategory)
                ->getFirstItem() // The parent category
                ->getChildrenCategories()
                ->getItems()
        ;

        //LEARN ADD FIELD TO FILTER IT SEEMS IT DOESN'T WORK AFTER GET ChildrenCategories

        foreach ($categories as $category) {
            if ($category->getName() == $attributeSetName) {
                $sortedCategories[] = (int) $category->getId();
            }
        }
        return $sortedCategories;
    }

}
