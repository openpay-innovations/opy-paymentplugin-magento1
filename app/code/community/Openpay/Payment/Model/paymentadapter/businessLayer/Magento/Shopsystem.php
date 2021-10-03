<?php

/**
 * All Magento function which can be necessary
 *
 * @author ideatarmac.com
 */

namespace BusinessLayer\Openpay\Magento;

class Shopsystem 
{
    /**
     * call functions from Magento to get all cartinformations
     * in Magento we use $quote as $cart
     * 
     * @param object $cart
     * 
     * @return object
     */
    public static function prepareShopCartObj($cart)
    {
        $shopCart = new \stdClass();
        if (count($cart->getAllVisibleItems()) > 0) {
            foreach ($cart->getAllVisibleItems() as $item) {
                $shopCart->products[] = $item->getData();
            }
        }
        
        if ($cart->getCustomer()->getId()) {
            $shopCart->custom = $cart->getCustomer()->load($cart->getCustomer()->getId())->getData();
        } else {
            $shopCart->custom = ['email' => $cart->getCustomerEmail()];
        }
        $shopCart->total = $cart->getGrandTotal();
        $integerTotal = round((float)$cart->getGrandTotal(), 2);
        $shopCart->integerTotal = ($integerTotal * 100);
        $shopCart->deliveryAddress = $cart->getShippingAddress()->getData();
        $shopCart->invoiceAddress = $cart->getBillingAddress()->getData();

        $linesInvoice = explode("\n", $shopCart->invoiceAddress['street']);
        $shopCart->invoiceAddress['line1'] = $linesInvoice[0];
        $shopCart->invoiceAddress['line2'] = (isset($linesInvoice[1])) ? $linesInvoice[1] : '';
        $linesDelivery = explode("\n", $shopCart->deliveryAddress['street']);
        $shopCart->deliveryAddress['line1'] = $linesDelivery[0];
        $shopCart->deliveryAddress['line2'] = (isset($linesDelivery[1])) ? $linesDelivery[1] : '';     
        
        if (!empty($shopCart->deliveryAddress['region'])) {
            $regionDelivery = \Mage::getModel('directory/region')
                ->loadByName($shopCart->deliveryAddress['region'], $shopCart->deliveryAddress['country_id'])
                ->getData();
            $shopCart->deliveryAddress['regioncode'] = (isset($regionDelivery['code']) && $regionDelivery['code']) ? $regionDelivery['code'] : $shopCart->deliveryAddress['region'];
        }
        if (!empty($shopCart->invoiceAddress['region'])) {
            $regionInvoice = \Mage::getModel('directory/region')
                ->loadByName($shopCart->invoiceAddress['region'], $shopCart->invoiceAddress['country_id'])
                ->getData();
            $shopCart->invoiceAddress['regioncode'] = (isset($regionInvoice['code']) && $regionInvoice['code']) ? $regionInvoice['code'] : $shopCart->invoiceAddress['region']; 
        }
        
        $shopCart->isoCurrency = \Mage::app()->getStore()->getCurrentCurrencyCode();
        $shopCart->cartId = $cart->getId();
        $shopCart->source = 'Magento';
        
        return $shopCart;
    }
}
