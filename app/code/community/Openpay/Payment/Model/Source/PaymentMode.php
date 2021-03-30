<?php
/**
 * Payment mode source with values test and live
 *
 * @category Openpay
 * @package  Openpay_Payment
 * @author   ideatarmac.com
 */

class Openpay_Payment_Model_Source_PaymentMode 
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray() {
        return array(
            array(
                'value' => 'test',
                'label' => Mage::helper('openpay_payment')->__(' Sandbox')
            ),
            array(
                'value' => 'live',
                'label' => Mage::helper('openpay_payment')->__(' Production')
            ),
        );
    }
}
