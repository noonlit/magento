<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author bogdanhaidu
 */
class Evozon_Qa_Adminhtml_Model_Answers extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resources
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('evozon_qa_adminhtml/answers');
    }
    /**
     * Get default category id
     *
     * @return int
     */
    public function getDefaultCategoryId()
    {
        $category = Mage::app()->getStore()->getRootCategoryId();
        if ($this->getDefaultCategory()) {
            $category = intval($this->getDefaultCategory());
        }
        return $category;
    }
    /**
     * @return Mage_Catalog_Model_Category
     */
    public function getCategory()
    {
        if (!$this->hasData('category_object')) {
            $category = Mage::getModel('catalog/category');
            if ($this->getDefaultCategory()) {
                $category->load($this->getDefaultCategory());
            }
            $this->setData('category_object', $category);
        }
        return $this->getData('category_object');
    }
}