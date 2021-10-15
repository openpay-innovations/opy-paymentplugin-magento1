<?php
/**
 * block file to disable input fields
 *
 * @category Openpay
 * @package  Openpay_Payment
 * @author   ideatarmac.com
 */

class Openpay_Payment_Block_Field_Disable extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * get disable html
     * 
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) 
    {     
        $element->setData('readonly', 1);   
        return parent::_getElementHtml($element);
    }
}
