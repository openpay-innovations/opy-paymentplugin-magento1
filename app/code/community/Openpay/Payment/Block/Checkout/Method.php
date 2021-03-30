<?php

/**
 * Block model for custom checkout
 */

class Openpay_Payment_Block_Checkout_Method extends Mage_Core_Block_Template
{

    const CHECKOUT_JS_PATH = 'js/openpay.js';

    /**
     * is current payment active
     *
     * @return boolean
     */
    public function isActive()
    {
        return Mage::helper('openpay_payment')->getEnable();
    }

    /**
     * get Tokenization Controller url
     * 
     * @return string
     */
    public function getCheckoutRedirectUrl()
    {
       return Mage::helper('openpay_payment')->getPaymentGatewayUrl();
    }
}
