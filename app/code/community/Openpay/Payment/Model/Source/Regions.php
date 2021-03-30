<?php
/**
 * Regions source with already implemented regions API's in Openpay
 *
 * @category Openpay
 * @package  Openpay_Payment
 * @author   ideatarmac.com
 */

class Openpay_Payment_Model_Source_Regions
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray() 
    {
        return array(
            array(
                'value' => 'Au',
                'label' => Mage::helper('openpay_payment')->__('Australia')
            ),
            array(
                'value' => 'En',
                'label' => Mage::helper('openpay_payment')->__('United Kingdom')
            ),
        );
    }
}
