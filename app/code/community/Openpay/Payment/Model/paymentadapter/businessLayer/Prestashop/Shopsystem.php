<?php

/**
 * All Prestashop function which can be necessary
 *
 * @author ideatarmac.com
 */

namespace BusinessLayer\Openpay\Prestashop;

class Shopsystem 
{
    /**
     * call functions from prestashop to get all cartinformations
     * in Prestashop we use $this->context as $cartObj
     * 
     * @param object $cartObj
     * 
     * @return object
     */
    public static function prepareShopCartObj($cartObj)
    {
        /*$cart = $cartObj->cart;
        $cart->products = $cart->getProducts();
        $cart->custom = new \Customer($cart->id_customer);
        $cart->deliveryAddress = new \Address($cart->id_address_delivery);
        $cart->deliveryAddress->country = $cartObj->country->iso_code;
        $cart->invoiceAddress = new \Address($cart->id_address_invoice);
        $cart->invoiceAddress->country = $cartObj->country->iso_code;
        $cart->total = $cart->getOrderTotal(true, \Cart::BOTH);
        $cart->isoCurrency = $cartObj->currency->iso_code;
        $cart->shopcountry = $cartObj->country->iso_code;*/
        
        return $cartObj;
    }
}