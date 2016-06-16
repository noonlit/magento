<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Status
 *
 * @author bogdanhaidu
 */
class Evozon_Qa_Model_Resource_Question_Attribute_Source_Status
{

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_DISABLED = 'disabled';

    /**
     * Get Menu Item Type Values
     *
     * @return array
     */
    public static function getValues()
    {
        $helper = Mage::helper('evozon_qa');
        return array(
            self::STATUS_PENDING => $helper->__('pending'),
            self::STATUS_APPROVED => $helper->__('approved'),
            self::STATUS_DISABLED => $helper->__('disabled'),
        );
    }

}
