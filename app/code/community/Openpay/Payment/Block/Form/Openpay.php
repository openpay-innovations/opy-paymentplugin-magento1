<?php
/**
 * block file to call the related template file to display 
 * a openpay form.
 *
 * @category Openpay
 * @package  Openpay_Payment
 * @author   ideatarmac.com
 */
class Openpay_Payment_Block_Form_Openpay extends Mage_Payment_Block_Form
{
    /**
     * Form for paymentmethod in checkout process
     */
    protected function _construct()
    {    
        $isCheckoutWidgetEnabled = false;
        if (Mage::helper('core')->isModuleEnabled('Openpay_Widgets')) {
            $helper = Mage::helper('widgets/data');
            $isCheckoutWidgetEnabled = $helper->isCheckoutWidgetEnabled();
        }
    	if ($isCheckoutWidgetEnabled) {
            $this->setTemplate('openpay/checkout/form.phtml')
                 ->setMethodLabelAfterHtml('
                    <span class="openpay learn-more">
                        <img src="https://static.openpay.com.au/brand/logo/amber-lozenge-logo.svg" alt="OPENPAY" height="" width="75">
                        <opy-learn-more-button></opy-learn-more-button>
                    </span>
                ');
	} else {
            $mark = Mage::getConfig()->getBlockClassName('core/template');
            $mark = new $mark;
            $mark->setTemplate('openpay/form/openpaylogo.phtml');
            $this->setTemplate('openpay/form/openpay.phtml')
            ->setMethodLabelAfterHtml($mark->toHtml());
        }
        parent::_construct();
    }
}